<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\LaporanPraktikum;
use App\Models\Praktikum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
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
            ->get();

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

    // file download and view panduan and template
    // Ganti method downloadPanduan dan downloadTemplate dalam LaporanController

    public function downloadPanduan(Praktikum $praktikum)
    {
        $this->authorize('view', $praktikum);

        if (!$praktikum->panduan_path || !Storage::exists($praktikum->panduan_path)) {
            abort(404, 'File panduan tidak ditemukan.');
        }

        return Storage::download($praktikum->panduan_path);
    }

    // view panduan
    public function viewPanduan(Praktikum $praktikum)
    {
        // Verify mahasiswa is enrolled in the class untuk praktikum ini
        $this->authorize('view', $praktikum);

        if (!$praktikum) {
            abort(403, 'Anda tidak memiliki akses ke praktikum ini.');
        }
        if (!$praktikum->panduan_path || !Storage::exists($praktikum->panduan_path)) {
            abort(404, 'File panduan tidak ditemukan.');
        }
        $file = Storage::get($praktikum->panduan_path);
        $type = Storage::mimeType($praktikum->panduan_path);
        $filename = basename($praktikum->panduan_path);
        return Response::make($file, 200, [
            'Content-Type' => $type,
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ]);
    }

    public function downloadTemplate(Praktikum $praktikum)
    {
        // Verify mahasiswa is enrolled in the class untuk praktikum ini
        $isEnrolled = $praktikum->whereHas('kelas.mahasiswa', function ($query) {
            $query->where('users.id', Auth::id());
        })->exists();

        if (!$isEnrolled) {
            abort(403, 'Anda tidak memiliki akses ke praktikum ini.');
        }

        if (!$praktikum->template_path || !Storage::exists($praktikum->template_path)) {
            abort(404, 'File template tidak ditemukan.');
        }

        return Storage::download($praktikum->template_path);
    }

    // view template
    public function viewTemplate(Praktikum $praktikum)
    {
        // Verify mahasiswa is enrolled in the class untuk praktikum ini
        $isEnrolled = $praktikum->whereHas('kelas.mahasiswa', function ($query) {
            $query->where('users.id', Auth::id());
        })->exists();
        if (!$isEnrolled) {
            abort(403, 'Anda tidak memiliki akses ke praktikum ini.');
        }
        if (!$praktikum->template_path || !Storage::exists($praktikum->template_path)) {
            abort(404, 'File template tidak ditemukan.');
        }
        $file = Storage::get($praktikum->template_path);
        $type = Storage::mimeType($praktikum->template_path);
        $filename = basename($praktikum->template_path);
        return Response::make($file, 200, [
            'Content-Type' => $type,
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ]);
    }






    // file download and view methods
    // These methods handle downloading and viewing files for the laporan praktikum
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
        $this->authorize('view', $laporan);

        if (!$laporan->file_path || !Storage::exists($laporan->file_path)) {
            abort(404, 'File laporan tidak ditemukan.');
        }

        $file = Storage::get($laporan->file_path);
        $type = Storage::mimeType($laporan->file_path);
        $filename = basename($laporan->file_path);

        return Response::make($file, 200, [
            'Content-Type' => $type,
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ]);
    }

    public function viewKoreksiFile(LaporanPraktikum $laporan)
    {
        $this->authorize('downloadKoreksi', $laporan);

        if (!$laporan->file_koreksi_path || !Storage::exists($laporan->file_koreksi_path)) {
            abort(404, 'File koreksi tidak ditemukan.');
        }

        $file = Storage::get($laporan->file_koreksi_path);
        $type = Storage::mimeType($laporan->file_koreksi_path);
        $filename = basename($laporan->file_koreksi_path);

        return Response::make($file, 200, [
            'Content-Type' => $type,
            'Content-Disposition' => 'inline; filename="koreksi_' . $filename . '"'
        ]);
    }
}
