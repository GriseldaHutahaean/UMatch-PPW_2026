<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirectToGoogle(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(): RedirectResponse
    {
        $googleUser = Socialite::driver('google')->user();
        $user = User::query()->where('google_id', $googleUser->getId())
            ->orWhere('email', $googleUser->getEmail())
            ->first();

        if ($user === null) {
            $user = User::query()->create([
                'nama' => $googleUser->getName() ?: 'Pengguna Google',
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'foto_profil' => $googleUser->getAvatar(),
                'status_akun' => 'aktif',
            ]);

            $selectedRole = session('selected_role', 'customer');
            $roleName = array_key_exists($selectedRole, config('umatch.roles', [])) ? $selectedRole : 'customer';
            $role = Role::query()->firstOrCreate(['nama_role' => $roleName]);
            $user->roles()->attach($role->getKey(), ['tanggal_aktif' => now()]);
        } elseif ($user->google_id !== $googleUser->getId()) {
            $user->forceFill([
                'google_id' => $googleUser->getId(),
                'foto_profil' => $googleUser->getAvatar() ?: $user->foto_profil,
            ])->save();
        }

        Auth::login($user, true);

        return redirect()->intended(route('dashboard'));
    }
}
