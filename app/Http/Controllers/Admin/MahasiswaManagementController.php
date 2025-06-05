<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class MahasiswaManagementController extends Controller
{
    public function index()
    {
        $mahasiswa = User::where('role', 'mahasiswa')
            ->where('approved_by_admin', User::APPROVAL_APPROVED)
            ->latest()
            ->paginate(perPage: 1000);
        return view('admin.mahasiswa.index', compact('mahasiswa'));
    }
    public function edit(User $mahasiswa)
    {
        return view('admin.mahasiswa.edit', compact('mahasiswa'));
    }

    public function update(Request $request, User $mahasiswa)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'tempat_lahir' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'agama' => ['required', 'string', 'max:255'],
            'nomor_telepon' => ['required', 'string', 'max:20'],
            'alamat_ktp' => ['required', 'string'],
        ]);

        $mahasiswa->update([
            'name' => $request->name,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'agama' => $request->agama,
            'nomor_telepon' => $request->nomor_telepon,
            'alamat_ktp' => $request->alamat_ktp,
        ]);

        if ($request->has('password') && $request->password) {
            $request->validate([
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);

            $mahasiswa->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('admin.mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil diupdate.');
    }

    public function destroy(User $mahasiswa)
    {
        if ($mahasiswa->id === Auth::user()->id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $mahasiswa->delete();
        return back()->with('success', 'Data mahasiswa berhasil dihapus.');
    }

    public function approve(User $mahasiswa)
    {
        $mahasiswa->update([
            'approved_by_admin' => true
        ]);

        return back()->with('success', 'Mahasiswa berhasil disetujui.');
    }

    public function reject(User $mahasiswa)
    {
        $mahasiswa->update([
            'approved_by_admin' => false
        ]);

        return back()->with('success', 'Mahasiswa berhasil ditolak.');
    }

    public function show(User $mahasiswa)
    {
        return view('admin.mahasiswa.show', compact('mahasiswa'));
    }
}
