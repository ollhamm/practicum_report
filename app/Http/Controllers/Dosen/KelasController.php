<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::where('dosen_id', Auth::id())
            ->withCount(['mahasiswa', 'praktikum'])
            ->latest()
            ->paginate(10);

        return view('dosen.kelas.index', compact('kelas'));
    }

    public function create()
    {
        $mahasiswa = User::where('role', 'mahasiswa')
            ->where('approved_by_admin', true)
            ->orderBy('name')
            ->get();

        return view('dosen.kelas.create', compact('mahasiswa'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'kode' => ['required', 'string', 'max:50', 'unique:kelas'],
            'tahun_ajaran' => ['required', 'string', 'max:20'],
            'semester' => ['required', 'in:ganjil,genap'],
            'mahasiswa' => ['required', 'array', 'min:1'],
            'mahasiswa.*' => ['exists:users,id'],
        ]);

        $kelas = Kelas::create([
            'nama' => $request->nama,
            'kode' => $request->kode,
            'tahun_ajaran' => $request->tahun_ajaran,
            'semester' => $request->semester,
            'dosen_id' => Auth::id(),
        ]);

        $kelas->mahasiswa()->attach($request->mahasiswa);

        return redirect()->route('dosen.kelas.index')
            ->with('success', 'Kelas berhasil dibuat.');
    }

    public function show(Kelas $kela)
    {
        $this->authorize('view', $kela);

        $kela->load(['mahasiswa', 'praktikum' => function($query) {
            $query->withCount('laporan_praktikum');
        }]);

        return view('dosen.kelas.show', [
            'kelas' => $kela
        ]);
    }

    public function edit(Kelas $kela)
    {
        $this->authorize('update', $kela);

        $mahasiswa = User::where('role', 'mahasiswa')
            ->where('approved_by_admin', true)
            ->orderBy('name')
            ->get();

        $selectedMahasiswa = $kela->mahasiswa->pluck('id')->toArray();

        return view('dosen.kelas.edit', [
            'kelas' => $kela,
            'mahasiswa' => $mahasiswa,
            'selectedMahasiswa' => $selectedMahasiswa,
        ]);
    }

    public function update(Request $request, Kelas $kela)
    {
        $this->authorize('update', $kela);

        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'kode' => ['required', 'string', 'max:50', 'unique:kelas,kode,' . $kela->id],
            'tahun_ajaran' => ['required', 'string', 'max:20'],
            'semester' => ['required', 'in:ganjil,genap'],
            'mahasiswa' => ['required', 'array', 'min:1'],
            'mahasiswa.*' => ['exists:users,id'],
        ]);

        $kela->update([
            'nama' => $request->nama,
            'kode' => $request->kode,
            'tahun_ajaran' => $request->tahun_ajaran,
            'semester' => $request->semester,
        ]);

        $kela->mahasiswa()->sync($request->mahasiswa);

        return redirect()->route('dosen.kelas.index')
            ->with('success', 'Kelas berhasil diupdate.');
    }

    public function destroy(Kelas $kela)
    {
        $this->authorize('delete', $kela);

        $kela->delete();

        return redirect()->route('dosen.kelas.index')
            ->with('success', 'Kelas berhasil dihapus.');
    }
}
