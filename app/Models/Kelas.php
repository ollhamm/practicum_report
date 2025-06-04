<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kelas',
        'tahun_ajaran',
        'semester',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function praktikum()
    {
        return $this->hasMany(Praktikum::class);
    }

    public function mahasiswa()
    {
        return $this->belongsToMany(User::class)->where('role', 'mahasiswa');
    }

    public function dosen()
    {
        return $this->belongsToMany(User::class)->where('role', 'dosen');
    }
}
