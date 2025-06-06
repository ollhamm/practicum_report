<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Praktikum;
use App\Models\LaporanPraktikum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil semua kelas yang diikuti mahasiswa
        $kelasIds = $user->kelas()->pluck('kelas.id');

        // Ambil semua praktikum dari kelas yang diikuti
        $praktikumIds = Praktikum::whereIn('kelas_id', $kelasIds)->pluck('id');

        // Ambil laporan yang sudah dikumpulkan oleh mahasiswa
        $laporanDikumpulkan = LaporanPraktikum::where('mahasiswa_id', $user->id)
            ->whereIn('praktikum_id', $praktikumIds)
            ->pluck('praktikum_id');

        $stats = [
            'total_kelas' => $kelasIds->count(),
            'total_praktikum' => $praktikumIds->count(),
            'praktikum_dikumpulkan' => $laporanDikumpulkan->count(),
            'praktikum_belum_dikumpulkan' => $praktikumIds->count() - $laporanDikumpulkan->count(),
        ];

        // Ambil kelas yang diikuti dengan informasi praktikum
        $kelasDiikuti = Kelas::whereIn('id', $kelasIds)
            ->with(['dosen', 'praktikum' => function ($query) {
                $query->latest()->limit(3);
            }])
            ->latest()
            ->take(5)
            ->get();

        // Ambil praktikum terbaru yang belum dikumpulkan
        $praktikumTerbaru = Praktikum::whereIn('id', $praktikumIds)
            ->whereNotIn('id', $laporanDikumpulkan)
            ->with(['kelas'])
            ->latest()
            ->take(5)
            ->get();

        return view('mahasiswa.dashboard', compact('stats', 'kelasDiikuti', 'praktikumTerbaru'));
    }
}
