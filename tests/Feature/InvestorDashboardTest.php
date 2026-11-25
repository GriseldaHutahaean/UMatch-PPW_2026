<?php

use App\Models\FinancialCategory;
use App\Models\InvestmentOffer;
use App\Models\InvestorProfile;
use App\Models\Role;
use App\Models\UmkmProfile;
use App\Models\User;
use Database\Seeders\InvestmentOfferSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

beforeEach(function (): void {
    config(['app.key' => 'base64:'.base64_encode(str_repeat('a', 32))]);
    $this->withoutVite();
});

function createUserWithRole(string $roleName, string $email): User
{
    $user = User::query()->create([
        'nama' => 'Pak Investor',
        'email' => $email,
        'password' => 'secret-password',
        'status_akun' => 'aktif',
    ]);
    $role = Role::query()->firstOrCreate(['nama_role' => $roleName]);
    $user->roles()->attach($role->getKey(), ['tanggal_aktif' => now()]);

    return $user;
}

it('shows the investor dashboard with the KYC status and risk profile of the investor', function (): void {
    $user = createUserWithRole('investor', 'investor@example.test');
    InvestorProfile::query()->create([
        'user_id' => $user->getKey(),
        'nik' => '1234567890123456',
        'pekerjaan' => 'Wiraswasta',
        'penghasilan' => 10000000,
        'jenis_investor' => 'Individu',
        'tingkat_risiko' => 'Moderat',
        'tujuan_investasi' => 'Pertumbuhan modal',
        'status_verifikasi' => 'verified',
    ]);

    $this->actingAs($user)
        ->get(route('investor.dashboard'))
        ->assertOk()
        ->assertSee('Dashboard Investor')
        ->assertSee('KYC Terverifikasi')
        ->assertSee('Profil Risiko: Moderat')
        ->assertSeeInOrder(['Total Investasi', 'UMKM Didanai', 'Return Investasi', 'Portofolio Aktif'])
        ->assertSeeInOrder(['Alokasi Investasi', 'UMKM Terverifikasi', 'Tawaran Investasi Terbaru', 'Menu'])
        ->assertSeeInOrder(['Jelajahi UMKM', 'Portofolio', 'Tawaran Saya', 'Verifikasi KYC', 'Bantuan']);
});

it('searches UMKM from the header search box', function (): void {
    $user = createUserWithRole('investor', 'header-search@example.test');

    $this->actingAs($user)
        ->get(route('investor.dashboard'))
        ->assertSee('action="'.route('investor.explore').'" role="search"', false);
});

it('shows the current month revenue of a verified UMKM', function (): void {
    $user = createUserWithRole('investor', 'revenue@example.test');
    $umkm = createUmkmProfile('Dapur Batak', 'Makanan', 'verified');
    $category = FinancialCategory::query()->create(['nama_kategori' => 'Penjualan', 'jenis' => 'pemasukan']);

    foreach ([
        ['pemasukan', 1500000, now()],
        ['pemasukan', 500000, now()->startOfMonth()],
        ['pengeluaran', 900000, now()],
        ['pemasukan', 7000000, now()->subMonthsNoOverflow()],
    ] as [$type, $amount, $date]) {
        $umkm->financialTransactions()->create([
            'fin_category_id' => $category->getKey(),
            'jenis' => $type,
            'nominal' => $amount,
            'tanggal' => $date->toDateString(),
        ]);
    }

    $this->actingAs($user)
        ->get(route('investor.explore'))
        ->assertSee('Rp 2.000.000');
});

it('tells the investor when a UMKM has no transaction data', function (): void {
    $user = createUserWithRole('investor', 'no-revenue@example.test');
    createUmkmProfile('Toko Baru', 'Makanan', 'verified');

    $this->actingAs($user)
        ->get(route('investor.explore'))
        ->assertSee('Belum ada data transaksi');
});

