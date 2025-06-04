<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kelas extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kelas',
        'kode',
        'tahun_ajaran',
        'semester',
        'angkatan',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function dosen(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'kelas_dosen', 'kelas_id', 'user_id')
            ->where('role', 'dosen');
    }

    public function mahasiswa(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'kelas_mahasiswa', 'kelas_id', 'user_id')
            ->where('role', 'mahasiswa');
    }

    public function praktikum(): HasMany
    {
        return $this->hasMany(Praktikum::class);
    }
}
