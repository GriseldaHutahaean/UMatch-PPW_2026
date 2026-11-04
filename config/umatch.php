<?php

// Teks dan tema tiap peran, dipakai di halaman Pilih Peran, Login, dan Daftar.
return [
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
];
