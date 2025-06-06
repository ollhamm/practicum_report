<?php

namespace App\Policies;

use App\Models\Praktikum;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\DB;

class PraktikumPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->role === 'dosen';
    }

    public function view(User $user, Praktikum $praktikum): bool
    {
        if ($user->role === 'admin') return true;

        // Dosen yang mengajar di kelas tersebut
        if ($user->role === 'dosen') {
            return DB::table('kelas_dosen')
                ->where('kelas_id', $praktikum->kelas_id)
                ->where('user_id', $user->id)
                ->exists();
        }

        // Mahasiswa yang terdaftar di kelas tersebut
        if ($user->role === 'mahasiswa') {
            return DB::table('kelas_mahasiswa') // atau tabel relasi mahasiswa-kelas Anda
                ->where('kelas_id', $praktikum->kelas_id)
                ->where('user_id', $user->id)
                ->exists();
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $user->role === 'dosen';
    }

    public function update(User $user, Praktikum $praktikum): bool
    {
        if ($user->role === 'admin') return true;

        return DB::table('kelas_dosen')
            ->where('kelas_id', $praktikum->kelas_id)
            ->where('user_id', $user->id)
            ->exists();
    }

    public function delete(User $user, Praktikum $praktikum): bool
    {
        if ($user->role === 'admin') return true;

        return DB::table('kelas_dosen')
            ->where('kelas_id', $praktikum->kelas_id)
            ->where('user_id', $user->id)
            ->exists();
    }

    // Method khusus untuk download panduan
    public function downloadPanduan(User $user, Praktikum $praktikum): bool
    {
        if ($user->role === 'admin') return true;

        // Dosen yang mengajar di kelas tersebut
        if ($user->role === 'dosen') {
            return DB::table('kelas_dosen')
                ->where('kelas_id', $praktikum->kelas_id)
                ->where('user_id', $user->id)
                ->exists();
        }

        // Mahasiswa yang terdaftar di kelas tersebut
        if ($user->role === 'mahasiswa') {
            return DB::table('kelas_mahasiswa') // sesuaikan dengan nama tabel Anda
                ->where('kelas_id', $praktikum->kelas_id)
                ->where('user_id', $user->id)
                ->exists();
        }

        return false;
    }
}
