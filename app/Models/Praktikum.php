<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Praktikum extends Model
{
    use HasFactory;

    protected $table = 'praktikum';

    protected $fillable = [
        'judul',
        'deskripsi',
        'deadline',
        'kelas_id',
        'panduan_path',
        'template_path',
    ];

    protected $casts = [
        'deadline' => 'datetime',
    ];

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class);
    }

    public function laporan_praktikum(): HasMany
    {
        return $this->hasMany(LaporanPraktikum::class);
    }

    public function hasilNormal()
    {
        return $this->hasMany(HasilNormal::class);
    }
}
