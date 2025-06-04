<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * App\Models\User
 *
 * @method bool isAdmin()
 * @method bool isDosen()
 * @method bool isMahasiswa()
 */
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'approved_by_admin', // Tambahkan ini jika belum ada
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'approved_by_admin' => 'boolean', // Tambahkan cast untuk boolean
        ];
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'dosen_id');
    }

    public function kelas_mahasiswa()
    {
        return $this->belongsToMany(Kelas::class, 'kelas_mahasiswa', 'mahasiswa_id', 'kelas_id');
    }

    public function laporan_praktikum()
    {
        return $this->hasMany(LaporanPraktikum::class, 'mahasiswa_id');
    }

    public function responPraktikum()
    {
        return $this->hasMany(ResponPraktikum::class);
    }

    /**
     * Check if user is admin
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is dosen
     *
     * @return bool
     */
    public function isDosen(): bool
    {
        return $this->role === 'dosen';
    }

    /**
     * Check if user is mahasiswa
     *
     * @return bool
     */
    public function isMahasiswa(): bool
    {
        return $this->role === 'mahasiswa';
    }
}
