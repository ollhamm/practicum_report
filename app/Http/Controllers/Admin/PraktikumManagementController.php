<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Praktikum;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PraktikumManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $praktikums = Praktikum::with(['kelas.dosen' => function ($query) {
            $query->select('users.id', 'users.name');
        }])->latest()->paginate(1000); // atau angka besar agar "terlihat seperti semua"


        return view('admin.praktikum.index', compact('praktikums'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kelas_list = Kelas::all();
        return view('admin.praktikum.create', compact('kelas_list'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'judul' => ['required', 'string', 'max:255'],
                'deskripsi' => ['required', 'string'],
                'kelas_id' => ['required', 'exists:kelas,id'],
                'dosen_id' => ['required', 'exists:users,id'],
                'deadline' => ['required', 'date'],
            ]);

            DB::beginTransaction();

            // Create praktikum
            $praktikum = Praktikum::create([
                'judul' => $validated['judul'],
                'deskripsi' => $validated['deskripsi'],
                'kelas_id' => $validated['kelas_id'],
                'deadline' => $validated['deadline'],
            ]);

            // Verify if dosen is already assigned to kelas
            $kelasDosen = DB::table('kelas_dosen')
                ->where('kelas_id', $validated['kelas_id'])
                ->where('user_id', $validated['dosen_id'])
                ->first();

            // If not assigned, assign dosen to kelas
            if (!$kelasDosen) {
                DB::table('kelas_dosen')->insert([
                    'kelas_id' => $validated['kelas_id'],
                    'user_id' => $validated['dosen_id'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::commit();

            return redirect()
                ->route('admin.praktikum.index')
                ->with('success', 'Praktikum berhasil dibuat.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating praktikum:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat membuat praktikum: ' . $e->getMessage());
        }
    }

    private function getRecentLogs()
    {
        // Ambil log terakhir dari storage/logs/laravel.log
        $logFile = storage_path('logs/laravel.log');
        if (!file_exists($logFile)) {
            return ['No log file found'];
        }

        // Baca 50 baris terakhir dari file log
        $logs = [];
        $file = new \SplFileObject($logFile, 'r');
        $file->seek(PHP_INT_MAX);
        $lastLine = $file->key();
        
        $lines = new \LimitIterator($file, max(0, $lastLine - 50), $lastLine);
        foreach ($lines as $line) {
            if (trim($line)) {
                $logs[] = trim($line);
            }
        }

        return array_reverse($logs);
    }

    /**
     * Display the specified resource.
     */
    public function show(Praktikum $praktikum)
    {
        $praktikum->load([
            'kelas.dosen',
            'kelas.mahasiswa',
            'laporan_praktikum.mahasiswa',
        ]);

        return view('admin.praktikum.show', compact('praktikum'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Praktikum $praktikum)
    {
        $kelas_list = Kelas::all();
        $dosen_id = $praktikum->kelas->dosen->first()->id ?? null;
        
        return view('admin.praktikum.edit', compact('praktikum', 'kelas_list', 'dosen_id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Praktikum $praktikum)
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'kelas_id' => ['required', 'exists:kelas,id'],
            'dosen_id' => ['required', 'exists:users,id'],
            'deadline' => ['required', 'date'],
        ]);

        try {
            DB::beginTransaction();

            // Update praktikum
            $praktikum->update([
                'judul' => $validated['judul'],
                'deskripsi' => $validated['deskripsi'],
                'kelas_id' => $validated['kelas_id'],
                'deadline' => $validated['deadline'],
            ]);

            // Verify if dosen is already assigned to kelas
            $kelasDosen = DB::table('kelas_dosen')
                ->where('kelas_id', $validated['kelas_id'])
                ->where('user_id', $validated['dosen_id'])
                ->first();

            // If not assigned, assign dosen to kelas
            if (!$kelasDosen) {
                DB::table('kelas_dosen')->insert([
                    'kelas_id' => $validated['kelas_id'],
                    'user_id' => $validated['dosen_id'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::commit();

            return redirect()
                ->route('admin.praktikum.index')
                ->with('success', 'Praktikum berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating praktikum:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui praktikum: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Praktikum $praktikum)
    {
        try {
            $praktikum->delete();
            return back()->with('success', 'Praktikum berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menghapus praktikum.');
        }
    }

    public function getDosenByKelas(Kelas $kelas)
    {
        try {
            $dosen = $kelas->dosen()
                ->where('role', 'dosen')
                ->get(['users.id', 'users.name']);

            return response()->json($dosen);
        } catch (\Exception $e) {
            Log::error('Error getting dosen by kelas: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan saat mengambil data dosen'], 500);
        }
    }
}
