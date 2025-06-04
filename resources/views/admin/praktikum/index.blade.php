<x-app-layout>
    <div class="py-12">
        <div class="w-full mx-auto px-2">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-md">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Manajemen Praktikum</h2>
                        <a href="{{ route('admin.praktikum.create') }}"
                            class=" hover:bg-blue-500 border border-blue-500 text-blue-500 hover:text-white text-xs px-4 py-2 rounded-sm transition-all duration-300">
                            Tambah Praktikum
                        </a>
                    </div>

                    <!-- Praktikum DataTable -->
                    <div class="overflow-x-auto">
                        <div
                            class="relative px-4 mb-4 gap-1 mr-4 w-48 bg-white border border-gray-300 flex flex-row py-2 items-center rounded-sm shadow-sm group focus-within:shadow-lg transition-shadow duration-300">
                            <input type="text" id="customSearch"
                                class="w-full bg-transparent text-gray-900 text-xs transition duration-300 focus:outline-none"
                                placeholder="Cari Praktikum..." autocomplete="off" />
                        </div>
                        <table id="praktikumTable" class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th>No</th>
                                    <th>Kelas</th>
                                    <th>Judul</th>
                                    <th>Dosen</th>
                                    <th>Deadline</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($praktikums as $index => $praktikum)
                                <tr>
                                    <td class="py-4 whitespace-nowrap">{{ $praktikums->firstItem() + $index }}</td>
                                    <td class="py-4 whitespace-nowrap">
                                        <div class="flex flex-col">
                                            <span class="text-gray-900 font-medium">{{ $praktikum->kelas->nama_kelas }}</span>
                                            <span class="text-gray-500 text-sm">{{ $praktikum->kelas->kode }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4 whitespace-nowrap">{{ $praktikum->judul }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-col">
                                            @if($praktikum->kelas->dosen->isNotEmpty())
                                            @foreach($praktikum->kelas->dosen as $dosen)
                                            <span class="text-sm text-gray-900">{{ $dosen->name }}</span>
                                            @endforeach
                                            @else
                                            <span class="text-sm text-gray-500">Belum ada dosen</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($praktikum->deadline)->format('d/m/Y H:i') }}</td>
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

                        <div class="mt-4">
                            {{ $praktikums->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
    <script>
        window.onload = function() {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Berhasil!',
                    icon: 'success',
                    html: `{{ session('success') }}`,
                    toast: true,
                    position: 'top',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                })
            } else {
                console.error('SweetAlert2 tidak dimuat');
                alert(`{{ session('success') }}`);
            }
        };
    </script>
    @endif

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
                    [0, "asc"]
                ],
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