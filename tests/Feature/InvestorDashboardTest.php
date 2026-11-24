<?php

use App\Models\InvestorProfile;
use App\Models\Role;
use App\Models\UmkmProfile;
use App\Models\User;
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
        ->assertSee('Perkembangan Portofolio')
        ->assertSee('Tawaran Investasi Terbaru');
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
