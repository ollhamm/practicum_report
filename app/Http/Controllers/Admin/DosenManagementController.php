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
            'email' => ['required', 'email', Rule::unique('users')->ignore($dosen->id)],
        ]);

        $dosen->update([
            'name' => $request->name,
            'email' => $request->email,
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
}
