<?php

namespace Database\Factories;

use App\Models\PemetaanLahan;
use Illuminate\Database\Eloquent\Factories\Factory;
Use App\Models\Akun;
Use App\Models\Petani;
use Carbon\Carbon;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LaporanMapping>
 */
class LaporanMappingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Schema::create('laporan_mapping', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('akun_id')->constrained('akun')->onDelete('cascade');
        //     $table->foreignId('petani_id')->constrained('petani')->onDelete('cascade');
        //     $table->foreignId('pemetaan_lahan_id')->constrained('pemetaan_lahan')->onDelete('cascade');

        // });
        return [
            'akun_id'=>Akun::inRandomOrder()->first()->id,
            'petani_id'=>Petani::inRandomOrder()->first()->id,
            'pemetaan_lahan_id'=>PemetaanLahan::inRandomOrder()->first()->id,
            'waktu_laporan' => Carbon::now()->timezone('Asia/Jakarta'),
        ];
    }
}
