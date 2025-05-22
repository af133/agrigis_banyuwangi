<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use Illuminate\Support\Facades\Hash;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Petani>
 */
class PetaniFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
    //     return [
    //         'name' => fake()->name(),
    //         'email_verified_at' => now(),
    //         'remember_token' => Str::random(10),
    //     ];
    // $table->id();
    // $table->string('nama')->nullable();
    // $table->string('nmr_telpon')->nullable();
    // $table->string('nik')->unique();
    return [
        'nama'=>fake()->name(),
        'nmr_telpon'=>fake()->phoneNumber(),
        'nik' => $this->faker->unique()->numerify('################'),
        ];
    }
}
