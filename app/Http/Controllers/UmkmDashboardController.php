<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class UmkmDashboardController extends Controller
{
    public function createProduct(): View
    {
        foreach (['Makanan', 'Snack', 'Minuman'] as $categoryName) {
            ProductCategory::firstOrCreate(['nama_kategori' => $categoryName]);
        }

        return view('umkm.products.create', ['categories' => ProductCategory::query()->orderBy('nama_kategori')->get()]);
    }

    public function storeProduct(StoreProductRequest $request): RedirectResponse
    {
        $profile = Auth::user()->umkmProfile;
        abort_unless($profile, 403, 'Profil UMKM belum tersedia.');

        $cost = (float) $request->validated('biaya_produksi_per_unit');
        $margin = (float) $request->validated('target_margin');
        $suggestedPrice = ceil(($cost * (1 + ($margin / 100))) / 1000) * 1000;
        $salePrice = (float) ($request->validated('harga') ?: $suggestedPrice);

        Product::create([
            ...$request->safe()->except('harga'),
            'umkm_profile_id' => $profile->umkm_profile_id,
            'harga' => $salePrice,
            'status_produk' => 'aktif',
            'status_moderasi' => 'menunggu',
        ]);

        return redirect()->route('umkm.products')->with('success', 'Produk berhasil disimpan. Rekomendasi harga: Rp '.number_format($suggestedPrice, 0, ',', '.').'.');
    }

    public function products(): View
    {
        $profile = Auth::user()->umkmProfile;
        if ($profile && $profile->products()->exists()) {
            $products = $profile->products()->with('category')->get()->map(fn (Product $product): array => [
                'name' => $product->nama_produk,
                'category' => $product->category?->nama_kategori ?? 'Lainnya',
                'price' => 'Rp '.number_format((float) $product->harga, 0, ',', '.'),
                'stock' => $product->jumlah_stok,
                'max' => max($product->jumlah_stok, 1),
                'status' => $product->jumlah_stok === 0 ? 'Stok Habis' : ($product->jumlah_stok <= $product->batas_minimum ? 'Stok Menipis' : 'Stok Tersedia'),
            ])->all();

            return view('umkm.management', ['page' => 'products', 'title' => 'Kelola Produk', 'subtitle' => count($products).' produk terdaftar • stok diperbarui secara real-time', 'products' => $products]);
        }

        return view('umkm.management', ['page' => 'products', 'title' => 'Kelola Produk', 'subtitle' => '20 produk terdaftar • stok diperbarui secara real-time', 'products' => [
            ['name' => 'Naniura Khas Toba', 'category' => 'Makanan', 'price' => 'Rp 85.000', 'stock' => 32, 'max' => 50, 'status' => 'Stok Tersedia'], ['name' => 'Mie Gomak Medan', 'category' => 'Makanan', 'price' => 'Rp 35.000', 'stock' => 8, 'max' => 50, 'status' => 'Stok Tersedia'], ['name' => 'Sambal Andaliman Asli', 'category' => 'Makanan', 'price' => 'Rp 32.000', 'stock' => 20, 'max' => 60, 'status' => 'Stok Tersedia'], ['name' => 'Teri Sambal Balado', 'category' => 'Makanan', 'price' => 'Rp 28.000', 'stock' => 15, 'max' => 40, 'status' => 'Stok Tersedia'], ['name' => 'Ayam Napinadar Rempah', 'category' => 'Makanan', 'price' => 'Rp 75.000', 'stock' => 0, 'max' => 30, 'status' => 'Stok Habis'], ['name' => 'Ombus Ombus', 'category' => 'Snack', 'price' => 'Rp 15.000', 'stock' => 40, 'max' => 80, 'status' => 'Stok Tersedia'], ['name' => 'Lappet', 'category' => 'Snack', 'price' => 'Rp 18.000', 'stock' => 3, 'max' => 50, 'status' => 'Stok Menipis'],
        ]]);
    }

    public function orders(): View
    {
        return view('umkm.management', ['page' => 'orders', 'title' => 'Pesanan Masuk', 'subtitle' => '5 pesanan perlu dipantau', 'orders' => [
            ['product' => 'Naniura Khas Toba', 'customer' => 'Siti Rahayu', 'qty' => 2, 'date' => '26 Sep 2026', 'total' => 'Rp 170.000', 'status' => 'Dikirim'], ['product' => 'Sambal Andaliman Asli', 'customer' => 'Budi Santoso', 'qty' => 3, 'date' => '25 Sep 2026', 'total' => 'Rp 96.000', 'status' => 'Diproses'], ['product' => 'Mie Gomak Medan', 'customer' => 'Dewi Lestari', 'qty' => 1, 'date' => '25 Sep 2026', 'total' => 'Rp 35.000', 'status' => 'Menunggu'], ['product' => 'Ombus Ombus', 'customer' => 'Ahmad Susilo', 'qty' => 5, 'date' => '24 Sep 2026', 'total' => 'Rp 75.000', 'status' => 'Selesai'], ['product' => 'Ayam Napinadar', 'customer' => 'Rizal Fauzi', 'qty' => 2, 'date' => '23 Sep 2026', 'total' => 'Rp 150.000', 'status' => 'Dibatalkan'],
        ]]);
    }

    public function stock(): View
    {
        return view('umkm.management', ['page' => 'stock', 'title' => 'Monitor Stok', 'subtitle' => '1 habis • 2 menipis', 'stockItems' => [
            ['name' => 'Ayam Napinadar Rempah', 'stock' => 0, 'max' => 30, 'state' => 'empty'], ['name' => 'Lappet', 'stock' => 3, 'max' => 50, 'state' => 'low'], ['name' => 'Ukiran Kayu', 'stock' => 5, 'max' => 15, 'state' => 'low'], ['name' => 'Naniura Khas Toba', 'stock' => 32, 'max' => 50, 'state' => 'safe'], ['name' => 'Mie Gomak Medan', 'stock' => 8, 'max' => 50, 'state' => 'safe'], ['name' => 'Sambal Andaliman Asli', 'stock' => 20, 'max' => 60, 'state' => 'safe'], ['name' => 'Ombus Ombus', 'stock' => 40, 'max' => 80, 'state' => 'safe'], ['name' => 'Stik Keju Andaliman', 'stock' => 24, 'max' => 60, 'state' => 'safe'],
        ]]);
    }

    public function finance(): View
    {
        $transactions = Auth::user()->umkmProfile?->financialTransactions()->get() ?? collect();
        $income = (float) $transactions->where('jenis', 'pemasukan')->sum('nominal');
        $expense = (float) $transactions->where('jenis', 'pengeluaran')->sum('nominal');

        return view('umkm.management', ['page' => 'finance', 'title' => 'Keuangan', 'subtitle' => 'Catatan kas usaha kamu', 'income' => $income, 'expense' => $expense, 'balance' => $income - $expense]);
    }

    public function investors(): View
    {
        return view('umkm.management', ['page' => 'investors', 'title' => 'Investor Hub', 'subtitle' => '2 penawaran masuk', 'investors' => [
            ['name' => 'Pak Ahmad Susilo', 'location' => 'Jakarta', 'date' => '20 Sep 2026', 'amount' => 'Rp 50 juta', 'equity' => '15% ekuitas'], ['name' => 'Ibu Dewi Hartono', 'location' => 'Surabaya', 'date' => '22 Sep 2026', 'amount' => 'Rp 30 juta', 'equity' => '10% ekuitas'],
        ]]);
    }

    public function reports(): View
    {
        $profile = Auth::user()->umkmProfile;
        $now = Carbon::now();
        $periods = [
            ['label' => 'Harian', 'date' => $now->format('d M Y'), 'from' => $now->copy()->startOfDay(), 'to' => $now->copy()->endOfDay()],
            ['label' => 'Mingguan', 'date' => $now->copy()->startOfWeek()->format('d M').'–'.$now->copy()->endOfWeek()->format('d M Y'), 'from' => $now->copy()->startOfWeek(), 'to' => $now->copy()->endOfWeek()],
            ['label' => 'Tahunan', 'date' => $now->format('Y'), 'from' => $now->copy()->startOfYear(), 'to' => $now->copy()->endOfYear()],
        ];
        $reports = collect($periods)->map(function (array $period) use ($profile): array {
            $transactions = $profile?->financialTransactions()->whereBetween('tanggal', [$period['from'], $period['to']])->get() ?? collect();
            return ['label' => $period['label'], 'date' => $period['date'], 'income' => (float) $transactions->where('jenis', 'pemasukan')->sum('nominal'), 'expense' => (float) $transactions->where('jenis', 'pengeluaran')->sum('nominal'), 'count' => $transactions->count()];
        })->all();

        return view('umkm.management', ['page' => 'reports', 'title' => 'Laporan Usaha', 'subtitle' => 'Ringkasan performa bisnis kamu', 'reports' => $reports]);
    }

    public function store(): View
    {
        return view('umkm.management', ['page' => 'store', 'title' => 'Profil Toko', 'subtitle' => 'Kelola identitas dan informasi toko kamu']);
    }
}
