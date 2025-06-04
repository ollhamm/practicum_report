<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KelasManagementController extends Controller
{
    public function index()
    {
        $kelas = Kelas::with(['dosen', 'mahasiswa'])->latest()->paginate(10);
        return view('admin.kelas.index', compact('kelas'));
    }

    public function create()
    {
        $dosen = User::where('role', 'dosen')
            ->where('approved_by_admin', User::APPROVAL_APPROVED)
            ->get();
            
        $mahasiswa = User::where('role', 'mahasiswa')
            ->where('approved_by_admin', User::APPROVAL_APPROVED)
            ->get();
            
        return view('admin.kelas.create', compact('dosen', 'mahasiswa'));
    }

    public function store(Request $request)
    {
        \Log::info('Kelas store method called');
        \Log::info('Request data:', $request->all());

        $request->validate([
            'nama_kelas' => ['required', 'string', 'max:255'],
            'kode' => ['required', 'string', 'max:50', 'unique:kelas'],
            'tahun_ajaran' => ['required', 'string', 'max:20'],
            'semester' => ['required', 'in:ganjil,genap'],
            'angkatan' => ['required', 'string', 'max:4'],
            'dosen_ids' => ['required', 'array', 'min:1'],
            'dosen_ids.*' => ['exists:users,id'],
            'mahasiswa_ids' => ['required', 'array', 'min:1'],
            'mahasiswa_ids.*' => ['exists:users,id'],
        ]);

        DB::beginTransaction();
        try {
            \Log::info('Creating kelas with data:', [
                'nama_kelas' => $request->nama_kelas,
                'kode' => $request->kode,
                'tahun_ajaran' => $request->tahun_ajaran,
                'semester' => $request->semester,
                'angkatan' => $request->angkatan,
            ]);
            
            // Verify all selected users are approved
            $selectedDosen = User::whereIn('id', $request->dosen_ids)
                ->where('approved_by_admin', '!=', User::APPROVAL_APPROVED)
                ->exists();
                
            $selectedMahasiswa = User::whereIn('id', $request->mahasiswa_ids)
                ->where('approved_by_admin', '!=', User::APPROVAL_APPROVED)
                ->exists();
                
            if ($selectedDosen || $selectedMahasiswa) {
                throw new \Exception('Hanya user yang sudah disetujui yang dapat ditambahkan ke kelas.');
            }

            $kelas = Kelas::create([
                'nama_kelas' => $request->nama_kelas,
                'kode' => $request->kode,
                'tahun_ajaran' => $request->tahun_ajaran,
                'semester' => $request->semester,
                'angkatan' => $request->angkatan,
            ]);

            $kelas->dosen()->attach($request->dosen_ids);
            $kelas->mahasiswa()->attach($request->mahasiswa_ids);

            DB::commit();
            return redirect()->route('admin.kelas.index')
                ->with('success', 'Kelas berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Error creating kelas: ' . $e->getMessage());
            return back()->with('error', $e->getMessage())
                ->withInput();
        }
    }

    public function edit(Kelas $kela)
    {
        $dosen = User::where('role', 'dosen')->where('approved_by_admin', true)->get();
        $mahasiswa = User::where('role', 'mahasiswa')->where('approved_by_admin', true)->get();
        $selectedDosen = $kela->dosen->pluck('id')->toArray();
        $selectedMahasiswa = $kela->mahasiswa->pluck('id')->toArray();
        
        return view('admin.kelas.edit', compact('kela', 'dosen', 'mahasiswa', 'selectedDosen', 'selectedMahasiswa'));
    }

    public function update(Request $request, Kelas $kela)
    {
        $request->validate([
            'nama_kelas' => ['required', 'string', 'max:255'],
            'kode' => ['required', 'string', 'max:50', 'unique:kelas,kode,' . $kela->id],
            'tahun_ajaran' => ['required', 'string', 'max:20'],
            'semester' => ['required', 'in:ganjil,genap'],
            'angkatan' => ['required', 'string', 'max:4'],
            'dosen_ids' => ['required', 'array', 'min:1'],
            'dosen_ids.*' => ['exists:users,id'],
            'mahasiswa_ids' => ['required', 'array', 'min:1'],
            'mahasiswa_ids.*' => ['exists:users,id'],
        ]);

        DB::beginTransaction();
        try {
            $kela->update([
                'nama_kelas' => $request->nama_kelas,
                'kode' => $request->kode,
                'tahun_ajaran' => $request->tahun_ajaran,
                'semester' => $request->semester,
                'angkatan' => $request->angkatan,
            ]);

            $kela->dosen()->sync($request->dosen_ids);
            $kela->mahasiswa()->sync($request->mahasiswa_ids);

            DB::commit();
            return redirect()->route('admin.kelas.index')
                ->with('success', 'Kelas berhasil diupdate.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan saat mengupdate kelas.');
        }
    }

    public function destroy(Kelas $kela)
    {
        DB::beginTransaction();
        try {
            $kela->dosen()->detach();
            $kela->mahasiswa()->detach();
            $kela->delete();

            DB::commit();
            return back()->with('success', 'Kelas berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan saat menghapus kelas.');
        }
    }

    public function show(Kelas $kela)
    {
        $kela->load(['dosen', 'mahasiswa']);
        return view('admin.kelas.show', compact('kela'));
    }
} 