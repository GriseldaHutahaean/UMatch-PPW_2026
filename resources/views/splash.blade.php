@extends('layouts.auth')

@section('title', 'UMatch')

@section('content')
<main id="splash" class="flex min-h-screen w-full flex-col items-center justify-center overflow-x-hidden bg-[#0d4d96] px-6 text-center text-white transition-opacity duration-500">
    <div class="flex h-24 w-24 items-center justify-center rounded-[2rem] bg-white shadow-2xl shadow-blue-950/30"><x-logo size="70" /></div>
    <h1 class="mt-7 text-5xl font-extrabold tracking-tight">UMatch</h1>
    <p class="mt-3 max-w-sm text-blue-100">Belanja, Berjualan, dan Berinvestasi dalam Satu Akun.</p>
    <div class="mt-8 flex gap-2" aria-label="Memuat"><span class="h-2 w-2 animate-bounce rounded-full bg-amber-300"></span><span class="h-2 w-2 animate-bounce rounded-full bg-amber-300 [animation-delay:150ms]"></span><span class="h-2 w-2 animate-bounce rounded-full bg-amber-300 [animation-delay:300ms]"></span></div>
    <a href="{{ auth()->check() ? route('dashboard') : route('onboarding') }}" class="mt-12 text-sm font-bold text-blue-100 underline underline-offset-4">Lewati</a>
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
