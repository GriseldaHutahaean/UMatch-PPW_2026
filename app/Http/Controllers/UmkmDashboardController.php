<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class UmkmDashboardController extends Controller
{
    public function products(): View
    {
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
        return view('umkm.management', ['page' => 'finance', 'title' => 'Keuangan', 'subtitle' => 'Catatan kas Dapur Batak']);
    }

    public function investors(): View
    {
        return view('umkm.management', ['page' => 'investors', 'title' => 'Investor Hub', 'subtitle' => '2 penawaran masuk', 'investors' => [
            ['name' => 'Pak Ahmad Susilo', 'location' => 'Jakarta', 'date' => '20 Sep 2026', 'amount' => 'Rp 50 juta', 'equity' => '15% ekuitas'], ['name' => 'Ibu Dewi Hartono', 'location' => 'Surabaya', 'date' => '22 Sep 2026', 'amount' => 'Rp 30 juta', 'equity' => '10% ekuitas'],
        ]]);
    }

    public function reports(): View
    {
        return view('umkm.management', ['page' => 'reports', 'title' => 'Laporan Usaha', 'subtitle' => 'Ringkasan performa bisnis kamu']);
    }

    public function store(): View
    {
        return view('umkm.management', ['page' => 'store', 'title' => 'Profil Toko', 'subtitle' => 'Kelola identitas dan informasi toko kamu']);
    }
}
