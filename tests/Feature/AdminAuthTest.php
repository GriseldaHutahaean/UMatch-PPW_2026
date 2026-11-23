<?php

use App\Models\Role;
use App\Models\User;
use Database\Seeders\AdminSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

beforeEach(function (): void {
    config(['app.key' => 'base64:'.base64_encode(str_repeat('a', 32))]);
    $this->withoutVite();
});

// ─────────────────────────────────────────────────────────────────────────────
// Helpers
// ─────────────────────────────────────────────────────────────────────────────

function createAdminAccount(string $username, string $password = 'admin123'): User
{
    $adminRole = Role::query()->firstOrCreate(['nama_role' => 'admin']);

    $user = User::query()->create([
        'nama' => ucfirst($username),
        'email' => "{$username}@admin.umatch.internal",
        'username_admin' => $username,
        'password' => Hash::make($password),
        'status_akun' => 'aktif',
    ]);

    $user->roles()->attach($adminRole->getKey(), ['tanggal_aktif' => now()]);

    return $user;
}

// ─────────────────────────────────────────────────────────────────────────────
// Admin login page visibility
// ─────────────────────────────────────────────────────────────────────────────

it('shows the admin login page at /admin/login', function (): void {
    $this->get(route('admin.login'))->assertOk()->assertSee('UMatch Admin Portal');
});

// ─────────────────────────────────────────────────────────────────────────────
// Authorized admin logins (Test 1 – 4)
// ─────────────────────────────────────────────────────────────────────────────

it('allows griselda to log in with correct credentials', function (): void {
    createAdminAccount('griselda');

    $this->post(route('admin.login.store'), [
        'username' => 'griselda',
        'password' => 'admin123',
    ])->assertRedirect(route('admin.dashboard'));

    $this->assertAuthenticated();
});

it('allows swasti to log in with correct credentials', function (): void {
    createAdminAccount('swasti');

    $this->post(route('admin.login.store'), [
        'username' => 'swasti',
        'password' => 'admin123',
    ])->assertRedirect(route('admin.dashboard'));

    $this->assertAuthenticated();
});

it('allows laura to log in with correct credentials', function (): void {
    createAdminAccount('laura');

    $this->post(route('admin.login.store'), [
        'username' => 'laura',
        'password' => 'admin123',
    ])->assertRedirect(route('admin.dashboard'));

    $this->assertAuthenticated();
});

it('allows nicolas to log in with correct credentials', function (): void {
    createAdminAccount('nicolas');

    $this->post(route('admin.login.store'), [
        'username' => 'nicolas',
        'password' => 'admin123',
    ])->assertRedirect(route('admin.dashboard'));

    $this->assertAuthenticated();
});

// ─────────────────────────────────────────────────────────────────────────────
// Username is treated case-insensitively
// ─────────────────────────────────────────────────────────────────────────────

it('treats the username comparison as case-insensitive', function (): void {
    createAdminAccount('griselda');

    $this->post(route('admin.login.store'), [
        'username' => 'GRISELDA',
        'password' => 'admin123',
    ])->assertRedirect(route('admin.dashboard'));
});

// ─────────────────────────────────────────────────────────────────────────────
// Unauthorized username (Test 5 — Scenario B)
// ─────────────────────────────────────────────────────────────────────────────

it('denies access when the username is not in the authorized allowlist', function (): void {
    $this->post(route('admin.login.store'), [
        'username' => 'unknownuser',
        'password' => 'admin123',
    ])->assertSessionHasErrors(['username']);

    $this->assertGuest();
});

it('returns a 403 JSON response for an unauthorized username via AJAX', function (): void {
    $this->postJson(route('admin.login.store'), [
        'username' => 'hacker',
        'password' => 'admin123',
    ])->assertStatus(403)->assertJsonFragment(['message' => 'Access Denied. You are not authorized to access the UMatch Admin Portal.']);
});

// ─────────────────────────────────────────────────────────────────────────────
// Incorrect password (Test 6 — Scenario C)
// ─────────────────────────────────────────────────────────────────────────────

it('rejects login when the password is wrong for an authorized username', function (): void {
    createAdminAccount('griselda');

    $this->post(route('admin.login.store'), [
        'username' => 'griselda',
        'password' => 'wrongpassword',
    ])->assertSessionHasErrors(['password']);

    $this->assertGuest();
});

it('password comparison is case-sensitive', function (): void {
    createAdminAccount('griselda');

    $this->post(route('admin.login.store'), [
        'username' => 'griselda',
        'password' => 'Admin123',
    ])->assertSessionHasErrors(['password']);

    $this->assertGuest();
});

// ─────────────────────────────────────────────────────────────────────────────
// Unauthorized direct URL access (Test 7 — Scenario D)
// ─────────────────────────────────────────────────────────────────────────────

it('redirects unauthenticated requests to /admin/dashboard to the admin login', function (): void {
    $this->get(route('admin.dashboard'))->assertRedirect(route('admin.login'));
});

