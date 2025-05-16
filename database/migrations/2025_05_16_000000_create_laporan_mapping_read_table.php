<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_mapping_read', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_mapping_id')->constrained('laporan_mapping')->onDelete('cascade');
            $table->foreignId('akun_id')->constrained('akun')->onDelete('cascade');
            $table->boolean('is_read')->default(false);
            $table->timestamps(); // opsional: untuk tahu kapan dibaca
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_mapping_read');
    }
};
