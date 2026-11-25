<?php

// Teks dan tema tiap peran, dipakai di halaman Pilih Peran, Login, dan Daftar.
return [
    // Kontak resmi yang tampil di Pusat Bantuan. Isi UMATCH_SUPPORT_EMAIL dengan alamat asli.
    'support_email' => env('UMATCH_SUPPORT_EMAIL', 'bantuan@umatch.test'),
    'roles' => [
        'customer' => [
            'label' => 'Customer',
            'subtitle' => 'Belanja produk UMKM',
            'tagline' => 'Pembeli & Masyarakat Umum',
            'features' => ['Belanja langsung dari ribuan UMKM', 'Tracking pesanan real-time', 'Simpan produk favorit'],
            'icon' => 'bag',
        ],
        'umkm' => [
            'label' => 'UMKM',
            'subtitle' => 'Kelola usaha & penjualan',
            'tagline' => 'Pemilik Usaha Mikro & Kecil',
            'features' => ['Dashboard penjualan & analitik', 'Manajemen produk & stok', 'Koneksi dengan investor'],
            'icon' => 'store',
        ],
        'investor' => [
            'label' => 'Investor',
            'subtitle' => 'Temukan UMKM potensial',
            'tagline' => 'Investor & Mitra Usaha',
            'features' => ['Eksplorasi UMKM potensial', 'Review profil & keuangan UMKM', 'Kelola portofolio investasi'],
            'icon' => 'trend',
        ],
    ],
    'internal_roles' => [
        'admin' => [
            'label' => 'Admin',
            'subtitle' => 'Kelola platform & operasional',
            'tagline' => 'Administrator UMatch',
            'features' => ['Kelola pengguna & akses', 'Pantau aktivitas platform', 'Mengatur kebijakan & promosi'],
            'icon' => 'shield',
        ],
    ],
];
