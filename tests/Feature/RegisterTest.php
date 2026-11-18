<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Laravel\Socialite\Contracts\User as SocialiteUser;
use Laravel\Socialite\Facades\Socialite;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

beforeEach(function (): void {
    config(['app.key' => 'base64:'.base64_encode(str_repeat('a', 32))]);
    $this->withoutVite();
});

it('renders a separate investor register view and role-specific registration copy', function (string $role, string $buttonLabel, string $panelClass): void {
    $viewName = $role === 'investor' ? 'auth.register-investor' : 'auth.register';

    $this->withSession(['selected_role' => $role])
        ->get(route('register'))
        ->assertOk()
        ->assertViewIs($viewName)
        ->assertSee('Nama Lengkap')
        ->assertSee('Email')
        ->assertSee('Nomor HP')
        ->assertSee('Konfirmasi Password')
        ->assertSee('Satu akun, tiga peran:')
        ->assertSee($buttonLabel)
        ->assertSee($panelClass, false);
})->with([
    'customer' => ['customer', 'Daftar & Masuk sebagai Customer', 'from-[#00a98f]'],
    'umkm' => ['umkm', 'Daftar & Masuk sebagai UMKM', 'from-[#ff6b3d]'],
    'investor' => ['investor', 'Daftar & Masuk sebagai Investor', 'from-[#1d4e88]'],
]);

it('renders the matching profile and verification fields for each public role', function (string $role, array $fields): void {
    $response = $this->withSession(['selected_role' => $role])->get(route('register'));

    $response->assertOk();

    foreach ($fields as $field) {
        $response->assertSee($field);
    }
})->with([
    'customer profile' => ['customer', ['Profil Customer', 'Alamat', 'Kota']],
    'umkm profile and document' => ['umkm', ['Profil Usaha', 'Nama Usaha', 'Kategori Usaha', 'Unggah Dokumen Usaha']],
    'investor KYC' => ['investor', ['Profil dan Verifikasi Investor', 'NIK', 'Pekerjaan', 'Penghasilan per Bulan', 'Unggah KTP', 'Unggah Selfie']],
]);

it('creates a user with the selected public role and logs them in', function (string $role): void {
    Storage::fake('local');
    $email = "{$role}@example.test";

    $registrationData = match ($role) {
        'customer' => [],
        'umkm' => [
            'nama_usaha' => 'Toko Nusantara',
            'kategori_usaha' => 'Kerajinan',
            'deskripsi' => 'Produk lokal pilihan',
            'alamat_usaha' => 'Bandung',
            'kontak_usaha' => '+62 812-0000-0000',
            'terima_investasi' => '1',
            'jenis_dokumen' => 'NIB',
            'dokumen_usaha' => UploadedFile::fake()->create('nib.pdf', 150, 'application/pdf'),
        ],
        'investor' => [
            'nik' => '3201011234567890',
            'pekerjaan' => 'Wiraswasta',
            'penghasilan' => '15000000',
            'jenis_investor' => 'Individu',
            'tingkat_risiko' => 'Moderat',
            'tujuan_investasi' => 'Mendukung usaha lokal',
            'ktp' => UploadedFile::fake()->create('ktp.pdf', 200, 'application/pdf'),
            'selfie' => UploadedFile::fake()->image('selfie.png'),
        ],
    };

    $response = $this->withSession(['selected_role' => $role])
        ->post(route('register.store'), [
            'name' => 'UMatch User',
            'email' => $email,
            'no_hp' => '+62 812-3456-7890',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ] + $registrationData);

    $response->assertRedirect(route('dashboard'));

    $user = User::query()->where('email', $email)->firstOrFail();

    $this->assertDatabaseHas('users', [
        'user_id' => $user->getKey(),
        'no_hp' => '+62 812-3456-7890',
    ]);
    $this->assertTrue($user->hasRole($role));
    $this->assertTrue(Hash::check('secret123', $user->password));
    $this->assertAuthenticatedAs($user);

    if ($role === 'customer') {
        $this->assertDatabaseHas('customer_profiles', ['user_id' => $user->getKey()]);
    }

    if ($role === 'umkm') {
        $this->assertDatabaseHas('umkm_profiles', [
            'user_id' => $user->getKey(),
            'status_verifikasi' => 'pending',
        ]);
        $this->assertDatabaseHas('umkm_documents', ['jenis_dokumen' => 'NIB']);
        $storedPath = DB::table('umkm_documents')->value('file_dokumen');
        Storage::disk('local')->assertExists($storedPath);
    }

    if ($role === 'investor') {
        $this->assertDatabaseHas('investor_profiles', [
            'user_id' => $user->getKey(),
            'nik' => '3201011234567890',
            'status_verifikasi' => 'pending',
        ]);
        $this->assertDatabaseCount('investor_documents', 2);
        foreach (DB::table('investor_documents')->pluck('file_dokumen') as $storedPath) {
            Storage::disk('local')->assertExists($storedPath);
        }
    }
})->with(['customer', 'umkm', 'investor']);

