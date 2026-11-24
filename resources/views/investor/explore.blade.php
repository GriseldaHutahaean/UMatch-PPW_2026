@extends('layouts.investor')

@section('title', 'Jelajah UMKM — UMatch')

@section('content')
<div class="mx-auto max-w-7xl space-y-7">
    <section>
        <h1 class="text-2xl font-bold tracking-tight text-gray-900">Jelajah UMKM</h1>
        <p class="mt-0.5 text-sm text-gray-400">{{ $umkms->count() }} UMKM terverifikasi ditemukan</p>
    </section>

    <form method="GET" action="{{ route('investor.explore') }}" class="flex flex-col gap-3 sm:flex-row">
        <div class="relative flex-1">
            <x-icon name="search" size="17" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400" />
            <input type="search" name="q" value="{{ $search }}" placeholder="Cari nama usaha atau lokasi..." class="w-full rounded-xl border border-gray-200 bg-white py-2.5 pl-11 pr-4 text-sm text-gray-700 outline-none transition placeholder:text-gray-400 focus:border-[#93C5FD] focus:ring-2 focus:ring-blue-100">
        </div>
        <select name="kategori" aria-label="Kategori usaha" class="rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm text-gray-700 outline-none focus:border-[#93C5FD] focus:ring-2 focus:ring-blue-100">
            <option value="">Semua kategori</option>
            @foreach ($categories as $categoryOption)
                <option value="{{ $categoryOption }}" @selected($category === $categoryOption)>{{ $categoryOption }}</option>
            @endforeach
        </select>
        <button type="submit" class="rounded-xl bg-[#2563EB] px-5 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-[#1D4ED8]">Cari</button>
    </form>

    @if ($umkms->isEmpty())
        <section class="rounded-2xl border border-[#F1F5F9] bg-white p-10 text-center shadow-[0_2px_10px_rgba(0,0,0,0.03)]">
            <p class="text-sm font-semibold text-gray-900">Belum ada UMKM yang cocok</p>
            <p class="mt-1 text-xs text-gray-400">Coba ubah kata kunci atau kategori pencarian.</p>
        </section>
    @else
        <section class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3" aria-label="Daftar UMKM terverifikasi">
            @foreach ($umkms as $umkm)
                <article class="flex flex-col rounded-2xl border border-[#F1F5F9] bg-white p-5 shadow-[0_2px_10px_rgba(0,0,0,0.03)] transition hover:-translate-y-0.5 hover:shadow-md">
                    <div class="flex items-start justify-between gap-3">
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#EFF6FF] text-[#2563EB]"><x-icon name="store" size="20" /></span>
                        <span class="rounded-full bg-[#ECFDF5] px-2.5 py-0.5 text-xs font-semibold text-[#10B981]">Terverifikasi</span>
                    </div>
                    <h2 class="mt-4 truncate text-base font-bold text-gray-900">{{ $umkm->nama_usaha }}</h2>
                    <p class="mt-1 text-xs text-gray-400">{{ $umkm->kategori_usaha }}@if ($umkm->alamat_usaha) <span aria-hidden="true">•</span> {{ $umkm->alamat_usaha }}@endif</p>
                    <p class="mt-3 line-clamp-3 text-sm text-gray-600">{{ $umkm->deskripsi ?: 'Belum ada deskripsi usaha.' }}</p>
                    <div class="mt-auto flex items-center justify-between gap-3 pt-5">
                        @if ($umkm->terima_investasi)
                            <span class="rounded-full bg-[#EFF6FF] px-2.5 py-0.5 text-xs font-semibold text-[#2563EB]">Pendanaan terbuka</span>
                        @else
                            <span class="rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-semibold text-gray-500">Pendanaan tertutup</span>
                        @endif
                        <button type="button" data-toast="Detail {{ $umkm->nama_usaha }} akan segera tersedia" class="text-xs font-semibold text-[#2563EB] hover:underline">Lihat Detail</button>
                    </div>
                </article>
            @endforeach
        </section>
    @endif
</div>
@endsection
