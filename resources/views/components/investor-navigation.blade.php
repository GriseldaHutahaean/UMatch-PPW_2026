<nav class="space-y-1.5 p-4" aria-label="Navigasi utama">
    @php($items = [['Dashboard', 'layout-grid', 'investor.dashboard'], ['Jelajah UMKM', 'search', 'investor.explore'], ['Tawaran', 'file-text', null], ['Portofolio', 'bar-chart', null], ['Return', 'trending-up', null]])
    @foreach ($items as [$label, $icon, $route])
        @if ($route)
            <a href="{{ route($route) }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs($route) ? 'bg-[#2563EB] text-white shadow-sm' : 'text-slate-600 hover:bg-slate-50' }}"><x-icon name="{{ $icon }}" size="18" />{{ $label }}</a>
        @else
            <button type="button" data-toast="{{ $label }} akan segera tersedia" class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-left text-sm font-medium text-slate-600 transition hover:bg-slate-50"><x-icon name="{{ $icon }}" size="18" />{{ $label }}</button>
        @endif
    @endforeach
</nav>
