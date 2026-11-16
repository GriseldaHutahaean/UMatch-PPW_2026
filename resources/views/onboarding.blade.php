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

<main id="onboarding" class="min-h-screen w-full overflow-hidden bg-slate-50">
    <section class="relative min-h-screen overflow-hidden transition-colors duration-500" data-onboarding-shell>
        <div class="absolute -right-40 -top-40 h-96 w-96 rounded-full bg-white/60 blur-3xl"></div>
        <header class="relative z-10 flex h-20 items-center justify-between border-b border-white/70 bg-white/70 px-6 backdrop-blur-xl sm:px-10 lg:px-16">
            <a href="{{ route('landing') }}" class="flex items-center gap-3">
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white shadow-sm ring-1 ring-slate-200"><x-logo size="28" /></span>
                <span><span class="block text-base font-extrabold tracking-tight text-slate-900">UMatch</span><span class="block text-[10px] font-medium text-slate-400">Satu ekosistem, banyak peluang</span></span>
            </a>
            <span class="hidden rounded-full border border-slate-200 bg-white/70 px-4 py-2 text-xs font-semibold text-slate-500 sm:inline-flex">Kenali platform kami</span>
        </header>

        <div class="relative z-10 mx-auto flex min-h-[calc(100vh-5rem)] max-w-7xl flex-col justify-center gap-10 px-6 py-10 sm:px-10 lg:grid lg:grid-cols-[1.15fr_.85fr] lg:items-center lg:gap-20 lg:px-16 lg:py-16" data-onboarding-content>
            <div class="relative order-2 lg:order-1">
                <div class="absolute -inset-4 rounded-[2.5rem] bg-white/50 blur-xl"></div>
                <div class="relative h-[280px] overflow-hidden rounded-[2rem] bg-slate-200 shadow-2xl shadow-slate-900/10 sm:h-[390px] lg:h-[min(65vh,610px)]">
                    <img data-slide-image class="h-full w-full object-cover transition duration-500" alt="Ilustrasi UMatch" loading="eager">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/50 via-transparent to-slate-950/10"></div>
                    <div class="absolute bottom-6 left-6 right-6 flex items-end justify-between text-white sm:bottom-8 sm:left-8 sm:right-8">
                        <span data-slide-eyebrow class="rounded-full border border-white/30 bg-white/15 px-4 py-2 text-xs font-bold backdrop-blur-md"></span>
                        <span class="text-xs font-semibold text-white/70">UMatch 01—03</span>
                    </div>
                </div>
            </div>

            <div class="order-1 flex flex-col items-center text-center lg:order-2 lg:items-start lg:text-left">
                <div data-slide-icon class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white shadow-lg ring-1 ring-slate-200"></div>
                <p class="mt-7 text-xs font-extrabold uppercase tracking-[0.3em] text-slate-400">Satu akun untuk banyak kemungkinan</p>
                <h1 data-slide-title class="mt-4 max-w-xl text-4xl font-extrabold leading-[1.08] tracking-tight text-slate-900 sm:text-5xl lg:text-6xl"></h1>
                <p data-slide-description class="mt-6 max-w-lg text-sm leading-7 text-slate-500 sm:text-base"></p>

                <div class="mt-9 w-full max-w-lg">
                    <div class="mb-4 flex items-center justify-between text-xs font-bold text-slate-400"><span data-slide-count>01 / 03</span><span>Mulai perjalananmu</span></div>
                    <div class="h-1.5 overflow-hidden rounded-full bg-white/80"><div data-progress class="h-full rounded-full transition-all duration-500"></div></div>
                </div>

                <div class="mt-8 flex w-full max-w-lg flex-col gap-4 sm:flex-row sm:items-center">
                    <button type="button" data-next class="h-14 flex-1 rounded-2xl px-6 text-sm font-extrabold text-white shadow-lg transition hover:-translate-y-0.5 hover:brightness-105 active:translate-y-0"></button>
                    <button type="button" data-skip class="rounded-2xl px-5 py-3 text-sm font-bold text-slate-400 transition hover:bg-white/70 hover:text-slate-700">Lewati</button>
                </div>
                <div class="mt-7 flex gap-2" data-dots aria-label="Progress onboarding"></div>
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
const content = document.querySelector('[data-onboarding-content]');
const image = document.querySelector('[data-slide-image]');
const icon = document.querySelector('[data-slide-icon]');
const eyebrow = document.querySelector('[data-slide-eyebrow]');
const title = document.querySelector('[data-slide-title]');
const description = document.querySelector('[data-slide-description]');
const count = document.querySelector('[data-slide-count]');
const progress = document.querySelector('[data-progress]');
const dots = document.querySelector('[data-dots]');
const next = document.querySelector('[data-next]');
const iconMarkup = {
    bag: '<svg width="27" height="27" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 8h12l-1 12H7z"/><path d="M9 8a3 3 0 0 1 6 0"/></svg>',
    store: '<svg width="27" height="27" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 9l1.5-5h15L21 9"/><path d="M3 9h18v1.5a3 3 0 0 1-6 0 3 3 0 0 1-6 0 3 3 0 0 1-6 0z"/><path d="M5 13v7h14v-7"/><path d="M10 20v-4h4v4"/></svg>',
    trend: '<svg width="27" height="27" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 17l6-6 4 4 8-8"/><path d="M14 7h7v7"/></svg>',
};
const themeClasses = {
    mint: { background: 'bg-[#e9faf7]', button: 'bg-[#00a99d]', text: 'text-[#00a99d]', icon: 'text-[#00a99d]', progress: 'bg-[#00a99d]' },
    peach: { background: 'bg-[#fff3ee]', button: 'bg-[#ff6946]', text: 'text-[#ff6946]', icon: 'text-[#ff6946]', progress: 'bg-[#ff6946]' },
    blue: { background: 'bg-[#eef5ff]', button: 'bg-[#205a98]', text: 'text-[#205a98]', icon: 'text-[#205a98]', progress: 'bg-[#205a98]' },
};

