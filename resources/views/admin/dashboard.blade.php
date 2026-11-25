<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — UMatch Admin Console</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 font-[Plus_Jakarta_Sans,ui-sans-serif,sans-serif] text-slate-900">

<div class="flex min-h-screen">

    {{-- ===== Sidebar ===== --}}
<aside class="fixed inset-y-0 left-0 z-30 flex w-[220px] flex-col bg-emerald-950 text-white">

        {{-- Logo --}}
        <div class="flex items-center gap-3 px-5 py-5 border-b border-white/10">
            <span class="flex h-8 w-8 items-center justify-center rounded-md bg-white">
                <x-logo size="22" />
            </span>
            <div>
                <span class="block text-sm font-extrabold tracking-tight leading-tight">UMatch</span>
<span class="block text-[10px] font-semibold uppercase tracking-widest text-emerald-200">Admin Console</span>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 overflow-y-auto px-3 py-5 space-y-1 text-xs font-semibold">
            <p class="px-3 pb-1 pt-3 text-[9px] font-bold uppercase tracking-widest text-slate-500">Workspace</p>
<a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 rounded-lg bg-emerald-700 px-3 py-2.5 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="3" y="3" width="7" height="7" rx="1" /><rect x="14" y="3" width="7" height="7" rx="1" /><rect x="3" y="14" width="7" height="7" rx="1" /><rect x="14" y="14" width="7" height="7" rx="1" /></svg>
                Dashboard
            </a>

            <p class="px-3 pb-1 pt-4 text-[9px] font-bold uppercase tracking-widest text-slate-500">Verifikasi</p>

            @foreach ([
                ['label' => 'Verifikasi UMKM',      'icon' => 'store',   'count' => 18],
                ['label' => 'KYC Investor',          'icon' => 'users',   'count' => 7],
                ['label' => 'Manajemen Pengguna',    'icon' => 'user',    'count' => null],
                ['label' => 'Manajemen Kategori',    'icon' => 'tag',     'count' => null],
            ] as $item)
                <button type="button" class="flex w-full items-center justify-between gap-3 rounded-lg px-3 py-2.5 text-slate-400 transition hover:bg-white/10 hover:text-white">
                    <span class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            @if ($item['icon'] === 'store')
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                            @elseif ($item['icon'] === 'users')
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            @elseif ($item['icon'] === 'tag')
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/>
                            @else
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            @endif
                        </svg>
                        {{ $item['label'] }}
                    </span>
                    @if ($item['count'])
<span class="rounded-full bg-emerald-700 px-2 py-0.5 text-[10px] font-bold text-white">{{ $item['count'] }}</span>
                    @endif
                </button>
            @endforeach

            <p class="px-3 pb-1 pt-4 text-[9px] font-bold uppercase tracking-widest text-slate-500">Platform</p>
            @foreach ([
                ['label' => 'Moderasi Konten',       'count' => 12],
                ['label' => 'Transaksi & Investasi', 'count' => null],
                ['label' => 'Promosi',               'count' => null],
                ['label' => 'Pengumuman',            'count' => null],
                ['label' => 'Laporan Platform',      'count' => null],
            ] as $item)
                <button type="button" class="flex w-full items-center justify-between gap-3 rounded-lg px-3 py-2.5 text-slate-400 transition hover:bg-white/10 hover:text-white">
                    <span>{{ $item['label'] }}</span>
                    @if ($item['count'])
<span class="rounded-full bg-emerald-700 px-2 py-0.5 text-[10px] font-bold text-white">{{ $item['count'] }}</span>
                    @endif
                </button>
            @endforeach
        </nav>

        {{-- Admin identity --}}
        <div class="border-t border-white/10 p-4">
            <div class="flex items-center gap-3">
