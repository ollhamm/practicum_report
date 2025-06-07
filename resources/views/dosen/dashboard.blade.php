<x-app-layout>
    <div class="py-6">
        <div class="w-full mx-auto px-2">
            <div class="bg-white overflow-hidden shadow-sm rounded-sm">
                <div class="p-6">
                    <!-- Summary Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <!-- Total Kelas Card -->
                        <div class="bg-white p-6 rounded-sm border border-gray-200">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-blue-50 text-blue-500">
                                    <i class="fas fa-chalkboard text-2xl"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="mb-2 text-sm font-medium text-gray-600">Total Kelas</p>
                                    <p class="text-lg font-semibold text-gray-700">{{ $total_kelas }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Total Praktikum Card -->
                        <div class="bg-white p-6 rounded-sm border border-gray-200">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-green-50 text-green-500">
                                    <i class="fas fa-flask text-2xl"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="mb-2 text-sm font-medium text-gray-600">Total Praktikum</p>
                                    <p class="text-lg font-semibold text-gray-700">{{ $total_praktikum }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Total Mahasiswa Card -->
                        <div class="bg-white p-6 rounded-sm border border-gray-200">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-purple-50 text-purple-500">
                                    <i class="fas fa-user-graduate text-2xl"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="mb-2 text-sm font-medium text-gray-600">Total Mahasiswa</p>
                                    <p class="text-lg font-semibold text-gray-700">{{ $total_mahasiswa }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Praktikum -->
                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-800">Praktikum Terbaru</h3>
                            <a href="{{ route('dosen.praktikum.index') }}" class="text-sm text-blue-500 hover:text-blue-600">
                                Lihat Semua
                                <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                        <div class="overflow-x-auto">
                            <table id="praktikumTable" class="min-w-full">
                                <thead class="bg-gray-200">
                                    <tr>
                                        <th>Judul</th>
                                        <th>Mata Kuliah</th>
                                        <th>Kelas</th>
                                        <th>Deadline</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($recent_praktikum as $praktikum)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-950">{{ $praktikum->judul }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $praktikum->matakuliah }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $praktikum->kelas->nama_kelas }}</div>
                                            <div class="text-sm text-gray-500">{{ $praktikum->kelas->kode }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ \Carbon\Carbon::parse($praktikum->deadline)->locale('id')->translatedFormat('l, d F Y') }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ \Carbon\Carbon::parse($praktikum->deadline)->locale('id')->translatedFormat('H:i') }}
                                            </div>
                                        </td>

                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                            Tidak ada praktikum terbaru
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            var kelasTable = $("#praktikumTable").DataTable({
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