function renderSlide() {
    const slide = onboardingSlides[activeSlide];
    const theme = themeClasses[slide.theme];
    shell.className = `relative min-h-screen overflow-hidden transition-colors duration-500 ${theme.background}`;
    image.src = slide.image;
    eyebrow.textContent = slide.eyebrow;
    icon.innerHTML = iconMarkup[slide.icon];
    icon.className = `flex h-14 w-14 items-center justify-center rounded-2xl bg-white shadow-lg ring-1 ring-slate-200 ${theme.icon}`;
    title.textContent = slide.title;
    description.textContent = slide.description;
    count.textContent = `${String(activeSlide + 1).padStart(2, '0')} / ${String(onboardingSlides.length).padStart(2, '0')}`;
    progress.className = `h-full rounded-full transition-all duration-500 ${theme.progress}`;
    progress.style.width = `${((activeSlide + 1) / onboardingSlides.length) * 100}%`;
    next.textContent = activeSlide === onboardingSlides.length - 1 ? 'Mulai Sekarang' : 'Lanjutkan';
    next.className = `h-14 flex-1 rounded-2xl px-6 text-sm font-extrabold text-white shadow-lg transition hover:-translate-y-0.5 hover:brightness-105 active:translate-y-0 ${theme.button}`;
    dots.innerHTML = onboardingSlides.map((item, index) => `<span class="h-2 rounded-full transition-all ${index === activeSlide ? `w-8 ${theme.button}` : 'w-2 bg-slate-300'}"></span>`).join('');
}

document.querySelector('[data-skip]').addEventListener('click', () => { window.location.href = @json(route('roles.choose')); });
next.addEventListener('click', () => {
    if (activeSlide === onboardingSlides.length - 1) {
        window.location.href = @json(route('roles.choose'));
        return;
    }
    activeSlide++;
    renderSlide();
});
renderSlide();
</script>
@endpush
