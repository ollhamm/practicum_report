<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilNormal extends Model
{
    use HasFactory;

    protected $fillable = [
        'praktikum_id',
        'judul',
        'deskripsi',
        'gambar_path',
    ];

    public function praktikum()
    {
        return $this->belongsTo(Praktikum::class);
    }
}
