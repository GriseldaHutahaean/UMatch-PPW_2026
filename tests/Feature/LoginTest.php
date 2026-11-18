<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

beforeEach(function (): void {
    config(['app.key' => 'base64:'.base64_encode(str_repeat('a', 32))]);
});

it('keeps the existing login flow working for an existing user', function (): void {
    $user = User::query()->create([
        'nama' => 'Existing Customer',
        'email' => 'existing-customer@example.test',
        'password' => 'existing-password',
        'status_akun' => 'aktif',
    ]);
    $role = Role::query()->create(['nama_role' => 'customer']);
    $user->roles()->attach($role->getKey(), ['tanggal_aktif' => now()]);

    $this->post(route('login.store'), [
        'email' => 'existing-customer@example.test',
        'password' => 'existing-password',
    ])
        ->assertRedirect(route('dashboard'));

    $this->assertAuthenticatedAs($user);
});
