<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UMatch Admin Portal</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-white text-slate-900">

<main class="grid min-h-screen lg:grid-cols-2">

    {{-- Left panel: dark teal branding --}}
<section class="relative hidden overflow-hidden bg-emerald-950 p-10 text-white lg:flex lg:flex-col lg:justify-between lg:p-14">
        <div class="absolute -right-28 -top-28 h-96 w-96 rounded-full bg-[#1a4544]/40"></div>
<div class="absolute -bottom-28 -left-28 h-80 w-80 rounded-full bg-emerald-400/15"></div>

        {{-- Logo + name --}}
        <a href="/" class="relative z-10 flex items-center gap-3">
            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-white">
                <x-logo size="24" />
            </span>
            <span class="text-xl font-extrabold tracking-tight">UMatch</span>
<span class="rounded-full bg-emerald-400/25 px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-widest text-emerald-200">Admin Console</span>
        </a>

        {{-- Hero content --}}
        <div class="relative z-10 max-w-sm">
<div class="mb-6 inline-flex items-center gap-2 rounded-full border border-emerald-400/30 bg-emerald-400/10 px-4 py-2 text-xs font-semibold text-emerald-200">
<span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                Akses internal terenkripsi
            </div>
            <h1 class="text-4xl font-extrabold leading-tight xl:text-5xl">
                Satu ruang kendali<br>untuk ekosistem yang<br>terus bertumbuh.
            </h1>
            <p class="mt-5 text-sm font-medium leading-relaxed text-slate-400">
                Verifikasi, moderasi, dan pantau kesehatan platform UMatch<br>
                dengan keputusan yang tercatat dan transparan.
            </p>
        </div>

        {{-- Footer --}}
        <div class="relative z-10 flex items-center justify-between text-xs text-slate-500">
            <span>UMatch Internal</span>
            <span>Secure Console v2.5</span>
        </div>
    </section>

    {{-- Right panel: login form --}}
    <section class="flex min-h-screen items-center justify-center px-6 py-10 sm:px-12 lg:px-16">
        <div class="w-full max-w-md">

            {{-- Mobile logo --}}
            <div class="mb-10 flex items-center gap-3 lg:hidden">
<span class="flex h-9 w-9 items-center justify-center rounded-lg bg-emerald-950">
                    <x-logo size="24" />
                </span>
                <span class="text-xl font-extrabold text-slate-900">UMatch</span>
                <span class="rounded-full bg-slate-100 px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-widest text-slate-500">Admin</span>
            </div>

            {{-- Session-expired banner --}}
            @if ($sessionExpired)
                <div class="mb-6 flex items-start gap-3 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm font-medium text-amber-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Your session has expired. Please sign in again.
                </div>
            @endif

            {{-- Header --}}
<div class="mb-2 text-xs font-bold uppercase tracking-widest text-emerald-700">ADM-01 · Admin Login</div>
            <h2 class="text-3xl font-extrabold tracking-tight text-slate-900">UMatch Admin Portal</h2>
            <p class="mt-2 text-sm text-slate-500">Secure access for authorized UMatch administrators.</p>

            {{-- Form card --}}
            <div class="mt-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                <form id="admin-login-form" action="{{ route('admin.login.store') }}" method="POST" novalidate class="space-y-5">
                    @csrf

                    {{-- Username --}}
                    <div>
                        <label for="username" class="mb-2 block text-xs font-semibold text-slate-600">Username</label>
                        <div class="relative">
                            <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </span>
                            <input
                                id="username"
                                name="username"
                                type="text"
                                value="{{ old('username') }}"
                                autocomplete="username"
                                required
class="h-12 w-full rounded-xl border border-slate-200 bg-slate-50 pl-11 pr-4 text-sm outline-none transition focus:border-emerald-700 focus:ring-4 focus:ring-emerald-200 @error('username') border-red-400 bg-red-50 @enderror"
                                placeholder="admin username"
                            >
                        </div>
                        @error('username')
                            <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password" class="mb-2 block text-xs font-semibold text-slate-600">Password</label>
                        <div class="relative">
                            <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            </span>
                            <input
                                id="password"
                                name="password"
                                type="password"
                                autocomplete="current-password"
                                required
