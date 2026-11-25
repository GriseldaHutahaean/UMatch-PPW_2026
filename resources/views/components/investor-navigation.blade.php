<nav class="space-y-1.5 p-4" aria-label="Navigasi utama">
    @php($items = [['Dashboard', 'layout-grid'], ['Jelajah UMKM', 'search'], ['Tawaran', 'file-text'], ['Portofolio', 'bar-chart'], ['Return', 'trending-up']])
    @foreach ($items as [$label, $icon])
        @if ($label === 'Dashboard')
            <a href="{{ route('investor.dashboard') }}" class="flex items-center gap-3 rounded-xl bg-emerald-50 px-3 py-2.5 text-sm font-medium text-emerald-700 shadow-sm transition"><x-icon name="{{ $icon }}" size="18" />{{ $label }}</a>
        @else
            <button type="button" data-toast="{{ $label }} akan segera tersedia" class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-left text-sm font-medium text-slate-600 transition hover:bg-slate-50"><x-icon name="{{ $icon }}" size="18" />{{ $label }}</button>
        @endif
    @endforeach
</nav>
