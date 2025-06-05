<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;

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

    // Status constants for approved_by_admin
    public const APPROVAL_PENDING = 0;
    public const APPROVAL_REJECTED = 1;
    public const APPROVAL_APPROVED = 2;

    // Legacy status constants (keeping for backward compatibility if needed)
    public const STATUS_PENDING = 0;
    public const STATUS_REJECTED = 1;
    public const STATUS_APPROVED = 2;

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
        'nip',
        'approved_by_admin',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'nomor_telepon',
        'alamat_ktp',
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
            'approved_by_admin' => 'integer',
        ];
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function kelasAsDosen()
    {
        return $this->belongsToMany(Kelas::class, 'kelas_dosen', 'user_id', 'kelas_id');
    }

    public function kelasAsMahasiswa()
    {
        return $this->belongsToMany(Kelas::class, 'kelas_mahasiswa', 'user_id', 'kelas_id');
    }

    public function praktikumAsDosen()
    {
        return $this->hasManyThrough(
            Praktikum::class,
            Kelas::class,
            'id', // Local key on kelas table
            'kelas_id', // Local key on praktikum table
            'id', // Local key on users table
            'id' // Local key on kelas table
        )->whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('kelas_dosen')
                ->whereColumn('kelas_dosen.kelas_id', 'kelas.id')
                ->where('kelas_dosen.user_id', $this->id);
        });
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

    /**
     * Check if user is pending approval
     */
    public function isPending(): bool
    {
        return $this->approved_by_admin === self::APPROVAL_PENDING;
    }

    /**
     * Check if user is rejected
     */
    public function isRejected(): bool
    {
        return $this->approved_by_admin === self::APPROVAL_REJECTED;
    }

    /**
     * Check if user is approved
     */
    public function isApproved(): bool
    {
        return $this->approved_by_admin === self::APPROVAL_APPROVED;
    }

    /**
     * Get approval status text
     */
    public function getApprovalStatusText(): string
    {
        return match ($this->approved_by_admin) {
            self::APPROVAL_PENDING => 'pending',
            self::APPROVAL_REJECTED => 'rejected',
            self::APPROVAL_APPROVED => 'approved',
            default => 'unknown'
        };
    }

    /**
     * Set approval status using text
     */
    public function setApprovalStatus(string $status): void
    {
        $this->approved_by_admin = match (strtolower($status)) {
            'pending' => self::APPROVAL_PENDING,
            'rejected' => self::APPROVAL_REJECTED,
            'approved' => self::APPROVAL_APPROVED,
            default => self::APPROVAL_PENDING
        };
    }
}
