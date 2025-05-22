<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        
        Schema::create('laporan_mapping', function (Blueprint $table) {
            $table->id();
            $table->foreignId('akun_id')->constrained('akun')->onDelete('cascade');
            $table->foreignId('petani_id')->constrained('petani')->onDelete('cascade');
            $table->foreignId('pemetaan_lahan_id')->constrained('pemetaan_lahan')->onDelete('cascade');
            $table->dateTime('waktu_laporan')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_mapping');
    }
};