<span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-emerald-700 text-sm font-bold text-white uppercase">
                    {{ substr($admin->getAdminDisplayName(), 0, 2) }}
                </span>
                <div class="min-w-0">
                    <p class="truncate text-sm font-bold text-white">{{ $admin->getAdminDisplayName() }}</p>
                    <p class="text-[10px] font-medium text-slate-400">Super Administrator</p>
                </div>
            </div>
            {{-- Logout trigger --}}
            <button
                type="button"
                id="logout-trigger"
                class="mt-3 flex w-full items-center gap-2 rounded-lg px-3 py-2 text-xs font-semibold text-slate-400 transition hover:bg-white/10 hover:text-white"
            >
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Keluar dari Admin
            </button>
        </div>
    </aside>

    {{-- ===== Main content ===== --}}
    <div class="ml-[220px] flex min-h-screen flex-1 flex-col">

        {{-- Top bar --}}
        <header class="sticky top-0 z-20 flex h-14 items-center justify-between border-b border-slate-200 bg-white px-6 shadow-sm">
            <div>
<span class="text-[10px] font-bold uppercase tracking-widest text-emerald-700">ADM-02 · PUSAT KENDALI</span>
                <h1 class="text-xl font-extrabold text-slate-900">Dashboard</h1>
            </div>
            <div class="flex items-center gap-3">
                <button type="button" class="relative flex h-9 w-9 items-center justify-center rounded-full border border-slate-200 text-slate-500 transition hover:bg-slate-50" aria-label="Notifications">
                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    <span class="absolute right-2 top-2 h-1.5 w-1.5 rounded-full bg-red-500"></span>
                </button>

                <div class="flex items-center gap-2 rounded-full border border-slate-200 bg-slate-50 px-3 py-1.5">
<span class="flex h-6 w-6 items-center justify-center rounded-full bg-emerald-700 text-[10px] font-bold text-white uppercase">
                        {{ substr($admin->getAdminDisplayName(), 0, 2) }}
                    </span>
                    <div>
                        <p class="text-xs font-bold text-slate-900">{{ $admin->getAdminDisplayName() }}</p>
                        <p class="text-[10px] text-slate-400">Admin Internal</p>
                    </div>
                </div>
            </div>
        </header>

        {{-- Page body --}}
        <main class="flex-1 p-6 md:p-8">

            {{-- Breadcrumb --}}
            <nav class="mb-4 flex items-center gap-2 text-xs text-slate-400" aria-label="Breadcrumb">
                <span>Admin Panel</span>
                <span aria-hidden="true">›</span>
                <span class="font-semibold text-slate-700">Dashboard</span>
            </nav>

            <p class="mb-6 text-sm text-slate-500">Ringkasan aktivitas dan kesehatan ekosistem UMatch.</p>

            {{-- Welcome banner --}}
<div class="mb-6 flex items-center gap-3 rounded-xl border border-emerald-100 bg-emerald-50 px-5 py-4">
<span class="flex h-9 w-9 items-center justify-center rounded-full bg-emerald-700 text-sm font-bold text-white uppercase">
                    {{ substr($admin->getAdminDisplayName(), 0, 2) }}
                </span>
                <div>
                    <p class="text-sm font-bold text-slate-900">Welcome back, {{ $admin->getAdminDisplayName() }}.</p>
