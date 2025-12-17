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
    Schema::create('laporans', function (Blueprint $table) {
        $table->id();
        $table->string('gedung');
        $table->string('ruang');
        $table->string('fasilitas');
        $table->text('kerusakan');
        $table->string('foto')->nullable();
        $table->enum('status', ['Diterima', 'Diproses', 'Selesai'])->default('Diterima');
        $table->string('pelapor_nama')->nullable();
        $table->string('pelapor_nim')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};
