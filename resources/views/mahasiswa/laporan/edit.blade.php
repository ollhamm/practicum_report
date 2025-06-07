<x-maha-layout>
    <div class="py-6">
        <div class="w-full mx-auto px-2">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6" data-aos="fade-down" data-aos-duration="400">
                        <h2 class="text-2xl font-semibold text-gray-800">Edit Laporan Praktikum</h2>

                        <a href="{{ route('mahasiswa.laporan.show', $laporan) }}"
                            class="flex items-center justify-center transition-all duration-300 border border-gray-400 p-2 rounded-sm text-gray-600 hover:bg-gray-500 hover:text-white w-8 h-8">
                            <i class="fas fa-arrow-left fa-sm"></i>
                        </a>
                    </div>

                    <!-- Praktikum Info -->
                    <div class="mb-6 bg-yellow-50 border border-yellow-200 p-4 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Informasi Praktikum</h3>
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Judul</dt>
                                <dd class="text-sm text-gray-900">{{ $laporan->praktikum->judul }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Dosen Pengajar</dt>
                                <dd class="text-sm text-gray-900">{{ $laporan->praktikum->dosen->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Kelas</dt>
                                <dd class="text-sm text-gray-900">{{ $laporan->praktikum->kelas->nama }} ({{ $laporan->praktikum->kelas->kode }})</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Deadline</dt>
                                <dd class="text-sm">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        {{ $laporan->praktikum->deadline < now() ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                        {{ $laporan->praktikum->deadline->format('d M Y H:i') }}
                                    </span>
                                </dd>
                            </div>
                        </dl>

                        <div class="mt-4 space-y-2">
                            @if($laporan->praktikum->panduan_path)
                            <a href="{{ route('mahasiswa.laporan.view-panduan', $laporan->praktikum) }}"
                                target="_blank"
                                class="text-purple-600 flex flex-row gap-2 items-center w-fit font-medium hover:text-purple-800 text-sm">
                                <i class="fa-solid fa-eye"></i>
                                <span>Panduan Praktikum</span>
                            </a>
                            @endif
                            @if($laporan->praktikum->template_path)
                            <a href="{{ route('dosen.praktikum.download-template', $laporan->praktikum) }}"
                                class="inline-flex items-center text-blue-600 hover:text-blue-800">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v4.586l-2.293-2.293a1 1 0 10-1.414 1.414l4 4a1 1 0 001.414 0l4-4a1 1 0 00-1.414-1.414L11 11.586V7z"></path>
                                </svg>
                                Download Template
                            </a>
                            @endif
                        </div>
                    </div>

                    <form action="{{ route('mahasiswa.laporan.update', $laporan) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="file" class="block text-sm font-medium text-gray-700">File Laporan (PDF)</label>
                            <div class="mt-2 flex items-center space-x-2">
                                <span class="text-sm text-gray-500">File saat ini:</span>
                                <a href="{{ route('mahasiswa.laporan.view-file', $laporan) }}"
                                    target="_blank"
                                    class="text-purple-600 flex flex-row gap-2 items-center w-fit font-medium hover:text-purple-800 text-sm">
                                    <span>File Laporan Praktikum Anda </span>
                                </a>
                            </div>
                            <input type="file" name="file" id="file" accept=".pdf"
                                class="mt-1 bg-gray-100 hover:bg-gray-500 hover:text-white transition-all duration-300 cursor-pointer border border-gray-500 rounded-md w-64 p-2 @error('file') border-red-500 @enderror">
                            <p class="mt-1 text-sm text-gray-500">Max. 10MB</p>
                            @error('file')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="catatan" class="block text-sm font-medium mb-2 text-gray-700">Catatan <span class="text-red-500">*</span></label>
                            <textarea name="catatan" id="catatan" rows="3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-transparent @error('catatan') border-red-500 @enderror">{{ old('catatan', $laporan->catatan) }}</textarea>
                            @error('catatan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                class="bg-blue-100 border text-sm border-blue-500 hover:bg-blue-500 hover:text-white transition-all duration-300 text-blue-500 font-medium py-2 px-4 rounded">
                                <i class="fa-solid fa-paper-plane mr-2"></i>
                                Perbaharui Laporan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-maha-layout>