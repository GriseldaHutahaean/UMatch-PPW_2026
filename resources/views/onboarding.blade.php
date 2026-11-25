@extends('layouts.auth')

@section('title', 'Kenali UMatch')

@section('content')
@php
    $slides = [
        ['theme' => 'mint', 'image' => 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?auto=format&fit=crop&w=1100&q=85', 'icon' => 'bag', 'eyebrow' => 'Customer', 'title' => 'Temukan UMKM lokal terbaik', 'description' => 'Jelajahi produk pilihan dari pelaku usaha lokal dan temukan cerita di balik setiap karya.'],
        ['theme' => 'peach', 'image' => 'https://images.unsplash.com/photo-1556761175-b413da4baf72?auto=format&fit=crop&w=1100&q=85', 'icon' => 'store', 'eyebrow' => 'UMKM', 'title' => 'Kelola usaha lebih mudah', 'description' => 'Atur produk, pantau penjualan, dan bangun koneksi bisnis dari satu ruang kerja digital.'],
        ['theme' => 'blue', 'image' => 'https://images.unsplash.com/photo-1556740749-887f6717d7e4?auto=format&fit=crop&w=1100&q=85', 'icon' => 'trend', 'eyebrow' => 'Investor', 'title' => 'Investasi di UMKM berpotensi', 'description' => 'Temukan peluang yang tepat melalui profil usaha, data finansial, dan insight yang lebih terpercaya.'],
    ];
@endphp

<main id="onboarding" class="min-h-screen w-full overflow-x-hidden bg-slate-50">
    <section class="min-h-screen transition-colors duration-500" data-onboarding-shell>
        <header class="relative z-10 flex h-[68px] items-center justify-between border-b border-slate-100 bg-white px-5 sm:px-8 lg:px-[3.25rem]">
            <a href="{{ route('landing') }}" class="flex items-center gap-2.5 rounded-xl focus:outline-none focus:ring-4 focus:ring-slate-200" aria-label="UMatch, kembali ke halaman utama">
                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-white shadow-sm ring-1 ring-slate-200"><x-logo size="28" /></span>
                <span>
                    <span class="block text-sm font-extrabold leading-4 tracking-tight text-slate-900">UMatch</span>
                    <span class="mt-0.5 block text-[9px] font-medium leading-3 text-slate-400">Satu ekosistem, banyak peluang</span>
                </span>
            </a>
            <button type="button" data-reset-slide class="rounded-full border border-slate-200 bg-white px-3.5 py-2 text-[10px] font-semibold text-slate-500 transition hover:border-slate-300 hover:text-slate-700 focus:outline-none focus:ring-4 focus:ring-slate-200 sm:px-4 sm:text-xs">Kenali platform kami</button>
        </header>

        <div class="mx-auto grid min-h-[calc(100vh-68px)] w-full max-w-[1088px] grid-cols-1 items-center gap-8 px-5 py-8 sm:grid-cols-[1.15fr_1fr] sm:gap-6 sm:px-8 lg:-translate-y-12 lg:grid-cols-[1.35fr_1fr] lg:gap-16 lg:px-16 lg:py-10" data-onboarding-content>
            <div class="relative order-1 w-full">
                <div class="absolute -inset-3 rounded-[2rem] bg-white/40 blur-xl sm:-inset-4"></div>
                <div class="relative h-[clamp(240px,55vw,520px)] overflow-hidden rounded-[1.5rem] bg-slate-200 shadow-[0_24px_60px_rgba(15,23,42,0.12)] sm:h-[min(52vh,520px)] sm:rounded-[1.75rem] lg:h-[min(58vh,520px)] lg:rounded-[1.5rem]">
                    <img data-slide-image class="h-full w-full object-cover" alt="Foto aktivitas di UMatch" loading="eager">
                    <div class="absolute inset-0 bg-slate-950/10"></div>
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/50 via-transparent to-slate-950/10"></div>
                    <div class="absolute bottom-5 left-5 right-5 flex items-end justify-between text-white sm:bottom-6 sm:left-7 sm:right-7">
                        <span data-slide-eyebrow class="rounded-full border border-white/35 bg-white/15 px-3.5 py-1.5 text-[10px] font-bold backdrop-blur-md sm:px-4 sm:py-2 sm:text-xs"></span>
                        <span data-slide-range class="text-[10px] font-semibold text-white/80 sm:text-xs"></span>
                    </div>
                </div>
            </div>

            <div class="order-2 flex w-full flex-col items-center text-center sm:items-start sm:text-left">
                <div data-slide-icon class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white text-emerald-700 shadow-[0_5px_14px_rgba(15,23,42,0.10)] ring-1 ring-slate-100"></div>
                <p class="mt-6 text-[10px] font-extrabold uppercase tracking-[0.28em] text-slate-400 sm:text-[11px]">Satu akun untuk banyak kemungkinan</p>
                <h1 data-slide-title aria-live="polite" class="mt-4 max-w-md text-3xl font-extrabold leading-[1.12] tracking-tight text-slate-900 sm:text-[clamp(2rem,5.5vw,3rem)] lg:text-[48px]"></h1>
                <p data-slide-description class="mt-4 max-w-md text-[13px] leading-6 text-slate-500 sm:text-sm sm:leading-7"></p>

                <div class="mt-7 w-full max-w-md">
                    <div class="mb-3 flex items-center justify-between text-[10px] font-bold text-slate-400 sm:text-xs"><span data-slide-count>01 / 03</span><span>Mulai perjalananmu</span></div>
                    <div class="h-1 overflow-hidden rounded-full bg-white/90"><div data-progress class="h-full rounded-full transition-[width,background-color] duration-500"></div></div>
                </div>

                <div class="mt-6 flex w-full max-w-md items-center gap-3 sm:gap-5">
                    <button type="button" data-next class="h-12 flex-1 rounded-xl px-5 text-xs font-extrabold text-white shadow-[0_7px_16px_rgba(15,23,42,0.12)] transition duration-200 hover:-translate-y-0.5 hover:brightness-105 focus:outline-none focus:ring-4 focus:ring-white/80 active:translate-y-0 sm:text-sm"></button>
                    <button type="button" data-skip class="rounded-xl px-3 py-3 text-[11px] font-bold text-slate-400 transition hover:bg-white/70 hover:text-slate-700 focus:outline-none focus:ring-4 focus:ring-white/80 sm:px-4 sm:text-xs">Lewati</button>
                </div>
                <div class="mt-5 flex min-h-3 items-center gap-1.5" data-dots role="group" aria-label="Pilih slide onboarding"></div>
            </div>
        </div>
    </section>
</main>
@endsection

@push('scripts')
<script>
const onboardingSlides = @json($slides);
let activeSlide = 0;
const shell = document.querySelector('[data-onboarding-shell]');
const image = document.querySelector('[data-slide-image]');
const icon = document.querySelector('[data-slide-icon]');
const eyebrow = document.querySelector('[data-slide-eyebrow]');
const title = document.querySelector('[data-slide-title]');
const description = document.querySelector('[data-slide-description]');
const count = document.querySelector('[data-slide-count]');
const slideRange = document.querySelector('[data-slide-range]');
const progress = document.querySelector('[data-progress]');
const dots = document.querySelector('[data-dots]');
const next = document.querySelector('[data-next]');
const iconMarkup = {
    bag: '<svg width="27" height="27" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 8h12l-1 12H7z"/><path d="M9 8a3 3 0 0 1 6 0"/></svg>',
    store: '<svg width="27" height="27" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 9l1.5-5h15L21 9"/><path d="M3 9h18v1.5a3 3 0 0 1-6 0 3 3 0 0 1-6 0 3 3 0 0 1-6 0z"/><path d="M5 13v7h14v-7"/><path d="M10 20v-4h4v4"/></svg>',
    trend: '<svg width="27" height="27" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 17l6-6 4 4 8-8"/><path d="M14 7h7v7"/></svg>',
};
const themeClasses = {
    mint: { background: 'bg-slate-50', button: 'bg-emerald-700', icon: 'text-emerald-700', progress: 'bg-emerald-500' },
    peach: { background: 'bg-slate-50', button: 'bg-emerald-700', icon: 'text-emerald-700', progress: 'bg-emerald-500' },
    blue: { background: 'bg-slate-50', button: 'bg-emerald-700', icon: 'text-emerald-700', progress: 'bg-emerald-500' },
};

function renderSlide() {
    const slide = onboardingSlides[activeSlide];
    const theme = themeClasses[slide.theme];
    shell.className = `relative min-h-screen overflow-hidden transition-colors duration-500 ${theme.background}`;
    image.src = slide.image;
    image.alt = `Foto untuk peran ${slide.eyebrow} di UMatch`;
    eyebrow.textContent = slide.eyebrow;
    icon.innerHTML = iconMarkup[slide.icon];
    icon.className = `flex h-12 w-12 items-center justify-center rounded-2xl bg-white shadow-[0_5px_14px_rgba(15,23,42,0.10)] ring-1 ring-slate-100 ${theme.icon}`;
    title.textContent = slide.title;
    description.textContent = slide.description;
    count.textContent = `${String(activeSlide + 1).padStart(2, '0')} / ${String(onboardingSlides.length).padStart(2, '0')}`;
    slideRange.textContent = `UMatch ${String(activeSlide + 1).padStart(2, '0')}—${String(onboardingSlides.length).padStart(2, '0')}`;
    progress.className = `h-full rounded-full transition-all duration-500 ${theme.progress}`;
    progress.style.width = `${((activeSlide + 1) / onboardingSlides.length) * 100}%`;
    next.textContent = activeSlide === onboardingSlides.length - 1 ? 'Mulai Sekarang' : 'Lanjutkan';
    next.className = `h-12 flex-1 rounded-xl px-5 text-xs font-extrabold text-white shadow-[0_7px_16px_rgba(15,23,42,0.12)] transition duration-200 hover:-translate-y-0.5 hover:brightness-105 focus:outline-none focus:ring-4 focus:ring-white/80 active:translate-y-0 sm:text-sm ${theme.button}`;
    dots.innerHTML = onboardingSlides.map((item, index) => `<button type="button" data-slide-index="${index}" aria-label="Buka slide ${index + 1}: ${item.eyebrow}" aria-current="${index === activeSlide ? 'step' : 'false'}" class="h-2 rounded-full transition-all focus:outline-none focus:ring-2 focus:ring-white ${index === activeSlide ? `w-8 ${theme.button}` : 'w-2 bg-slate-300'}"></button>`).join('');
}

function finishOnboarding() {
    try {
        window.localStorage.setItem('umatch_onboarding_complete', '1');
    } catch (error) {
        // Continue to role selection when browser storage is unavailable.
    }
    window.location.href = @json(route('roles.choose'));
}

document.querySelector('[data-skip]').addEventListener('click', finishOnboarding);
document.querySelector('[data-reset-slide]').addEventListener('click', () => {
    activeSlide = 0;
    renderSlide();
});
dots.addEventListener('click', (event) => {
    const button = event.target instanceof Element ? event.target.closest('[data-slide-index]') : null;
    if (button) {
        activeSlide = Number(button.dataset.slideIndex);
        renderSlide();
    }
});
next.addEventListener('click', () => {
    if (activeSlide === onboardingSlides.length - 1) {
        finishOnboarding();
        return;
    }
    activeSlide++;
    renderSlide();
});
renderSlide();
</script>
@endpush
