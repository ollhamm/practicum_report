<?php

namespace App\Policies;

use App\Models\Kelas;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\DB;

class KelasPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->role === 'dosen';
    }

    public function view(User $user, Kelas $kelas)
    {
        if ($user->role === 'admin') return true;

        return DB::table('kelas_dosen')
            ->where('kelas_id', $kelas->id)
            ->where('user_id', $user->id)
            ->exists();
    }

    public function create(User $user): bool
    {
        return $user->role === 'dosen';
    }

    public function update(User $user, Kelas $kelas)
    {
        if ($user->role === 'admin') return true;

        return DB::table('kelas_dosen')
            ->where('kelas_id', $kelas->id)
            ->where('user_id', $user->id)
            ->exists();
    }

    public function delete(User $user, Kelas $kelas)
    {
        if ($user->role === 'admin') return true;

        return DB::table('kelas_dosen')
            ->where('kelas_id', $kelas->id)
            ->where('user_id', $user->id)
            ->exists();
    }
} 