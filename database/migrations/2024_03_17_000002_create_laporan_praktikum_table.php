<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_praktikum', function (Blueprint $table) {
            $table->id();
            $table->foreignId('praktikum_id')->constrained('praktikum')->onDelete('cascade');
            $table->foreignId('mahasiswa_id')->constrained('users')->onDelete('cascade');
            $table->string('file_path');
            $table->text('catatan')->nullable();
            $table->enum('status', ['submitted', 'reviewed'])->default('submitted');
            $table->timestamp('submitted_at')->useCurrent();
            $table->timestamps();

            $table->unique(['praktikum_id', 'mahasiswa_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_praktikum');
    }
}; 