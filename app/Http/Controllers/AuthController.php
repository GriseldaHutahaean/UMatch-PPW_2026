<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(Request $request): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        $selectedRole = session('selected_role', $request->string('role')->toString());

        if (! array_key_exists($selectedRole, config('umatch.roles', []))) {
            return redirect()->route('roles.choose');
        }

        session()->put('selected_role', $selectedRole);

        return view('auth.login', [
            'selectedRole' => $selectedRole,
            'roleLabel' => config("umatch.roles.{$selectedRole}.label"),
        ]);
    }

    public function selectRole(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'role' => ['required', 'string', 'in:customer,umkm,investor'],
        ]);

        $request->session()->put('selected_role', $validated['role']);

        return redirect()->route('login');
    }

    public function showRegister(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        $selectedRole = session('selected_role');

        if (! array_key_exists($selectedRole, config('umatch.roles', []))) {
            return redirect()->route('roles.choose');
        }

        return view('auth.register', [
            'selectedRole' => $selectedRole,
            'roleLabel' => config("umatch.roles.{$selectedRole}.label"),
        ]);
    }

    public function register(Request $request): RedirectResponse
    {
        $selectedRole = session('selected_role');

        if (! array_key_exists($selectedRole, config('umatch.roles', []))) {
            return redirect()->route('roles.choose');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::query()->create([
            'nama' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'status_akun' => 'aktif',
        ]);

        $role = Role::query()->firstOrCreate(['nama_role' => $selectedRole]);
        $user->roles()->attach($role->getKey(), ['tanggal_aktif' => now()]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    public function login(Request $request): JsonResponse|RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return $request->expectsJson()
                ? response()->json(['message' => 'Email atau password salah.'], 422)
                : back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
        }

        $request->session()->regenerate();

        return $request->expectsJson()
            ? response()->json(['redirect' => route('dashboard')])
            : redirect()->intended(route('dashboard'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
