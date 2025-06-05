<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Praktikum;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Get total kelas where dosen is assigned
        $total_kelas = $user->kelas()->count();

        // Get total praktikum created by dosen
        $total_praktikum = Praktikum::where('dosen_id', $user->id)->count();

        // Get total mahasiswa in dosen's classes
        $total_mahasiswa = User::whereHas('kelas', function ($query) use ($user) {
            $query->whereHas('dosen', function ($q) use ($user) {
                $q->where('users.id', $user->id);
            });
        })->where('role', 'mahasiswa')->count();

        // Get recent praktikum
        $recent_praktikum = Praktikum::with(['kelas'])
            ->where('dosen_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('dosen.dashboard', compact(
            'total_kelas',
            'total_praktikum',
            'total_mahasiswa',
            'recent_praktikum'
        ));
    }
}
