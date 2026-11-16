@extends('layouts.auth')

@section('title', 'UMatch')

@section('content')
<main id="splash" class="relative flex min-h-screen w-full items-center justify-center overflow-hidden bg-[#062d68] px-6 text-center text-white transition-opacity duration-500">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_18%_15%,rgba(30,155,95,0.85),transparent_30%),radial-gradient(circle_at_82%_12%,rgba(249,178,27,0.8),transparent_28%),linear-gradient(135deg,#0d4d96_0%,#095b8c_43%,#087d73_72%,#0b5e59_100%)]"></div>
    <div class="absolute -left-32 top-1/4 h-80 w-80 rounded-full bg-[#1e9b5f]/30 blur-3xl"></div>
    <div class="absolute -right-28 bottom-0 h-96 w-96 rounded-full bg-[#f9b21b]/25 blur-3xl"></div>
    <div class="absolute left-1/2 top-1/2 h-[min(72vw,42rem)] w-[min(72vw,42rem)] -translate-x-1/2 -translate-y-1/2 rounded-full border border-white/10"></div>
    <div class="absolute left-1/2 top-1/2 h-[min(56vw,32rem)] w-[min(56vw,32rem)] -translate-x-1/2 -translate-y-1/2 rounded-full border border-white/10"></div>

    <div class="absolute left-7 top-7 flex items-center gap-2 text-sm font-bold tracking-wide text-white/80 sm:left-10 sm:top-10">
        <span class="h-2 w-2 rounded-full bg-[#f9b21b]"></span> UMatch
    </div>
    <div class="absolute right-7 top-7 rounded-full border border-white/20 bg-white/10 px-4 py-2 text-xs font-semibold text-white/75 backdrop-blur-sm sm:right-10 sm:top-10">Satu akun • Tiga peran</div>

    <section class="relative z-10 flex max-w-xl flex-col items-center">
        <div class="relative flex h-28 w-28 items-center justify-center rounded-[2rem] bg-white shadow-2xl shadow-[#062d68]/40 ring-8 ring-white/10 sm:h-32 sm:w-32 sm:rounded-[2.25rem]">
            <div class="absolute inset-2 rounded-[1.5rem] border border-slate-100"></div>
            <x-logo size="82" />
        </div>
        <p class="mt-8 text-xs font-bold uppercase tracking-[0.35em] text-[#ffd978]">Welcome to</p>
        <h1 class="mt-3 text-5xl font-extrabold tracking-[-0.04em] sm:text-7xl">UMatch</h1>
        <p class="mt-5 max-w-md text-sm leading-7 text-white/80 sm:text-base">Belanja, berjualan, dan berinvestasi dalam satu ekosistem yang saling menguatkan.</p>

        <div class="mt-9 flex items-center gap-3" aria-label="Memuat">
            <span class="h-2.5 w-2.5 animate-pulse rounded-full bg-[#f9b21b]"></span>
            <span class="h-2.5 w-2.5 animate-pulse rounded-full bg-[#ff704b] [animation-delay:150ms]"></span>
            <span class="h-2.5 w-2.5 animate-pulse rounded-full bg-[#66d5ca] [animation-delay:300ms]"></span>
        </div>

        <a href="{{ auth()->check() ? route('dashboard') : route('onboarding') }}" class="mt-10 inline-flex items-center gap-2 rounded-full border border-white/25 bg-white/10 px-6 py-3 text-sm font-bold text-white backdrop-blur-sm transition hover:bg-white/20">
            Lewati <span aria-hidden="true">→</span>
        </a>
    </section>

    <p class="absolute bottom-7 text-xs text-white/45 sm:bottom-9">Temukan peluang. Bangun masa depan.</p>
</main>
@endsection

@push('scripts')
<script>
setTimeout(() => {
    const splash = document.getElementById('splash');
    splash.classList.add('opacity-0');
    setTimeout(() => { window.location.href = @json(auth()->check() ? route('dashboard') : route('onboarding')); }, 500);
}, 1800);
</script>
@endpush
