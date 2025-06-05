<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Hasil Koreksi Laporan</h2>
                        <a href="{{ route('mahasiswa.laporan.index') }}" class="text-blue-500 hover:text-blue-600">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali
                        </a>
                    </div>

                    <!-- Praktikum Info -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">{{ $laporan->praktikum->judul }}</h3>
                        <p class="text-sm text-gray-600">{{ $laporan->praktikum->kelas->nama_kelas }}</p>
                    </div>

                    <!-- Assessment Details -->
                    <div class="bg-gray-50 p-4 rounded-lg mb-6">
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
                            <div class="border rounded-lg overflow-hidden">
                                <iframe src="{{ Storage::url($laporan->file_path) }}" class="w-full h-[600px]"></iframe>
                            </div>
                            <div class="mt-2 flex justify-end">
                                <a href="{{ route('mahasiswa.laporan.download', $laporan) }}" class="text-blue-500 hover:text-blue-600 text-sm">
                                    <i class="fas fa-download mr-1"></i>Download Laporan
                                </a>
                            </div>
                        </div>

                        <!-- Correction File -->
                        @if($laporan->file_koreksi_path)
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">File Koreksi</h3>
                            <div class="border rounded-lg overflow-hidden">
                                <iframe src="{{ Storage::url($laporan->file_koreksi_path) }}" class="w-full h-[600px]"></iframe>
                            </div>
                            <div class="mt-2 flex justify-end">
                                <a href="{{ route('mahasiswa.laporan.download-koreksi', $laporan) }}" class="text-blue-500 hover:text-blue-600 text-sm">
                                    <i class="fas fa-download mr-1"></i>Download File Koreksi
                                </a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>