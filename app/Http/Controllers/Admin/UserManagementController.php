<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();


        // Filter by role
        if ($request->has('role') && in_array($request->role, ['admin', 'dosen', 'mahasiswa'])) {
            $query->where('role', $request->role);
        }

        // Filter by approval status
        // Filter by approval status
        if ($request->has('status') && in_array($request->status, ['1', '0'])) {
            $query->where('approved_by_admin', $request->status);
        }


        $users = $query->latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', 'in:admin,dosen,mahasiswa'],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        if ($request->has('password') && $request->password) {
            $request->validate([
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);

            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil diupdate.');
    }

    public function destroy(User $user)
    {
        if ($user->id === Auth::user()->id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();
        return back()->with('success', 'User berhasil dihapus.');
    }

    public function approve(User $user)
    {
        $user->update(['approved_by_admin' => true]);
        return back()->with('success', 'User berhasil disetujui.');
    }

    public function reject(User $user)
    {
        $user->update(['approved_by_admin' => false]);
        return back()->with('success', 'User berhasil ditolak.');
    }
}
