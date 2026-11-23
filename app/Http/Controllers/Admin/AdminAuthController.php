<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminAuthController extends Controller
{
    /**
     * The list of authorized admin usernames (case-insensitive) and their display names.
     *
     * @var array<string, string>
     */
    private const AUTHORIZED_ADMINS = [
        'griselda' => 'Griselda',
        'swasti' => 'Swasti',
        'laura' => 'Laura',
        'nicolas' => 'Nicolas',
    ];

    /** Maximum failed attempts before temporary lockout. */
    private const MAX_ATTEMPTS = 5;

    /** Lockout duration in seconds (15 minutes). */
    private const LOCKOUT_SECONDS = 900;

    public function showLogin(Request $request): View|RedirectResponse
    {
        if (Auth::check() && Auth::user()->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        $sessionExpired = $request->session()->pull('admin_session_expired', false);

        return view('admin.login', [
            'sessionExpired' => $sessionExpired,
        ]);
    }

    public function login(Request $request): JsonResponse|RedirectResponse
    {
        $credentials = $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string'],
        ]);

        $throttleKey = $this->throttleKey($request);

        if (RateLimiter::tooManyAttempts($throttleKey, self::MAX_ATTEMPTS)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            $message = "Terlalu banyak percobaan login. Coba lagi dalam {$seconds} detik.";

            return $request->expectsJson()
                ? response()->json(['message' => $message], 429)
                : back()->withErrors(['username' => $message])->withInput($request->only('username'));
        }

        $username = strtolower(trim($credentials['username']));

        if (! array_key_exists($username, self::AUTHORIZED_ADMINS)) {
            RateLimiter::hit($throttleKey, self::LOCKOUT_SECONDS);

            $errorMessage = 'Access Denied. You are not authorized to access the UMatch Admin Portal.';

            return $request->expectsJson()
                ? response()->json(['message' => $errorMessage], 403)
                : back()->withErrors(['username' => $errorMessage])->withInput($request->only('username'));
        }

        $admin = User::query()
            ->where('username_admin', $username)
            ->whereHas('roles', fn ($query) => $query->where('nama_role', 'admin'))
            ->first();

        if ($admin === null || ! Hash::check($credentials['password'], $admin->password)) {
            RateLimiter::hit($throttleKey, self::LOCKOUT_SECONDS);

            $errorMessage = 'Invalid username or password. Please try again.';

            return $request->expectsJson()
                ? response()->json(['message' => $errorMessage], 422)
                : back()->withErrors(['password' => $errorMessage])->withInput($request->only('username'));
        }

        RateLimiter::clear($throttleKey);

        Auth::login($admin, $request->boolean('remember'));
        $request->session()->regenerate();
        $request->session()->put('admin_authenticated', true);

        $redirectUrl = route('admin.dashboard');

        return $request->expectsJson()
            ? response()->json(['redirect' => $redirectUrl])
            : redirect()->intended($redirectUrl);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    /**
     * Generate a unique throttle key for the given request.
     */
    private function throttleKey(Request $request): string
    {
        return 'admin_login|'.Str::lower($request->input('username', '')).'|'.$request->ip();
    }
}
