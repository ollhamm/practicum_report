<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Praktikum;
use App\Models\LaporanPraktikum;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'pending_users' => User::where('approved_by_admin', false)->count(),
            'total_dosen' => User::where('role', 'dosen')->count(),
            'total_mahasiswa' => User::where('role', 'mahasiswa')->count(),
            'total_kelas' => Kelas::count(),
            'total_praktikum' => Praktikum::count(),
            'total_laporan' => LaporanPraktikum::count(),
        ];

        $pendingUsers = User::where('approved_by_admin', false)
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'pendingUsers'));
    }
}
