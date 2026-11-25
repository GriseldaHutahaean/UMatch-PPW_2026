@extends('layouts.investor')

@section('title', 'Tawaran Saya — UMatch')

@php
    $statuses = [
        'menunggu' => ['label' => 'Menunggu', 'class' => 'bg-[#FFFBEB] text-[#D97706]'],
        'diterima' => ['label' => 'Diterima', 'class' => 'bg-[#ECFDF5] text-[#10B981]'],
        'ditolak' => ['label' => 'Ditolak', 'class' => 'bg-[#FEF2F2] text-[#EF4444]'],
    ];
@endphp

@section('content')
<div class="mx-auto max-w-7xl space-y-7">
    <section>
        <h1 class="text-2xl font-bold tracking-tight text-gray-900">Tawaran Saya</h1>
        <p class="mt-0.5 text-sm text-gray-400">{{ $totalOffers }} tawaran investasi dikirim ke UMKM</p>
    </section>

    <nav class="flex flex-wrap gap-2" aria-label="Filter status tawaran">
        <a href="{{ route('investor.offers') }}" @if (! $status) aria-current="page" @endif class="rounded-full border px-4 py-2 text-xs font-semibold transition {{ ! $status ? 'border-[#1E4E8C] bg-[#1E4E8C] text-white' : 'border-gray-200 bg-white text-gray-600 hover:bg-blue-50' }}">Semua ({{ $totalOffers }})</a>
        @foreach ($statuses as $statusKey => $statusOption)
            <a href="{{ route('investor.offers', ['status' => $statusKey]) }}" @if ($status === $statusKey) aria-current="page" @endif class="rounded-full border px-4 py-2 text-xs font-semibold transition {{ $status === $statusKey ? 'border-[#1E4E8C] bg-[#1E4E8C] text-white' : 'border-gray-200 bg-white text-gray-600 hover:bg-blue-50' }}">{{ $statusOption['label'] }} ({{ $statusCounts->get($statusKey, 0) }})</a>
        @endforeach
    </nav>

    @if ($offers->isEmpty())
        <section class="rounded-2xl border border-[#F1F5F9] bg-white p-10 text-center shadow-[0_2px_10px_rgba(0,0,0,0.03)]">
            <p class="text-sm font-semibold text-gray-900">{{ $status ? 'Tidak ada tawaran dengan status ini' : 'Kamu belum mengirim tawaran' }}</p>
            <p class="mt-1 text-xs text-gray-400">Temukan UMKM terverifikasi yang membuka peluang pendanaan.</p>
            <a href="{{ route('investor.explore') }}" class="mt-5 inline-flex rounded-xl bg-[#1E4E8C] px-5 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-[#173F73]">Jelajahi UMKM</a>
        </section>
    @else
        <section class="space-y-4" aria-label="Daftar tawaran investasi">
            @foreach ($offers as $offer)
                @php($badge = $statuses[$offer->status_penawaran] ?? ['label' => ucfirst($offer->status_penawaran), 'class' => 'bg-gray-100 text-gray-500'])
                <article class="rounded-2xl border border-[#F1F5F9] bg-white p-5 shadow-[0_2px_10px_rgba(0,0,0,0.03)]">
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex min-w-0 items-center gap-3">
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#EAF1FA] text-[#1E4E8C]"><x-icon name="store" size="20" /></span>
                            <div class="min-w-0">
                                <h2 class="truncate text-sm font-bold text-gray-900">{{ $offer->umkmProfile->nama_usaha }}</h2>
                                <p class="mt-1 text-xs text-gray-400">{{ $offer->umkmProfile->kategori_usaha }}</p>
                            </div>
                        </div>
                        <span class="shrink-0 rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $badge['class'] }}">{{ $badge['label'] }}</span>
                    </div>
                    <dl class="mt-4 grid grid-cols-1 gap-3 border-t border-gray-100 pt-4 sm:grid-cols-3">
                        <div><dt class="text-xs text-gray-400">Nominal Tawaran</dt><dd class="mt-1 text-sm font-semibold text-gray-900">Rp {{ number_format((float) $offer->jumlah_penawaran, 0, ',', '.') }}</dd></div>
                        <div><dt class="text-xs text-gray-400">Skema Investasi</dt><dd class="mt-1 text-sm font-semibold text-gray-900">{{ $offer->skema_investasi }}</dd></div>
                        <div><dt class="text-xs text-gray-400">Tanggal Pengajuan</dt><dd class="mt-1 text-sm font-semibold text-gray-900">{{ $offer->tanggal_pengajuan->locale('id')->translatedFormat('d M Y') }}</dd></div>
                    </dl>
                </article>
            @endforeach
        </section>
    @endif
</div>
@endsection
