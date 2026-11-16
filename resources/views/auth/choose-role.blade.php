@extends('layouts.auth')

@section('title', 'Pilih Role — UMatch')

@section('content')
@php
    $roleStyles = [
        'customer' => ['background' => 'bg-[#e8faf7]', 'accent' => 'text-[#00a99d]', 'border' => 'border-[#00afa5]', 'button' => 'bg-[#00a99d]', 'icon' => 'bag', 'description' => 'Sumber pendapatan dan pelanggan untuk UMKM lokal.'],
        'umkm' => ['background' => 'bg-[#fff1ec]', 'accent' => 'text-[#ff6946]', 'border' => 'border-[#ff6946]', 'button' => 'bg-[#ff6946]', 'icon' => 'store', 'description' => 'Kembangkan bisnis dan jangkau peluang baru.'],
        'investor' => ['background' => 'bg-[#edf5ff]', 'accent' => 'text-[#205a98]', 'border' => 'border-[#205a98]', 'button' => 'bg-[#205a98]', 'icon' => 'trend', 'description' => 'Temukan peluang investasi yang profesional dan terukur.'],
    ];
@endphp

<main class="min-h-screen bg-[linear-gradient(135deg,#f8fbff_0%,#f4faf8_48%,#fff9f5_100%)] px-5 py-7 text-slate-800 sm:px-8 lg:px-12">
    <header class="mx-auto flex w-full max-w-6xl items-center justify-between">
        <a href="{{ route('landing') }}" class="flex items-center gap-3"><span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white shadow-sm ring-1 ring-slate-200"><x-logo size="28" /></span><span class="text-xl font-extrabold tracking-tight">UMatch</span></a>
        <div class="flex items-center gap-3"><span class="hidden text-xs font-semibold text-slate-400 sm:inline">Langkah 1 dari 2</span><span class="h-1.5 w-16 overflow-hidden rounded-full bg-slate-200"><span class="block h-full w-1/2 rounded-full bg-[#205a98]"></span></span></div>
    </header>

    <section class="mx-auto w-full max-w-6xl py-14 sm:py-20">
        <div class="mx-auto max-w-2xl text-center">
            <p class="text-xs font-extrabold uppercase tracking-[0.3em] text-[#205a98]">Pilih pengalamanmu</p>
            <h1 class="mt-4 text-4xl font-extrabold tracking-tight text-slate-900 sm:text-5xl">Kamu menggunakan UMatch sebagai apa?</h1>
            <p class="mx-auto mt-5 max-w-xl text-sm leading-7 text-slate-500 sm:text-base">Pilih role yang paling sesuai untuk menyesuaikan pengalamanmu. Satu akun tetap bisa digunakan untuk tiga peran.</p>
        </div>

        <form id="role-form" action="{{ route('roles.select') }}" method="POST" class="mt-12">
            @csrf
            <div class="grid gap-5 md:grid-cols-3">
                @foreach (config('umatch.roles') as $key => $role)
                    @php($style = $roleStyles[$key])
                    <label class="group relative cursor-pointer rounded-[2rem] border-2 {{ $style['border'] }} bg-white p-7 text-left shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl {{ $selectedRole === $key ? 'ring-2 ring-slate-200 ring-offset-2' : '' }}">
                        <input type="radio" name="role" value="{{ $key }}" class="peer sr-only" @checked($selectedRole === $key)>
                        <span class="absolute right-7 top-7 hidden h-7 w-7 items-center justify-center rounded-full {{ $style['button'] }} text-white peer-checked:flex"><x-icon name="check" size="15" /></span>
                        <div class="flex h-16 w-16 items-center justify-center rounded-2xl {{ $style['background'] }} {{ $style['accent'] }}"><x-icon :name="$style['icon']" size="30" /></div>
                        <div class="mt-8"><p class="text-xs font-bold uppercase tracking-[0.2em] {{ $style['accent'] }}">{{ $role['label'] }}</p><h2 class="mt-2 text-2xl font-extrabold text-slate-900">{{ $role['subtitle'] }}</h2></div>
                        <p class="mt-4 text-sm leading-6 text-slate-500">{{ $style['description'] }}</p>
                        <span class="mt-8 inline-flex items-center gap-2 text-sm font-bold {{ $style['accent'] }}">Lanjut sebagai {{ $role['label'] }} <span class="transition group-hover:translate-x-1">→</span></span>
                    </label>
                @endforeach
            </div>

            @error('role')<p class="mt-4 text-center text-sm font-medium text-red-600">{{ $message }}</p>@enderror
            <div class="mt-12 flex flex-col items-center gap-4"><button type="submit" class="h-14 w-full max-w-md rounded-2xl bg-[#205a98] px-8 text-sm font-extrabold text-white shadow-lg shadow-blue-900/15 transition hover:-translate-y-0.5 hover:bg-[#174777] disabled:cursor-not-allowed disabled:opacity-40" disabled data-role-submit>Lanjut ke Login</button><p class="text-xs text-slate-400">Kamu bisa mengganti role kapan saja.</p></div>
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
        card.classList.toggle('ring-2', input.checked);
        card.classList.toggle('ring-slate-200', input.checked);
        card.classList.toggle('ring-offset-2', input.checked);
    });
}

roleForm.querySelectorAll('input[name="role"]').forEach((input) => input.addEventListener('change', updateSelectedRole));
updateSelectedRole();
</script>
@endpush
