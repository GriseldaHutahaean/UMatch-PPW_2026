@extends('layouts.auth')

@section('title', 'Daftar — UMatch')
@section('body-class', 'min-h-screen bg-slate-50 text-slate-900')

@section('content')
<main class="flex min-h-screen items-center justify-center px-6 py-12 sm:px-12">
    <section class="w-full max-w-md rounded-3xl bg-white p-7 shadow-xl shadow-slate-200/70 sm:p-10">
        <a href="{{ route('login') }}" class="text-sm font-bold text-[#0d4d96]">← Kembali ke Login</a>
        <div class="mt-8 flex items-center gap-3"><x-logo size="42" /><div><p class="text-2xl font-extrabold">Buat akun UMatch</p><p class="mt-1 text-sm text-slate-500">Satu akun untuk semua kebutuhanmu.</p></div></div>
        <div class="mt-6 inline-flex rounded-full bg-blue-50 px-4 py-2 text-xs font-bold text-[#0d4d96]">Mendaftar sebagai {{ $roleLabel }}</div>

        <form action="{{ route('register.store') }}" method="POST" class="mt-8 space-y-5">
            @csrf
            <div><label for="name" class="mb-2 block text-sm font-bold">Nama lengkap</label><input id="name" name="name" value="{{ old('name') }}" required class="h-14 w-full rounded-2xl border border-slate-200 px-4 outline-none focus:border-[#0d4d96] focus:ring-4 focus:ring-blue-100"></div>
            <div><label for="email" class="mb-2 block text-sm font-bold">Email</label><input id="email" name="email" type="email" value="{{ old('email') }}" required class="h-14 w-full rounded-2xl border border-slate-200 px-4 outline-none focus:border-[#0d4d96] focus:ring-4 focus:ring-blue-100"></div>
            <div><label for="password" class="mb-2 block text-sm font-bold">Password</label><input id="password" name="password" type="password" required class="h-14 w-full rounded-2xl border border-slate-200 px-4 outline-none focus:border-[#0d4d96] focus:ring-4 focus:ring-blue-100"></div>
            <div><label for="password_confirmation" class="mb-2 block text-sm font-bold">Konfirmasi password</label><input id="password_confirmation" name="password_confirmation" type="password" required class="h-14 w-full rounded-2xl border border-slate-200 px-4 outline-none focus:border-[#0d4d96] focus:ring-4 focus:ring-blue-100"></div>
            @if ($errors->any())<div class="rounded-xl bg-red-50 px-4 py-3 text-sm text-red-700">{{ $errors->first() }}</div>@endif
            <button type="submit" class="h-14 w-full rounded-2xl bg-[#0d4d96] font-bold text-white shadow-lg shadow-blue-900/20 hover:bg-blue-900">Buat Akun</button>
        </form>
    </section>
</main>
@endsection
