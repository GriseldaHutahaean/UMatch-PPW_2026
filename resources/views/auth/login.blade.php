@extends('layouts.auth')

@php
    $role = config("umatch.roles.{$selectedRole}");
    $roleStyles = [
        'customer' => ['panel' => 'bg-emerald-800', 'panelSoft' => 'bg-white/15', 'panelText' => 'text-white/80', 'accent' => 'text-emerald-700', 'accentBg' => 'bg-emerald-700', 'accentSoft' => 'bg-emerald-50', 'accentHover' => 'hover:bg-emerald-800', 'focus' => 'focus:border-emerald-700 focus:ring-emerald-200/60', 'icon' => 'bag'],
        'umkm' => ['panel' => 'bg-emerald-800', 'panelSoft' => 'bg-white/15', 'panelText' => 'text-white/80', 'accent' => 'text-emerald-700', 'accentBg' => 'bg-emerald-700', 'accentSoft' => 'bg-emerald-50', 'accentHover' => 'hover:bg-emerald-800', 'focus' => 'focus:border-emerald-700 focus:ring-emerald-200/60', 'icon' => 'store'],
        'investor' => ['panel' => 'bg-emerald-800', 'panelSoft' => 'bg-white/15', 'panelText' => 'text-white/80', 'accent' => 'text-emerald-700', 'accentBg' => 'bg-emerald-700', 'accentSoft' => 'bg-emerald-50', 'accentHover' => 'hover:bg-emerald-800', 'focus' => 'focus:border-emerald-700 focus:ring-emerald-200/60', 'icon' => 'trend'],
    ][$selectedRole];
@endphp

@section('title', "Masuk sebagai {$role['label']} — UMatch")
@section('body-class', 'min-h-screen bg-white text-slate-900')

