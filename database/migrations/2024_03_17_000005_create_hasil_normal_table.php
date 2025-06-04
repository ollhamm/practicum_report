<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hasil_normal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('praktikum_id')->constrained('praktikum')->onDelete('cascade');
            $table->string('judul');
            $table->text('deskripsi');
            $table->string('gambar_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hasil_normal');
    }
}; 