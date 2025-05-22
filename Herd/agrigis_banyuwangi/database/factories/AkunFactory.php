<?php

namespace Database\Factories;

use App\Models\StatusPekerjaan;
use Illuminate\Database\Eloquent\Factories\Factory;

use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Akun>
 */
class AkunFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * 
     * @return array<string, mixed>
     */
    protected static ?string $password;
    public function definition(): array
    {
        // Schema::create('akun', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('nama')->nullable();
        //     $table->string('nmr_telpon')->nullable();
        //     $table->string('email');
        //     $table->string('password');
        //     $table->string('path_img');
        //     $table->foreignId('status_id')->constrained('status_pekerja')->onDelete('cascade');
        // });
        return [
            'nama'=>fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
            'nmr_telpon'=>fake()->phoneNumber(),
            'path_img'=>fake()->imageUrl(),
            'status_id'=>StatusPekerjaan::inRandomOrder()->first()->id,
        ];
    }
}
