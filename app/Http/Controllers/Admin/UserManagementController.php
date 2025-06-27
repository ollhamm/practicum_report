<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

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


        $users = $query->latest()->get();

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

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:admin,dosen,mahasiswa'],
            'nip' => ['required', 'string', 'max:50', 'unique:users'],
            'tempat_lahir' => ['nullable', 'string', 'max:255'],
            'tanggal_lahir' => ['nullable', 'date'],
            'jenis_kelamin' => ['nullable', 'in:L,P'],
            'agama' => ['nullable', 'string', 'max:50'],
            'nomor_telepon' => ['nullable', 'string', 'max:20'],
            'alamat_ktp' => ['nullable', 'string', 'max:500'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'nip' => $request->nip,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'agama' => $request->agama,
            'nomor_telepon' => $request->nomor_telepon,
            'alamat_ktp' => $request->alamat_ktp,
            'approved_by_admin' => User::APPROVAL_APPROVED, // Langsung approved karena dibuat oleh admin
            'approved_at' => now(),
            'email_verified_at' => now(), // Langsung verified karena dibuat oleh admin
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan dan langsung disetujui.');
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

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        $file = $request->file('file');
        $data = \PhpOffice\PhpSpreadsheet\IOFactory::load($file)->getActiveSheet()->toArray(null, true, true, true);

        $header = array_map('strtolower', $data[1]);
        $rows = array_slice($data, 1);
        $errors = [];
        $emails = [];
        $nips = [];
        $imported = 0;

        foreach ($rows as $i => $row) {
            $rowData = array_combine($header, $row);
            $rowNum = $i + 2; // Excel row number (header is row 1)

            $email = trim($rowData['email'] ?? '');
            $nip = trim($rowData['nim/nip'] ?? '');
            $name = trim($rowData['nama'] ?? '');
            $role = trim(strtolower($rowData['role'] ?? ''));

            if (!$name || !$email || !$nip || !$role) {
                $errors[] = "Baris $rowNum: Data tidak lengkap.";
                continue;
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Baris $rowNum: Email tidak valid.";
                continue;
            }
            if (in_array($email, $emails)) {
                $errors[] = "Baris $rowNum: Email duplikat di file.";
                continue;
            }
            if (in_array($nip, $nips)) {
                $errors[] = "Baris $rowNum: NIM/NIP duplikat di file.";
                continue;
            }
            if (User::where('email', $email)->exists()) {
                $errors[] = "Baris $rowNum: Email sudah terdaftar.";
                continue;
            }
            if (User::where('nip', $nip)->exists()) {
                $errors[] = "Baris $rowNum: NIM/NIP sudah terdaftar.";
                continue;
            }
            if (!in_array($role, ['admin', 'dosen', 'mahasiswa'])) {
                $errors[] = "Baris $rowNum: Role tidak valid (admin/dosen/mahasiswa).";
                continue;
            }

            $emails[] = $email;
            $nips[] = $nip;

            User::create([
                'name' => $name,
                'email' => $email,
                'password' => \Hash::make('password123'), // default password
                'role' => $role,
                'nip' => $nip,
                'approved_by_admin' => User::APPROVAL_APPROVED,
                'approved_at' => now(),
                'email_verified_at' => now(),
            ]);
            $imported++;
        }

        if ($errors) {
            return redirect()->route('admin.users.index')->with('error', join('<br>', $errors));
        }
        return redirect()->route('admin.users.index')->with('success', "$imported pengguna berhasil diimport.");
    }
}
