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
        Schema::create('nilai_normal', function (Blueprint $table) {
            $table->id();
            $table->string('test_name', 100);
            $table->string('parameter', 100);
            $table->string('unit', 20);
            $table->decimal('normal_min', 10, 2)->nullable();
            $table->decimal('normal_max', 10, 2)->nullable();
            $table->enum('gender', ['L', 'P'])->nullable();
            $table->integer('age_min');
            $table->integer('age_max');
            $table->text('notes')->nullable();
            $table->string('referensi', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_normal');
    }
};
