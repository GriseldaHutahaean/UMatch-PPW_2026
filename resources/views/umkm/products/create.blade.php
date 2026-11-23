@extends('layouts.umkm')

@section('title', 'Tambah Produk — UMatch')

@section('content')
<div class="mx-auto max-w-2xl space-y-5">
    <div class="flex items-start gap-3">
        <a href="{{ route('umkm.products') }}" class="mt-1 rounded-lg p-1 text-slate-500 hover:bg-slate-100" aria-label="Kembali"><x-icon name="arrow-left" size="20" /></a>
        <div><h1 class="text-2xl font-extrabold tracking-tight">Tambah Produk</h1><p class="mt-1 text-sm text-slate-400">Masukkan biaya produksi untuk mendapatkan rekomendasi harga jual.</p></div>
    </div>

    @if ($errors->any())
        <div class="rounded-xl border border-red-100 bg-red-50 p-4 text-sm text-red-600">Periksa kembali data produk yang diisi.</div>
    @endif

    <form method="POST" action="{{ route('umkm.products.store') }}" class="space-y-5 rounded-2xl border border-slate-100 bg-white p-5 shadow-sm sm:p-7" data-price-form>
        @csrf
        <div><label class="text-xs font-semibold text-slate-600">Nama Produk</label><input name="nama_produk" value="{{ old('nama_produk') }}" required placeholder="Contoh: Sambal Andaliman Asli" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-orange-300 focus:ring-2 focus:ring-orange-100"></div>
        <div><label class="text-xs font-semibold text-slate-600">Kategori</label><select name="category_id" required class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none focus:border-orange-300">@forelse($categories as $category)<option value="{{ $category->category_id }}">{{ $category->nama_kategori }}</option>@empty<option disabled selected>Belum ada kategori</option>@endforelse</select></div>
        <div class="grid gap-4 sm:grid-cols-2"><div><label class="text-xs font-semibold text-slate-600">Biaya Produksi / Unit (Rp)</label><input name="biaya_produksi_per_unit" value="{{ old('biaya_produksi_per_unit') }}" required min="0" step="100" type="number" data-cost class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-orange-300"></div><div><label class="text-xs font-semibold text-slate-600">Target Keuntungan (%)</label><input name="target_margin" value="{{ old('target_margin', 30) }}" required min="0" max="500" step="1" type="number" data-margin class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-orange-300"></div></div>
        <div class="rounded-xl border border-orange-100 bg-orange-50 p-4"><p class="text-xs font-bold text-orange-700">Rekomendasi harga jual</p><p class="mt-1 text-2xl font-extrabold text-[#FF7043]" data-suggested-price>Rp 0</p><p class="mt-1 text-[11px] text-orange-700/70">Biaya produksi + target keuntungan, dibulatkan ke Rp1.000 terdekat.</p></div>
        <div class="grid gap-4 sm:grid-cols-2"><div><label class="text-xs font-semibold text-slate-600">Harga Jual (opsional)</label><input name="harga" value="{{ old('harga') }}" min="0" step="100" type="number" placeholder="Kosongkan untuk memakai rekomendasi" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-orange-300"></div><div><label class="text-xs font-semibold text-slate-600">Stok Awal</label><input name="jumlah_stok" value="{{ old('jumlah_stok', 0) }}" required min="0" type="number" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-orange-300"></div></div>
        <div><label class="text-xs font-semibold text-slate-600">Batas Minimum Stok</label><input name="batas_minimum" value="{{ old('batas_minimum', 5) }}" required min="0" type="number" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-orange-300"></div>
        <div><label class="text-xs font-semibold text-slate-600">Deskripsi</label><textarea name="deskripsi" rows="3" placeholder="Deskripsi produk..." class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-orange-300">{{ old('deskripsi') }}</textarea></div>
        <button type="submit" class="w-full rounded-xl bg-[#FF7043] px-5 py-3 text-sm font-bold text-white shadow-sm hover:bg-orange-600">Simpan Produk</button>
    </form>
</div>
<script>
const priceForm = document.querySelector('[data-price-form]');
const formatRupiah = (value) => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(value);
const updateSuggestedPrice = () => {
    const cost = Number(priceForm.querySelector('[data-cost]').value || 0);
    const margin = Number(priceForm.querySelector('[data-margin]').value || 0);
    const suggested = Math.ceil((cost * (1 + margin / 100)) / 1000) * 1000;
    priceForm.querySelector('[data-suggested-price]').textContent = formatRupiah(suggested);
};
priceForm?.querySelectorAll('[data-cost], [data-margin]').forEach((field) => field.addEventListener('input', updateSuggestedPrice));
updateSuggestedPrice();
</script>
@endsection
