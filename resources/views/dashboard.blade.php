@extends('layouts.auth')

@section('title', 'Dashboard UMKM — UMatch')

@php
    $navigation = [
        ['label' => 'Dashboard', 'icon' => 'layout-grid'],
        ['label' => 'Produk', 'icon' => 'package'],
        ['label' => 'Pesanan', 'icon' => 'clipboard'],
        ['label' => 'Stok', 'icon' => 'bar-chart'],
        ['label' => 'Keuangan', 'icon' => 'trending-up'],
        ['label' => 'Investor', 'icon' => 'users'],
        ['label' => 'Laporan', 'icon' => 'file-text'],
        ['label' => 'Toko', 'icon' => 'store'],
    ];

    $kpis = [
        ['label' => 'Omzet Bulan Ini', 'value' => 'Rp 10.280.000', 'change' => '+12%', 'icon' => 'trending-up', 'iconClass' => 'bg-[#FFF1EB] text-[#F96332]'],
        ['label' => 'Total Pesanan', 'value' => '147', 'change' => '+8%', 'icon' => 'shopping-bag', 'iconClass' => 'bg-[#E6F7F4] text-[#00A88F]'],
        ['label' => 'Total Pelanggan', 'value' => '312', 'change' => '+15%', 'icon' => 'users', 'iconClass' => 'bg-[#EEF2FF] text-[#6366F1]'],
        ['label' => 'Stok Menipis', 'value' => '3 produk', 'change' => 'Perlu diisi', 'icon' => 'alert-triangle', 'iconClass' => 'bg-[#FEF2F2] text-[#EF4444]'],
    ];

    $chart = [
        ['day' => 'Sen', 'short' => '1.2jt', 'amount' => 'Rp 1.200.000', 'height' => '57%'],
        ['day' => 'Sel', 'short' => '980rb', 'amount' => 'Rp 980.000', 'height' => '47%'],
        ['day' => 'Rab', 'short' => '1.4jt', 'amount' => 'Rp 1.400.000', 'height' => '67%'],
        ['day' => 'Kam', 'short' => '1.1jt', 'amount' => 'Rp 1.100.000', 'height' => '52%'],
        ['day' => 'Jum', 'short' => '1.8jt', 'amount' => 'Rp 1.800.000', 'height' => '86%'],
        ['day' => 'Sab', 'short' => '2.1jt', 'amount' => 'Rp 2.100.000', 'height' => '100%'],
        ['day' => 'Min', 'short' => '1.6jt', 'amount' => 'Rp 1.600.000', 'height' => '76%'],
    ];

    $products = [
        ['name' => 'Arsik Ikan Mas Andaliman', 'detail' => 'Rp 85.000 • 234 terjual', 'progress' => 68, 'bar' => 'bg-[#00A88F]', 'thumbnail' => 'from-amber-200 via-orange-300 to-emerald-700'],
        ['name' => 'Saksang Babi / Ayam Khas Batak', 'detail' => 'Rp 35.000 • 189 terjual', 'progress' => 18, 'bar' => 'bg-[#F59E0B]', 'thumbnail' => 'from-stone-800 via-red-900 to-amber-700'],
        ['name' => 'Naniura Ikan Mas Segar', 'detail' => 'Rp 32.000 • 412 terjual', 'progress' => 35, 'bar' => 'bg-[#00A88F]', 'thumbnail' => 'from-yellow-200 via-orange-300 to-red-500'],
        ['name' => 'Ayam Pinadar Panggang', 'detail' => 'Rp 28.000 • 178 terjual', 'progress' => 40, 'bar' => 'bg-[#F59E0B]', 'thumbnail' => 'from-yellow-200 via-orange-500 to-red-800'],
        ['name' => 'Sambal Tuk-tuk Andaliman', 'detail' => 'Rp 75.000 • 95 terjual', 'progress' => 15, 'bar' => 'bg-[#CBD5E1]', 'thumbnail' => 'from-slate-700 via-red-900 to-stone-950'],
    ];

    $quickActions = [
        ['label' => 'Kelola Produk', 'icon' => 'box', 'iconClass' => 'bg-[#FFF1EB] text-[#F96332]'],
        ['label' => 'Monitor Stok', 'icon' => 'bar-chart', 'iconClass' => 'bg-[#E6F7F4] text-[#00A88F]'],
        ['label' => 'Laporan', 'icon' => 'file-text', 'iconClass' => 'bg-[#EEF2FF] text-[#4F46E5]'],
        ['label' => 'Investor Hub', 'icon' => 'users', 'iconClass' => 'bg-[#ECFDF5] text-[#10B981]'],
    ];
