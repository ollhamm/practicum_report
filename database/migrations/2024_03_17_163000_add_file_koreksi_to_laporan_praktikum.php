<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('laporan_praktikum', function (Blueprint $table) {
            if (!Schema::hasColumn('laporan_praktikum', 'file_koreksi_path')) {
                $table->string('file_koreksi_path')->nullable()->after('file_path');
            }
            if (!Schema::hasColumn('laporan_praktikum', 'nilai')) {
                $table->decimal('nilai', 5, 2)->nullable()->after('status');
            }
            if (!Schema::hasColumn('laporan_praktikum', 'catatan')) {
                $table->text('catatan')->nullable()->after('nilai');
            }
        });
    }

    public function down()
    {
        Schema::table('laporan_praktikum', function (Blueprint $table) {
            $table->dropColumn(['file_koreksi_path', 'nilai', 'catatan']);
        });
    }
}; 