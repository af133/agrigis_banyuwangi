<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JenisLahan>
 */
class JenisLahanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'jenis_lahan'=>fake()->randomElement([' Non-LP2B','LP2B','Lahan Basah','Tegal']),
        ];
    }
}
