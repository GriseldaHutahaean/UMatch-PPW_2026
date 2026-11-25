<?php

namespace Database\Seeders;

use App\Models\InvestmentOffer;
use App\Models\InvestorProfile;
use App\Models\UmkmProfile;
use Illuminate\Database\Seeder;

class InvestmentOfferSeeder extends Seeder
{
    /**
     * Data contoh tawaran untuk pengembangan lokal. Setiap investor mendapat satu
     * tawaran ke maksimal tiga UMKM terverifikasi. Aman dijalankan berulang.
     */
    public function run(): void
    {
        $investors = InvestorProfile::query()->get();
        $umkms = UmkmProfile::query()->where('status_verifikasi', 'verified')->limit(3)->get();

        if ($investors->isEmpty() || $umkms->isEmpty()) {
            $this->command?->warn('Butuh minimal satu profil investor dan satu UMKM berstatus verified.');

            return;
        }

        $statuses = ['menunggu', 'diterima', 'ditolak'];

        foreach ($investors as $investor) {
            foreach ($umkms->values() as $index => $umkm) {
                InvestmentOffer::query()->firstOrCreate(
                    ['investor_profile_id' => $investor->getKey(), 'umkm_profile_id' => $umkm->getKey()],
                    InvestmentOffer::factory()->raw(['status_penawaran' => $statuses[$index]]),
                );
            }
        }
    }
}
