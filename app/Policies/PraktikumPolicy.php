<?php

namespace App\Policies;

use App\Models\Praktikum;
use App\Models\User;

class PraktikumPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role === 'dosen';
    }

    public function view(User $user, Praktikum $praktikum): bool
    {
        return $user->id === $praktikum->kelas->dosen_id;
    }

    public function create(User $user): bool
    {
        return $user->role === 'dosen';
    }

    public function update(User $user, Praktikum $praktikum): bool
    {
        return $user->id === $praktikum->kelas->dosen_id;
    }

    public function delete(User $user, Praktikum $praktikum): bool
    {
        return $user->id === $praktikum->kelas->dosen_id;
    }
} 