it('rejects admin role selection and ignores a manually supplied role during registration', function (): void {
    $this->post(route('roles.select'), ['role' => 'admin'])
        ->assertSessionHasErrors('role');

    $this->withSession(['selected_role' => 'customer'])
        ->post(route('register.store'), [
            'role' => 'admin',
            'name' => 'Public User',
            'email' => 'public@example.test',
            'no_hp' => '+62 812-3456-7890',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ])
        ->assertRedirect(route('dashboard'));

    $user = User::query()->where('email', 'public@example.test')->firstOrFail();

    $this->assertTrue($user->hasRole('customer'));
    $this->assertFalse($user->hasRole('admin'));
});

it('redirects registration when the session contains an internal role', function (): void {
    $this->withSession(['selected_role' => 'admin'])
        ->post(route('register.store'), [
            'name' => 'Public User',
            'email' => 'admin-attempt@example.test',
            'no_hp' => '+62 812-3456-7890',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ])
        ->assertRedirect(route('roles.choose'));

    $this->assertDatabaseMissing('users', ['email' => 'admin-attempt@example.test']);
});

it('rejects invalid phone numbers and passwords shorter than six characters', function (): void {
    $this->withSession(['selected_role' => 'customer'])
        ->from(route('register'))
        ->post(route('register.store'), [
            'name' => 'Public User',
            'email' => 'invalid@example.test',
            'no_hp' => 'not a phone number',
            'password' => '12345',
            'password_confirmation' => '12345',
        ])
        ->assertRedirect(route('register'))
        ->assertSessionHasErrors(['no_hp', 'password']);

    $this->assertDatabaseMissing('users', ['email' => 'invalid@example.test']);
});

it('rolls back the user when attaching the selected role fails', function (): void {
    DB::statement("CREATE TRIGGER fail_user_role BEFORE INSERT ON user_roles BEGIN SELECT RAISE(ABORT, 'forced pivot failure'); END;");

    try {
        $this->withoutExceptionHandling()
            ->withSession(['selected_role' => 'customer'])
            ->post(route('register.store'), [
                'name' => 'Transactional User',
                'email' => 'transaction@example.test',
                'no_hp' => '+62 812-3456-7890',
                'password' => 'secret123',
                'password_confirmation' => 'secret123',
            ]);

        $this->fail('The role pivot insert should fail.');
    } catch (QueryException) {
        $this->assertDatabaseMissing('users', ['email' => 'transaction@example.test']);
    }
});

it('rolls back an UMKM profile and removes its private upload when document persistence fails', function (): void {
    Storage::fake('local');
    DB::statement("CREATE TRIGGER fail_umkm_document BEFORE INSERT ON umkm_documents BEGIN SELECT RAISE(ABORT, 'forced document failure'); END;");

    try {
        $this->withoutExceptionHandling()
            ->withSession(['selected_role' => 'umkm'])
            ->post(route('register.store'), [
                'name' => 'UMKM Applicant',
                'email' => 'rollback-umkm@example.test',
                'no_hp' => '+62 812-3456-7890',
                'password' => 'secret123',
                'password_confirmation' => 'secret123',
                'nama_usaha' => 'Toko Uji',
                'kategori_usaha' => 'Kuliner',
                'jenis_dokumen' => 'NIB',
                'dokumen_usaha' => UploadedFile::fake()->create('nib.pdf', 100, 'application/pdf'),
            ]);

        $this->fail('The document insert should fail.');
    } catch (QueryException) {
        $this->assertDatabaseMissing('users', ['email' => 'rollback-umkm@example.test']);
        $this->assertDatabaseCount('umkm_profiles', 0);
        $this->assertDatabaseCount('user_roles', 0);
        $this->assertSame([], Storage::disk('local')->allFiles());
    }
});

