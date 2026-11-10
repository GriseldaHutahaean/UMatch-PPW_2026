@extends('layouts.auth')

@section('title', 'Dashboard — UMatch')

@section('content')
<main class="flex min-h-screen items-center justify-center bg-slate-50 px-6">
    <section class="w-full max-w-xl rounded-3xl bg-white p-10 text-center shadow-xl shadow-slate-200/70">
        <x-logo size="64" class="mx-auto" />
        <p class="mt-6 text-sm font-bold uppercase tracking-[0.25em] text-[#0d4d96]">{{ strtoupper($role) }}</p>
        <h1 class="mt-2 text-3xl font-extrabold">Selamat datang, {{ auth()->user()->nama }}!</h1>
        <p class="mt-3 text-slate-500">Dashboard {{ ucfirst($role) }} siap dikembangkan.</p>
        <form action="{{ route('logout') }}" method="POST" class="mt-8">@csrf<button class="rounded-xl bg-[#0d4d96] px-5 py-3 font-bold text-white">Keluar</button></form>
    </section>
</main>
@endsection