<p class="text-xs text-slate-500">Role: <span class="font-semibold text-emerald-700">Administrator</span> · @{{ $admin->username_admin }}</p>
                </div>
            </div>

            {{-- KPI cards --}}
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
                @foreach ([
['label' => 'Total Pengguna',  'value' => '14.284', 'sub' => '+8.4% bulan ini',    'color' => 'text-emerald-700', 'bg' => 'bg-emerald-50'],
['label' => 'Customer',         'value' => '10.842', 'sub' => '75.9% pengguna',     'color' => 'text-emerald-700', 'bg' => 'bg-emerald-50'],
['label' => 'UMKM',             'value' => '2.318',  'sub' => '2.041 terverifikasi','color' => 'text-emerald-700','bg' => 'bg-emerald-50'],
                    ['label' => 'Investor',         'value' => '1.124',  'sub' => '986 terverifikasi',  'color' => 'text-[#2563eb]', 'bg' => 'bg-blue-50'],
                ] as $kpi)
                    <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                        <div class="flex items-start justify-between">
                            <p class="text-xs font-semibold text-slate-500">{{ $kpi['label'] }}</p>
                            <span class="flex h-8 w-8 items-center justify-center rounded-xl {{ $kpi['bg'] }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="{{ $kpi['color'] }}" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            </span>
                        </div>
                        <p class="mt-3 text-3xl font-extrabold tracking-tight text-slate-900">{{ $kpi['value'] }}</p>
                        <p class="mt-1 text-xs font-medium {{ $kpi['color'] }}">{{ $kpi['sub'] }}</p>
                    </div>
                @endforeach
            </div>

            {{-- Pending action cards --}}
            <div class="mt-5 grid grid-cols-1 gap-4 sm:grid-cols-3">
                @foreach ([
                    ['label' => 'KYB Menunggu',          'value' => '18',     'color' => 'text-amber-600',  'bg' => 'bg-amber-50',  'border' => 'border-amber-200'],
                    ['label' => 'KYC Menunggu',          'value' => '7',      'color' => 'text-blue-600',   'bg' => 'bg-blue-50',   'border' => 'border-blue-200'],
                    ['label' => 'Konten Perlu Review',   'value' => '12',     'color' => 'text-rose-600',   'bg' => 'bg-rose-50',   'border' => 'border-rose-200'],
                ] as $item)
                    <div class="flex items-center gap-4 rounded-2xl border {{ $item['border'] }} {{ $item['bg'] }} p-5">
                        <p class="text-4xl font-extrabold {{ $item['color'] }}">{{ $item['value'] }}</p>
                        <p class="text-sm font-semibold text-slate-700">{{ $item['label'] }}</p>
                    </div>
                @endforeach
            </div>

            {{-- Stats row --}}
            <div class="mt-5 grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                    <p class="text-xs font-semibold text-slate-500">Total Pesanan</p>
                    <p class="mt-2 text-3xl font-extrabold text-slate-900">28.640</p>
                </div>
                <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                    <p class="text-xs font-semibold text-slate-500">Total Investasi</p>
                    <p class="mt-2 text-3xl font-extrabold text-slate-900">Rp 18,7 M</p>
                </div>
            </div>

        </main>
    </div>
</div>

{{-- ===== Logout confirmation modal ===== --}}
<div id="logout-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/40 px-4" aria-modal="true" role="dialog" aria-labelledby="logout-modal-title">
    <div class="w-full max-w-sm rounded-2xl bg-white p-6 shadow-2xl">
        <h2 id="logout-modal-title" class="text-lg font-bold text-slate-900">Keluar dari Admin?</h2>
        <p class="mt-2 text-sm text-slate-500">Sesi Anda akan diakhiri. Anda harus masuk kembali untuk mengakses panel admin.</p>
        <div class="mt-6 flex gap-3">
            <button type="button" id="logout-cancel" class="flex-1 rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                Batal
            </button>
            <form action="{{ route('admin.logout') }}" method="POST" class="flex-1">
                @csrf
                <button type="submit" class="w-full rounded-xl bg-red-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-red-700">
                    Ya, Keluar
                </button>
            </form>
        </div>
    </div>
</div>

<script>
(function () {
    'use strict';

    const modal = document.getElementById('logout-modal');
    const triggerBtn = document.getElementById('logout-trigger');
    const cancelBtn = document.getElementById('logout-cancel');

    function openModal() {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    if (triggerBtn) { triggerBtn.addEventListener('click', openModal); }
    if (cancelBtn)  { cancelBtn.addEventListener('click', closeModal); }

    modal.addEventListener('click', function (event) {
        if (event.target === modal) { closeModal(); }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') { closeModal(); }
    });
}());
</script>

</body>
</html>
