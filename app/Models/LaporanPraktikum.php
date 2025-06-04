<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class LaporanPraktikum extends Model
{
    use HasFactory;

    protected $table = 'laporan_praktikum';

    protected $fillable = [
        'praktikum_id',
        'mahasiswa_id',
        'file_path',
        'catatan',
        'status',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
    ];

    public function praktikum(): BelongsTo
    {
        return $this->belongsTo(Praktikum::class);
    }

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }

    public function respon_praktikum(): HasOne
    {
        return $this->hasOne(ResponPraktikum::class);
    }

    public function isLate(): bool
    {
        return $this->created_at > $this->praktikum->deadline;
    }
}
