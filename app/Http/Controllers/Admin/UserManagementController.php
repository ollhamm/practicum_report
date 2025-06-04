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

        // Filter by approval status using enum values
        if ($request->has('status')) {
            if ($request->status === 'pending') {
                $query->where('approved_by_admin', User::APPROVAL_PENDING);
            } elseif ($request->status === 'approved') {
                $query->where('approved_by_admin', User::APPROVAL_APPROVED);
            } elseif ($request->status === 'rejected') {
                $query->where('approved_by_admin', User::APPROVAL_REJECTED);
            }
        }

        $users = $query->latest()->paginate(10);

        // Pass status data to view for cleaner blade template
        $statusData = [
            'approved' => [
                'value' => User::APPROVAL_APPROVED,
                'text' => 'Approved',
                'class' => 'bg-green-500 text-white'
            ],
            'rejected' => [
                'value' => User::APPROVAL_REJECTED,
                'text' => 'Rejected',
                'class' => 'bg-red-500 text-white'
            ],
            'pending' => [
                'value' => User::APPROVAL_PENDING,
                'text' => 'Pending',
                'class' => 'bg-yellow-500 text-white'
            ]
        ];

        return view('admin.users.index', compact('users', 'statusData'));
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
            'nip' => ['required', 'string', 'max:50', Rule::unique('users')->ignore($user->id)],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'nip' => $request->nip,
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
        $user->update([
            'approved_by_admin' => User::APPROVAL_APPROVED,
            'approved_at' => now()
        ]);
        return back()->with('success', 'User berhasil disetujui.');
    }

    public function reject(User $user)
    {
        try {
            $user->update([
                'approved_by_admin' => User::APPROVAL_REJECTED,
                'approved_at' => null
            ]);

            return back()->with('success', 'User berhasil ditolak.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menolak user: ' . $e->getMessage());
        }
    }

    public function setPending(User $user)
    {
        try {
            $user->update([
                'approved_by_admin' => User::APPROVAL_PENDING,
                'approved_at' => null
            ]);

            return back()->with('success', 'Status user berhasil diubah ke pending.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengubah status user: ' . $e->getMessage());
        }
    }
}
