<x-app-layout>
    <div class="py-6">
        <div class="px-2 mb-4">
            <ol class="flex w-full flex-wrap items-center">
                <li class="flex cursor-pointer items-center text-sm text-gray-600 transition-colors duration-300 hover:text-gray-400">
                    <a href="/dosen/dashboard">Dashboard</a>
                    <span class="pointer-events-none mx-2 text-gray-600">/</span>
                </li>
                <li class="flex active items-center text-sm text-gray-500 transition-colors duration-300">
                    <span>Praktikum</span>
                    <span class="pointer-events-none mx-2 text-gray-600">/</span>
                </li>
                <li class="flex cursor-pointer items-center text-sm text-gray-600 transition-colors duration-300 hover:text-gray-400">
                    <a href="{{ route('dosen.praktikum.show', $praktikum) }}">Detail Praktikum</a>
                    <span class="pointer-events-none mx-2 text-gray-600">/</span>
                </li>
                <li class="flex items-center text-sm text-gray-700 transition-colors duration-300">
                    <span>Penilaian Laporan</span>
                </li>
            </ol>
        </div>

        <div class="w-full mx-auto px-2">
            <div class="bg-white overflow-hidden shadow-sm rounded-sm">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Penilaian Laporan Praktikum</h2>
                        <a href="{{ route('dosen.praktikum.show', $praktikum) }}"
                            class="flex items-center justify-center transition-all duration-300 border border-gray-400 p-2 rounded-sm text-gray-600 hover:bg-gray-500 hover:text-white w-8 h-8">
                            <i class="fas fa-arrow-left fa-sm"></i>
                        </a>
                    </div>

                    @if(session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                    @endif

                    <div class="grid grid-cols-1 gap-6">
                        <!-- Informasi Mahasiswa -->
                        <div class="md:col-span-1">
                            <div class="bg-gray-50 border border-gray-200 rounded-sm p-6">
                                <h3 class="text-sm font-semibold text-gray-800 mb-4 border-b border-b-gray-300 pb-2">Informasi Mahasiswa</h3>
                                <div class="space-y-4">
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Nama</label>
                                        <p class="mt-1 text-gray-900 text-sm">{{ $mahasiswa->name }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">NIM</label>
                                        <p class="mt-1 text-gray-900 text-sm">{{ $mahasiswa->nip }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Kelas</label>
                                        <p class="mt-1 text-gray-900 text-sm">{{ $praktikum->kelas->nama_kelas }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Praktikum</label>
                                        <p class="mt-1 text-gray-900 text-sm">{{ $praktikum->judul }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Penilaian -->
                            <div class="mt-6 bg-gray-50 border border-gray-200 rounded-sm p-6">
                                <h3 class="text-sm font-semibold text-gray-800 mb-4 border-b border-b-gray-300 pb-2">Form Penilaian</h3>
                                <form id="penilaianForm" action="{{ route('dosen.praktikum.submit-penilaian', ['laporan' => $laporan->id]) }}"
                                    method="POST" enctype="multipart/form-data" class="space-y-4">
                                    @csrf
                                    @method('PUT')

                                    <div>
                                        <label for="nilai" class="block text-sm font-medium text-gray-700 mb-2">Nilai </label>
                                        <input type="number" step="0.01" min="0" max="100" name="nilai" id="nilai"
                                            value="{{ old('nilai', $laporan->nilai) }}" required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500">
                                        @error('nilai')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="catatan" class="block text-sm font-medium text-gray-700">Catatan</label>
                                        <textarea name="catatan" id="catatan" rows="4"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500">{{ old('catatan', $laporan->catatan) }}</textarea>
                                        @error('catatan')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="file_koreksi" class="block text-sm font-medium text-gray-700">Upload File Koreksi</label>
                                        <input type="file" name="file_koreksi" id="file_koreksi" accept=".pdf"
                                            class="w-fit px-3 py-2 bg-gray-200 rounded-sm">
                                        <p class="mt-1 text-sm text-gray-500">Upload file PDF hasil koreksi</p>
                                        @error('file_koreksi')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="flex justify-end">
                                        <button type="submit" id="submitBtn"
                                            class="flex items-center justify-center transition-all text-sm cursor-pointer duration-300 border border-blue-500 px-4 py-2 rounded-sm text-blue-500 hover:bg-blue-500 hover:text-white min-w-[120px]">
                                            <i class="fas fa-save mr-2 fa-lg"></i>
                                            Simpan Penilaian
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- PDF Viewer -->
                        <div class="md:col-span-2">
                            <div class="bg-gray-50 border border-gray-200 rounded-sm p-6 h-full">
                                <h3 class="text-sm font-semibold text-gray-800 mb-4 border-b border-b-gray-300 pb-2">File Laporan</h3>
                                <div class="h-[800px]">
                                    <iframe src="{{ route('dosen.praktikum.view-laporan', ['laporan' => $laporan->id]) }}"
                                        class="w-full h-full border-0" frameborder="0"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>
    <script>
        // Initialize PDF.js
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.worker.min.js';

        // Form submission handling
        document.getElementById('penilaianForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Disable submit button
            document.getElementById('submitBtn').disabled = true;
            document.getElementById('submitBtn').innerHTML = 'Menyimpan...';

            // Submit form
            this.submit();
        });
    </script>
    @endpush
</x-app-layout>