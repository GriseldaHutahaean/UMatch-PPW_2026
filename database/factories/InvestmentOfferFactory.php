<?php

namespace Database\Factories;

use App\Models\InvestmentOffer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Profil investor dan UMKM (`investor_profile_id`, `umkm_profile_id`) harus
 * diberikan oleh pemanggil karena kedua profil belum memiliki factory.
 *
 * @extends Factory<InvestmentOffer>
 */
class InvestmentOfferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'jumlah_penawaran' => fake()->numberBetween(5, 100) * 1_000_000,
            'skema_investasi' => fake()->randomElement([5, 8, 10, 15]).'% ekuitas',
            'status_penawaran' => 'menunggu',
            'tanggal_pengajuan' => fake()->dateTimeBetween('-1 month'),
        ];
    }

    public function accepted(): static
    {
        return $this->state(['status_penawaran' => 'diterima']);
    }

    public function rejected(): static
    {
        return $this->state(['status_penawaran' => 'ditolak']);
    }
}
