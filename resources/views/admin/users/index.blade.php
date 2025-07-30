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
            <div class="bg-white overflow-hidden shadow-sm rounded-sm">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Manajemen Pengguna</h2>
                        <div class="flex items-center gap-3">
                            <!-- Import Button -->
                            <button type="button" id="importBtn"
                                class="flex items-center justify-center transition-all duration-300 border border-green-500 px-4 py-2 rounded-sm text-green-500 hover:bg-green-500 hover:text-white text-sm">
                                <i class="fas fa-file-import mr-2"></i>
                                Import Pengguna
                            </button>

                            <!-- Create Button -->
                            <a href="{{ route('admin.users.create') }}"
                                class="flex items-center justify-center transition-all duration-300 border border-blue-500 px-4 py-2 rounded-sm text-blue-500 hover:bg-blue-500 hover:text-white text-sm">
                                <i class="fas fa-plus mr-2"></i>
                                Tambah Pengguna
                            </a>
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
                                    <th>Created At</th>
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
                                    <td class="py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $user->created_at ? $user->created_at->setTimezone('Asia/Jakarta')->format('d/m/Y H:i') : '-' }}
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

                                            <a href="{{ route('admin.users.edit', $user) }}"
                                                class="flex items-center justify-center transition-all duration-300 border border-yellow-500 p-2 rounded-sm text-yellow-500 hover:bg-yellow-500 hover:text-white w-8 h-8">
                                                <i class="fas fa-edit fa-md"></i>
                                            </a>

                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    class="text-red-500 flex transition-all duration-300 items-center justify-center w-8 h-8 border-red-500 border rounded-sm p-2 cursor-pointer hover:bg-red-500 hover:text-white delete-btn"
                                                    data-name="{{ $user->name }}">
                                                    <i class="fas fa-trash-alt fa-md"></i>
                                                </button>
                                            </form>

                                            @if($user->approved_by_admin == false)
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

    <!-- Import Modal -->
    <div id="importModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-sm shadow-lg max-w-md w-full">
                <div class="flex items-center justify-between p-6 border-b">
                    <h3 class="text-lg font-semibold text-gray-800">Import Pengguna</h3>
                    <button type="button" id="closeImportModal" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form action="{{ route('admin.users.import') }}" method="POST" enctype="multipart/form-data" class="p-6">
                    @csrf
                    <div class="mb-4">
                        <label for="import_file" class="block text-sm font-medium text-gray-700 mb-2">
                            Pilih File Excel (.xlsx, .xls)
                        </label>
                        <input type="file" name="file" id="import_file" accept=".xlsx,.xls" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div class="mb-4 p-3 bg-blue-50 rounded-sm">
                        <h4 class="text-sm font-medium text-blue-800 mb-2">Format File Excel:</h4>
                        <ul class="text-xs text-blue-700 space-y-1">
                            <li>• Kolom A: Nama</li>
                            <li>• Kolom B: Email</li>
                            <li>• Kolom C: NIM/NIP</li>
                            <li>• Kolom D: Role (admin/dosen/mahasiswa)</li>
                            <li>• Baris pertama adalah header</li>
                        </ul>
                        <div class="mt-3">
                            <a href="{{ asset('template_import_pengguna.xlsx') }}"
                                class="inline-flex items-center text-xs text-blue-600 hover:text-blue-800">
                                <i class="fas fa-download mr-1"></i>
                                Download Template Excel
                            </a>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="button" id="cancelImport"
                            class="px-4 py-2 text-sm border border-gray-300 text-gray-700 rounded-sm hover:bg-gray-500 hover:text-white transition-all duration-300">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 text-sm bg-blue-500 text-white rounded-sm hover:bg-blue-600 transition-all duration-300">
                            <i class="fas fa-upload mr-2"></i>
                            Import
                        </button>
                    </div>
                </form>
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
                [5, 'desc']
            ], // Sort by created_at column (index 5) descending
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
    document.addEventListener("DOMContentLoaded", function() {
        // Import modal functionality
        const importBtn = document.getElementById('importBtn');
        const importModal = document.getElementById('importModal');
        const closeImportModal = document.getElementById('closeImportModal');
        const cancelImport = document.getElementById('cancelImport');

        // Open import modal
        importBtn.addEventListener('click', function() {
            importModal.classList.remove('hidden');
        });

        // Close import modal
        function closeModal() {
            importModal.classList.add('hidden');
        }

        closeImportModal.addEventListener('click', closeModal);
        cancelImport.addEventListener('click', closeModal);

        // Close modal when clicking outside
        importModal.addEventListener('click', function(e) {
            if (e.target === importModal) {
                closeModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !importModal.classList.contains('hidden')) {
                closeModal();
            }
        });
    });
</script>