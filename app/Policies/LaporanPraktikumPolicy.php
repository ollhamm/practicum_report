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
        // Admin can view all
        if ($user->role === 'admin') return true;

        // Mahasiswa can view their own reports
        if ($user->role === 'mahasiswa') {
            return $laporan->mahasiswa_id === $user->id;
        }

        // Dosen can view if they are assigned to the class
        if ($user->role === 'dosen') {
            return DB::table('kelas_dosen')
                ->where('kelas_id', $laporan->praktikum->kelas_id)
                ->where('user_id', $user->id)
                ->exists();
        }

        return false;
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

        return $laporan->mahasiswa_id === $user->id;
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

        return $laporan->mahasiswa_id === $user->id;
    }

    public function downloadKoreksi(User $user, LaporanPraktikum $laporan): bool
    {
        // Admin can download all
        if ($user->role === 'admin') return true;

        // Mahasiswa can download their own report corrections
        if ($user->role === 'mahasiswa') {
            return $laporan->mahasiswa_id === $user->id;
        }

        // Dosen can download if they are assigned to the class
        if ($user->role === 'dosen') {
            return DB::table('kelas_dosen')
                ->where('kelas_id', $laporan->praktikum->kelas_id)
                ->where('user_id', $user->id)
                ->exists();
        }

        return false;
    }
}
