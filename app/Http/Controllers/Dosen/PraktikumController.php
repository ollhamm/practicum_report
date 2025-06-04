<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Praktikum;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PraktikumController extends Controller
{
    public function index()
    {
        $praktikums = Praktikum::whereHas('kelas', function($query) {
                $query->where('dosen_id', Auth::id());
            })
            ->with('kelas')
            ->withCount('laporan_praktikum')
            ->latest()
            ->paginate(10);

        return view('dosen.praktikum.index', compact('praktikums'));
    }

    public function create(Request $request)
    {
        $kelas = null;
        if ($request->has('kelas_id')) {
            $kelas = Kelas::where('dosen_id', Auth::id())
                ->findOrFail($request->kelas_id);
        }

        $kelas_list = Kelas::where('dosen_id', Auth::id())
            ->orderBy('tahun_ajaran', 'desc')
            ->orderBy('semester', 'desc')
            ->get();

        return view('dosen.praktikum.create', [
            'kelas' => $kelas,
            'kelas_list' => $kelas_list,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'deadline' => ['required', 'date', 'after:now'],
            'kelas_id' => ['required', 'exists:kelas,id'],
            'panduan' => ['nullable', 'file', 'mimes:pdf', 'max:10240'], // max 10MB
            'template' => ['nullable', 'file', 'mimes:doc,docx,pdf', 'max:10240'],
        ]);

        // Verify kelas belongs to authenticated dosen
        $kelas = Kelas::where('dosen_id', Auth::id())
            ->findOrFail($request->kelas_id);

        $praktikum = Praktikum::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'deadline' => $request->deadline,
            'kelas_id' => $kelas->id,
        ]);

        // Handle file uploads
        if ($request->hasFile('panduan')) {
            $path = $request->file('panduan')->store('panduan');
            $praktikum->update(['panduan_path' => $path]);
        }

        if ($request->hasFile('template')) {
            $path = $request->file('template')->store('template');
            $praktikum->update(['template_path' => $path]);
        }

        return redirect()->route('dosen.kelas.show', $kelas)
            ->with('success', 'Praktikum berhasil dibuat.');
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
        $this->authorize('update', $praktikum);

        $kelas_list = Kelas::where('dosen_id', Auth::id())
            ->orderBy('tahun_ajaran', 'desc')
            ->orderBy('semester', 'desc')
            ->get();

        return view('dosen.praktikum.edit', [
            'praktikum' => $praktikum,
            'kelas_list' => $kelas_list,
        ]);
    }

    public function update(Request $request, Praktikum $praktikum)
    {
        $this->authorize('update', $praktikum);

        $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'deadline' => ['required', 'date'],
            'kelas_id' => ['required', 'exists:kelas,id'],
            'panduan' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
            'template' => ['nullable', 'file', 'mimes:doc,docx,pdf', 'max:10240'],
        ]);

        // Verify kelas belongs to authenticated dosen
        $kelas = Kelas::where('dosen_id', Auth::id())
            ->findOrFail($request->kelas_id);

        $praktikum->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'deadline' => $request->deadline,
            'kelas_id' => $kelas->id,
        ]);

        // Handle file uploads
        if ($request->hasFile('panduan')) {
            if ($praktikum->panduan_path) {
                Storage::delete($praktikum->panduan_path);
            }
            $path = $request->file('panduan')->store('panduan');
            $praktikum->update(['panduan_path' => $path]);
        }

        if ($request->hasFile('template')) {
            if ($praktikum->template_path) {
                Storage::delete($praktikum->template_path);
            }
            $path = $request->file('template')->store('template');
            $praktikum->update(['template_path' => $path]);
        }

        return redirect()->route('dosen.kelas.show', $kelas)
            ->with('success', 'Praktikum berhasil diupdate.');
    }

    public function destroy(Praktikum $praktikum)
    {
        $this->authorize('delete', $praktikum);

        $kelas = $praktikum->kelas;

        // Delete associated files
        if ($praktikum->panduan_path) {
            Storage::delete($praktikum->panduan_path);
        }
        if ($praktikum->template_path) {
            Storage::delete($praktikum->template_path);
        }

        $praktikum->delete();

        return redirect()->route('dosen.kelas.show', $kelas)
            ->with('success', 'Praktikum berhasil dihapus.');
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
