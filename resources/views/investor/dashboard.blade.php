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
<div class="mx-auto max-w-7xl space-y-7">
    <section class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900">Dashboard Investor</h1>
            <p class="mt-0.5 text-sm text-gray-400">{{ $user->nama }} <span aria-hidden="true">•</span> {{ $today }}</p>
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
