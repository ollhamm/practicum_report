<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('respon_praktikum', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_praktikum_id')->constrained('laporan_praktikum')->onDelete('cascade');
            $table->decimal('nilai', 5, 2);
            $table->text('komentar')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('respon_praktikum');
    }
}; 