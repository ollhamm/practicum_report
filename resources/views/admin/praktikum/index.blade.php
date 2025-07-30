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
                    <span>Praktikum</span>
                    <span class="pointer-events-none mx-2 text-gray-600">
                        /
                    </span>
                </li>
                <li class="flex items-center text-sm text-gray-700 transition-colors duration-300">
                    <span>Manajemen Praktikum</span>
                </li>
            </ol>
        </div>
        <div class="w-full mx-auto px-2">
            <div class="bg-white overflow-hidden shadow-sm rounded-sm">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Manajemen Praktikum</h2>
                        <a href="{{ route('admin.praktikum.create') }}"
                            class=" hover:bg-blue-500 border border-blue-500 text-blue-500 hover:text-white text-sm px-4 py-2 rounded-sm transition-all duration-300">
                            <i class="fas fa-plus fa-sm mr-1"></i>
                            Tambah Praktikum
                        </a>
                    </div>

                    <!-- Praktikum DataTable -->
                    <div class="overflow-x-auto">
                        <div class="relative max-w-xs mb-4">
                            <i class="fas fa-search fa-sm text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2"></i>
                            <input type="text" id="customSearch"
                                class="w-full pl-9 pr-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:border-gray-400"
                                placeholder="Search..." autocomplete="off" />
                        </div>
                        <table id="praktikumTable" class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th>Judul</th>
                                    <th>Kelas</th>
                                    <th>Mata Kuliah</th>
                                    <th>Dosen</th>
                                    <th>Deadline</th>
                                    <th>Updated At</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($praktikums as $index => $praktikum)
                                <tr>
                                    <td class="py-4 whitespace-nowrap">
                                        <span class="text-gray-950 font-medium">
                                            {{ $praktikum->judul }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $praktikum->kelas->nama_kelas }}</div>
                                        <div class="text-sm text-gray-500">{{ $praktikum->kelas->kode }}</div>
                                    </td>
                                    <td class="py-4 whitespace-nowrap">
                                        <span class="text-gray-900">
                                            {{ !empty($praktikum->matakuliah) ? $praktikum->matakuliah : '-' }}
                                        </span>

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($praktikum->dosen)
                                        <div class="text-sm text-gray-900">
                                            {{ $praktikum->dosen->name }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $praktikum->dosen->nip ?? '-' }}
                                        </div>
                                        @else
                                        <div class="text-sm text-gray-500">
                                            Dosen belum ditentukan
                                        </div>
                                        @endif
                                    </td>
                                    <td class="py-4 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($praktikum->deadline)->locale('id')->translatedFormat('l, d F Y H:i') }}
                                    </td>
                                    <td class="py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $praktikum->updated_at ? $praktikum->updated_at->setTimezone('Asia/Jakarta')->format('d/m/Y H:i') : '-' }}
                                    </td>

                                    <td class="py-4 whitespace-nowrap text-sm">
                                        <div class="flex flex-row items-center justify-start gap-2">
                                            <a href="{{ route('admin.praktikum.edit', $praktikum) }}"
                                                class="flex items-center justify-center transition-all duration-300 border border-yellow-500 p-2 rounded-sm text-yellow-500 hover:bg-yellow-500 hover:text-white w-8 h-8">
                                                <i class="fas fa-edit fa-md"></i>
                                            </a>

                                            <a href="{{ route('admin.praktikum.show', $praktikum) }}"
                                                class="flex items-center justify-center transition-all duration-300 border border-purple-500 p-2 rounded-sm text-purple-500 hover:bg-purple-500 hover:text-white w-8 h-8">
                                                <i class="fas fa-eye fa-md"></i>
                                            </a>

                                            <form action="{{ route('admin.praktikum.destroy', $praktikum) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    class="text-red-500 flex transition-all duration-300 items-center justify-center w-8 h-8 border-red-500 border rounded-sm p-2 cursor-pointer hover:bg-red-500 hover:text-white delete-btn"
                                                    data-name="{{ $praktikum->judul }}">
                                                    <i class="fas fa-trash-alt fa-md"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            $("#customSearch").on("keyup", function() {
                praktikumTable.search(this.value).draw();
            });
            var praktikumTable = $("#praktikumTable").DataTable({
                info: false,
                responsive: true,
                dom: "trip",
                stripeClasses: [],
                order: [
                    [5, 'desc']
                ], // Sort by updated_at column (index 5) descending
            });

            // Delete confirmation
            document.querySelectorAll('.delete-btn').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const form = this.closest('form');
                    const name = this.dataset.name;

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        html: `Praktikum <span class="font-semibold">${name}</span> akan dihapus secara permanen!`,
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
</x-app-layout>