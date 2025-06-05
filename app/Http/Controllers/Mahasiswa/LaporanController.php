<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\LaporanPraktikum;
use App\Models\Praktikum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    public function index()
    {
        $praktikums = Praktikum::whereHas('kelas.mahasiswa', function ($query) {
            $query->where('users.id', Auth::id());
        })
            ->with(['kelas', 'laporan_praktikum' => function ($query) {
                $query->where('mahasiswa_id', Auth::id());
            }])
            ->latest()
            ->paginate(10);

        return view('mahasiswa.laporan.index', compact('praktikums'));
    }

    public function create(Request $request)
    {
        $praktikum = Praktikum::whereHas('kelas.mahasiswa', function ($query) {
            $query->where('users.id', Auth::id());
        })
            ->findOrFail($request->praktikum_id);

        return view('mahasiswa.laporan.create', compact('praktikum'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'praktikum_id' => ['required', 'exists:praktikum,id'],
            'file' => ['required', 'file', 'mimes:pdf', 'max:10240'], // max 10MB
            'catatan' => ['nullable', 'string'],
        ]);

        // Verify mahasiswa is enrolled in the class
        $praktikum = Praktikum::whereHas('kelas.mahasiswa', function ($query) {
            $query->where('users.id', Auth::id());
        })
            ->findOrFail($request->praktikum_id);

        // Check if laporan already exists
        $existingLaporan = LaporanPraktikum::where('praktikum_id', $praktikum->id)
            ->where('mahasiswa_id', Auth::id())
            ->first();

        if ($existingLaporan) {
            return redirect()->back()
                ->withErrors(['error' => 'Anda sudah mengumpulkan laporan untuk praktikum ini.']);
        }

        // Store file
        $path = $request->file('file')->store('laporan');

        // Create laporan
        LaporanPraktikum::create([
            'praktikum_id' => $praktikum->id,
            'mahasiswa_id' => Auth::id(),
            'file_path' => $path,
            'catatan' => $request->catatan,
            'status' => 'submitted',
        ]);

        return redirect()->route('mahasiswa.laporan.index')
            ->with('success', 'Laporan praktikum berhasil dikumpulkan.');
    }

    public function show(LaporanPraktikum $laporan)
    {
        $this->authorize('view', $laporan);

        $laporan->load(['praktikum.kelas']);

        return view('mahasiswa.laporan.show', compact('laporan'));
    }

    public function viewKoreksi(LaporanPraktikum $laporan)
    {
        $this->authorize('view', $laporan);

        return view('mahasiswa.laporan.koreksi', compact('laporan'));
    }

    public function edit(LaporanPraktikum $laporan)
    {
        $this->authorize('update', $laporan);

        return view('mahasiswa.laporan.edit', compact('laporan'));
    }

    public function update(Request $request, LaporanPraktikum $laporan)
    {
        $this->authorize('update', $laporan);

        $request->validate([
            'file' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
            'catatan' => ['nullable', 'string'],
        ]);

        if ($request->hasFile('file')) {
            // Delete old file
            Storage::delete($laporan->file_path);

            // Store new file
            $path = $request->file('file')->store('laporan');
            $laporan->file_path = $path;
        }

        $laporan->catatan = $request->catatan;
        $laporan->save();

        return redirect()->route('mahasiswa.laporan.show', $laporan)
            ->with('success', 'Laporan praktikum berhasil diupdate.');
    }

    public function destroy(LaporanPraktikum $laporan)
    {
        $this->authorize('delete', $laporan);

        // Delete file
        Storage::delete($laporan->file_path);

        $laporan->delete();

        return redirect()->route('mahasiswa.laporan.index')
            ->with('success', 'Laporan praktikum berhasil dihapus.');
    }

    public function download(LaporanPraktikum $laporan)
    {
        $this->authorize('view', $laporan);

        if (!Storage::exists($laporan->file_path)) {
            abort(404, 'File laporan tidak ditemukan.');
        }

        return Storage::download($laporan->file_path);
    }

    public function downloadKoreksi(LaporanPraktikum $laporan)
    {
        $this->authorize('downloadKoreksi', $laporan);

        if (!$laporan->file_koreksi_path || !Storage::exists($laporan->file_koreksi_path)) {
            abort(404, 'File koreksi tidak ditemukan.');
        }

        return Storage::download($laporan->file_koreksi_path, 'koreksi_' . $laporan->id . '.pdf');
    }

    public function viewFile(LaporanPraktikum $laporan)
    {
        // Otomatis aman karena scoped binding (lihat route di bawah)
        // Tapi tetap cek tambahan untuk jaga-jaga
        if ($laporan->mahasiswa_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        // Pastikan file ada
        if (!Storage::disk('public')->exists($laporan->file_path)) {
            abort(404, 'File laporan tidak ditemukan.');
        }

        $filePath = Storage::disk('public')->path($laporan->file_path);

        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="laporan.pdf"'
        ]);
    }

    public function viewKoreksiFile(LaporanPraktikum $laporan)
    {
        $this->authorize('downloadKoreksi', $laporan);

        if (!$laporan->file_koreksi_path || !Storage::exists($laporan->file_koreksi_path)) {
            abort(404, 'File koreksi tidak ditemukan.');
        }

        return response()->file(Storage::path($laporan->file_koreksi_path));
    }
}