@section('content')
<main class="grid min-h-screen lg:grid-cols-2">
    <section class="{{ $roleStyles['panel'] }} relative hidden overflow-hidden p-10 text-white lg:flex lg:flex-col lg:justify-between lg:p-12">
        <div class="absolute -right-24 -top-24 h-80 w-80 rounded-full {{ $roleStyles['panelSoft'] }}"></div>
        <div class="absolute -bottom-24 -left-24 h-64 w-64 rounded-full {{ $roleStyles['panelSoft'] }}"></div>
        <a href="{{ route('landing') }}" class="relative z-10 flex items-center gap-3 text-xl font-extrabold"><span class="flex h-9 w-9 items-center justify-center rounded-md bg-white"><x-logo size="27" /></span> UMatch</a>
        <div class="relative z-10 max-w-lg">
            <div class="mb-7 flex h-16 w-16 items-center justify-center rounded-2xl bg-white/20 backdrop-blur-sm"><x-icon :name="$roleStyles['icon']" size="31" /></div>
            <h1 class="text-4xl font-extrabold leading-tight xl:text-5xl">Masuk sebagai {{ $role['label'] }}</h1>
            <p class="mt-3 text-sm font-medium {{ $roleStyles['panelText'] }}">{{ $role['tagline'] }}</p>
            <ul class="mt-7 space-y-3 text-sm {{ $roleStyles['panelText'] }}">
                @foreach ($role['features'] as $feature)
                    <li class="flex items-center gap-3"><x-icon name="check" size="17" /> {{ $feature }}</li>
                @endforeach
            </ul>
        </div>
        <p class="relative z-10 text-xs {{ $roleStyles['panelText'] }}">Satu akun • Tiga peran • UMatch</p>
    </section>

    <section class="flex min-h-screen items-center justify-center px-6 py-10 sm:px-12 lg:px-16">
        <div class="w-full max-w-md">
            <div class="mb-12 lg:hidden"><a href="{{ route('landing') }}" class="flex items-center gap-3 text-xl font-extrabold"><x-logo size="36" /> UMatch</a></div>
            <a href="{{ route('roles.choose') }}" class="inline-flex items-center gap-2 text-sm font-bold {{ $roleStyles['accent'] }}"><x-icon name="arrow-left" size="16" /> Ganti peran</a>
            <h2 class="mt-6 text-3xl font-extrabold tracking-tight">Selamat datang kembali!</h2>
            <p class="mt-2 text-sm text-slate-500">Masuk sebagai <span class="font-bold {{ $roleStyles['accent'] }}">{{ $role['label'] }}</span> ke akun UMatch kamu.</p>
            <div class="mt-5 inline-flex items-center gap-2 rounded-full {{ $roleStyles['accentSoft'] ?? 'bg-slate-100' }} px-4 py-2 text-xs font-bold {{ $roleStyles['accent'] }}"><span class="h-2 w-2 rounded-full {{ $roleStyles['accentBg'] }}"></span> Role: {{ $role['label'] }} <a href="{{ route('roles.choose') }}" class="ml-1 underline underline-offset-2">Ubah</a></div>

            <a href="{{ route('auth.google') }}" class="mt-7 flex h-12 items-center justify-center gap-3 rounded-xl border border-slate-200 bg-white text-sm font-bold shadow-sm transition hover:border-slate-300 hover:shadow-md">
                <svg width="19" height="19" viewBox="0 0 24 24" aria-hidden="true"><path fill="#4285F4" d="M21.6 12.23c0-.7-.06-1.37-.18-2.02H12v3.82h5.38a4.6 4.6 0 0 1-1.99 3.02v2.51h3.22c1.88-1.73 2.99-4.28 2.99-7.33Z"/><path fill="#34A853" d="M12 22c2.7 0 4.96-.9 6.61-2.44l-3.22-2.51c-.9.6-2.05.96-3.39.96-2.61 0-4.82-1.76-5.62-4.13H3.05v2.59A9.99 9.99 0 0 0 12 22Z"/><path fill="#FBBC05" d="M6.38 13.88A6 6 0 0 1 6.06 12c0-.65.11-1.28.32-1.88V7.53H3.05A10 10 0 0 0 2 12c0 1.61.39 3.13 1.05 4.47l3.33-2.59Z"/><path fill="#EA4335" d="M12 5.98c1.47 0 2.79.5 3.83 1.5l2.87-2.87C16.95 2.91 14.7 2 12 2a9.99 9.99 0 0 0-8.95 5.53l3.33 2.59C7.18 7.74 9.39 5.98 12 5.98Z"/></svg>
                Masuk / Daftar dengan Google
            </a>
            <div class="my-4 flex items-center gap-4 text-xs font-bold tracking-widest text-slate-400"><div class="h-px flex-1 bg-slate-200"></div>ATAU<div class="h-px flex-1 bg-slate-200"></div></div>

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-7">
                <form id="login-form" action="{{ route('login.store') }}" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label for="email" class="mb-2 block text-xs font-medium text-slate-600">Email</label>
                        <div class="relative"><x-icon name="mail" size="17" class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400" /><input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required class="h-12 w-full rounded-xl border border-slate-200 bg-slate-50 pl-11 pr-4 text-sm outline-none transition {{ $roleStyles['focus'] }} focus:ring-4" placeholder="nama@email.com"></div>
                    </div>
                    <div>
                        <div class="mb-2 flex justify-between"><label for="password" class="text-xs font-medium text-slate-600">Password</label><a href="#" class="text-xs font-bold {{ $roleStyles['accent'] }}">Lupa password?</a></div>
                        <div class="relative"><x-icon name="lock" size="17" class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400" /><input id="password" name="password" type="password" autocomplete="current-password" required class="h-12 w-full rounded-xl border border-slate-200 bg-slate-50 pl-11 pr-4 text-sm outline-none transition {{ $roleStyles['focus'] }} focus:ring-4" placeholder="Masukkan password"></div>
                    </div>
                    <p id="login-error" class="hidden rounded-xl bg-red-50 px-4 py-3 text-sm font-medium text-red-700"></p>
                    <button type="submit" class="h-12 w-full rounded-xl {{ $roleStyles['accentBg'] }} font-bold text-white shadow-lg shadow-slate-900/10 transition {{ $roleStyles['accentHover'] }} disabled:cursor-wait disabled:opacity-60">Masuk ke UMatch</button>
                </form>
                <p class="mt-5 border-t border-slate-100 pt-5 text-center text-sm text-slate-500">Belum punya akun? <a href="{{ route('register') }}" class="font-bold {{ $roleStyles['accent'] }}">Daftar sekarang</a></p>
            </div>
        </div>
    </section>
</main>
@endsection

@push('scripts')
<script>
document.getElementById('login-form').addEventListener('submit', async (event) => {
    event.preventDefault();
    const form = event.currentTarget;
    const error = document.getElementById('login-error');
    const button = form.querySelector('button');
    error.classList.add('hidden');
    button.disabled = true;
    try {
        const response = await fetch(form.action, { method: 'POST', headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }, body: new FormData(form) });
        const data = await response.json();
        if (!response.ok) throw new Error(data.message || 'Login gagal. Periksa kembali data Anda.');
        window.location.href = data.redirect;
    } catch (exception) {
        error.textContent = exception.message;
        error.classList.remove('hidden');
        button.disabled = false;
    }
});
</script>
@endpush
