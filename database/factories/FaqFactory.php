<?php

namespace Database\Factories;

use App\Models\Faq;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Admin pengelola (`user_id`) harus diberikan oleh pemanggil.
 *
 * @extends Factory<Faq>
 */
class FaqFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'pertanyaan' => rtrim(fake()->sentence(), '.').'?',
            'jawaban' => fake()->paragraph(),
            'kategori' => fake()->randomElement(['Akun', 'Verifikasi KYC', 'Investasi']),
            'target_role' => null,
        ];
    }
}
