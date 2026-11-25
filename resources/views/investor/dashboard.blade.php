@extends('layouts.investor')

@section('title', 'Dashboard Investor — UMatch')

@php
    $kycBadge = match ($kycStatus) {
        'verified' => ['label' => 'KYC Terverifikasi', 'class' => 'border-[#BFD3EC] bg-[#EAF1FA] text-[#1E4E8C]'],
        'rejected' => ['label' => 'KYC Ditolak', 'class' => 'border-[#FECACA] bg-[#FEF2F2] text-[#EF4444]'],
        default => ['label' => 'KYC Menunggu Verifikasi', 'class' => 'border-[#FDE68A] bg-[#FFFBEB] text-[#D97706]'],
    };
    $cardClass = 'rounded-2xl border border-[#F1F5F9] bg-white p-5 shadow-[0_2px_10px_rgba(0,0,0,0.03)] sm:p-6';
    $menuClass = 'flex min-h-28 flex-col items-center justify-center gap-3 rounded-2xl border border-gray-100 p-4 text-center transition hover:-translate-y-0.5 hover:border-blue-200 hover:bg-blue-50/40 hover:shadow-sm';
@endphp

@section('content')
<<<<<<< HEAD
<div class="min-h-screen bg-[#FAFAFB] font-[Plus_Jakarta_Sans,ui-sans-serif,sans-serif] text-gray-900">
    <header class="sticky top-0 z-30 h-16 border-b border-gray-100 bg-white">
        <div class="mx-auto flex h-full max-w-[1440px] items-center gap-4 px-4 sm:px-6">
            <button type="button" class="rounded-lg p-2 text-gray-500 hover:bg-gray-50 lg:hidden" data-sidebar-toggle aria-label="Buka navigasi"><x-icon name="menu" size="20" /></button>
            <a href="{{ route('investor.dashboard') }}" class="flex shrink-0 items-center gap-2"><x-logo size="28" /><span class="text-base font-extrabold tracking-tight text-gray-900">UMatch</span><span class="rounded-full bg-[#2563EB] px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider text-white">Investor</span></a>
            <div class="relative ml-2 hidden w-80 md:block lg:w-96"><x-icon name="search" size="17" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400" /><input type="search" placeholder="Cari UMKM terverifikasi..." class="w-full rounded-full border border-gray-200 bg-[#F8FAFC] py-2 pl-11 pr-4 text-xs text-gray-700 outline-none transition placeholder:text-gray-400 focus:border-[#93C5FD] focus:ring-2 focus:ring-blue-100"></div>
            <div class="ml-auto flex items-center gap-2 sm:gap-3">
                <button type="button" class="relative flex h-10 w-10 items-center justify-center rounded-full border border-gray-200 text-gray-500 transition hover:bg-gray-50" data-toast="Tidak ada notifikasi baru" aria-label="Notifikasi"><x-icon name="bell" size="18" /><span class="absolute right-2 top-2 h-1.5 w-1.5 rounded-full bg-[#2563EB]"></span></button>
                <div class="relative">
<button type="button" class="flex items-center gap-2 rounded-full border border-emerald-100 bg-emerald-50 px-3 py-1.5 text-xs font-bold text-emerald-700 transition hover:bg-slate-100" data-role-menu-toggle aria-expanded="false">Investor<x-icon name="chevron-down" size="14" /></button>
                    <div class="absolute right-0 top-12 hidden w-52 rounded-xl border border-gray-100 bg-white p-1.5 shadow-xl" data-role-menu>
                        <p class="px-3 pb-1.5 pt-2 text-[10px] font-bold uppercase tracking-wider text-gray-400">Ganti Role</p>
                        @foreach (config('umatch.roles') as $roleKey => $availableRole)
<form action="{{ route('roles.select') }}" method="POST">@csrf<input type="hidden" name="role" value="{{ $roleKey }}"><button type="submit" class="flex w-full items-center justify-between rounded-lg px-3 py-2 text-left text-xs font-medium text-gray-700 hover:bg-slate-100 hover:text-emerald-700"><span>{{ $availableRole['label'] }}</span>@if ($roleKey === 'investor')<span class="text-[10px] font-bold text-emerald-700">Aktif</span>@endif</button></form>
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
=======
<div class="mx-auto max-w-7xl space-y-7">
    <section class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900">Dashboard Investor</h1>
            <p class="mt-0.5 text-sm text-gray-400">{{ $user->nama }} <span aria-hidden="true">•</span> {{ $today }}</p>
>>>>>>> aeb9600c8ffd94c8f35320e698561cb81e822e4d
        </div>
        <div class="flex flex-wrap items-center gap-2">
            @if ($riskProfile)
                <span class="rounded-xl border border-gray-200 bg-white px-4 py-2 text-xs font-semibold text-gray-600">Profil Risiko: {{ $riskProfile }}</span>
            @endif
            <span class="inline-flex items-center gap-2 rounded-xl border px-4 py-2 text-xs font-semibold {{ $kycBadge['class'] }}"><x-icon name="shield" size="15" />{{ $kycBadge['label'] }}</span>
        </div>
    </section>

    <section class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4" aria-label="Ringkasan investasi">
        @foreach ($kpis as $kpi)
            <article class="flex min-h-36 flex-col rounded-2xl border border-[#F1F5F9] bg-white p-5 shadow-[0_2px_10px_rgba(0,0,0,0.03)]">
                <div class="flex items-start justify-between">
                    <span class="flex h-9 w-9 items-center justify-center rounded-xl {{ $kpi['iconClass'] }}"><x-icon name="trending-up" size="18" /></span>
                    <span class="rounded-full bg-[#E6F7F4] px-2.5 py-0.5 text-xs font-semibold text-[#00A88F]">{{ $kpi['change'] }}</span>
                </div>
                <p class="mt-auto pt-5 text-2xl font-extrabold tracking-tight text-gray-900">{{ $kpi['value'] }}</p>
                <p class="mt-1 text-xs text-gray-400">{{ $kpi['label'] }}</p>
            </article>
        @endforeach
    </section>

    <div class="grid grid-cols-1 gap-7 xl:grid-cols-2">
        <section class="{{ $cardClass }}">
            <h2 class="text-base font-bold text-gray-900">Alokasi Investasi</h2>
            <div class="mt-6 space-y-5">
                @foreach ($allocations as $allocation)
                    <div>
                        <div class="flex items-center justify-between gap-3">
                            <p class="truncate text-sm font-semibold text-gray-900">{{ $allocation['name'] }}</p>
                            <p class="shrink-0 text-xs text-gray-400">{{ $allocation['amount'] }} <span class="ml-1 font-bold {{ $allocation['textClass'] }}">{{ $allocation['percentage'] }}%</span></p>
                        </div>
                        <div class="mt-2 h-1.5 overflow-hidden rounded-full bg-gray-100">
                            <div class="h-full rounded-full {{ $allocation['barClass'] }}" style="width: {{ $allocation['percentage'] }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="{{ $cardClass }}">
            <div class="flex items-center justify-between">
                <h2 class="text-base font-bold text-gray-900">UMKM Terverifikasi</h2>
                <a href="{{ route('investor.explore') }}" class="text-xs font-semibold text-[#1E4E8C] hover:underline">Jelajahi</a>
            </div>
            <div class="mt-5 space-y-2">
                @foreach ($umkms as $umkm)
                    <button type="button" data-toast="Detail {{ $umkm['name'] }} akan segera tersedia" class="flex w-full items-center gap-3 rounded-xl px-2 py-2.5 text-left transition hover:bg-gray-50">
                        <span class="h-11 w-11 shrink-0 rounded-xl bg-gray-100" aria-hidden="true"></span>
                        <span class="min-w-0 flex-1"><span class="block truncate text-sm font-semibold text-gray-900">{{ $umkm['name'] }}</span><span class="mt-1 block text-xs text-gray-400">{{ $umkm['detail'] }}</span></span>
                        <span class="shrink-0 text-[#00A88F]" title="Terverifikasi"><x-icon name="check" size="16" /></span>
                        <span class="shrink-0 text-lg text-gray-300" aria-hidden="true">›</span>
                    </button>
                @endforeach
            </div>
        </section>
    </div>

    <section class="{{ $cardClass }}">
        <div class="flex items-center justify-between">
            <div><h2 class="text-base font-bold text-gray-900">Tawaran Investasi Terbaru</h2><p class="mt-1 text-xs text-gray-400">Status tawaran yang kamu kirim ke UMKM</p></div>
            <a href="{{ route('investor.offers') }}" class="text-xs font-semibold text-[#1E4E8C] hover:underline">Lihat Semua</a>
        </div>
        <div class="mt-5 space-y-2">
            @foreach ($offers as $offer)
                <div class="flex items-center justify-between gap-3 rounded-xl px-2 py-2.5 transition hover:bg-gray-50">
                    <div class="min-w-0"><p class="truncate text-sm font-semibold text-gray-900">{{ $offer['name'] }}</p><p class="mt-1 text-xs text-gray-400">{{ $offer['detail'] }}</p></div>
                    <span class="shrink-0 rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $offer['statusClass'] }}">{{ $offer['status'] }}</span>
                </div>
            @endforeach
        </div>
    </section>

    <section class="{{ $cardClass }}">
        <h2 class="mb-5 text-base font-bold text-gray-900">Menu</h2>
        <div class="grid grid-cols-2 gap-3 md:grid-cols-5">
            @foreach ($menus as $menu)
                @if (isset($menu['route']))
                    <a href="{{ route($menu['route']) }}" class="{{ $menuClass }}"><span class="flex h-10 w-10 items-center justify-center rounded-xl {{ $menu['iconClass'] }}"><x-icon name="{{ $menu['icon'] }}" size="18" /></span><span class="text-xs font-medium text-gray-700">{{ $menu['label'] }}</span></a>
                @else
                    <button type="button" data-toast="{{ $menu['label'] }} akan segera tersedia" class="{{ $menuClass }}"><span class="flex h-10 w-10 items-center justify-center rounded-xl {{ $menu['iconClass'] }}"><x-icon name="{{ $menu['icon'] }}" size="18" /></span><span class="text-xs font-medium text-gray-700">{{ $menu['label'] }}</span></button>
                @endif
            @endforeach
        </div>
    </section>
</div>
@endsection
