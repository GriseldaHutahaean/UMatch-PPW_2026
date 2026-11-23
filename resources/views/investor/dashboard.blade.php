@extends('layouts.auth')

@section('title', 'Dashboard Investor — UMatch')

@php
    $kycBadge = match ($kycStatus) {
        'verified' => ['label' => 'KYC Terverifikasi', 'class' => 'bg-[#ECFDF5] text-[#10B981]'],
        'rejected' => ['label' => 'KYC Ditolak', 'class' => 'bg-[#FEF2F2] text-[#EF4444]'],
        default => ['label' => 'KYC Menunggu Verifikasi', 'class' => 'bg-[#FFFBEB] text-[#D97706]'],
    };
@endphp

@section('content')
<div class="min-h-screen bg-[#FAFAFB] font-[Plus_Jakarta_Sans,ui-sans-serif,sans-serif] text-gray-900">
    <header class="sticky top-0 z-30 h-16 border-b border-gray-100 bg-white">
        <div class="mx-auto flex h-full max-w-[1440px] items-center gap-4 px-4 sm:px-6">
            <button type="button" class="rounded-lg p-2 text-gray-500 hover:bg-gray-50 lg:hidden" data-sidebar-toggle aria-label="Buka navigasi"><x-icon name="menu" size="20" /></button>
            <a href="{{ route('investor.dashboard') }}" class="flex shrink-0 items-center gap-2"><x-logo size="28" /><span class="text-base font-extrabold tracking-tight text-gray-900">UMatch</span><span class="rounded-full bg-[#2563EB] px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider text-white">Investor</span></a>
            <div class="relative ml-2 hidden w-80 md:block lg:w-96"><x-icon name="search" size="17" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400" /><input type="search" placeholder="Cari UMKM terverifikasi..." class="w-full rounded-full border border-gray-200 bg-[#F8FAFC] py-2 pl-11 pr-4 text-xs text-gray-700 outline-none transition placeholder:text-gray-400 focus:border-[#93C5FD] focus:ring-2 focus:ring-blue-100"></div>
            <div class="ml-auto flex items-center gap-2 sm:gap-3">
                <button type="button" class="relative flex h-10 w-10 items-center justify-center rounded-full border border-gray-200 text-gray-500 transition hover:bg-gray-50" data-toast="Tidak ada notifikasi baru" aria-label="Notifikasi"><x-icon name="bell" size="18" /><span class="absolute right-2 top-2 h-1.5 w-1.5 rounded-full bg-[#2563EB]"></span></button>
                <div class="relative">
                    <button type="button" class="flex items-center gap-2 rounded-full border border-[#93C5FD] bg-[#EFF6FF] px-3 py-1.5 text-xs font-bold text-[#2563EB] transition hover:bg-blue-100" data-role-menu-toggle aria-expanded="false">Investor<x-icon name="chevron-down" size="14" /></button>
                    <div class="absolute right-0 top-12 hidden w-52 rounded-xl border border-gray-100 bg-white p-1.5 shadow-xl" data-role-menu>
                        <p class="px-3 pb-1.5 pt-2 text-[10px] font-bold uppercase tracking-wider text-gray-400">Ganti Role</p>
                        @foreach (config('umatch.roles') as $roleKey => $availableRole)
                            <form action="{{ route('roles.select') }}" method="POST">@csrf<input type="hidden" name="role" value="{{ $roleKey }}"><button type="submit" class="flex w-full items-center justify-between rounded-lg px-3 py-2 text-left text-xs font-medium text-gray-700 hover:bg-blue-50 hover:text-[#2563EB]"><span>{{ $availableRole['label'] }}</span>@if ($roleKey === 'investor')<span class="text-[10px] font-bold text-[#2563EB]">Aktif</span>@endif</button></form>
                        @endforeach
                    </div>
                </div>
                <div class="relative">
                    <button type="button" class="flex h-9 w-9 items-center justify-center rounded-full bg-[#2563EB] text-sm font-semibold text-white transition hover:ring-4 hover:ring-blue-100" data-profile-menu-toggle aria-expanded="false" aria-label="Buka profil">{{ mb_strtoupper(mb_substr($user->nama, 0, 1)) }}</button>
                    <div class="absolute right-0 top-12 hidden w-60 rounded-xl border border-gray-100 bg-white p-2 shadow-xl" data-profile-menu>
                        <div class="rounded-lg bg-blue-50 px-3 py-3"><p class="text-sm font-bold text-gray-900">{{ $user->nama }}</p><p class="mt-0.5 truncate text-xs text-gray-500">{{ $user->email }}</p><p class="mt-2 text-[10px] font-bold uppercase tracking-wider text-[#2563EB]">Profil Investor</p></div>
                        <button type="button" data-toast="Profil kamu sedang aktif" class="mt-1.5 block w-full rounded-lg px-3 py-2 text-left text-xs font-medium text-gray-700 hover:bg-gray-50">Profil Saya</button>
                        <form action="{{ route('logout') }}" method="POST" class="mt-1.5 border-t border-gray-100 pt-1.5">@csrf<button type="submit" class="block w-full rounded-lg px-3 py-2 text-left text-xs font-medium text-red-600 hover:bg-red-50">Keluar</button></form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="mx-auto flex max-w-[1440px]">
        <aside class="fixed inset-y-16 left-0 z-20 hidden w-60 border-r border-gray-100 bg-white lg:block"><x-investor-navigation /></aside>
        <div class="fixed inset-0 z-10 hidden bg-gray-900/20 lg:hidden" data-sidebar-backdrop></div>
        <aside class="fixed inset-y-16 left-0 z-20 hidden w-60 border-r border-gray-100 bg-white lg:hidden" data-mobile-sidebar><x-investor-navigation /></aside>

        <main class="w-full px-4 py-6 sm:px-6 md:p-8 lg:ml-60">
            <div class="mx-auto max-w-7xl space-y-7">
                <section class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h1 class="text-2xl font-bold tracking-tight text-gray-900">Dashboard Investor</h1>
                        <p class="mt-0.5 text-sm text-gray-400">{{ $user->nama }} <span aria-hidden="true">•</span> {{ $today }}</p>
                    </div>
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="rounded-full px-3 py-1.5 text-xs font-semibold {{ $kycBadge['class'] }}">{{ $kycBadge['label'] }}</span>
                        @if ($riskProfile)
                            <span class="rounded-full bg-[#EFF6FF] px-3 py-1.5 text-xs font-semibold text-[#2563EB]">Profil Risiko: {{ $riskProfile }}</span>
                        @endif
                    </div>
                </section>

                <section class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4" aria-label="Ringkasan investasi">
                    @foreach ($kpis as $kpi)
                        <article class="flex min-h-40 flex-col rounded-2xl border border-[#F1F5F9] bg-white p-5 shadow-[0_2px_10px_rgba(0,0,0,0.03)]">
                            <div class="flex items-start justify-between">
                                <span class="flex h-9 w-9 items-center justify-center rounded-xl {{ $kpi['iconClass'] }}"><x-icon name="{{ $kpi['icon'] }}" size="18" /></span>
                                <span class="rounded-full bg-[#EFF6FF] px-2.5 py-0.5 text-xs font-semibold text-[#2563EB]">{{ $kpi['change'] }}</span>
                            </div>
                            <p class="mt-auto pt-5 text-2xl font-extrabold tracking-tight text-gray-900">{{ $kpi['value'] }}</p>
                            <p class="mt-1 text-xs text-gray-400">{{ $kpi['label'] }}</p>
                        </article>
                    @endforeach
                </section>

                <section class="rounded-2xl border border-[#F1F5F9] bg-white p-5 shadow-[0_2px_10px_rgba(0,0,0,0.03)] sm:p-6">
                    <div class="flex items-center justify-between">
                        <div><h2 class="text-base font-bold text-gray-900">Perkembangan Portofolio</h2><p class="mt-1 text-xs text-gray-400">Nilai portofolio selama 6 bulan terakhir</p></div>
                        <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-[#2563EB]">6 bulan</span>
                    </div>
                    <div class="mt-7 flex min-w-0 items-end gap-2 border-b border-gray-100 sm:gap-4">
                        @foreach ($chart as $bar)
                            <div class="group relative flex h-44 min-w-0 flex-1 flex-col justify-end text-center">
                                <span class="mb-1 text-[10px] font-bold text-[#2563EB] sm:text-[11px]">{{ $bar['short'] }}</span>
                                <div class="relative flex h-32 items-end">
                                    <div class="w-full rounded-t-lg bg-[#2563EB] transition-all group-hover:bg-[#1D4ED8]" style="height: {{ $bar['height'] }}" title="{{ $bar['amount'] }}"></div>
                                    <span class="pointer-events-none absolute bottom-2 left-1/2 hidden -translate-x-1/2 -translate-y-full whitespace-nowrap rounded-lg bg-gray-900 px-2 py-1 text-[10px] font-medium text-white shadow-lg group-hover:block">{{ $bar['amount'] }}</span>
                                </div>
                                <span class="mt-2 text-[10px] text-gray-400 sm:text-xs">{{ $bar['month'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </section>

                <div class="grid grid-cols-1 gap-7 xl:grid-cols-2">
                    <section class="rounded-2xl border border-[#F1F5F9] bg-white p-5 shadow-[0_2px_10px_rgba(0,0,0,0.03)] sm:p-6">
                        <div class="flex items-center justify-between">
                            <div><h2 class="text-base font-bold text-gray-900">Tawaran Investasi Terbaru</h2><p class="mt-1 text-xs text-gray-400">Status tawaran yang kamu kirim ke UMKM</p></div>
                            <button type="button" class="text-xs font-semibold text-[#2563EB] hover:underline" data-toast="Menampilkan semua tawaran">Lihat Semua</button>
                        </div>
                        <div class="mt-6 space-y-2">
                            @foreach ($offers as $offer)
                                <div class="flex items-center justify-between gap-3 rounded-xl px-2 py-2.5 transition hover:bg-gray-50">
                                    <div class="min-w-0"><p class="truncate text-sm font-semibold text-gray-900">{{ $offer['name'] }}</p><p class="mt-1 text-xs text-gray-400">{{ $offer['detail'] }}</p></div>
                                    <span class="shrink-0 rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $offer['statusClass'] }}">{{ $offer['status'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </section>

                    <section class="rounded-2xl border border-[#F1F5F9] bg-white p-5 shadow-[0_2px_10px_rgba(0,0,0,0.03)] sm:p-6">
                        <div class="flex items-center justify-between">
                            <div><h2 class="text-base font-bold text-gray-900">UMKM Terverifikasi</h2><p class="mt-1 text-xs text-gray-400">UMKM yang membuka peluang pendanaan</p></div>
                            <button type="button" class="text-xs font-semibold text-[#2563EB] hover:underline" data-toast="Menampilkan semua UMKM">Lihat Semua</button>
                        </div>
                        <div class="mt-6 space-y-2">
                            @foreach ($umkms as $umkm)
                                <div class="flex items-center gap-3 rounded-xl px-2 py-2.5 transition hover:bg-gray-50">
                                    <span class="flex h-11 w-11 shrink-0 items-center justify-center overflow-hidden rounded-xl bg-gradient-to-br {{ $umkm['thumbnail'] }} text-lg shadow-inner">{{ $umkm['emoji'] }}</span>
                                    <div class="min-w-0 flex-1"><p class="truncate text-sm font-semibold text-gray-900">{{ $umkm['name'] }}</p><p class="mt-1 text-xs text-gray-400">{{ $umkm['detail'] }}</p></div>
                                    <span class="hidden shrink-0 rounded-full bg-[#ECFDF5] px-2.5 py-0.5 text-xs font-semibold text-[#10B981] sm:inline-flex">{{ $umkm['funding'] }}</span>
                                    <button type="button" data-toast="Membuka detail {{ $umkm['name'] }}" class="shrink-0 text-xs font-semibold text-[#2563EB] hover:underline">Detail</button>
                                </div>
                            @endforeach
                        </div>
                    </section>
                </div>

                <section class="rounded-2xl border border-[#F1F5F9] bg-white p-5 shadow-[0_2px_10px_rgba(0,0,0,0.03)] sm:p-6">
                    <div class="mb-5"><h2 class="text-base font-bold text-gray-900">Aksi Cepat</h2><p class="mt-1 text-xs text-gray-400">Akses fitur yang paling sering digunakan</p></div>
                    <div class="grid grid-cols-2 gap-3 md:grid-cols-4">
                        @foreach ($quickActions as $action)
                            <button type="button" data-toast="{{ $action['label'] }} akan segera tersedia" class="flex min-h-28 flex-col items-center justify-center gap-3 rounded-2xl border border-gray-100 p-4 text-center transition hover:-translate-y-0.5 hover:border-blue-200 hover:bg-blue-50/40 hover:shadow-sm"><span class="flex h-10 w-10 items-center justify-center rounded-xl {{ $action['iconClass'] }}"><x-icon name="{{ $action['icon'] }}" size="18" /></span><span class="text-xs font-medium text-gray-700">{{ $action['label'] }}</span></button>
                        @endforeach
                    </div>
                </section>
            </div>
        </main>
    </div>
</div>

<div class="fixed bottom-5 right-5 z-[60] hidden max-w-xs rounded-xl bg-gray-900 px-4 py-3 text-sm font-medium text-white shadow-xl" data-toast-message></div>
@endsection

@push('scripts')
<script>
const toastMessage = document.querySelector('[data-toast-message]');
let toastTimer;
function showToast(message) { toastMessage.textContent = message; toastMessage.classList.remove('hidden'); clearTimeout(toastTimer); toastTimer = setTimeout(() => toastMessage.classList.add('hidden'), 2600); }
document.querySelectorAll('[data-toast]').forEach((element) => element.addEventListener('click', () => showToast(element.dataset.toast)));

const roleMenuToggle = document.querySelector('[data-role-menu-toggle]');
const roleMenu = document.querySelector('[data-role-menu]');
const profileMenuToggle = document.querySelector('[data-profile-menu-toggle]');
const profileMenu = document.querySelector('[data-profile-menu]');
roleMenuToggle.addEventListener('click', () => {
    const isOpen = !roleMenu.classList.contains('hidden');
    roleMenu.classList.toggle('hidden', isOpen);
    roleMenuToggle.setAttribute('aria-expanded', String(!isOpen));
    profileMenu.classList.add('hidden');
    profileMenuToggle.setAttribute('aria-expanded', 'false');
});
profileMenuToggle.addEventListener('click', () => {
    const isOpen = !profileMenu.classList.contains('hidden');
    profileMenu.classList.toggle('hidden', isOpen);
    profileMenuToggle.setAttribute('aria-expanded', String(!isOpen));
    roleMenu.classList.add('hidden');
    roleMenuToggle.setAttribute('aria-expanded', 'false');
});
document.addEventListener('click', (event) => {
    if (!roleMenu.contains(event.target) && !roleMenuToggle.contains(event.target)) {
        roleMenu.classList.add('hidden');
        roleMenuToggle.setAttribute('aria-expanded', 'false');
    }
    if (!profileMenu.contains(event.target) && !profileMenuToggle.contains(event.target)) {
        profileMenu.classList.add('hidden');
        profileMenuToggle.setAttribute('aria-expanded', 'false');
    }
});

const mobileSidebar = document.querySelector('[data-mobile-sidebar]');
const sidebarBackdrop = document.querySelector('[data-sidebar-backdrop]');
function toggleMobileSidebar(open) { mobileSidebar.classList.toggle('hidden', !open); sidebarBackdrop.classList.toggle('hidden', !open); }
document.querySelector('[data-sidebar-toggle]').addEventListener('click', () => toggleMobileSidebar(true));
sidebarBackdrop.addEventListener('click', () => toggleMobileSidebar(false));
</script>
@endpush
