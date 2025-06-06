<x-maha-layout>
    <div class="py-6">
        <div class="w-full mx-auto px-2">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6" data-aos="fade-down" data-aos-duration="400">
                        <h2 class="text-2xl font-semibold text-gray-800">Submit Laporan Praktikum</h2>
                        <a href="{{ route('mahasiswa.laporan.index') }}"
                            class="flex items-center justify-center transition-all duration-300 border border-gray-400 p-2 rounded-sm text-gray-600 hover:bg-gray-500 hover:text-white w-8 h-8">
                            <i class="fas fa-arrow-left fa-sm"></i>
                        </a>
                    </div>

                    <!-- Praktikum Info -->
                    <div class="mb-6 bg-blue-50 border border-blue-300 p-4 rounded-lg" data-aos="fade-up" data-aos-duration="500">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Informasi Praktikum</h3>
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Judul</dt>
                                <dd class="text-sm text-gray-900">{{ $praktikum->judul }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Kelas</dt>
                                <dd class="text-sm text-gray-900">{{ $praktikum->kelas->nama_kelas}} ({{ $praktikum->kelas->kode }})</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Deadline</dt>
                                <dd class="text-sm">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        {{ $praktikum->deadline < now() ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                        {{ $praktikum->deadline->format('d M Y H:i') }}
                                    </span>
                                </dd>
                            </div>
                        </dl>

                        <div class="mt-4 space-x-4 space-y-2">
                            @if($praktikum->panduan_path)
                            <a href="{{ route('mahasiswa.laporan.download-panduan', $praktikum) }}"
                                class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800">
                                <i class="fa-solid fa-circle-arrow-down mr-2"></i>
                                Download Panduan
                            </a>
                            @endif
                            @if($praktikum->template_path)
                            <a href="{{ route('mahasiswa.laporan.download-template', $praktikum) }}"
                                class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800">
                                <i class="fa-solid fa-circle-arrow-down mr-2"></i>
                                Download Template
                            </a>
                            @endif
                        </div>
                    </div>

                    <form action="{{ route('mahasiswa.laporan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        <input type="hidden" name="praktikum_id" value="{{ $praktikum->id }}">

                        <div>
                            <label for="file" class="block text-sm font-medium mb-2 text-gray-700">Uanggal Hasil Praktikum (PDF) <span class="text-red-500">*</span></label>
                            <input type="file" name="file" id="file" accept=".pdf" required
                                class="mt-1 bg-gray-100 hover:bg-gray-500 hover:text-white transition-all duration-300 cursor-pointer border border-gray-500 rounded-md w-64 p-2 block @error('file') border-red-500 @enderror">
                            <p class="mt-1 text-sm text-gray-500">Max. 10MB</p>
                            @error('file')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="catatan" class="block text-sm font-medium mb-2 text-gray-700">Catatan <span class="text-red-500">*</span></label>
                            <textarea name="catatan" id="catatan" rows="3" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-transparent @error('catatan') border-red-500 @enderror">{{ old('catatan') }}</textarea>
                            @error('catatan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                class="bg-blue-100 border text-sm border-blue-500 hover:bg-blue-500 hover:text-white transition-all duration-300 text-blue-500 font-medium py-2 px-4 rounded">
                                <i class="fa-solid fa-paper-plane mr-2"></i>
                                Submit Laporan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-maha-layout>