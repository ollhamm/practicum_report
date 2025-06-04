<?php

namespace App\Policies;

use App\Models\LaporanPraktikum;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\DB;

class LaporanPraktikumPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->role === 'mahasiswa';
    }

    public function view(User $user, LaporanPraktikum $laporan): bool
    {
        if ($user->role === 'admin') return true;

        return DB::table('kelas_dosen')
            ->where('kelas_id', $laporan->praktikum->kelas_id)
            ->where('user_id', $user->id)
            ->exists();
    }

    public function create(User $user): bool
    {
        return $user->role === 'mahasiswa';
    }

    public function update(User $user, LaporanPraktikum $laporan): bool
    {
        if ($user->role === 'admin') return true;

        if ($user->role !== 'mahasiswa') {
            return false;
        }

        if ($laporan->status === 'reviewed') {
            return false;
        }

        return DB::table('kelas_dosen')
            ->where('kelas_id', $laporan->praktikum->kelas_id)
            ->where('user_id', $user->id)
            ->exists();
    }

    public function delete(User $user, LaporanPraktikum $laporan): bool
    {
        if ($user->role === 'admin') return true;

        if ($user->role !== 'mahasiswa') {
            return false;
        }

        if ($laporan->status === 'reviewed') {
            return false;
        }

        return DB::table('kelas_dosen')
            ->where('kelas_id', $laporan->praktikum->kelas_id)
            ->where('user_id', $user->id)
            ->exists();
    }
} 