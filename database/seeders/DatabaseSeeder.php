<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        foreach (['admin', 'customer', 'umkm', 'investor'] as $roleName) {
            Role::query()->firstOrCreate(['nama_role' => $roleName]);
        }

        $users = [
            ['nama' => 'Admin UMatch', 'email' => 'admin@umatch.test', 'role' => 'admin'],
            ['nama' => 'Customer UMatch', 'email' => 'customer@umatch.test', 'role' => 'customer'],
            ['nama' => 'UMKM UMatch', 'email' => 'umkm@umatch.test', 'role' => 'umkm'],
            ['nama' => 'Investor UMatch', 'email' => 'investor@umatch.test', 'role' => 'investor'],
        ];

        foreach ($users as $userData) {
            $user = User::query()->updateOrCreate(
                ['email' => $userData['email']],
                ['nama' => $userData['nama'], 'password' => 'password123', 'status_akun' => 'aktif'],
            );

            $user->roles()->sync([
                Role::query()->where('nama_role', $userData['role'])->value('role_id') => ['tanggal_aktif' => now()],
            ]);
        }
    }
}
