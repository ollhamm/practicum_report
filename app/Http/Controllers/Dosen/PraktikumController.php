<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Praktikum;
use App\Models\Kelas;
use App\Models\User;
use App\Models\LaporanPraktikum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class PraktikumController extends Controller
{
    public function index()
    {
        $praktikums = Praktikum::with(['kelas'])
            ->where('dosen_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('dosen.praktikum.index', compact('praktikums'));
    }

    public function create(Request $request)
    {
        $kelas = null;
        $kelas_list = Auth::user()->kelas;
        
        // Jika ada kelas_id dari request, load data kelas
        if ($request->has('kelas_id')) {
            $kelas = $kelas_list->find($request->kelas_id);
            
            // Jika kelas tidak ditemukan atau dosen tidak memiliki akses
            if (!$kelas) {
                return redirect()
                    ->route('dosen.praktikum.create')
                    ->with('error', 'Kelas tidak ditemukan atau Anda tidak memiliki akses.');
            }
        }

        return view('dosen.praktikum.create', compact('kelas_list', 'kelas'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'judul' => ['required', 'string', 'max:255'],
                'deskripsi' => ['required', 'string'],
                'kelas_id' => ['required', 'exists:kelas,id'],
                'deadline' => ['required', 'date'],
                'panduan' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
                'template' => ['nullable', 'file', 'mimes:doc,docx,pdf', 'max:10240'],
            ]);

            // Verify that the dosen is assigned to this kelas
            if (!Auth::user()->kelas->contains('id', $validated['kelas_id'])) {
                return back()
                    ->withInput()
                    ->with('error', 'Anda tidak memiliki akses ke kelas ini.');
            }

            DB::beginTransaction();

            $praktikum = new Praktikum([
                'judul' => $validated['judul'],
                'deskripsi' => $validated['deskripsi'],
                'kelas_id' => $validated['kelas_id'],
                'dosen_id' => Auth::id(),
                'deadline' => $validated['deadline'],
            ]);

            // Handle file uploads
            if ($request->hasFile('panduan')) {
                $path = $request->file('panduan')->store('panduan');
                $praktikum->panduan_path = $path;
            }

            if ($request->hasFile('template')) {
                $path = $request->file('template')->store('template');
                $praktikum->template_path = $path;
            }

            $praktikum->save();

            DB::commit();

            // Redirect ke detail kelas jika pembuatan dari halaman kelas
            if ($request->has('from_kelas')) {
                return redirect()
                    ->route('dosen.kelas.show', $validated['kelas_id'])
                    ->with('success', 'Praktikum berhasil dibuat.');
            }

            return redirect()
                ->route('dosen.praktikum.index')
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

    public function show(Praktikum $praktikum)
    {
        // Verify that the dosen owns this praktikum
        if ($praktikum->dosen_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $praktikum->load([
            'kelas.mahasiswa',
            'laporan_praktikum.mahasiswa',
        ]);

        return view('dosen.praktikum.show', compact('praktikum'));
    }

    public function edit(Praktikum $praktikum)
    {
        // Verify that the dosen owns this praktikum
        if ($praktikum->dosen_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $kelas_list = Auth::user()->kelas;
        return view('dosen.praktikum.edit', compact('praktikum', 'kelas_list'));
    }

    public function update(Request $request, Praktikum $praktikum)
    {
        // Verify that the dosen owns this praktikum
        if ($praktikum->dosen_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $validated = $request->validate([
                'judul' => ['required', 'string', 'max:255'],
                'deskripsi' => ['required', 'string'],
                'kelas_id' => ['required', 'exists:kelas,id'],
                'deadline' => ['required', 'date'],
            ]);

            // Verify that the dosen is assigned to this kelas
            if (!Auth::user()->kelas->contains('id', $validated['kelas_id'])) {
                return back()
                    ->withInput()
                    ->with('error', 'Anda tidak memiliki akses ke kelas ini.');
            }

            DB::beginTransaction();

            $praktikum->update([
                'judul' => $validated['judul'],
                'deskripsi' => $validated['deskripsi'],
                'kelas_id' => $validated['kelas_id'],
                'deadline' => $validated['deadline'],
            ]);

            DB::commit();

            return redirect()
                ->route('dosen.praktikum.index')
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

    public function destroy(Praktikum $praktikum)
    {
        // Verify that the dosen owns this praktikum
        if ($praktikum->dosen_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
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

    public function penilaian(Praktikum $praktikum, User $mahasiswa)
    {
        // Verify that the dosen owns this praktikum
        if ($praktikum->dosen_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Get laporan praktikum
        $laporan = LaporanPraktikum::where('praktikum_id', $praktikum->id)
            ->where('mahasiswa_id', $mahasiswa->id)
            ->firstOrFail();

        return view('dosen.praktikum.penilaian', compact('praktikum', 'mahasiswa', 'laporan'));
    }

    public function submitPenilaian(Request $request, LaporanPraktikum $laporan)
    {
        Log::info('Submitting assessment:', [
            'request_data' => $request->all(),
            'laporan_id' => $laporan->id,
            'praktikum_id' => $laporan->praktikum_id,
            'mahasiswa_id' => $laporan->mahasiswa_id
        ]);

        // Verify that the dosen owns this praktikum
        if ($laporan->praktikum->dosen_id !== Auth::id()) {
            Log::warning('Unauthorized assessment attempt:', [
                'dosen_id' => Auth::id(),
                'praktikum_dosen_id' => $laporan->praktikum->dosen_id
            ]);
            abort(403, 'Unauthorized action.');
        }

        try {
            $validated = $request->validate([
                'nilai' => ['required', 'numeric', 'min:0', 'max:100'],
                'catatan' => ['nullable', 'string'],
                'file_koreksi' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
            ]);

            Log::info('Validated data:', $validated);

            DB::beginTransaction();

            // Handle file upload if provided
            if ($request->hasFile('file_koreksi')) {
                Log::info('Processing file upload');
                // Delete old file if exists
                if ($laporan->file_koreksi_path) {
                    Storage::delete($laporan->file_koreksi_path);
                }
                
                $path = $request->file('file_koreksi')->store('koreksi');
                $laporan->file_koreksi_path = $path;
                Log::info('File uploaded to: ' . $path);
            }

            $laporan->nilai = $validated['nilai'];
            $laporan->catatan = $validated['catatan'];
            $laporan->status = 'reviewed';
            $laporan->save();

            Log::info('Laporan updated successfully', [
                'laporan_id' => $laporan->id,
                'nilai' => $laporan->nilai,
                'status' => $laporan->status
            ]);

            DB::commit();

            return redirect()
                ->route('dosen.praktikum.show', $laporan->praktikum)
                ->with('success', 'Penilaian berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error submitting assessment:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan penilaian: ' . $e->getMessage());
        }
    }

    public function viewLaporan(LaporanPraktikum $laporan)
    {
        // Verify that the dosen owns this praktikum
        if ($laporan->praktikum->dosen_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if (!Storage::exists($laporan->file_path)) {
            abort(404, 'File tidak ditemukan.');
        }

        $file = Storage::get($laporan->file_path);
        $type = Storage::mimeType($laporan->file_path);

        return Response::make($file, 200, [
            'Content-Type' => $type,
            'Content-Disposition' => 'inline; filename="laporan.pdf"'
        ]);
    }

    public function downloadKoreksi(LaporanPraktikum $laporan)
    {
        // Verify that the dosen owns this praktikum
        if ($laporan->praktikum->dosen_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if (!$laporan->file_koreksi_path || !Storage::exists($laporan->file_koreksi_path)) {
            abort(404, 'File koreksi tidak ditemukan.');
        }

        return Storage::download($laporan->file_koreksi_path, 'koreksi.pdf');
    }
}
