<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class KelasController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $kelas_list = $user->kelas()
            ->withCount(['mahasiswa', 'praktikum'])
            ->latest()
            ->paginate(10);

        return view('dosen.kelas.index', compact('kelas_list'));
    }

    public function show($id)
    {
        $user = Auth::user();
        $kelas = Kelas::findOrFail($id);
        
        // Cek akses menggunakan query langsung ke tabel pivot
        $hasAccess = DB::table('kelas_dosen')
            ->where('user_id', $user->id)
            ->where('kelas_id', $kelas->id)
            ->exists();
            
        if (!$hasAccess) {
            Log::warning('Akses ditolak ke kelas', [
                'user_id' => $user->id,
                'kelas_id' => $kelas->id
            ]);
            abort(403, 'Anda tidak memiliki akses ke kelas ini.');
        }

        $kelas->load([
            'dosen',
            'mahasiswa',
            'praktikum' => function ($query) use ($user) {
                $query->where('dosen_id', $user->id);
            },
            'praktikum.laporan_praktikum.mahasiswa'
        ]);

        return view('dosen.kelas.show', compact('kelas'));
    }
}
