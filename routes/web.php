<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InvestorDashboardController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\UmkmDashboardController;
use Illuminate\Support\Facades\Route;

// ─────────────────────────────────────────────────────────────────────────────
// Admin-only routes — completely separate from public authentication
// ─────────────────────────────────────────────────────────────────────────────

// Admin guest routes (redirect to dashboard if already authenticated as admin)
Route::prefix('admin')->name('admin.')->middleware('admin.guest')->group(function (): void {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.store');
});

// Admin protected routes
Route::prefix('admin')->name('admin.')->middleware('admin.auth')->group(function (): void {
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Reserved admin sub-sections (protected, placeholder for future implementation)
    Route::get('/users', fn () => view('admin.dashboard', ['admin' => auth()->user()]))->name('users');
    Route::get('/umkm-verification', fn () => view('admin.dashboard', ['admin' => auth()->user()]))->name('umkm-verification');
    Route::get('/investor-kyc', fn () => view('admin.dashboard', ['admin' => auth()->user()]))->name('investor-kyc');
    Route::get('/content-moderation', fn () => view('admin.dashboard', ['admin' => auth()->user()]))->name('content-moderation');
});

// ─────────────────────────────────────────────────────────────────────────────
// Public routes — Customer, UMKM, and Investor (unchanged)
// ─────────────────────────────────────────────────────────────────────────────

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

    // Public role dashboards (admin excluded — admin uses its own /admin/dashboard)
    foreach (['customer', 'umkm'] as $role) {
        Route::view("/{$role}/dashboard", 'dashboard', ['role' => $role])
            ->middleware("role:{$role}")
            ->name("{$role}.dashboard");
    }

    Route::middleware('role:investor')->prefix('investor')->name('investor.')->group(function (): void {
        Route::get('/dashboard', [InvestorDashboardController::class, 'index'])->name('dashboard');
        Route::get('/explore', [InvestorDashboardController::class, 'explore'])->name('explore');
        Route::get('/offers', [InvestorDashboardController::class, 'offers'])->name('offers');
    });

    Route::middleware('role:umkm')->prefix('umkm')->name('umkm.')->group(function (): void {
        Route::get('/products', [UmkmDashboardController::class, 'products'])->name('products');
        Route::get('/products/create', [UmkmDashboardController::class, 'createProduct'])->name('products.create');
        Route::post('/products', [UmkmDashboardController::class, 'storeProduct'])->name('products.store');
        Route::get('/orders', [UmkmDashboardController::class, 'orders'])->name('orders');
        Route::get('/stock', [UmkmDashboardController::class, 'stock'])->name('stock');
        Route::get('/finance', [UmkmDashboardController::class, 'finance'])->name('finance');
        Route::get('/investors', [UmkmDashboardController::class, 'investors'])->name('investors');
        Route::get('/reports', [UmkmDashboardController::class, 'reports'])->name('reports');
        Route::get('/store', [UmkmDashboardController::class, 'store'])->name('store');
    });
});
