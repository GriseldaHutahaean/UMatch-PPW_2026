<?php

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

it('creates an admin from hidden interactive credentials', function (): void {
    $this->artisan('umatch:admin:create')
        ->expectsQuestion('Nama lengkap', 'Internal Admin')
        ->expectsQuestion('Email', 'internal-admin@example.test')
        ->expectsQuestion('Password', 'A-Strong-Admin-Password-123')
        ->expectsQuestion('Konfirmasi password', 'A-Strong-Admin-Password-123')
        ->expectsOutput('Akun Admin berhasil dibuat.')
        ->assertExitCode(0);

    $admin = User::query()->where('email', 'internal-admin@example.test')->firstOrFail();

    expect($admin->hasRole('admin'))->toBeTrue()
        ->and(Hash::check('A-Strong-Admin-Password-123', $admin->password))->toBeTrue();
});

it('does not create an admin when the interactive password confirmation differs', function (): void {
    $this->artisan('umatch:admin:create')
        ->expectsQuestion('Nama lengkap', 'Internal Admin')
        ->expectsQuestion('Email', 'mismatch-admin@example.test')
        ->expectsQuestion('Password', 'A-Strong-Admin-Password-123')
        ->expectsQuestion('Konfirmasi password', 'Different-Admin-Password-123')
        ->expectsOutputToContain('The password field confirmation does not match.')
        ->assertExitCode(1);

    $this->assertDatabaseMissing('users', ['email' => 'mismatch-admin@example.test']);
});

it('does not seed a default admin account', function (): void {
    $this->seed(DatabaseSeeder::class);

    $this->assertDatabaseHas('roles', ['nama_role' => 'admin']);
    $this->assertDatabaseMissing('users', ['email' => 'admin@umatch.test']);
});
