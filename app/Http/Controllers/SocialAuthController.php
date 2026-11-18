<?php

namespace App\Http\Controllers;

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
        $selectedRole = session('selected_role', 'customer');
        $roleName = array_key_exists($selectedRole, config('umatch.roles', [])) ? $selectedRole : 'customer';
        session()->put('selected_role', $roleName);

        if ($user === null) {
            $user = User::query()->create([
                'nama' => $googleUser->getName() ?: 'Pengguna Google',
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'foto_profil' => $googleUser->getAvatar(),
                'status_akun' => 'aktif',
            ]);
        } elseif ($user->google_id !== $googleUser->getId()) {
            $user->forceFill([
                'google_id' => $googleUser->getId(),
                'foto_profil' => $googleUser->getAvatar() ?: $user->foto_profil,
            ])->save();
        }

        Auth::login($user);

        $profileExists = match ($roleName) {
            'customer' => $user->customerProfile()->exists(),
            'umkm' => $user->umkmProfile()->exists(),
            'investor' => $user->investorProfile()->exists(),
        };

        if (! $user->hasRole($roleName) || ! $profileExists) {
            return redirect()->route('register');
        }

        return redirect()->intended(route('dashboard'));
    }
}
