<x-maha-layout>
    <div class="py-6">
        <div class="w-full mx-auto px-2">
            <!-- Header -->
            <div class="mb-6" data-aos="fade-down" data-aos-duration="400">
                <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Daftar Kelas Saya</h1>
                <p class="text-gray-600 mt-1">Lihat dan ikuti perkembangan kelas Anda</p>
            </div>

            @forelse($kelas_list as $kelas)
            <!-- Single Class Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200">
                <!-- Card Header -->
                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                {{ $kelas->nama_kelas }}
                            </h3>
                            <div class="flex items-center text-sm text-gray-600 mb-2">
                                {{ $kelas->kode }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="p-6">
                    <!-- Statistics -->
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <!-- Students Count -->
                        <div class="text-start p-4 bg-gray-50 border border-gray-200 rounded-lg">
                            <div class="flex items-center justify-start mb-2">
                                <i class="fas fa-users text-gray-400 mr-2"></i>
                                <span class="text-sm text-gray-600">Total Mahasiswa</span>
                            </div>
                            <div class="text-2xl font-bold text-gray-900">{{ $kelas->mahasiswa_count }}</div>
                        </div>

                        <!-- Practicum Count -->
                        <div class="text-start p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <div class="flex items-center justify-start mb-2">
                                <i class="fas fa-flask text-gray-400 mr-2"></i>
                                <span class="text-sm text-gray-600">Total Praktikum</span>
                            </div>
                            <div class="text-2xl font-bold text-gray-900">{{ $kelas->praktikum_count }}</div>
                        </div>
                    </div>
                </div>

                <!-- Card Footer/Actions -->
                <div class="px-6 pb-6">
                    <a href="{{ route('mahasiswa.kelas.show', $kelas) }}"
                        class="w-full inline-flex items-center justify-center px-4 py-3 border-blue-200 bg-blue-50 border text-blue-700 text-sm font-medium rounded-lg hover:bg-blue-100 hover:text-blue-800 transition-colors duration-200">
                        <i class="fas fa-eye mr-2"></i>
                        Lihat Detail Kelas
                    </a>
                </div>
            </div>
            @empty
            <!-- Empty State -->
            <div class="bg-white rounded-lg shadow-sm p-8 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-chalkboard-teacher text-2xl text-gray-400"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Kelas</h3>
                <p class="text-gray-500">Tidak ada kelas yang ditugaskan kepada Anda saat ini.</p>
            </div>
            @endforelse
        </div>
    </div>

    <style>
        /* Responsive adjustments */
        @media (max-width: 640px) {
            .grid-cols-2 {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
        }
    </style>
</x-maha-layout>