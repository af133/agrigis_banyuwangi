<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\JenisLahan;
use App\Models\Tanaman;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PemetaanLahan>
 */
class PemetaanLahanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
           'alamat' => fake()->address(),
           'status_tanam' =>$this->faker->randomElement(['Panen','Tanam']),
            'luas_lahan' => fake()->numberBetween(100, 10000), 
            'lat' => fake()->latitude(), 
            'lng' => fake()->longitude(),
            'jenis_lahan_id' => JenisLahan::inRandomOrder()->first()?->id ?? 1,
            'jenis_tanam_id' => Tanaman::inRandomOrder()->first()?->id ?? 1,


        ];
    }
}
