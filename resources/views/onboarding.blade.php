@extends('layouts.auth')

@section('title', 'Kenali UMatch')

@section('content')
@php
    $slides = [
        [
            'theme' => 'mint',
            'image' => 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?auto=format&fit=crop&w=900&q=85',
            'icon' => '🛍️',
            'title' => 'Temukan UMKM Lokal Terbaik',
            'description' => 'Jelajahi ribuan produk dan toko UMKM asli Indonesia. Dari kuliner hingga kerajinan tangan — semuanya ada di sini.',
        ],
        [
            'theme' => 'peach',
            'image' => 'https://images.unsplash.com/photo-1556761175-b413da4baf72?auto=format&fit=crop&w=900&q=85',
            'icon' => '🏪',
            'title' => 'Kelola Usaha Lebih Mudah',
            'description' => 'Catat transaksi, pantau stok, publikasikan ke media sosial sekaligus, dan terima tawaran investor — cukup dari satu aplikasi.',
        ],
        [
            'theme' => 'blue',
            'image' => 'https://images.unsplash.com/photo-1556740749-887f6717d7e4?auto=format&fit=crop&w=900&q=85',
            'icon' => '💼',
            'title' => 'Investasi di UMKM Berpotensi',
            'description' => 'Temukan UMKM lokal dengan potensi tinggi. Lihat pitchdeck, data keuangan, dan kirim tawaran investasi langsung dari aplikasi.',
        ],
    ];
@endphp

<main id="onboarding" class="min-h-screen w-full overflow-x-hidden bg-[#e4f8f7]">
    <section class="min-h-screen w-full overflow-hidden bg-[#e4f8f7]" data-onboarding-shell>
        <header class="flex h-[66px] items-center justify-between border-b border-slate-100 bg-white px-4 sm:px-8 lg:px-12">
            <div class="flex items-center gap-2.5">
                <div class="flex h-8 w-8 items-center justify-center rounded-[10px] border border-slate-200 bg-white shadow-sm"><x-logo size="23" /></div>
                <div class="leading-none"><p class="text-[11px] font-extrabold text-slate-800">UMiKA</p><p class="mt-1 text-[6px] text-slate-400">Aplikasi Manajemen & Digitalisasi UMKM</p></div>
            </div>
            <span class="text-[8px] text-slate-400">Platform UMKM Digital</span>
        </header>

        <div class="relative flex min-h-[calc(100vh-66px)] flex-col px-4 pb-6 pt-3 sm:px-8 lg:px-12" data-onboarding-content>
            <div class="flex items-center justify-between text-[10px] font-medium" data-navigation></div>

            <div class="flex flex-1 flex-col items-center justify-center pb-28 pt-10 sm:pb-32 sm:pt-12 lg:pt-8" data-slide-content>
                <div class="relative mx-auto h-[180px] w-full max-w-[350px] overflow-hidden rounded-[18px] bg-slate-200 shadow-sm sm:h-[205px] lg:h-[min(38vh,420px)] lg:w-[min(72vw,1000px)] lg:max-w-none lg:rounded-[24px]">
                    <img data-slide-image class="h-full w-full object-cover" alt="Ilustrasi UMatch" loading="eager">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent"></div>
                </div>
                <div data-slide-icon class="mx-auto mt-4 flex h-11 w-11 items-center justify-center rounded-xl bg-white text-xl shadow-[0_2px_8px_rgba(0,0,0,.12)]"></div>
                <h1 data-slide-title class="mx-auto mt-4 max-w-[320px] text-center text-[15px] font-extrabold leading-6 text-slate-800 sm:text-base"></h1>
                <p data-slide-description class="mx-auto mt-1.5 max-w-[330px] text-center text-[10px] leading-[1.7] text-slate-500 sm:text-[11px]"></p>
            </div>

            <div class="absolute bottom-6 left-4 right-4 sm:left-8 sm:right-8 lg:left-1/2 lg:right-auto lg:w-[min(90%,680px)] lg:-translate-x-1/2">
                <div class="mb-3 flex justify-center gap-1.5" data-dots></div>
                <button type="button" data-next class="h-11 w-full rounded-xl text-[10px] font-extrabold text-white shadow-lg transition hover:brightness-95 active:scale-[.99] sm:h-12 sm:text-[11px]"></button>
                <a data-guest href="{{ route('roles.choose') }}" class="mt-3 block text-center text-[9px] text-slate-400 underline decoration-slate-300 underline-offset-2">Coba dulu tanpa daftar (Mode Tamu)</a>
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
const title = document.querySelector('[data-slide-title]');
const description = document.querySelector('[data-slide-description]');
const navigation = document.querySelector('[data-navigation]');
const dots = document.querySelector('[data-dots]');
const next = document.querySelector('[data-next]');

const themeClasses = {
    mint: { background: 'bg-[#e4f8f7]', button: 'bg-[#00afa5]', active: 'bg-[#00afa5]', text: 'text-[#00afa5]' },
    peach: { background: 'bg-[#fff1ec]', button: 'bg-[#ff6946]', active: 'bg-[#ff6946]', text: 'text-[#ff6946]' },
    blue: { background: 'bg-[#edf5ff]', button: 'bg-[#205a98]', active: 'bg-[#205a98]', text: 'text-[#205a98]' },
};

function renderSlide() {
    const slide = onboardingSlides[activeSlide];
    const theme = themeClasses[slide.theme];
    shell.className = `min-h-screen w-full overflow-hidden ${theme.background}`;
    content.className = `relative flex min-h-[calc(100vh-66px)] flex-col px-4 pb-6 pt-3 sm:px-8 lg:px-12 ${theme.background}`;
    image.classList.remove('opacity-0');
    image.src = slide.image;
    image.onerror = () => { image.classList.add('opacity-0'); };
    icon.textContent = slide.icon;
    title.textContent = slide.title;
    description.textContent = slide.description;
    navigation.innerHTML = activeSlide === 0
        ? `<span></span><button type="button" data-skip class="text-slate-400 hover:text-slate-600">Lewati</button>`
        : `<button type="button" data-back class="${theme.text}">←&nbsp; Kembali</button><button type="button" data-skip class="text-slate-400 hover:text-slate-600">Lewati</button>`;
    next.textContent = activeSlide === onboardingSlides.length - 1 ? 'Mulai Sekarang →' : 'Lanjut';
    next.className = `h-11 w-full rounded-xl text-[10px] font-extrabold text-white shadow-lg transition hover:brightness-95 active:scale-[.99] sm:h-12 sm:text-[11px] ${theme.button}`;
    dots.innerHTML = onboardingSlides.map((item, index) => `<span class="h-1.5 rounded-full transition-all ${index === activeSlide ? `w-4 ${theme.active}` : 'w-1.5 bg-slate-300/70'}"></span>`).join('');
    document.querySelector('[data-skip]').addEventListener('click', () => { window.location.href = @json(route('roles.choose')); });
    if (document.querySelector('[data-back]')) document.querySelector('[data-back]').addEventListener('click', () => { activeSlide--; renderSlide(); });
}

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
