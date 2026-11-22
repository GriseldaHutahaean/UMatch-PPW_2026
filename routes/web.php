<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\UmkmDashboardController;
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

    Route::middleware('role:umkm')->prefix('umkm')->name('umkm.')->group(function (): void {
        Route::get('/products', [UmkmDashboardController::class, 'products'])->name('products');
        Route::get('/orders', [UmkmDashboardController::class, 'orders'])->name('orders');
        Route::get('/stock', [UmkmDashboardController::class, 'stock'])->name('stock');
        Route::get('/finance', [UmkmDashboardController::class, 'finance'])->name('finance');
        Route::get('/investors', [UmkmDashboardController::class, 'investors'])->name('investors');
        Route::get('/reports', [UmkmDashboardController::class, 'reports'])->name('reports');
        Route::get('/store', [UmkmDashboardController::class, 'store'])->name('store');
    });
});
