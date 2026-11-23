<nav class="space-y-1.5 p-4" aria-label="Navigasi utama">
    @php($items = [['Dashboard','layout-grid','umkm.dashboard'],['Produk','package','umkm.products'],['Pesanan','clipboard','umkm.orders'],['Stok','bar-chart','umkm.stock'],['Keuangan','trending-up','umkm.finance'],['Investor','users','umkm.investors'],['Laporan','file-text','umkm.reports'],['Toko','store','umkm.store']])
    @foreach ($items as [$label, $icon, $route])
        <a href="{{ route($route) }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs($route) ? 'umatch-gradient text-white shadow-sm' : 'text-slate-600 hover:bg-slate-50' }}"><x-icon name="{{ $icon }}" size="18" />{{ $label }}</a>
    @endforeach
</nav>