@endphp

@section('content')
<div class="min-h-screen bg-[#FAFAFB] font-[Plus_Jakarta_Sans,ui-sans-serif,sans-serif] text-gray-900">
    <header class="sticky top-0 z-30 h-16 border-b border-gray-100 bg-white">
        <div class="mx-auto flex h-full max-w-[1440px] items-center gap-4 px-4 sm:px-6">
            <button type="button" class="rounded-lg p-2 text-gray-500 hover:bg-gray-50 lg:hidden" data-sidebar-toggle aria-label="Buka navigasi"><x-icon name="menu" size="20" /></button>
            <a href="{{ route('umkm.dashboard') }}" class="flex shrink-0 items-center gap-2"><x-logo size="28" /><span class="text-base font-extrabold tracking-tight text-gray-900">UMatch</span><span class="rounded-full bg-[#F96332] px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider text-white">UMKM</span></a>
            <div class="relative ml-2 hidden w-80 md:block lg:w-96"><x-icon name="search" size="17" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400" /><input type="search" placeholder="Cari produk, UMKM, atau investasi..." class="w-full rounded-full border border-gray-200 bg-[#F8FAFC] py-2 pl-11 pr-4 text-xs text-gray-700 outline-none transition placeholder:text-gray-400 focus:border-[#FDBA74] focus:ring-2 focus:ring-orange-100"></div>
            <div class="ml-auto flex items-center gap-2 sm:gap-3"><button type="button" class="relative flex h-10 w-10 items-center justify-center rounded-full border border-gray-200 text-gray-500 transition hover:bg-gray-50" data-toast="Tidak ada notifikasi baru" aria-label="Notifikasi"><x-icon name="bell" size="18" /><span class="absolute right-2 top-2 h-1.5 w-1.5 rounded-full bg-[#F96332]"></span></button><div class="relative"><button type="button" class="flex items-center gap-2 rounded-full border border-[#FDBA74] bg-[#FFF7ED] px-3 py-1.5 text-xs font-bold text-[#F96332] transition hover:bg-orange-100" data-role-menu-toggle aria-expanded="false"><span class="flex h-5 w-5 items-center justify-center rounded-full bg-emerald-700 text-[9px] text-white">D</span>UMKM<x-icon name="chevron-down" size="14" /></button><div class="absolute right-0 top-12 hidden w-52 rounded-xl border border-gray-100 bg-white p-1.5 shadow-xl" data-role-menu><p class="px-3 pb-1.5 pt-2 text-[10px] font-bold uppercase tracking-wider text-gray-400">Ganti Role</p>@foreach (config('umatch.roles') as $roleKey => $availableRole)<form action="{{ route('roles.select') }}" method="POST">@csrf<input type="hidden" name="role" value="{{ $roleKey }}"><button type="submit" class="flex w-full items-center justify-between rounded-lg px-3 py-2 text-left text-xs font-medium text-gray-700 hover:bg-orange-50 hover:text-[#F96332]"><span>{{ $availableRole['label'] }}</span>@if ($roleKey === 'umkm')<span class="text-[10px] font-bold text-[#F96332]">Aktif</span>@endif</button></form>@endforeach</div></div><div class="relative"><button type="button" class="flex h-9 w-9 items-center justify-center rounded-full bg-[#F96332] text-sm font-semibold text-white transition hover:ring-4 hover:ring-orange-100" data-profile-menu-toggle aria-expanded="false" aria-label="Buka profil">B</button><div class="absolute right-0 top-12 hidden w-60 rounded-xl border border-gray-100 bg-white p-2 shadow-xl" data-profile-menu><div class="rounded-lg bg-orange-50 px-3 py-3"><p class="text-sm font-bold text-gray-900">{{ auth()->user()->nama }}</p><p class="mt-0.5 truncate text-xs text-gray-500">{{ auth()->user()->email }}</p><p class="mt-2 text-[10px] font-bold uppercase tracking-wider text-[#F96332]">Profil UMKM</p></div><button type="button" data-toast="Profil kamu sedang aktif" class="mt-1.5 block w-full rounded-lg px-3 py-2 text-left text-xs font-medium text-gray-700 hover:bg-gray-50">Profil Saya</button><form action="{{ route('logout') }}" method="POST" class="mt-1.5 border-t border-gray-100 pt-1.5">@csrf<button type="submit" class="block w-full rounded-lg px-3 py-2 text-left text-xs font-medium text-red-600 hover:bg-red-50">Keluar</button></form></div></div></div>
        </div>
    </header>

    <div class="mx-auto flex max-w-[1440px]">
        <aside class="fixed inset-y-16 left-0 z-20 hidden w-60 border-r border-gray-100 bg-white lg:block"><nav class="space-y-1.5 p-4" aria-label="Navigasi utama">@foreach ($navigation as $item)<button type="button" data-nav-item="{{ $item['label'] }}" class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-left text-sm font-medium transition {{ $loop->first ? 'bg-[#F96332] text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50' }}"><x-icon name="{{ $item['icon'] }}" size="18" />{{ $item['label'] }}</button>@endforeach</nav></aside>
        <div class="fixed inset-0 z-10 hidden bg-gray-900/20 lg:hidden" data-sidebar-backdrop></div>
        <aside class="fixed inset-y-16 left-0 z-20 hidden w-60 border-r border-gray-100 bg-white lg:hidden" data-mobile-sidebar><nav class="space-y-1.5 p-4" aria-label="Navigasi mobile">@foreach ($navigation as $item)<button type="button" data-nav-item="{{ $item['label'] }}" class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-left text-sm font-medium transition {{ $loop->first ? 'bg-[#F96332] text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50' }}"><x-icon name="{{ $item['icon'] }}" size="18" />{{ $item['label'] }}</button>@endforeach</nav></aside>

        <main class="w-full px-4 py-6 sm:px-6 md:p-8 lg:ml-60"><div class="mx-auto max-w-7xl space-y-7">
            <section class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"><div><h1 class="text-2xl font-bold tracking-tight text-gray-900">Dashboard UMKM</h1><p class="mt-0.5 text-sm text-gray-400">Dapur Batak <span aria-hidden="true">•</span> Senin, 26 Sep 2026</p></div><button type="button" data-product-modal-open class="inline-flex w-fit items-center gap-2 rounded-xl bg-[#F96332] px-5 py-2.5 text-sm font-medium text-white shadow-sm transition hover:-translate-y-0.5 hover:bg-[#EA580C]"><x-icon name="plus" size="17" />Tambah Produk</button></section>

            <section class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4" aria-label="Ringkasan performa">@foreach ($kpis as $kpi)<article class="flex min-h-40 flex-col rounded-2xl border border-[#F1F5F9] bg-white p-5 shadow-[0_2px_10px_rgba(0,0,0,0.03)]"><div class="flex items-start justify-between"><span class="flex h-9 w-9 items-center justify-center rounded-xl {{ $kpi['iconClass'] }}"><x-icon name="{{ $kpi['icon'] }}" size="18" /></span><span class="rounded-full bg-[#ECFDF5] px-2.5 py-0.5 text-xs font-semibold text-[#10B981]">{{ $kpi['change'] }}</span></div><p class="mt-auto pt-5 text-2xl font-extrabold tracking-tight text-gray-900">{{ $kpi['value'] }}</p><p class="mt-1 text-xs text-gray-400">{{ $kpi['label'] }}</p></article>@endforeach</section>

            <section class="rounded-2xl border border-[#F1F5F9] bg-white p-5 shadow-[0_2px_10px_rgba(0,0,0,0.03)] sm:p-6"><div class="flex items-center justify-between"><div><h2 class="text-base font-bold text-gray-900">Omzet Mingguan</h2><p class="mt-1 text-xs text-gray-400">Performa penjualan selama 7 hari terakhir</p></div><span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-600">Minggu ini</span></div><div class="mt-7 flex gap-3 sm:gap-5"><div class="flex h-44 shrink-0 flex-col justify-between pb-6 text-[11px] text-gray-400"><span>2.1jt</span><span>1.5jt</span><span>980rb</span></div><div class="flex min-w-0 flex-1 items-end gap-2 border-b border-gray-100 sm:gap-4">@foreach ($chart as $bar)<div class="group relative flex h-44 min-w-0 flex-1 flex-col justify-end text-center"><span class="mb-1 text-[10px] font-bold text-[#00A88F] sm:text-[11px]">{{ $bar['short'] }}</span><div class="relative h-32 flex items-end"><div class="w-full rounded-t-lg bg-[#00A88F] transition-all group-hover:bg-[#008F7A]" style="height: {{ $bar['height'] }}" title="{{ $bar['amount'] }}"></div><span class="pointer-events-none absolute bottom-2 left-1/2 hidden -translate-x-1/2 -translate-y-full whitespace-nowrap rounded-lg bg-gray-900 px-2 py-1 text-[10px] font-medium text-white shadow-lg group-hover:block">{{ $bar['amount'] }}</span></div><span class="mt-2 text-[10px] text-gray-400 sm:text-xs">{{ $bar['day'] }}</span></div>@endforeach</div></div></section>

            <section class="rounded-2xl border border-[#F1F5F9] bg-white p-5 shadow-[0_2px_10px_rgba(0,0,0,0.03)] sm:p-6"><div class="flex items-center justify-between"><div><h2 class="text-base font-bold text-gray-900">Produk Terlaris</h2><p class="mt-1 text-xs text-gray-400">Produk dengan penjualan tertinggi</p></div><button type="button" class="text-xs font-semibold text-[#F96332] hover:underline" data-toast="Menampilkan semua produk">Lihat Semua</button></div><div class="mt-6 space-y-4">@foreach ($products as $index => $product)<div class="grid grid-cols-[24px_44px_minmax(0,1fr)] items-center gap-3 rounded-xl px-2 py-2 transition hover:bg-gray-50 sm:grid-cols-[24px_44px_minmax(170px,1.4fr)_minmax(160px,2fr)] sm:gap-4"><span class="flex h-4 w-4 items-center justify-center rounded-full text-[9px] font-bold {{ $index < 3 ? 'bg-[#F96332] text-white' : 'bg-gray-200 text-gray-600' }}">{{ $index + 1 }}</span><span class="flex h-11 w-11 items-center justify-center overflow-hidden rounded-xl bg-gradient-to-br {{ $product['thumbnail'] }} text-lg shadow-inner">🍲</span><div class="min-w-0"><p class="truncate text-sm font-semibold text-gray-900">{{ $product['name'] }}</p><p class="mt-1 text-xs text-gray-400">{{ $product['detail'] }}</p></div><div class="col-span-3 ml-[68px] h-1.5 overflow-hidden rounded-full bg-gray-100 sm:col-span-1 sm:ml-0"><div class="h-full rounded-full {{ $product['bar'] }}" style="width: {{ $product['progress'] }}%"></div></div></div>@endforeach</div></section>

            <section class="rounded-2xl border border-[#F1F5F9] bg-white p-5 shadow-[0_2px_10px_rgba(0,0,0,0.03)] sm:p-6"><div class="mb-5"><h2 class="text-base font-bold text-gray-900">Aksi Cepat</h2><p class="mt-1 text-xs text-gray-400">Akses fitur yang paling sering digunakan</p></div><div class="grid grid-cols-2 gap-3 md:grid-cols-4">@foreach ($quickActions as $action)<button type="button" data-toast="Membuka {{ $action['label'] }}" class="flex min-h-28 flex-col items-center justify-center gap-3 rounded-2xl border border-gray-100 p-4 text-center transition hover:-translate-y-0.5 hover:border-orange-200 hover:bg-orange-50/40 hover:shadow-sm"><span class="flex h-10 w-10 items-center justify-center rounded-xl {{ $action['iconClass'] }}"><x-icon name="{{ $action['icon'] }}" size="18" /></span><span class="text-xs font-medium text-gray-700">{{ $action['label'] }}</span></button>@endforeach</div></section>
        </div></main>
    </div>
</div>

<div class="fixed inset-0 z-50 hidden items-center justify-center bg-gray-900/30 px-4" data-product-modal><div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl" role="dialog" aria-modal="true" aria-labelledby="product-modal-title"><div class="flex items-start justify-between"><div><h2 id="product-modal-title" class="text-lg font-bold text-gray-900">Tambah Produk</h2><p class="mt-1 text-sm text-gray-400">Preview formulir produk baru.</p></div><button type="button" data-product-modal-close class="rounded-lg p-2 text-gray-400 hover:bg-gray-50 hover:text-gray-700" aria-label="Tutup"><x-icon name="x" size="18" /></button></div><div class="mt-5 space-y-4"><label class="block"><span class="text-xs font-semibold text-gray-600">Nama produk</span><input type="text" placeholder="Contoh: Arsik Ikan Mas" class="mt-1.5 w-full rounded-xl border border-gray-200 px-3 py-2.5 text-sm outline-none focus:border-[#F96332] focus:ring-2 focus:ring-orange-100"></label><label class="block"><span class="text-xs font-semibold text-gray-600">Harga</span><input type="text" placeholder="Rp 0" class="mt-1.5 w-full rounded-xl border border-gray-200 px-3 py-2.5 text-sm outline-none focus:border-[#F96332] focus:ring-2 focus:ring-orange-100"></label></div><button type="button" data-product-modal-close class="mt-6 w-full rounded-xl bg-[#F96332] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#EA580C]">Simpan Produk</button></div></div>
<div class="fixed bottom-5 right-5 z-[60] hidden max-w-xs rounded-xl bg-gray-900 px-4 py-3 text-sm font-medium text-white shadow-xl" data-toast-message></div>
@endsection

@push('scripts')
<script>
const toastMessage = document.querySelector('[data-toast-message]');
let toastTimer;
function showToast(message) { toastMessage.textContent = message; toastMessage.classList.remove('hidden'); clearTimeout(toastTimer); toastTimer = setTimeout(() => toastMessage.classList.add('hidden'), 2600); }
document.querySelectorAll('[data-toast]').forEach((element) => element.addEventListener('click', () => showToast(element.dataset.toast)));

const roleMenuToggle = document.querySelector('[data-role-menu-toggle]');
const roleMenu = document.querySelector('[data-role-menu]');
const profileMenuToggle = document.querySelector('[data-profile-menu-toggle]');
const profileMenu = document.querySelector('[data-profile-menu]');
roleMenuToggle.addEventListener('click', () => {
    const isOpen = !roleMenu.classList.contains('hidden');
    roleMenu.classList.toggle('hidden', isOpen);
    roleMenuToggle.setAttribute('aria-expanded', String(!isOpen));
    profileMenu.classList.add('hidden');
    profileMenuToggle.setAttribute('aria-expanded', 'false');
});
profileMenuToggle.addEventListener('click', () => {
    const isOpen = !profileMenu.classList.contains('hidden');
    profileMenu.classList.toggle('hidden', isOpen);
    profileMenuToggle.setAttribute('aria-expanded', String(!isOpen));
    roleMenu.classList.add('hidden');
    roleMenuToggle.setAttribute('aria-expanded', 'false');
});
document.addEventListener('click', (event) => {
    if (!roleMenu.contains(event.target) && !roleMenuToggle.contains(event.target)) {
        roleMenu.classList.add('hidden');
        roleMenuToggle.setAttribute('aria-expanded', 'false');
    }
    if (!profileMenu.contains(event.target) && !profileMenuToggle.contains(event.target)) {
        profileMenu.classList.add('hidden');
        profileMenuToggle.setAttribute('aria-expanded', 'false');
    }
});

const productModal = document.querySelector('[data-product-modal]');
document.querySelector('[data-product-modal-open]').addEventListener('click', () => { productModal.classList.remove('hidden'); productModal.classList.add('flex'); });
document.querySelectorAll('[data-product-modal-close]').forEach((button) => button.addEventListener('click', () => { productModal.classList.add('hidden'); productModal.classList.remove('flex'); if (button.textContent.trim() === 'Simpan Produk') showToast('Produk siap ditambahkan dari halaman Produk'); }));
productModal.addEventListener('click', (event) => { if (event.target === productModal) { productModal.classList.add('hidden'); productModal.classList.remove('flex'); } });

function activateNavigation(clickedItem) { document.querySelectorAll('[data-nav-item]').forEach((item) => { const active = item.dataset.navItem === clickedItem.dataset.navItem; item.classList.toggle('bg-[#F96332]', active); item.classList.toggle('text-white', active); item.classList.toggle('shadow-sm', active); item.classList.toggle('text-gray-600', !active); }); if (clickedItem.dataset.navItem !== 'Dashboard') showToast(`${clickedItem.dataset.navItem} akan segera tersedia`); }
document.querySelectorAll('[data-nav-item]').forEach((item) => item.addEventListener('click', () => activateNavigation(item)));

const mobileSidebar = document.querySelector('[data-mobile-sidebar]');
const sidebarBackdrop = document.querySelector('[data-sidebar-backdrop]');
function toggleMobileSidebar(open) { mobileSidebar.classList.toggle('hidden', !open); sidebarBackdrop.classList.toggle('hidden', !open); }
document.querySelector('[data-sidebar-toggle]').addEventListener('click', () => toggleMobileSidebar(true));
sidebarBackdrop.addEventListener('click', () => toggleMobileSidebar(false));
</script>
@endpush
