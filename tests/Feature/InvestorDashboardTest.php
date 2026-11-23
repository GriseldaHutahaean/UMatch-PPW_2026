<?php

use App\Models\InvestorProfile;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
