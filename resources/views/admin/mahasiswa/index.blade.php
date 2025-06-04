<x-app-layout>
    <div class="py-12">
        <div class="w-full mx-auto px-2">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-md">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Manajemen Mahasiswa</h2>
                    </div>

                    <!-- Mahasiswa DataTable -->
                    <div class="overflow-x-auto">
                        <div
                            class="relative px-4 mb-4 gap-1 mr-4 w-48 bg-white border border-gray-300 flex flex-row py-2 items-center rounded-sm shadow-sm group focus-within:shadow-lg transition-shadow duration-300">
                            <input type="text" id="customSearch"
                                class="w-full bg-transparent text-gray-900 text-xs transition duration-300 focus:outline-none"
                                placeholder="Cari Mahasiswa..." autocomplete="off" />
                        </div>
                        <table id="mahasiswaTable" class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>NIP/NIM</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($mahasiswa as $m)
                                <tr>
                                    <td class="py-4 whitespace-nowrap">{{ $m->name }}</td>
                                    <td class="py-4 whitespace-nowrap">{{ $m->email }}</td>
                                    <td class="py-4 whitespace-nowrap">{{ $m->nip ?? '-' }}</td>
                                    <td class="py-4 whitespace-nowrap">
                                        <span class="inline-flex text-[11px] rounded-sm p-1
                                            @if($m->approved_by_admin === true)
                                                bg-green-500 text-white
                                            @elseif($m->approved_by_admin === false)
                                                bg-red-500 text-white
                                            @else
                                                bg-yellow-500 text-white
                                            @endif">
                                            @if($m->approved_by_admin === true)
                                            Approved
                                            @elseif($m->approved_by_admin === false)
                                            Rejected
                                            @else
                                            Pending
                                            @endif
                                        </span>
                                    </td>
                                    <td class="py-4 whitespace-nowrap text-sm">
                                        <div class="flex flex-row items-center justify-start gap-2">
                                            <a href="{{ route('admin.mahasiswa.edit', $m) }}"
                                                class="flex items-center justify-center transition-all duration-300 border border-yellow-500 p-2 rounded-sm text-yellow-500 hover:bg-yellow-500 hover:text-white w-8 h-8">
                                                <i class="fas fa-edit fa-md"></i>
                                            </a>

                                            <form action="{{ route('admin.mahasiswa.destroy', $m) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    class="text-red-500 flex transition-all duration-300 items-center justify-center w-8 h-8 border-red-500 border rounded-sm p-2 cursor-pointer hover:bg-red-500 hover:text-white delete-btn"
                                                    data-name="{{ $m->name }}">
                                                    <i class="fas fa-trash-alt fa-md"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="mt-4">
                            {{ $mahasiswa->links() }}
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
                mahasiswaTable.search(this.value).draw();
            });
            var mahasiswaTable = $("#mahasiswaTable").DataTable({
                info: false,
                responsive: true,
                dom: "trip",
                stripeClasses: [],
                order: [
                    [0, "dsc"]
                ],
            });

            // Delete confirmation
            document.querySelectorAll('.delete-btn').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const form = this.closest('form');
                    const name = this.dataset.name;

                    Swal.fire({
                        title: 'Konfirmasi Hapus',
                        html: `Apakah Anda yakin ingin menghapus data mahasiswa <strong>${name}</strong>?`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#EF4444',
                        cancelButtonColor: '#6B7280',
                        confirmButtonText: 'Ya, Hapus',
                        cancelButtonText: 'Batal',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
</x-app-layout>