it('shows a pending KYC status when the investor is not verified yet', function (): void {
    $user = createUserWithRole('investor', 'pending-investor@example.test');
    InvestorProfile::query()->create([
        'user_id' => $user->getKey(),
        'nik' => '1234567890123456',
        'pekerjaan' => 'Wiraswasta',
        'penghasilan' => 10000000,
        'jenis_investor' => 'Individu',
        'tingkat_risiko' => 'Agresif',
        'tujuan_investasi' => 'Pertumbuhan modal',
        'status_verifikasi' => 'pending',
    ]);

    $this->actingAs($user)
        ->get(route('investor.dashboard'))
        ->assertOk()
        ->assertSee('KYC Menunggu Verifikasi');
});

it('forbids users without the investor role from the investor dashboard', function (): void {
    $customer = createUserWithRole('customer', 'customer@example.test');

    $this->actingAs($customer)
        ->get(route('investor.dashboard'))
        ->assertForbidden();
});

it('redirects guests away from the investor dashboard', function (): void {
    $this->get(route('investor.dashboard'))
        ->assertRedirect();
});

it('sends an investor to the investor dashboard after login', function (): void {
    $user = createUserWithRole('investor', 'login-investor@example.test');

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertRedirect(route('investor.dashboard'));
});

function createUmkmProfile(string $businessName, string $category, string $status, bool $acceptsInvestment = true, string $address = 'Balige'): UmkmProfile
{
    $owner = createUserWithRole('umkm', Str::slug($businessName).'@example.test');

    return UmkmProfile::query()->create([
        'user_id' => $owner->getKey(),
        'nama_usaha' => $businessName,
        'kategori_usaha' => $category,
        'alamat_usaha' => $address,
        'status_verifikasi' => $status,
        'terima_investasi' => $acceptsInvestment,
    ]);
}

it('links the Jelajah UMKM quick action on the dashboard to the explore page', function (): void {
    $user = createUserWithRole('investor', 'quick-action@example.test');

    $this->actingAs($user)
        ->get(route('investor.dashboard'))
        ->assertOk()
        ->assertSee('href="'.route('investor.explore').'"', false);
});

it('lists only verified UMKM on the explore page', function (): void {
    $user = createUserWithRole('investor', 'explorer@example.test');
    createUmkmProfile('Dapur Batak', 'Makanan', 'verified');
    createUmkmProfile('Toko Pending', 'Makanan', 'pending');
    createUmkmProfile('Toko Ditolak', 'Makanan', 'rejected');

    $this->actingAs($user)
        ->get(route('investor.explore'))
        ->assertOk()
        ->assertSee('Dapur Batak')
        ->assertDontSee('Toko Pending')
        ->assertDontSee('Toko Ditolak')
        ->assertSee('1 UMKM terverifikasi ditemukan');
});

it('shows whether a verified UMKM is open for funding', function (): void {
    $user = createUserWithRole('investor', 'funding@example.test');
    createUmkmProfile('Kopi Terbuka', 'Minuman', 'verified', true);
    createUmkmProfile('Kopi Tertutup', 'Minuman', 'verified', false);

    $this->actingAs($user)
        ->get(route('investor.explore'))
        ->assertSee('Pendanaan terbuka')
        ->assertSee('Pendanaan tertutup');
});

it('filters the explore page by search keyword and category', function (): void {
    $user = createUserWithRole('investor', 'filter@example.test');
    createUmkmProfile('Dapur Batak', 'Makanan', 'verified', true, 'Balige');
    createUmkmProfile('Tenun Ulos', 'Kerajinan', 'verified', true, 'Sibolga');

    $this->actingAs($user)
        ->get(route('investor.explore', ['q' => 'Sibolga']))
        ->assertSee('Tenun Ulos')
        ->assertDontSee('Dapur Batak');

    $this->actingAs($user)
        ->get(route('investor.explore', ['kategori' => 'Makanan']))
        ->assertSee('Dapur Batak')
        ->assertDontSee('Tenun Ulos');
});

it('shows an empty state when no verified UMKM matches', function (): void {
    $user = createUserWithRole('investor', 'empty@example.test');

    $this->actingAs($user)
        ->get(route('investor.explore', ['q' => 'tidak-ada']))
        ->assertOk()
        ->assertSee('Belum ada UMKM yang cocok');
});

it('forbids users without the investor role from the explore page', function (): void {
    $customer = createUserWithRole('customer', 'customer-explore@example.test');

    $this->actingAs($customer)
        ->get(route('investor.explore'))
        ->assertForbidden();
});

