@extends('layouts.auth')

@section('title', 'Masuk — UMatch')
@section('body-class', 'min-h-screen bg-slate-50 text-slate-900')

@section('content')
<main class="grid min-h-screen lg:grid-cols-2">
    <section class="relative hidden overflow-hidden bg-[#0d4d96] p-12 text-white lg:flex lg:flex-col lg:justify-between">
        <div class="absolute -right-24 -top-24 h-80 w-80 rounded-full bg-[#f9b21b]/20 blur-3xl"></div>
        <div class="relative z-10 flex items-center gap-3 text-2xl font-extrabold"><x-logo size="42" /> UMatch</div>
        <div class="relative z-10 max-w-lg">
            <p class="mb-4 text-sm font-bold uppercase tracking-[0.3em] text-amber-300">Platform kolaborasi</p>
            <h1 class="text-5xl font-extrabold leading-tight">Temukan peluang. Bangun masa depan.</h1>
            <p class="mt-6 text-lg leading-8 text-blue-100">Hubungkan UMKM, investor, dan customer dalam satu ekosistem yang saling menguatkan.</p>
        </div>
        <p class="relative z-10 text-sm text-blue-200">© {{ date('Y') }} UMatch</p>
    </section>

    <section class="flex items-center justify-center px-6 py-12 sm:px-12">
        <div class="w-full max-w-md">
            <div class="mb-10 lg:hidden"><a href="{{ route('landing') }}" class="flex items-center gap-3 text-2xl font-extrabold"><x-logo size="42" /> UMatch</a></div>
            <p class="text-sm font-bold uppercase tracking-[0.25em] text-[#0d4d96]">Selamat datang kembali</p>
            <h2 class="mt-3 text-4xl font-extrabold tracking-tight">Masuk ke akunmu</h2>
            <p class="mt-3 text-slate-500">Kelola aktivitas UMatch dengan aman dan mudah.</p>
            <div class="mt-5 inline-flex items-center gap-2 rounded-full bg-blue-50 px-4 py-2 text-xs font-bold text-[#0d4d96]">
                <span class="h-2 w-2 rounded-full bg-[#0d4d96]"></span>
                Role: {{ $roleLabel }}
                <a href="{{ route('roles.choose') }}" class="ml-1 underline underline-offset-2">Ubah</a>
            </div>

            <a href="{{ route('auth.google') }}" class="mt-8 flex h-14 items-center justify-center gap-3 rounded-2xl border border-slate-200 bg-white font-bold shadow-sm transition hover:border-slate-300 hover:shadow-md">
                <svg width="21" height="21" viewBox="0 0 24 24" aria-hidden="true"><path fill="#4285F4" d="M21.6 12.23c0-.7-.06-1.37-.18-2.02H12v3.82h5.38a4.6 4.6 0 0 1-1.99 3.02v2.51h3.22c1.88-1.73 2.99-4.28 2.99-7.33Z"/><path fill="#34A853" d="M12 22c2.7 0 4.96-.9 6.61-2.44l-3.22-2.51c-.9.6-2.05.96-3.39.96-2.61 0-4.82-1.76-5.62-4.13H3.05v2.59A9.99 9.99 0 0 0 12 22Z"/><path fill="#FBBC05" d="M6.38 13.88A6 6 0 0 1 6.06 12c0-.65.11-1.28.32-1.88V7.53H3.05A10 10 0 0 0 2 12c0 1.61.39 3.13 1.05 4.47l3.33-2.59Z"/><path fill="#EA4335" d="M12 5.98c1.47 0 2.79.5 3.83 1.5l2.87-2.87C16.95 2.91 14.7 2 12 2a9.99 9.99 0 0 0-8.95 5.53l3.33 2.59C7.18 7.74 9.39 5.98 12 5.98Z"/></svg>
                Masuk / Daftar dengan Google
            </a>

            <div class="my-8 flex items-center gap-4 text-xs font-bold tracking-widest text-slate-400"><div class="h-px flex-1 bg-slate-200"></div>ATAU<div class="h-px flex-1 bg-slate-200"></div></div>

            <form id="login-form" action="{{ route('login.store') }}" method="POST" class="space-y-5">
                @csrf
                <div><label for="email" class="mb-2 block text-sm font-bold">Email</label><input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required class="h-14 w-full rounded-2xl border border-slate-200 bg-white px-4 outline-none transition focus:border-[#0d4d96] focus:ring-4 focus:ring-blue-100" placeholder="nama@email.com"></div>
                <div><div class="mb-2 flex justify-between"><label for="password" class="text-sm font-bold">Password</label><a href="#" class="text-sm font-bold text-[#0d4d96]">Lupa password?</a></div><input id="password" name="password" type="password" autocomplete="current-password" required class="h-14 w-full rounded-2xl border border-slate-200 bg-white px-4 outline-none transition focus:border-[#0d4d96] focus:ring-4 focus:ring-blue-100" placeholder="Masukkan password"></div>
                <p id="login-error" class="hidden rounded-xl bg-red-50 px-4 py-3 text-sm font-medium text-red-700"></p>
                <button type="submit" class="h-14 w-full rounded-2xl bg-[#0d4d96] font-bold text-white shadow-lg shadow-blue-900/20 transition hover:bg-blue-900 disabled:cursor-wait disabled:opacity-60">Masuk ke UMatch</button>
            </form>
            <p class="mt-8 text-center text-sm text-slate-500">Belum punya akun? <a href="{{ route('register') }}" class="font-bold text-[#0d4d96]">Daftar sekarang</a></p>
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
