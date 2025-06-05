<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class DosenManagementController extends Controller
{
    public function index()
    {
        $dosen = User::where('role', 'dosen')
            ->where('approved_by_admin', User::APPROVAL_APPROVED)
            ->latest()
            ->paginate(1000);
        return view('admin.dosen.index', compact('dosen'));
    }

    public function edit(User $dosen)
    {
        return view('admin.dosen.edit', compact('dosen'));
    }

    public function update(Request $request, User $dosen)
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

        $dosen->update([
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

            $dosen->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('admin.dosen.index')
            ->with('success', 'Data dosen berhasil diupdate.');
    }

    public function destroy(User $dosen)
    {
        if ($dosen->id === Auth::user()->id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $dosen->delete();
        return back()->with('success', 'Data dosen berhasil dihapus.');
    }

    public function show(User $dosen)
    {
        return view('admin.dosen.show', compact('dosen'));
    }
}
