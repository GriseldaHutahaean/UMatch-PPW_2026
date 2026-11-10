<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SocialAuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('splash');
})->name('landing');

Route::view('/onboarding', 'onboarding')->name('onboarding');

Route::get('/roles', fn () => view('auth.choose-role', [
    'selectedRole' => session('selected_role'),
]))->name('roles.choose');
Route::post('/roles', [AuthController::class, 'selectRole'])->name('roles.select');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
Route::get('/auth/google', [SocialAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

Route::middleware('auth')->group(function (): void {
    Route::get('/dashboard', function () {
        $selectedRole = session('selected_role');
        $role = $selectedRole && auth()->user()->hasRole($selectedRole)
            ? $selectedRole
            : auth()->user()->getPrimaryRole();

        return $role ? redirect()->route($role.'.dashboard') : redirect()->route('roles.choose');
    })->name('dashboard');

    foreach (['admin', 'customer', 'umkm', 'investor'] as $role) {
        Route::view("/{$role}/dashboard", 'dashboard', ['role' => $role])
            ->middleware("role:{$role}")
            ->name("{$role}.dashboard");
    }
});