it('adds a role and its profile to the authenticated user without creating another user', function (): void {
    $user = User::query()->create([
        'nama' => 'Existing Customer',
        'email' => 'multi-role@example.test',
        'no_hp' => '+62 812-3456-7890',
        'password' => 'secret123',
        'status_akun' => 'aktif',
    ]);
    $customerRole = Role::query()->create(['nama_role' => 'customer']);
    $user->roles()->attach($customerRole->getKey(), ['tanggal_aktif' => now()]);
    Storage::fake('local');

    $this->actingAs($user)
        ->post(route('roles.select'), ['role' => 'umkm'])
        ->assertRedirect(route('register'));

    $this->post(route('register.store'), [
        'nama_usaha' => 'Kedai Lokal',
        'kategori_usaha' => 'Kuliner',
        'jenis_dokumen' => 'Surat Izin Usaha',
        'dokumen_usaha' => UploadedFile::fake()->create('izin.pdf', 100, 'application/pdf'),
    ])->assertRedirect(route('dashboard'));

    $this->assertDatabaseCount('users', 1);
    $this->assertDatabaseHas('umkm_profiles', ['user_id' => $user->getKey()]);
    $this->assertTrue($user->fresh()->hasRole('customer'));
    $this->assertTrue($user->fresh()->hasRole('umkm'));
    $this->assertAuthenticatedAs($user);
});

it('rejects an invalid KYC document before creating an investor account', function (): void {
    Storage::fake('local');

    $this->from(route('register'))
        ->withSession(['selected_role' => 'investor'])
        ->post(route('register.store'), [
            'name' => 'Investor Applicant',
            'email' => 'invalid-investor@example.test',
            'no_hp' => '+62 812-3456-7890',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
            'nik' => '3201011234567890',
            'pekerjaan' => 'Wiraswasta',
            'penghasilan' => '12000000',
            'jenis_investor' => 'Individu',
            'tingkat_risiko' => 'Moderat',
            'tujuan_investasi' => 'Mendukung usaha lokal',
            'ktp' => UploadedFile::fake()->create('ktp.exe', 20, 'application/x-msdownload'),
            'selfie' => UploadedFile::fake()->image('selfie.png'),
        ])
        ->assertRedirect(route('register'))
        ->assertSessionHasErrors('ktp');

    $this->assertDatabaseMissing('users', ['email' => 'invalid-investor@example.test']);
    $this->assertDatabaseCount('investor_profiles', 0);
});

it('requires Google-created investors to complete the role profile and KYC', function (): void {
    Storage::fake('local');
    $googleUser = Mockery::mock(SocialiteUser::class);
    $googleUser->shouldReceive('getId')->andReturn('google-investor-001');
    $googleUser->shouldReceive('getEmail')->andReturn('google-investor@example.test');
    $googleUser->shouldReceive('getName')->andReturn('Google Investor');
    $googleUser->shouldReceive('getAvatar')->andReturn(null);

    $driver = Mockery::mock();
    $driver->shouldReceive('user')->once()->andReturn($googleUser);
    Socialite::shouldReceive('driver')->with('google')->once()->andReturn($driver);

    $this->withSession(['selected_role' => 'investor'])
        ->get(route('auth.google.callback'))
        ->assertRedirect(route('register'));

    $user = User::query()->where('email', 'google-investor@example.test')->firstOrFail();

    $this->assertAuthenticatedAs($user);
    $this->assertDatabaseCount('users', 1);
    $this->assertDatabaseMissing('user_roles', ['user_id' => $user->getKey()]);

    $this->post(route('register.store'), [
        'no_hp' => '+62 812-7654-3210',
        'nik' => '3201011234567890',
        'pekerjaan' => 'Wiraswasta',
        'penghasilan' => '15000000',
        'jenis_investor' => 'Individu',
        'tingkat_risiko' => 'Moderat',
        'tujuan_investasi' => 'Mendukung usaha lokal',
        'ktp' => UploadedFile::fake()->create('ktp.pdf', 200, 'application/pdf'),
        'selfie' => UploadedFile::fake()->image('selfie.png'),
    ])->assertRedirect(route('dashboard'));

    $this->assertDatabaseCount('users', 1);
    $this->assertTrue($user->fresh()->hasRole('investor'));
    $this->assertSame('+62 812-7654-3210', $user->fresh()->no_hp);
    $this->assertDatabaseHas('investor_profiles', [
        'user_id' => $user->getKey(),
        'status_verifikasi' => 'pending',
    ]);
});
