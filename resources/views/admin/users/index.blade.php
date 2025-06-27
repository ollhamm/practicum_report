<x-app-layout>
    <div class="py-6">
        <div class="px-2 mb-4">
            <ol class="flex w-full flex-wrap items-center">
                <li class="flex cursor-pointer items-center text-sm text-gray-600 transition-colors duration-300 hover:text-gray-400">
                    <a href="/admin/dashboard">Dashboard</a>
                    <span class="pointer-events-none mx-2 text-gray-600">
                        /
                    </span>
                </li>
                <li class="flex active items-center text-sm text-gray-500 transition-colors duration-300 ">
                    <span>Pengguna</span>
                    <span class="pointer-events-none mx-2 text-gray-600">
                        /
                    </span>
                </li>
                <li class="flex items-center text-sm text-gray-700 transition-colors duration-300">
                    <span>Manajemen Pengguna</span>
                </li>
            </ol>
        </div>
        <div class="w-full mx-auto px-2">
            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    {!! session('error') !!}
                </div>
            @endif
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm rounded-sm">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Manajemen Pengguna</h2>
                        <!-- add button import -->
                        <div class="flex justify-end gap-3">
                            <a href="#" id="openImportModal"
                                class="hover:bg-green-500 border border-green-500 text-green-500 hover:text-white text-sm px-4 py-2 rounded-sm transition-all duration-300">
                                <i class="fas fa-file-import"></i>
                                Import
                            </a>
                            <a href="{{ route('admin.users.create') }}"
                                class="hover:bg-blue-500 border border-blue-500 text-blue-500 hover:text-white text-sm px-4 py-2 rounded-sm transition-all duration-300">
                                <i class="fas fa-plus"></i>
                                Tambah Pengguna
                            </a>
                        </div>
                    </div>

                    <!-- Import Modal -->
                    <div id="importModal" class="fixed inset-0 z-50 flex items-center justify-center bg-white backdrop-blur-2xl bg-opacity-10 hidden">
                        <div class="bg-white rounded-md shadow-lg w-full max-w-md p-6 relative">
                            <button id="closeImportModal" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                            <h3 class="text-lg font-semibold mb-4">Import Pengguna dari Excel</h3>
                            <form action="{{ route('admin.users.import') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-4">
                                    <label for="file" class="block text-sm font-medium text-gray-700 mb-2">Pilih File Excel (.xlsx, .xls)</label>
                                    <input type="file" name="file" id="file" accept=".xlsx,.xls" required class="block w-full border border-gray-300 rounded-sm px-3 py-2">
                                </div>
                                <div class="flex justify-end gap-2">
                                    <button type="button" id="cancelImportModal" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-sm text-sm">Batal</button>
                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-sm text-sm">Import</button>
                                </div>
                                <div class="mt-4 text-xs text-gray-500">
                                    <b>Format kolom:</b> Nama, Email, NIM/NIP, Role<br>
                                    Semua pengguna akan otomatis <b>Approved</b>.<br>
                                    Email & NIM/NIP tidak boleh sama (baik di file maupun database).<br>
                                    Password default: <b>password123</b><br>
                                    <a href="{{ asset('template_import_pengguna.xlsx') }}" class="text-blue-600 underline mt-2 inline-block">Download template Excel</a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Custom Filters (Optional - can be removed if using DataTables built-in search) -->
                    <div class="mb-4 bg-gray-50 rounded-md">
                        <form method="GET" action="{{ route('admin.users.index') }}" class="mb-6 bg-gray-50 p-4 rounded-md">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Filter by Role</label>
                                    <select name="role" id="role"
                                        class="block w-full rounded-sm border-gray-300 bg-white py-2 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-gray-500">
                                        <option value="">Semua Roles</option>
                                        <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="dosen" {{ request('role') === 'dosen' ? 'selected' : '' }}>Dosen</option>
                                        <option value="mahasiswa" {{ request('role') === 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Filter by Status</label>
                                    <select name="status" id="status" class="block w-full rounded-sm border-gray-300 bg-white py-2 shadow-sm focus:outline-none focus:border-gray-500 focus:ring-gray-500">
                                        <option value="">Semua Status</option>
                                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                                    </select>

                                </div>

                                <div class="flex items-end justify-start gap-2">
                                    <button type="submit"
                                        class="border border-blue-500 hover:text-white transition-all duration-300 cursor-pointer hover:bg-blue-700 text-blue-500 text-sm font-medium py-2 px-4 rounded">
                                        Apply Filter
                                    </button>
                                    <a href="{{ route('admin.users.index') }}"
                                        class="border border-gray-500 hover:text-white transition-all duration-300 hover:bg-gray-500 text-gray-500 text-sm font-medium py-2 px-4 rounded">
                                        Clear
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Users DataTable -->
                    <div class="overflow-x-auto">
                        <div class="relative max-w-xs mb-4">
                            <i class="fas fa-search fa-sm text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2"></i>
                            <input type="text" id="customSearch"
                                class="w-full pl-9 pr-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:border-gray-400"
                                placeholder="Search..." autocomplete="off" />
                        </div>

                        <table id="usersTable" class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>NIP/NIM</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($users as $user)
                                <tr>
                                    <td class="py-4 whitespace-nowrap">
                                        <span class="text-gray-950 font-medium">
                                            {{ $user->name }}
                                        </span>
                                    </td>
                                    <td class="py-4 whitespace-nowrap">{{ $user->email }}</td>
                                    <td class="py-4 whitespace-nowrap">{{ $user->nip ?? '-' }}</td>
                                    <td class="py-4 whitespace-nowrap">
                                        {{ $user->role === 'admin' ? 'Admin' : ($user->role === 'dosen' ? 'Dosen' : 'Mahasiswa') }}
                                    </td>
                                    <td class="py-4 whitespace-nowrap">
                                        @php
                                        $currentStatus = match($user->approved_by_admin) {
                                        $statusData['approved']['value'] => 'approved',
                                        $statusData['rejected']['value'] => 'rejected',
                                        default => 'pending'
                                        };
                                        @endphp

                                        <span class="inline-flex text-xs rounded-sm p-1 {{ $statusData[$currentStatus]['class'] }}">
                                            {{ $statusData[$currentStatus]['text'] }}
                                        </span>
                                    </td>
                                    <td class="py-4 whitespace-nowrap text-sm">
                                        <div class="flex flex-row items-center justify-start gap-2">
                                            <form action="{{ route('admin.users.show', $user) }}" method="GET">
                                                @csrf
                                                <button type="submit"
                                                    class="text-purple-500 flex transition-all duration-300 items-center justify-center w-8 h-8 border-purple-500 border rounded-sm p-2 cursor-pointer hover:bg-purple-500 hover:text-white">
                                                    <i class="fas fa-eye fa-md"></i>
                                                </button>
                                            </form>
                                            @if($user->isApproved())
                                            {{-- Tampilkan hanya tombol Delete jika sudah disetujui --}}
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    class="text-red-500 flex transition-all duration-300 items-center justify-center w-8 h-8 border-red-500 border rounded-sm p-2 cursor-pointer hover:bg-red-500 hover:text-white delete-btn"
                                                    data-name="{{ $user->name }}">
                                                    <i class="fas fa-trash-alt fa-md"></i>
                                                </button>
                                            </form>
                                            @elseif($user->isRejected())
                                            {{-- Tampilkan hanya tombol Delete jika ditolak --}}
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    class="text-red-500 flex transition-all duration-300 items-center justify-center w-8 h-8 border-red-500 border rounded-sm p-2 cursor-pointer hover:bg-red-500 hover:text-white delete-btn"
                                                    data-name="{{ $user->name }}">
                                                    <i class="fas fa-trash-alt fa-md"></i>
                                                </button>
                                            </form>
                                            @elseif($user->isPending())
                                            {{-- Tampilkan Approve & Reject untuk status pending --}}
                                            <form action="{{ route('admin.users.approve', $user) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-green-500 transition-all duration-300 flex items-center justify-center w-8 h-8 border-green-500 border rounded-sm p-2 cursor-pointer hover:bg-green-500 hover:text-white">
                                                    <i class="fas fa-check fa-md"></i>
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.users.reject', $user) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-red-500 transition-all duration-300 flex items-center justify-center w-8 h-8 border-red-500 border rounded-sm p-2 cursor-pointer hover:bg-red-500 hover:text-white">
                                                    <i class="fas fa-times fa-md"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@if(session('error'))
<script>
    window.onload = function() {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Gagal!',
                icon: 'error',
                html: `{{ session('error') }}`,
                toast: true,
                position: 'top',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
            })
        } else {
            console.error('SweetAlert2 tidak dimuat');
            alert(`{{ session('error') }}`);
        }
    };
