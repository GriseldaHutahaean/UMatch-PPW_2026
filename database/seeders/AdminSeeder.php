<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Seeds the four authorized UMatch Admin accounts.
 *
 * Run with: php artisan db:seed --class=AdminSeeder
 *
 * Credentials are intentionally set for the development environment only.
 * For production, run this seeder once and then change passwords through
 * the internal admin password-change process.
 */
class AdminSeeder extends Seeder
{
    /**
     * The four authorized admin accounts.
     *
     * @var array<int, array{name: string, username: string, password: string}>
     */
    private const ADMIN_ACCOUNTS = [
        ['name' => 'Griselda', 'username' => 'griselda', 'password' => 'admin123'],
        ['name' => 'Swasti',   'username' => 'swasti',   'password' => 'admin123'],
        ['name' => 'Laura',    'username' => 'laura',     'password' => 'admin123'],
        ['name' => 'Nicolas',  'username' => 'nicolas',   'password' => 'admin123'],
    ];

    public function run(): void
    {
        $adminRole = Role::query()->firstOrCreate(['nama_role' => 'admin']);

        foreach (self::ADMIN_ACCOUNTS as $account) {
            $user = User::query()->updateOrCreate(
                ['username_admin' => $account['username']],
                [
                    'nama' => $account['name'],
                    'email' => "{$account['username']}@admin.umatch.internal",
                    'password' => Hash::make($account['password']),
                    'status_akun' => 'aktif',
                ],
            );

            if (! $user->roles()->whereKey($adminRole->getKey())->exists()) {
                $user->roles()->attach($adminRole->getKey(), ['tanggal_aktif' => now()]);
            }
        }
    }
}
