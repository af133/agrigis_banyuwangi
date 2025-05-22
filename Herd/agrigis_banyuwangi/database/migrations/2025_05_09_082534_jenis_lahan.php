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
        Schema::create('jenis_lahan', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis_lahan',['Non-LP2B','LP2B','Lahan Basah','Tegal']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenisLahan');
    }
};