</script>
@endif

<script>
    document.addEventListener("DOMContentLoaded", function() {
        $("#customSearch").on("keyup", function() {
            usersTable.search(this.value).draw();
        });
        var usersTable = $("#usersTable").DataTable({
            info: false,
            responsive: true,
            dom: "trip",
            stripeClasses: [],
            order: [
                [4, 'desc'],
                [1, 'asc']
            ]
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const deleteBtns = document.querySelectorAll('.delete-btn');
        deleteBtns.forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');
                const name = this.dataset.name;

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    html: `User <span class="font-semibold">: ${name}</span> akan dihapus secara permanen!`,
                    showCancelButton: true,
                    confirmButtonColor: '#EF4444',
                    cancelButtonColor: '#9e9e9e',
                    cancelButtonText: 'Batal',
                    confirmButtonText: 'Ya, hapus!',
                    reverseButtons: true,
                    position: 'top',
                    customClass: {
                        title: 'swal-title-custom',
                        confirmButton: 'swal-confirm-custom',
                        cancelButton: 'swal-cancel-custom',
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const loading = document.getElementById('loading-overlay');
                        if (loading) {
                            loading.classList.remove('hidden');
                        }
                        setTimeout(() => {
                            form.submit();
                        }, 100);
                    }
                });
            });
        });
    });
</script>

<script>
    document.getElementById('openImportModal').onclick = function(e) {
        e.preventDefault();
        document.getElementById('importModal').classList.remove('hidden');
    };
    document.getElementById('closeImportModal').onclick = function() {
        document.getElementById('importModal').classList.add('hidden');
    };
    document.getElementById('cancelImportModal').onclick = function() {
        document.getElementById('importModal').classList.add('hidden');
    };
</script>