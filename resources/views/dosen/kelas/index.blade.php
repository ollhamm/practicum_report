<x-app-layout>
    <div class="py-6">
        <div class="px-2 mb-4">
            <ol class="flex w-full flex-wrap items-center">
                <li class="flex cursor-pointer items-center text-sm text-gray-600 transition-colors duration-300 hover:text-gray-400">
                    <a href="/dosen/dashboard">Dashboard</a>
                    <span class="pointer-events-none mx-2 text-gray-600">
                        /
                    </span>
                </li>
                <li class="flex active items-center text-sm text-gray-500 transition-colors duration-300 ">
                    <span>Kelas</span>
                    <span class="pointer-events-none mx-2 text-gray-600">
                        /
                    </span>
                </li>
                <li class="flex items-center text-sm text-gray-700 transition-colors duration-300">
                    <span>Daftar Kelas Saya</span>
                </li>
            </ol>
        </div>
        <div class="w-full mx-auto px-2">
            <div class="bg-white overflow-hidden shadow-sm rounded-sm">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Daftar Kelas Saya</h2>
                    </div>

                    <!-- Kelas DataTable -->
                    <div class="overflow-x-auto">
                        <div class="relative max-w-xs mb-4">
                            <i class="fas fa-search fa-sm text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2"></i>
                            <input type="text" id="customSearch"
                                class="w-full pl-9 pr-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:border-gray-400"
                                placeholder="Search..." autocomplete="off" />
                        </div>
                        <table id="kelasTable" class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama Kelas</th>
                                    <th>Total Mahasiswa</th>
                                    <th>Total Praktikum</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($kelas_list as $kelas)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $kelas->kode }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $kelas->nama_kelas }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $kelas->mahasiswa_count }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $kelas->praktikum_count }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <div class="flex flex-row items-center justify-start gap-2">
                                            <a href="{{ route('dosen.kelas.show', $kelas) }}"
                                                class="flex items-center justify-center transition-all duration-300 border border-purple-500 p-2 rounded-sm text-purple-500 hover:bg-purple-500 hover:text-white w-8 h-8">
                                                <i class="fas fa-eye fa-md"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                        Tidak ada kelas yang ditugaskan
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="mt-4">
                            {{ $kelas_list->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            $("#customSearch").on("keyup", function() {
                kelasTable.search(this.value).draw();
            });
            var kelasTable = $("#kelasTable").DataTable({
                info: false,
                responsive: true,
                dom: "trip",
                stripeClasses: [],
                order: [
                    [0, "asc"]
                ],
            });
        });
    </script>
</x-app-layout>