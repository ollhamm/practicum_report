<?php

namespace App\Policies;

use App\Models\LaporanPraktikum;
use App\Models\User;

class LaporanPraktikumPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role === 'mahasiswa';
    }

    public function view(User $user, LaporanPraktikum $laporan): bool
    {
        return $user->id === $laporan->mahasiswa_id ||
            $user->id === $laporan->praktikum->kelas->dosen_id;
    }

    public function create(User $user): bool
    {
        return $user->role === 'mahasiswa';
    }

    public function update(User $user, LaporanPraktikum $laporan): bool
    {
        if ($user->role !== 'mahasiswa') {
            return false;
        }

        if ($laporan->status === 'reviewed') {
            return false;
        }

        return $user->id === $laporan->mahasiswa_id;
    }

    public function delete(User $user, LaporanPraktikum $laporan): bool
    {
        if ($user->role !== 'mahasiswa') {
            return false;
        }

        if ($laporan->status === 'reviewed') {
            return false;
        }

        return $user->id === $laporan->mahasiswa_id;
    }
} 