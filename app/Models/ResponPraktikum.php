<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponPraktikum extends Model
{
    use HasFactory;

    protected $table = 'respon_praktikum';

    protected $fillable = [
        'laporan_praktikum_id',
        'user_id',
        'komentar',
        'nilai',
    ];

    public function laporanPraktikum()
    {
        return $this->belongsTo(LaporanPraktikum::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
