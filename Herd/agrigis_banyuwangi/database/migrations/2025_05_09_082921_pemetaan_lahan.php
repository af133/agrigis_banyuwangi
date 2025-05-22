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
        Schema::create('pemetaan_lahan', function (Blueprint $table) {
            $table->id();
            $table->string('alamat');
            $table->integer('luas_lahan');
            $table->string('status_tanam');

            $table->foreignId('id_titik_komoditas')->constrained('titik_komoditas')->onDelete('cascade');
            $table->unsignedBigInteger('id_poligon_komoditas')->nullable();
            $table->foreign('id_poligon_komoditas')->references('id')->on('poligon_komoditas')->onDelete('set null');
            $table->foreignId('jenis_lahan_id')->constrained('jenis_lahan')->onDelete('cascade');
            $table->foreignId('jenis_tanam_id')->constrained('tanaman')->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemetaan_lahan');
    }
};