class="h-12 w-full rounded-xl border border-slate-200 bg-slate-50 pl-11 pr-14 text-sm outline-none transition focus:border-emerald-700 focus:ring-4 focus:ring-emerald-200 @error('password') border-red-400 bg-red-50 @enderror"
                                placeholder="••••••••"
                            >
                            {{-- Show / Hide password toggle --}}
                            <button
                                type="button"
                                id="toggle-password"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 transition hover:text-slate-600"
                                aria-label="Toggle password visibility"
                            >
                                <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <svg id="eye-off-icon" class="hidden" xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- AJAX error area --}}
                    <p id="admin-login-error" class="hidden rounded-xl bg-red-50 px-4 py-3 text-sm font-medium text-red-700"></p>

                    {{-- Remember Me + Remember hint --}}
                    <div class="flex items-center justify-between">
                        <label class="flex cursor-pointer select-none items-center gap-2 text-sm text-slate-600">
                            <input
                                type="checkbox"
                                name="remember"
class="h-4 w-4 rounded border-slate-300 text-emerald-700 focus:ring-emerald-200"
                            >
                            Ingat saya
                        </label>
                        <span class="text-xs text-slate-400">Internal access only</span>
                    </div>

                    {{-- Submit button --}}
                    <button
                        type="submit"
                        id="admin-login-btn"
class="relative h-12 w-full overflow-hidden rounded-xl bg-emerald-700 font-bold text-white shadow-lg shadow-emerald-900/25 transition hover:bg-emerald-800 disabled:cursor-wait disabled:opacity-60"
                    >
                        <span id="admin-login-btn-text" class="flex items-center justify-center gap-2">
                            Masuk ke Admin Panel
                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                        </span>
                        <span id="admin-login-spinner" class="absolute inset-0 hidden items-center justify-center">
                            <svg class="h-5 w-5 animate-spin text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </span>
                    </button>
                </form>

                {{-- No public registration notice --}}
                <p class="mt-6 border-t border-slate-100 pt-5 text-center text-xs text-slate-400">
                    Tidak ada pendaftaran publik. Permintaan akses baru diproses oleh tim UMatch.
                </p>
            </div>
        </div>
    </section>

</main>

<script>
(function () {
    'use strict';

    // Show / hide password toggle
    const passwordInput = document.getElementById('password');
    const toggleBtn = document.getElementById('toggle-password');
    const eyeIcon = document.getElementById('eye-icon');
    const eyeOffIcon = document.getElementById('eye-off-icon');

    if (toggleBtn) {
        toggleBtn.addEventListener('click', function () {
            const isHidden = passwordInput.type === 'password';
            passwordInput.type = isHidden ? 'text' : 'password';
            eyeIcon.classList.toggle('hidden', isHidden);
            eyeOffIcon.classList.toggle('hidden', !isHidden);
        });
    }

    // AJAX form submission with loading state
    const form = document.getElementById('admin-login-form');
    const errorEl = document.getElementById('admin-login-error');
    const btn = document.getElementById('admin-login-btn');
    const btnText = document.getElementById('admin-login-btn-text');
    const spinner = document.getElementById('admin-login-spinner');

    if (form) {
        form.addEventListener('submit', async function (event) {
            event.preventDefault();

            errorEl.textContent = '';
            errorEl.classList.add('hidden');
            btn.disabled = true;
            btnText.classList.add('hidden');
            spinner.classList.remove('hidden');
            spinner.classList.add('flex');

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: new FormData(form),
                });

                const data = await response.json();

                if (response.ok && data.redirect) {
                    window.location.href = data.redirect;
                    return;
                }

                throw new Error(data.message || 'Login failed. Please try again.');
            } catch (error) {
                errorEl.textContent = error.message;
                errorEl.classList.remove('hidden');
                btn.disabled = false;
                btnText.classList.remove('hidden');
                spinner.classList.add('hidden');
                spinner.classList.remove('flex');
            }
        });
    }
}());
</script>

</body>
</html>
