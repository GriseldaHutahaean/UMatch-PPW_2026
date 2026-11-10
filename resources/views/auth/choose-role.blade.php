@extends('layouts.auth')

@section('title', 'Pilih Role — UMatch')

@section('content')
@php
    $roleStyles = [
        'customer' => ['background' => 'bg-[#e4f8f7]', 'accent' => 'text-[#00a99d]', 'border' => 'border-[#00afa5]', 'icon' => '🛍️'],
        'umkm' => ['background' => 'bg-[#fff1ec]', 'accent' => 'text-[#ff6946]', 'border' => 'border-[#ff6946]', 'icon' => '🏪'],
        'investor' => ['background' => 'bg-[#edf5ff]', 'accent' => 'text-[#205a98]', 'border' => 'border-[#205a98]', 'icon' => '💼'],
    ];
@endphp

<main class="min-h-screen w-full bg-slate-50 px-4 py-8 text-slate-800 sm:px-8 lg:px-12">
    <header class="mx-auto flex w-full max-w-6xl items-center justify-between">
        <a href="{{ route('landing') }}" class="flex items-center gap-2 text-xl font-extrabold"><x-logo size="34" /> UMatch</a>
        <span class="text-xs font-semibold text-slate-400">Langkah 1 dari 2</span>
    </header>

    <section class="mx-auto w-full max-w-6xl py-12 text-center sm:py-16">
        <p class="text-xs font-extrabold uppercase tracking-[0.25em] text-[#0d4d96]">UMATCH</p>
        <h1 class="mt-3 text-3xl font-extrabold tracking-tight sm:text-4xl">Kamu menggunakan UMatch sebagai apa?</h1>
        <p class="mx-auto mt-3 max-w-xl text-sm leading-6 text-slate-500 sm:text-base">Pilih role untuk menyesuaikan pengalamanmu. Kamu tetap menggunakan satu akun dan dapat mengubah konteks akses kapan saja.</p>

        <form id="role-form" action="{{ route('roles.select') }}" method="POST" class="mt-10">
            @csrf
            <div class="grid gap-5 md:grid-cols-3">
                @foreach (config('umatch.roles') as $key => $role)
                    @php($style = $roleStyles[$key])
                    <label class="group relative cursor-pointer rounded-3xl border-2 bg-white p-6 text-left shadow-sm transition hover:-translate-y-1 hover:shadow-lg {{ $style['border'] }} {{ $selectedRole === $key ? 'ring-4 ring-slate-200' : '' }}">
                        <input type="radio" name="role" value="{{ $key }}" class="peer sr-only" @checked($selectedRole === $key)>
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl text-2xl {{ $style['background'] }}">{{ $style['icon'] }}</div>
                        <h2 class="mt-5 text-xl font-extrabold">{{ $role['label'] }}</h2>
                        <p class="mt-2 text-sm leading-6 text-slate-500">{{ $role['subtitle'] }}</p>
                        <span class="mt-6 inline-flex text-sm font-bold {{ $style['accent'] }}">Pilih role ini <span class="ml-2 transition group-hover:translate-x-1">→</span></span>
                        <span class="absolute right-5 top-5 hidden h-5 w-5 items-center justify-center rounded-full bg-current text-xs text-white peer-checked:flex {{ $style['accent'] }}">✓</span>
                    </label>
                @endforeach
            </div>

            @error('role')<p class="mt-4 text-sm font-medium text-red-600">{{ $message }}</p>@enderror
            <button type="submit" class="mt-10 h-14 w-full max-w-md rounded-2xl bg-[#0d4d96] px-8 font-bold text-white shadow-lg shadow-blue-900/20 transition hover:bg-blue-900 disabled:cursor-not-allowed disabled:opacity-50" disabled data-role-submit>Lanjut ke Login</button>
        </form>
    </section>
</main>
@endsection

@push('scripts')
<script>
const roleForm = document.getElementById('role-form');
const roleSubmit = document.querySelector('[data-role-submit]');
const roleCards = [...roleForm.querySelectorAll('label')];

function updateSelectedRole() {
    const selected = roleForm.querySelector('input[name="role"]:checked');
    roleSubmit.disabled = !selected;
    roleCards.forEach((card) => {
        const input = card.querySelector('input');
        card.classList.toggle('ring-4', input.checked);
        card.classList.toggle('ring-slate-200', input.checked);
    });
}

roleForm.querySelectorAll('input[name="role"]').forEach((input) => input.addEventListener('change', updateSelectedRole));
updateSelectedRole();
</script>
@endpush
