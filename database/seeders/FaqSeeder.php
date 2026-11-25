<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * FAQ awal Pusat Bantuan berdasarkan alur pada proposal UMatch. FAQ dicatat
     * atas nama Admin pertama. Aman dijalankan berulang.
     */
    public function run(): void
    {
        $admin = User::query()
            ->whereHas('roles', fn (Builder $query) => $query->where('nama_role', 'admin'))
            ->orderBy('user_id')
            ->first();

        if ($admin === null) {
            $this->command?->warn('Belum ada akun Admin. Jalankan AdminSeeder terlebih dahulu.');

            return;
        }

        foreach ($this->faqs() as [$category, $targetRole, $question, $answer]) {
            Faq::query()->updateOrCreate(
                ['pertanyaan' => $question],
                ['user_id' => $admin->getKey(), 'jawaban' => $answer, 'kategori' => $category, 'target_role' => $targetRole],
            );
        }
    }

    /**
     * @return list<array{0: string, 1: string|null, 2: string, 3: string}>
     */
    private function faqs(): array
    {
        return [
            ['Akun', null, 'Apakah satu akun bisa memiliki lebih dari satu peran?', 'Bisa. Satu akun dapat menjadi Customer, UMKM, dan Investor. Kamu dapat berpindah peran melalui Role Switcher tanpa login ulang.'],
            ['Akun', null, 'Bagaimana jika akun saya terkunci dan email tidak bisa diakses?', 'Hubungi kontak resmi UMatch di halaman Pusat Bantuan. Admin akan memeriksa riwayat login dan identitasmu sebelum membuka kunci akun atau mengganti email terdaftar.'],
            ['Verifikasi KYC', 'investor', 'Data apa saja yang dibutuhkan untuk verifikasi KYC?', 'NIK, foto KTP, foto selfie, pekerjaan, penghasilan, jenis investor, profil risiko, dan tujuan investasi.'],
            ['Verifikasi KYC', 'investor', 'Bagaimana proses verifikasi KYC?', 'Data yang dikirim berstatus Pending, lalu diperiksa secara manual oleh Admin. Hasilnya Verified jika data valid, atau Rejected disertai alasan penolakan.'],
            ['Investasi', 'investor', 'Apa syarat mengirim tawaran investasi?', 'KYC kamu harus terverifikasi, UMKM tujuan harus terverifikasi, dan UMKM tersebut sedang membuka ketersediaan pendanaan.'],
            ['Investasi', 'investor', 'Apa arti status pada tawaran investasi?', 'Menunggu berarti UMKM belum memberi keputusan. Diterima berarti UMKM menyetujui tawaran. Ditolak berarti UMKM tidak menerima tawaran.'],
            ['Investasi', 'investor', 'Apa yang terjadi setelah tawaran diterima?', 'Investor mengonfirmasi dan membayar investasi. Setelah itu investasi dicatat dan portofolio investor diperbarui.'],
            ['Investasi', 'investor', 'Apakah pembayaran investasi menggunakan uang sungguhan?', 'Tidak. Pembayaran disimulasikan dan tidak terhubung dengan payment gateway maupun rekening nyata. UMatch adalah prototipe akademik dan belum mencakup kepatuhan terhadap regulasi urun dana OJK.'],
        ];
    }
}
