@extends('layouts.auth')

@section('title', 'UMatch')
@section('body-class', 'splash-page')

@push('head')
    {{-- Cadangan kalau JavaScript mati: pindah ke Pilih Peran setelah 3 detik --}}
    <noscript><meta http-equiv="refresh" content="3;url={{ route('roles.choose') }}"></noscript>
@endpush

@section('content')
    <main class="splash" id="splash">
        <div class="splash-logo">
            <x-logo size="64" />
        </div>
        <h1 class="splash-title">UMatch</h1>
        <p class="splash-tagline">Belanja, Berjualan, dan Berinvestasi dalam Satu Akun.</p>
        <div class="splash-dots" aria-label="Memuat">
            <span></span><span></span><span></span>
        </div>
        <a href="{{ route('roles.choose') }}" class="splash-skip">Lewati</a>
    </main>
@endsection

@push('scripts')
    <script>
        // Tampilkan splash sebentar, lalu pindah ke halaman Pilih Peran
        setTimeout(function () {
            document.getElementById('splash').classList.add('is-leaving');
            setTimeout(function () {
                window.location.href = @json(route('roles.choose'));
            }, 400);
        }, 1800);
    </script>
@endpush
