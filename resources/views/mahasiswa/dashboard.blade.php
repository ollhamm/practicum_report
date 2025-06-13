<x-maha-layout>
    <div class="py-6 container-index">
        <div class="w-full mx-auto px-2">
            <!-- Welcome Section -->
            <div class="mb-6 sm:mb-8" data-aos="fade-down" data-aos-duration="400">
                <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Dashboard Mahasiswa</h1>
                <p class="text-sm sm:text-base text-gray-600 mt-1">Selamat datang, {{ Auth::user()->name }}!</p>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-6 sm:mb-8">
                <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200" data-aos="fade-up" data-aos-duration="500">
                    <div class="p-4 sm:p-6">
                        <div class="text-gray-600 text-xs sm:text-sm font-medium">Total Kelas</div>
                        <div class="text-xl sm:text-2xl font-bold text-blue-600 mt-1">{{ $stats['total_kelas'] }}</div>
                        <div class="text-xs text-gray-500 mt-1">Kelas diikuti</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200" data-aos="fade-up" data-aos-duration="500">
                    <div class="p-4 sm:p-6">
                        <div class="text-gray-600 text-xs sm:text-sm font-medium">Total Praktikum</div>
                        <div class="text-xl sm:text-2xl font-bold text-purple-600 mt-1">{{ $stats['total_praktikum'] }}</div>
                        <div class="text-xs text-gray-500 mt-1">Semua praktikum</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200" data-aos="fade-up" data-aos-duration="500">
                    <div class="p-4 sm:p-6">
                        <div class="text-gray-600 text-xs sm:text-sm font-medium">Sudah Dikumpulkan</div>
                        <div class="text-xl sm:text-2xl font-bold text-green-600 mt-1">{{ $stats['praktikum_dikumpulkan'] }}</div>
                        <div class="text-xs text-gray-500 mt-1">Laporan selesai</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200" data-aos="fade-up" data-aos-duration="500">
                    <div class="p-4 sm:p-6">
                        <div class="text-gray-600 text-xs sm:text-sm font-medium">Belum Dikumpulkan</div>
                        <div class="text-xl sm:text-2xl font-bold text-red-600 mt-1">{{ $stats['praktikum_belum_dikumpulkan'] }}</div>
                        <div class="text-xs text-gray-500 mt-1">Perlu dikerjakan</div>
                    </div>
                </div>
            </div>

            <!-- Progress Bar -->
            @if($stats['total_praktikum'] > 0)
            <div class="bg-white overflow-hidden border border-gray-200 shadow-sm rounded-lg mb-6 sm:mb-8" data-aos="zoom-in" data-aos-duration="500">
                <div class="p-4 sm:p-6">
                    <div class="flex justify-between items-center mb-2">
                        <h3 class="text-sm sm:text-base font-semibold text-gray-800">Progress Praktikum</h3>
                        <span class="text-xs sm:text-sm text-gray-600">
                            {{ $stats['praktikum_dikumpulkan'] }}/{{ $stats['total_praktikum'] }}
                        </span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2 sm:h-3">
                        <div class="bg-green-300 border border-green-800 h-2 sm:h-3 rounded-full transition-all duration-300"
                            style="width: {{ $stats['total_praktikum'] > 0 ? number_format(($stats['praktikum_dikumpulkan'] / $stats['total_praktikum']) * 100, 2, '.', '') : 0 }}%"></div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">
                        {{ $stats['total_praktikum'] > 0 ? round(($stats['praktikum_dikumpulkan'] / $stats['total_praktikum']) * 100, 1) : 0 }}% selesai
                    </p>
                </div>
            </div>
            @endif

            <!-- Nilai Normal Table Section -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200 mb-6 sm:mb-8" data-aos="fade-up" data-aos-duration="500">
                <div class="p-4 sm:p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-base sm:text-lg font-semibold text-gray-800">Referensi Nilai Normal</h2>
                        <span class="text-xs sm:text-sm text-gray-600">{{ $nilaiNormals->count() }} data</span>
                    </div>
                    <div class="overflow-x-auto md:py-0 py-4">
                        <div class="relative max-w-xs mb-4">
                            <i class="fas fa-search fa-sm text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2"></i>
                            <input type="text" id="customSearch"
                                class="w-full pl-9 pr-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:border-gray-400"
                                placeholder="Search..." autocomplete="off" />
                        </div>
                        <table id="nilaiNormalTable" class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-blue-50">
                                <tr>
                                    <th>Test</th>
                                    <th>Parameter</th>
                                    <th>Unit</th>
                                    <th>Min</th>
                                    <th>Max</th>
                                    <th>Gender</th>
                                    <th>Usia</th>
                                    <th>Referensi</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($nilaiNormals as $nilai)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-3 py-2 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $nilai->test_name }}</div>
                                    </td>
                                    <td class="px-3 py-2 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $nilai->parameter }}</div>
                                    </td>
                                    <td class="px-3 py-2 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $nilai->unit }}</div>
                                    </td>
                                    <td class="px-3 py-2 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $nilai->normal_min }}</div>
                                    </td>
                                    <td class="px-3 py-2 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $nilai->normal_max }}</div>
                                    </td>
                                    <td class="px-3 py-2 whitespace-nowrap">
                                        {{ $nilai->gender }}
                                    </td>
                                    <td class="px-3 py-2 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $nilai->age_min }} - {{ $nilai->age_max }}</div>
                                        <div class="text-xs text-gray-500">tahun</div>
                                    </td>
                                    <td class="px-3 py-2 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ Str::limit($nilai->referensi, 20) }}</div>
                                    </td>
                                    <td class="px-3 py-2">
                                        <div class="text-sm text-gray-900 max-w-xs">
                                            {{ $nilai->notes ? Str::limit($nilai->notes, 50) : '-' }}
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8">
                <!-- Kelas yang Diikuti -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200" data-aos="fade-right" data-aos-duration="500">
                    <div class="p-4 sm:p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-base sm:text-lg font-semibold text-gray-800">Kelas yang Diikuti</h2>
                            <a href="{{ route('mahasiswa.kelas.index') }}" class=" text-blue-600 text-xs sm:text-sm font-medium hover:text-blue-800">
                                Lihat Kelas →
                            </a>
                        </div>

                        @if($kelasDiikuti->count() > 0)
                        <div class="space-y-3 sm:space-y-4">
                            @foreach($kelasDiikuti as $index => $kelas)
                            <div class="border border-gray-200 rounded-lg p-3 sm:p-4 hover:shadow-md transition-shadow"
                                data-aos="fade-up" data-aos-duration="500" 00 + ($index * 100) }}">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="font-semibold text-sm sm:text-base text-gray-900 leading-tight">{{ $kelas->nama_kelas }}</h3>
                                    <span class="text-xs text-gray-500 ml-2 flex-shrink-0">{{ $kelas->kode_kelas }}</span>
                                </div>

                                <div class="flex justify-between items-center text-xs text-gray-500">
                                    <span>{{ $kelas->praktikum->count() }} praktikum</span>
                                    <a href="{{ route('mahasiswa.kelas.show', $kelas) }}"
                                        class="text-blue-600 hover:text-blue-800 font-medium">
                                        Lihat detail
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="text-center py-6 sm:py-8" data-aos="fade-up" data-aos-duration="500">
                            <svg class="mx-auto h-8 w-8 sm:h-12 sm:w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            <p class="text-gray-500 text-xs sm:text-sm mt-2">Belum mengikuti kelas apapun</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Praktikum Terbaru -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200" data-aos="fade-left" data-aos-duration="500">
                    <div class="p-4 sm:p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-base sm:text-lg font-semibold text-gray-800">Praktikum Belum Dikumpulkan</h2>
                            <a href="{{ route('mahasiswa.laporan.index') }}" class="text-blue-600 text-xs sm:text-sm font-medium hover:text-blue-800">
                                Lihat semua →
                            </a>
                        </div>

                        @if($praktikumTerbaru->count() > 0)
                        <div class="space-y-3 sm:space-y-4">
                            @foreach($praktikumTerbaru as $index => $praktikum)
                            <div class="border border-red-200 rounded-lg p-3 sm:p-4 bg-red-50 hover:shadow-md transition-shadow"
                                data-aos="fade-up" data-aos-duration="500" 00 + ($index * 100) }}">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="font-semibold text-sm sm:text-base text-gray-900 leading-tight">{{ $praktikum->judul }}</h3>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 ml-2 flex-shrink-0">
                                        Belum
                                    </span>
                                </div>
                                <p class="text-xs sm:text-sm text-gray-600 mb-2">
                                    Kelas: <span class="font-medium">{{ $praktikum->kelas->nama_kelas ?? 'Tidak ada' }}</span>
                                </p>
                                <div class="flex justify-between items-center text-xs text-gray-500">
                                    <span>Deadline: {{ $praktikum->deadline ? \Carbon\Carbon::parse($praktikum->deadline)->format('d M Y') : 'Tidak ada' }}</span>
                                    <a href="{{ route('mahasiswa.laporan.create', ['praktikum_id' => $praktikum->id]) }}"
                                        class="text-blue-600 hover:text-blue-800 font-medium">
                                        Kerjakan
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="text-center py-6 sm:py-8" data-aos="fade-up" data-aos-duration="500">
                            <i class="fa-solid fa-clipboard-check text-green-500 text-4xl"></i>
                            <p class="text-green-700 text-xs sm:text-sm mt-2">Semua praktikum sudah dikumpulkan!</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Quick Actions (Mobile) -->
            <div class="mt-6" data-aos="fade-up" data-aos-duration="500">
                <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">
                    <div class="p-4">
                        <h2 class="text-base font-semibold text-gray-800 mb-3">Aksi Cepat</h2>
                        <div class="grid grid-cols-2 gap-3">
                            <a href="{{ route('mahasiswa.kelas.index') }}"
                                class="flex items-center justify-center transition-all duration-300 p-3 bg-blue-50 rounded-lg border border-blue-200 text-blue-700 hover:bg-blue-100">
                                <i class="fas fa-door-open mb-1 text-xl mr-2"></i>
                                <span class="text-sm font-medium">Kelas Saya</span>
                            </a>
                            <a href="{{ route('mahasiswa.laporan.index') }}"
                                class="flex items-center justify-center p-3 transition-all duration-300 bg-purple-50 rounded-lg border border-purple-200 text-purple-700 hover:bg-purple-100">
                                <i class="fas fa-flask text-xl mb-1 mr-2"></i>
                                <span class="text-sm font-medium">Praktikum</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            $("#customSearch").on("keyup", function() {
                nilaiNormalTable.search(this.value).draw();
            });
            var nilaiNormalTable = $("#nilaiNormalTable").DataTable({
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
</x-maha-layout>