function createInvestorProfile(User $user): InvestorProfile
{
    return InvestorProfile::query()->create([
        'user_id' => $user->getKey(),
        'nik' => '1234567890123456',
        'pekerjaan' => 'Wiraswasta',
        'penghasilan' => 10000000,
        'jenis_investor' => 'Individu',
        'tingkat_risiko' => 'Moderat',
        'tujuan_investasi' => 'Pertumbuhan modal',
        'status_verifikasi' => 'verified',
    ]);
}

it('links the Tawaran Saya quick action and Tawaran menu to the offers page', function (): void {
    $user = createUserWithRole('investor', 'offer-links@example.test');

    $this->actingAs($user)
        ->get(route('investor.dashboard'))
        ->assertOk()
        ->assertSee('href="'.route('investor.offers').'"', false);
});

it('lists only the offers that belong to the logged in investor', function (): void {
    $user = createUserWithRole('investor', 'my-offers@example.test');
    $otherUser = createUserWithRole('investor', 'other-offers@example.test');
    InvestmentOffer::factory()->create([
        'investor_profile_id' => createInvestorProfile($user)->getKey(),
        'umkm_profile_id' => createUmkmProfile('Dapur Batak', 'Makanan', 'verified')->getKey(),
        'jumlah_penawaran' => 50000000,
        'skema_investasi' => '15% ekuitas',
    ]);
    InvestmentOffer::factory()->create([
        'investor_profile_id' => createInvestorProfile($otherUser)->getKey(),
        'umkm_profile_id' => createUmkmProfile('Toko Orang Lain', 'Makanan', 'verified')->getKey(),
    ]);

    $this->actingAs($user)
        ->get(route('investor.offers'))
        ->assertOk()
        ->assertSee('Dapur Batak')
        ->assertSee('Rp 50.000.000')
        ->assertSee('15% ekuitas')
        ->assertSee('1 tawaran investasi dikirim ke UMKM')
        ->assertDontSee('Toko Orang Lain');
});

it('filters offers by status', function (): void {
    $user = createUserWithRole('investor', 'status-offers@example.test');
    $profile = createInvestorProfile($user);
    InvestmentOffer::factory()->create([
        'investor_profile_id' => $profile->getKey(),
        'umkm_profile_id' => createUmkmProfile('Kopi Menunggu', 'Minuman', 'verified')->getKey(),
    ]);
    InvestmentOffer::factory()->accepted()->create([
        'investor_profile_id' => $profile->getKey(),
        'umkm_profile_id' => createUmkmProfile('Tenun Diterima', 'Kerajinan', 'verified')->getKey(),
    ]);

    $this->actingAs($user)
        ->get(route('investor.offers', ['status' => 'diterima']))
        ->assertSee('Tenun Diterima')
        ->assertDontSee('Kopi Menunggu')
        ->assertSee('Semua (2)')
        ->assertSee('Menunggu (1)');
});

it('rejects an unknown offer status filter', function (): void {
    $user = createUserWithRole('investor', 'bad-status@example.test');

    $this->actingAs($user)
        ->get(route('investor.offers', ['status' => 'ngawur']))
        ->assertSessionHasErrors('status');
});

it('shows an empty state when the investor has no offers', function (): void {
    $user = createUserWithRole('investor', 'no-offers@example.test');

    $this->actingAs($user)
        ->get(route('investor.offers'))
        ->assertOk()
        ->assertSee('Kamu belum mengirim tawaran');
});

it('forbids users without the investor role from the offers page', function (): void {
    $customer = createUserWithRole('customer', 'customer-offers@example.test');

    $this->actingAs($customer)
        ->get(route('investor.offers'))
        ->assertForbidden();
});

it('seeds sample offers without creating duplicates', function (): void {
    createInvestorProfile(createUserWithRole('investor', 'seeded@example.test'));
    createUmkmProfile('Dapur Batak', 'Makanan', 'verified');

    $this->seed(InvestmentOfferSeeder::class);
    $this->seed(InvestmentOfferSeeder::class);

    expect(InvestmentOffer::query()->count())->toBe(1);
});
