@extends('layouts.investor')

@section('title', 'Dashboard Investor — UMatch')

@php
    $kycBadge = match ($kycStatus) {
        'verified' => ['label' => 'KYC Terverifikasi', 'class' => 'bg-[#ECFDF5] text-[#10B981]'],
        'rejected' => ['label' => 'KYC Ditolak', 'class' => 'bg-[#FEF2F2] text-[#EF4444]'],
        default => ['label' => 'KYC Menunggu Verifikasi', 'class' => 'bg-[#FFFBEB] text-[#D97706]'],
    };
@endphp

@section('content')
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
                            @php($actionClass = 'flex min-h-28 flex-col items-center justify-center gap-3 rounded-2xl border border-gray-100 p-4 text-center transition hover:-translate-y-0.5 hover:border-blue-200 hover:bg-blue-50/40 hover:shadow-sm')
                            @if (isset($action['route']))
                                <a href="{{ route($action['route']) }}" class="{{ $actionClass }}"><span class="flex h-10 w-10 items-center justify-center rounded-xl {{ $action['iconClass'] }}"><x-icon name="{{ $action['icon'] }}" size="18" /></span><span class="text-xs font-medium text-gray-700">{{ $action['label'] }}</span></a>
                            @else
                                <button type="button" data-toast="{{ $action['label'] }} akan segera tersedia" class="{{ $actionClass }}"><span class="flex h-10 w-10 items-center justify-center rounded-xl {{ $action['iconClass'] }}"><x-icon name="{{ $action['icon'] }}" size="18" /></span><span class="text-xs font-medium text-gray-700">{{ $action['label'] }}</span></button>
                            @endif
                        @endforeach
                    </div>
                </section>
            </div>
@endsection
