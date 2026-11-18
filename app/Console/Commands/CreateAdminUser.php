<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

#[Signature('umatch:admin:create')]
#[Description('Create an Admin account through the internal CLI.')]
class CreateAdminUser extends Command
{
    public function handle(): int
    {
        $name = $this->ask('Nama lengkap');
        $email = $this->ask('Email');
        $password = $this->secret('Password');
        $passwordConfirmation = $this->secret('Konfirmasi password');

        $validator = Validator::make([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $passwordConfirmation,
        ], [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:12', 'confirmed'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return self::FAILURE;
        }

        DB::transaction(function () use ($name, $email, $password): void {
            $user = User::query()->create([
                'nama' => $name,
                'email' => $email,
                'password' => $password,
                'status_akun' => 'aktif',
            ]);

            $adminRole = Role::query()->firstOrCreate(['nama_role' => 'admin']);
            $user->roles()->attach($adminRole->getKey(), ['tanggal_aktif' => now()]);
        });

        $this->info('Akun Admin berhasil dibuat.');

        return self::SUCCESS;
    }
}
