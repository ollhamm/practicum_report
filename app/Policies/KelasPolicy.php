<?php

namespace App\Policies;

use App\Models\Kelas;
use App\Models\User;

class KelasPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role === 'dosen';
    }

    public function view(User $user, Kelas $kelas): bool
    {
        return $user->id === $kelas->dosen_id;
    }

    public function create(User $user): bool
    {
        return $user->role === 'dosen';
    }

    public function update(User $user, Kelas $kelas): bool
    {
        return $user->id === $kelas->dosen_id;
    }

    public function delete(User $user, Kelas $kelas): bool
    {
        return $user->id === $kelas->dosen_id;
    }
} 