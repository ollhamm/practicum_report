<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Praktikum;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PraktikumController extends Controller
{
    public function index()
    {
        $praktikums = Praktikum::whereHas('kelas', function($query) {
            $query->whereExists(function($subquery) {
                $subquery->select(DB::raw(1))
                    ->from('kelas_dosen')
                    ->whereColumn('kelas_dosen.kelas_id', 'kelas.id')
                    ->where('kelas_dosen.user_id', Auth::id());
            });
        })->with('kelas')->latest()->paginate(10);

        return view('dosen.praktikum.index', compact('praktikums'));
    }

    public function create()
    {
        $kelas = Kelas::whereExists(function($query) {
            $query->select(DB::raw(1))
                ->from('kelas_dosen')
                ->whereColumn('kelas_dosen.kelas_id', 'kelas.id')
                ->where('kelas_dosen.user_id', Auth::id());
        })->get();

        return view('dosen.praktikum.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'kelas_id' => ['required', 'exists:kelas,id'],
            'pertemuan' => ['required', 'integer', 'min:1'],
            'deadline' => ['required', 'date'],
        ]);

        // Verify access to kelas
        $hasAccess = DB::table('kelas_dosen')
            ->where('kelas_id', $request->kelas_id)
            ->where('user_id', Auth::id())
            ->exists();

        if (!$hasAccess) {
            return back()->with('error', 'Anda tidak memiliki akses ke kelas ini.');
        }

        try {
            Praktikum::create([
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'kelas_id' => $request->kelas_id,
                'pertemuan' => $request->pertemuan,
                'deadline' => $request->deadline,
            ]);

            return redirect()->route('dosen.praktikum.index')
                ->with('success', 'Praktikum berhasil dibuat.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat membuat praktikum.');
        }
    }

    public function show(Praktikum $praktikum)
    {
        $this->authorize('view', $praktikum);

        $praktikum->load([
            'kelas.mahasiswa',
            'laporan_praktikum.mahasiswa',
            'laporan_praktikum.respon_praktikum',
        ]);

        return view('dosen.praktikum.show', compact('praktikum'));
    }

    public function edit(Praktikum $praktikum)
    {
        // Verify access
        $hasAccess = DB::table('kelas_dosen')
            ->where('kelas_id', $praktikum->kelas_id)
            ->where('user_id', Auth::id())
            ->exists();

        if (!$hasAccess) {
            return redirect()->route('dosen.praktikum.index')
                ->with('error', 'Anda tidak memiliki akses ke praktikum ini.');
        }

        $kelas = Kelas::whereExists(function($query) {
            $query->select(DB::raw(1))
                ->from('kelas_dosen')
                ->whereColumn('kelas_dosen.kelas_id', 'kelas.id')
                ->where('kelas_dosen.user_id', Auth::id());
        })->get();

        return view('dosen.praktikum.edit', compact('praktikum', 'kelas'));
    }

    public function update(Request $request, Praktikum $praktikum)
    {
        $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'kelas_id' => ['required', 'exists:kelas,id'],
            'pertemuan' => ['required', 'integer', 'min:1'],
            'deadline' => ['required', 'date'],
        ]);

        // Verify access
        $hasAccess = DB::table('kelas_dosen')
            ->where('kelas_id', $request->kelas_id)
            ->where('user_id', Auth::id())
            ->exists();

        if (!$hasAccess) {
            return back()->with('error', 'Anda tidak memiliki akses ke kelas ini.');
        }

        try {
            $praktikum->update([
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'kelas_id' => $request->kelas_id,
                'pertemuan' => $request->pertemuan,
                'deadline' => $request->deadline,
            ]);

            return redirect()->route('dosen.praktikum.index')
                ->with('success', 'Praktikum berhasil diupdate.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mengupdate praktikum.');
        }
    }

    public function destroy(Praktikum $praktikum)
    {
        // Verify access
        $hasAccess = DB::table('kelas_dosen')
            ->where('kelas_id', $praktikum->kelas_id)
            ->where('user_id', Auth::id())
            ->exists();

        if (!$hasAccess) {
            return back()->with('error', 'Anda tidak memiliki akses ke praktikum ini.');
        }

        try {
            $praktikum->delete();
            return back()->with('success', 'Praktikum berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menghapus praktikum.');
        }
    }

    public function downloadPanduan(Praktikum $praktikum)
    {
        $this->authorize('view', $praktikum);

        if (!$praktikum->panduan_path || !Storage::exists($praktikum->panduan_path)) {
            abort(404, 'File panduan tidak ditemukan.');
        }

        return Storage::download($praktikum->panduan_path);
    }

    public function downloadTemplate(Praktikum $praktikum)
    {
        $this->authorize('view', $praktikum);

        if (!$praktikum->template_path || !Storage::exists($praktikum->template_path)) {
            abort(404, 'File template tidak ditemukan.');
        }

        return Storage::download($praktikum->template_path);
    }
}