it('redirects unauthenticated requests to /admin/users to the admin login', function (): void {
    $this->get(route('admin.users'))->assertRedirect(route('admin.login'));
});

it('redirects unauthenticated requests to /admin/umkm-verification to the admin login', function (): void {
    $this->get(route('admin.umkm-verification'))->assertRedirect(route('admin.login'));
});

it('redirects unauthenticated requests to /admin/investor-kyc to the admin login', function (): void {
    $this->get(route('admin.investor-kyc'))->assertRedirect(route('admin.login'));
});

it('redirects unauthenticated requests to /admin/content-moderation to the admin login', function (): void {
    $this->get(route('admin.content-moderation'))->assertRedirect(route('admin.login'));
});

// ─────────────────────────────────────────────────────────────────────────────
// A regular non-admin user cannot access admin routes (Test 12)
// ─────────────────────────────────────────────────────────────────────────────

it('denies a regular non-admin authenticated user access to admin routes', function (): void {
    $customerRole = Role::query()->firstOrCreate(['nama_role' => 'customer']);

    $customer = User::query()->create([
        'nama' => 'Regular Customer',
        'email' => 'customer@example.test',
        'password' => 'password',
        'status_akun' => 'aktif',
    ]);

    $customer->roles()->attach($customerRole->getKey(), ['tanggal_aktif' => now()]);

    $this->actingAs($customer)->get(route('admin.dashboard'))->assertRedirect(route('admin.login'));
});

// ─────────────────────────────────────────────────────────────────────────────
// Logout (Test 8 — Scenario)
// ─────────────────────────────────────────────────────────────────────────────

it('logs out the admin and redirects to the admin login page', function (): void {
    $admin = createAdminAccount('griselda');

    $this->actingAs($admin)
        ->post(route('admin.logout'))
        ->assertRedirect(route('admin.login'));

    $this->assertGuest();
});

it('redirects to admin login after logout when accessing a protected admin route', function (): void {
    $admin = createAdminAccount('griselda');

    $this->actingAs($admin)->post(route('admin.logout'));

    $this->get(route('admin.dashboard'))->assertRedirect(route('admin.login'));
});

// ─────────────────────────────────────────────────────────────────────────────
// Admin seeder creates exactly four admin accounts (Test 10)
// ─────────────────────────────────────────────────────────────────────────────

it('seeds exactly the four authorized admin accounts', function (): void {
    Role::query()->firstOrCreate(['nama_role' => 'admin']);

    $this->seed(AdminSeeder::class);

    foreach (['griselda', 'swasti', 'laura', 'nicolas'] as $username) {
        $user = User::query()->where('username_admin', $username)->first();

        expect($user)->not->toBeNull()
            ->and($user->hasRole('admin'))->toBeTrue()
            ->and(Hash::check('admin123', $user->password))->toBeTrue();
    }
});

it('does not create more than four admin accounts via the seeder', function (): void {
    Role::query()->firstOrCreate(['nama_role' => 'admin']);

    $this->seed(AdminSeeder::class);

    $adminCount = User::query()->whereNotNull('username_admin')->count();

    expect($adminCount)->toBe(4);
});

// ─────────────────────────────────────────────────────────────────────────────
// Admin login page does not contain social login options (Test 11)
// ─────────────────────────────────────────────────────────────────────────────

it('does not show Google Sign-In on the admin login page', function (): void {
    $this->get(route('admin.login'))
        ->assertDontSee('google')
        ->assertDontSee('Sign in with Google')
        ->assertDontSee('auth.google');
});

// ─────────────────────────────────────────────────────────────────────────────
// Admin identity is displayed correctly after login (Test: identity display)
// ─────────────────────────────────────────────────────────────────────────────

it('shows the correct admin display name on the dashboard after login', function (): void {
    $admin = createAdminAccount('griselda');

    $this->actingAs($admin)
        ->get(route('admin.dashboard'))
        ->assertOk()
        ->assertSee('Welcome back, Griselda.');
});

// ─────────────────────────────────────────────────────────────────────────────
// Admin login redirected when already authenticated (admin.guest middleware)
// ─────────────────────────────────────────────────────────────────────────────

it('redirects an already-authenticated admin away from the login page', function (): void {
    $admin = createAdminAccount('griselda');

    $this->actingAs($admin)
        ->get(route('admin.login'))
        ->assertRedirect(route('admin.dashboard'));
});

// ─────────────────────────────────────────────────────────────────────────────
// Rate limiting
// ─────────────────────────────────────────────────────────────────────────────

it('locks out the client after too many failed login attempts', function (): void {
    for ($i = 0; $i < 5; $i++) {
        $this->post(route('admin.login.store'), [
            'username' => 'unknownuser',
            'password' => 'wrongpassword',
        ]);
    }

    $this->post(route('admin.login.store'), [
        'username' => 'unknownuser',
        'password' => 'wrongpassword',
    ])->assertSessionHasErrors(['username']);
});
