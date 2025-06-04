<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Praktikum;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminPraktikumController extends Controller
{
    public function index()
    {
        $praktikums = Praktikum::with(['kelas'])->latest()->paginate(10);
        return view('admin.praktikum.index', compact('praktikums'));
    }

    public function create()
    {
        $kelas_list = Kelas::all();
        return view('admin.praktikum.create', compact('kelas_list'));
    }

    public function store(Request $request)
    {
        // Debug: Log input data
        Log::info('Praktikum store request:', $request->all());

        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'kelas_id' => ['required', 'exists:kelas,id'],
            'pertemuan' => ['required', 'integer', 'min:1'],
            'deadline' => ['required', 'date_format:Y-m-d\TH:i'],
        ]);

        try {
            DB::beginTransaction();

            $praktikum = Praktikum::create([
                'judul' => $validated['judul'],
                'deskripsi' => $validated['deskripsi'],
                'kelas_id' => $validated['kelas_id'],
                'pertemuan' => $validated['pertemuan'],
                'deadline' => $validated['deadline'],
            ]);

            DB::commit();

            Log::info('Praktikum created successfully:', ['id' => $praktikum->id]);

            return redirect()->route('admin.praktikum.index')
                ->with('success', 'Praktikum berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error creating praktikum:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat membuat praktikum: ' . $e->getMessage());
        }
    }

    public function show(Praktikum $praktikum)
    {
        $praktikum->load([
            'kelas.dosen',
            'kelas.mahasiswa',
            'laporan_praktikum.mahasiswa',
        ]);

        return view('admin.praktikum.show', compact('praktikum'));
    }

    public function edit(Praktikum $praktikum)
    {
        $kelas_list = Kelas::all();
        return view('admin.praktikum.edit', compact('praktikum', 'kelas_list'));
    }

    public function update(Request $request, Praktikum $praktikum)
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'kelas_id' => ['required', 'exists:kelas,id'],
            'pertemuan' => ['required', 'integer', 'min:1'],
            'deadline' => ['required', 'date_format:Y-m-d\TH:i'],
        ]);

        try {
            DB::beginTransaction();

            $praktikum->update($validated);

            DB::commit();

            return redirect()->route('admin.praktikum.index')
                ->with('success', 'Praktikum berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error updating praktikum:', [
                'error' => $e->getMessage(),
                'praktikum_id' => $praktikum->id
            ]);

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui praktikum: ' . $e->getMessage());
        }
    }

    public function destroy(Praktikum $praktikum)
    {
        try {
            DB::beginTransaction();

            $praktikum->delete();

            DB::commit();

            return back()->with('success', 'Praktikum berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error deleting praktikum:', [
                'error' => $e->getMessage(),
                'praktikum_id' => $praktikum->id
            ]);

            return back()->with('error', 'Terjadi kesalahan saat menghapus praktikum: ' . $e->getMessage());
        }
    }
}
