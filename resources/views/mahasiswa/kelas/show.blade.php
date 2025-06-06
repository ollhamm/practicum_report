<x-maha-layout>
    <div class="py-6">
        <div class="w-full mx-auto px-2">
            <!-- Header -->
            <div data-aos="fade-down" data-aos-duration="400" class="mb-6 flex flex-row justify-between gap-4">
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Detail Data Kelas</h1>
                    <p class="text-gray-600 mt-1">Informasi lengkap kelas</p>
                </div>
                <a href="{{ route('mahasiswa.kelas.index') }}"
                    class="flex items-center justify-center transition-all duration-300 border border-gray-400 p-2 rounded-sm text-gray-600 hover:bg-gray-500 hover:text-white w-8 h-8">
                    <i class="fas fa-arrow-left fa-sm"></i>
                </a>
            </div>

            <!-- Class Information Cards -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6" data-aos="fade-up" data-aos-duration="500">
                <!-- Class Info Card -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex items-center">
                            <i class="fas fa-graduation-cap text-gray-400 mr-2"></i>
                            <h3 class="text-lg font-semibold text-gray-900">Informasi Kelas</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex flex-col sm:flex-row sm:justify-between">
                                <span class="text-gray-600 font-medium text-sm">Nama Kelas:</span>
                                <span class="text-sm text-gray-900 font-medium">{{ $kelas->nama_kelas }}</span>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:justify-between">
                                <span class="text-gray-600 font-medium text-sm">Kode Kelas:</span>
                                <span class="text-sm text-gray-900">{{ $kelas->kode }}</span>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:justify-between">
                                <span class="text-gray-600 font-medium text-sm">Tahun Ajaran:</span>
                                <span class="text-sm text-gray-900">{{ $kelas->tahun_ajaran }}</span>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:justify-between">
                                <span class="text-gray-600 font-medium text-sm">Semester:</span>
                                <span class="text-sm text-gray-900 capitalize">{{ $kelas->semester }}</span>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:justify-between">
                                <span class="text-gray-600 font-medium text-sm">Angkatan:</span>
                                <span class="text-sm text-gray-900">{{ $kelas->angkatan }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Teachers Card -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex items-center">
                            <i class="fas fa-chalkboard-teacher text-gray-400 mr-2"></i>
                            <h3 class="text-lg font-semibold text-gray-900">Dosen Pengajar</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            @forelse($kelas->dosen as $dosen)
                            <div class="flex items-center p-3 bg-blue-50 rounded-lg">
                                <div class="w-10 h-10 bg-blue-200 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-blue-600 text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <div class="font-medium text-sm text-gray-900">{{ $dosen->name }}</div>
                                    <div class="text-xs text-gray-500">NIP: {{ $dosen->nip }}</div>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-4">
                                <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                    <i class="fas fa-user-slash text-gray-400"></i>
                                </div>
                                <p class="text-gray-500 text-sm">Belum ada dosen yang ditugaskan</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-maha-layout>