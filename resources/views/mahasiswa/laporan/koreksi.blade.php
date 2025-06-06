<x-maha-layout>
    <div class="py-6">
        <div class="w-full mx-auto px-2">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6" data-aos="fade-down" data-aos-duration="400">
                        <h2 class="text-2xl font-semibold text-gray-800">Hasil Koreksi Praktikum</h2>
                        <a href="{{ route('mahasiswa.laporan.index') }}"
                            class="flex items-center justify-center transition-all duration-300 border border-gray-400 p-2 rounded-sm text-gray-600 hover:bg-gray-500 hover:text-white w-8 h-8">
                            <i class="fas fa-arrow-left fa-sm"></i>
                        </a>
                    </div>

                    <!-- Praktikum Info -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">{{ $laporan->praktikum->judul }}</h3>
                        <p class="text-sm text-gray-600">{{ $laporan->praktikum->kelas->nama_kelas }}</p>
                    </div>

                    <!-- Assessment Details -->
                    <div class="bg-green-50 border border-green-300 p-4 rounded-lg mb-6" data-aos="fade-up" data-aos-duration="500">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <h4 class="text-sm font-medium text-gray-500 mb-1">Status</h4>
                                <p class="text-base font-medium {{ $laporan->status === 'reviewed' ? 'text-green-600' : 'text-yellow-600' }}">
                                    {{ ucfirst($laporan->status) }}
                                </p>
                            </div>
                            @if($laporan->nilai)
                            <div>
                                <h4 class="text-sm font-medium text-gray-500 mb-1">Nilai</h4>
                                <p class="text-base font-medium text-gray-900">{{ $laporan->nilai }}</p>
                            </div>
                            @endif
                        </div>
                        @if($laporan->catatan)
                        <div class="mt-4">
                            <h4 class="text-sm font-medium text-gray-500 mb-1">Catatan</h4>
                            <p class="text-base text-gray-900">{{ $laporan->catatan }}</p>
                        </div>
                        @endif
                    </div>

                    <!-- PDF Viewers -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Original Report -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Laporan Asli</h3>
                            <div class="mt-2 flex gap-2 flex-col justify-start">
                                <a href="{{ route('mahasiswa.laporan.view-file', $laporan) }}"
                                    target="_blank"
                                    class="text-purple-600 flex flex-row gap-2 items-center w-fit font-medium hover:text-purple-800 text-sm">
                                    <i class="fa-solid fa-eye"></i>
                                    <span>Lihat File Laporan Praktikum</span>
                                </a>
                                <hr class="border-gray-300 my-2 mx-4">

                                <a href="{{ route('mahasiswa.laporan.download', $laporan) }}"
                                    class="flex flex-row items-center gap-2 text-sm font-medium text-blue-600 hover:text-blue-800">
                                    <i class="fa-solid fa-circle-arrow-down "></i>
                                    <span>Download File Laporan Praktikum</span>
                                </a>
                            </div>
                        </div>

                        <!-- Correction File -->
                        @if($laporan->file_koreksi_path)
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">File Koreksi</h3>
                            <div class="mt-2 flex flex-col gap-2 justify-start">
                                <a href="{{ route('mahasiswa.laporan.view-koreksi-file', $laporan) }}"
                                    target="_blank"
                                    class="text-purple-600 flex flex-row gap-2 items-center w-fit font-medium hover:text-purple-800 text-sm">
                                    <i class="fa-solid fa-eye"></i>
                                    <span>Lihat File Koreksi Dari Dosen</span>
                                </a>
                                <hr class="border-gray-300 my-2 mx-4">
                                <a href="{{ route('mahasiswa.laporan.download-koreksi', $laporan) }}"
                                    class="flex flex-row items-center gap-2 text-sm font-medium text-blue-600 hover:text-blue-800">
                                    <i class="fa-solid fa-circle-arrow-down"></i>
                                    <span>Download File Koreksi Dari Dosen</span>
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
</x-maha-layout>