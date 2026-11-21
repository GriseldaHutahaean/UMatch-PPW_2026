@extends('layouts.auth')

@section('title', 'Pilih Role — UMatch')

@section('content')
@php
    $roleStyles = [
        'customer' => ['iconBackground' => 'bg-emerald-50', 'accent' => 'text-emerald-700', 'roleBorder' => 'border-emerald-300', 'selectedBorder' => 'border-emerald-500', 'selectedBackground' => 'bg-emerald-50/80', 'selectedRing' => 'ring-emerald-100'],
        'umkm' => ['iconBackground' => 'bg-orange-50', 'accent' => 'text-orange-700', 'roleBorder' => 'border-orange-300', 'selectedBorder' => 'border-orange-500', 'selectedBackground' => 'bg-orange-50/80', 'selectedRing' => 'ring-orange-100'],
        'investor' => ['iconBackground' => 'bg-blue-50', 'accent' => 'text-blue-700', 'roleBorder' => 'border-blue-300', 'selectedBorder' => 'border-blue-500', 'selectedBackground' => 'bg-blue-50/80', 'selectedRing' => 'ring-blue-100'],
    ];
    $roleDetails = [
        'customer' => 'Jelajahi produk lokal, simpan favorit, dan pantau pesanan dari satu akun.',
        'umkm' => 'Kelola katalog, stok, dan penjualan; lalu bangun koneksi dengan pelanggan serta investor.',
        'investor' => 'Pelajari profil dan performa UMKM, lalu temukan peluang sesuai profil risikomu.',
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
        <p class="mx-auto mt-3 max-w-xl text-sm leading-6 text-slate-500 sm:text-base">Pilih role yang paling sesuai untuk menyesuaikan pengalamanmu. Satu akun tetap bisa digunakan untuk tiga peran.</p>

        <form id="role-form" action="{{ route('roles.select') }}" method="POST" class="mt-10">
            @csrf
            <div class="grid gap-5 md:grid-cols-3">
                @foreach (config('umatch.roles') as $key => $role)
                    @php($style = $roleStyles[$key])
                    <label data-role-card data-role="{{ $key }}" class="group relative flex min-h-[270px] cursor-pointer flex-col rounded-3xl border-2 p-6 text-left shadow-sm transition duration-200 hover:-translate-y-1 hover:shadow-lg focus-within:ring-4 focus-within:ring-slate-100 {{ $style['roleBorder'] }} {{ $selectedRole === $key ? $style['selectedBorder'].' '.$style['selectedBackground'].' ring-4 '.$style['selectedRing'] : 'bg-white' }}">
                        <input type="radio" name="role" value="{{ $key }}" class="peer sr-only" aria-label="Pilih {{ $role['label'] }}" @checked($selectedRole === $key)>
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl {{ $style['iconBackground'] }} {{ $style['accent'] }}">
                            <x-icon :name="$role['icon']" size="25" />
                        </div>
                        <span data-selected-badge class="absolute right-5 top-5 items-center gap-1.5 rounded-full px-3 py-1 text-[10px] font-extrabold {{ $selectedRole === $key ? 'inline-flex' : 'hidden' }} {{ $style['iconBackground'] }} {{ $style['accent'] }}">
                            <span aria-hidden="true">✓</span> Dipilih
                        </span>
                        <p class="mt-5 text-[10px] font-extrabold uppercase tracking-[0.2em] {{ $style['accent'] }}">{{ $role['label'] }}</p>
                        <h2 class="mt-2 text-lg font-extrabold leading-6 text-slate-900">{{ $role['subtitle'] }}</h2>
                        <p class="mt-2 text-sm leading-6 text-slate-500">{{ $roleDetails[$key] }}</p>
                        <span class="mt-auto inline-flex pt-5 text-sm font-bold {{ $style['accent'] }}">Lanjut sebagai {{ $role['label'] }} <span class="ml-2 transition group-hover:translate-x-1" aria-hidden="true">→</span></span>
                    </label>
                @endforeach
            </div>

            @error('role')<p class="mt-4 text-sm font-medium text-red-600">{{ $message }}</p>@enderror
            <p data-role-summary aria-live="polite" class="mx-auto mt-6 min-h-5 text-sm font-semibold text-slate-500">Pilih salah satu role untuk melanjutkan.</p>
            <button type="submit" class="mt-5 h-14 w-full max-w-md rounded-2xl bg-[#0d4d96] px-8 font-bold text-white shadow-lg shadow-blue-900/20 transition hover:bg-blue-900 disabled:cursor-not-allowed disabled:opacity-50" disabled data-role-submit>{{ auth()->check() ? 'Lanjutkan untuk Menambahkan Role' : 'Lanjut ke Login' }}</button>
        </form>
    </section>
</main>
@endsection

@push('scripts')
<script>
const roleForm = document.getElementById('role-form');
const roleSubmit = document.querySelector('[data-role-submit]');
const roleSummary = document.querySelector('[data-role-summary]');
const roleCards = [...roleForm.querySelectorAll('[data-role-card]')];
const roleLabels = { customer: 'Customer', umkm: 'UMKM', investor: 'Investor' };
const selectedCardClasses = {
    customer: ['border-emerald-500', 'bg-emerald-50/80', 'ring-emerald-100'],
    umkm: ['border-orange-400', 'bg-orange-50/80', 'ring-orange-100'],
    investor: ['border-blue-400', 'bg-blue-50/80', 'ring-blue-100'],
};
const isAddingRole = @json(auth()->check());

function updateSelectedRole() {
    const selected = roleForm.querySelector('input[name="role"]:checked');
    roleSubmit.disabled = !selected;

    roleCards.forEach((card) => {
        const isSelected = card.querySelector('input').checked;
        const selectedBadge = card.querySelector('[data-selected-badge]');

        card.classList.toggle('bg-white', !isSelected);
        card.classList.toggle('ring-4', isSelected);
        card.classList.toggle('shadow-md', isSelected);
        card.classList.toggle('shadow-sm', !isSelected);
        selectedCardClasses[card.dataset.role].forEach((className) => card.classList.toggle(className, isSelected));
        selectedBadge.classList.toggle('inline-flex', isSelected);
        selectedBadge.classList.toggle('hidden', !isSelected);
    });

    if (selected) {
        const roleLabel = roleLabels[selected.value];
        roleSummary.textContent = `Role aktif yang dipilih: ${roleLabel}`;
        roleSubmit.textContent = isAddingRole ? `Tambahkan role ${roleLabel}` : `Lanjut sebagai ${roleLabel}`;
        return;
    }

    roleSummary.textContent = 'Pilih salah satu role untuk melanjutkan.';
    roleSubmit.textContent = isAddingRole ? 'Lanjutkan untuk Menambahkan Role' : 'Lanjut ke Login';
}

roleForm.querySelectorAll('input[name="role"]').forEach((input) => input.addEventListener('change', updateSelectedRole));
updateSelectedRole();
</script>
@endpush
