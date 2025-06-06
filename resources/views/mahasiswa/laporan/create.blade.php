<x-maha-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Submit Laporan Praktikum</h2>
                        <a href="{{ route('mahasiswa.laporan.index') }}"
                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Back
                        </a>
                    </div>

                    <!-- Praktikum Info -->
                    <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Informasi Praktikum</h3>
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Judul</dt>
                                <dd class="text-sm text-gray-900">{{ $praktikum->judul }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Kelas</dt>
                                <dd class="text-sm text-gray-900">{{ $praktikum->kelas->nama }} ({{ $praktikum->kelas->kode }})</dd>
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

                        <div class="mt-4 space-y-2">
                            @if($praktikum->panduan_path)
                            <a href="{{ route('dosen.praktikum.download-panduan', $praktikum) }}"
                                class="inline-flex items-center text-blue-600 hover:text-blue-800">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v4.586l-2.293-2.293a1 1 0 10-1.414 1.414l4 4a1 1 0 001.414 0l4-4a1 1 0 00-1.414-1.414L11 11.586V7z"></path>
                                </svg>
                                Download Panduan
                            </a>
                            @endif
                            @if($praktikum->template_path)
                            <a href="{{ route('dosen.praktikum.download-template', $praktikum) }}"
                                class="inline-flex items-center text-blue-600 hover:text-blue-800">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v4.586l-2.293-2.293a1 1 0 10-1.414 1.414l4 4a1 1 0 001.414 0l4-4a1 1 0 00-1.414-1.414L11 11.586V7z"></path>
                                </svg>
                                Download Template
                            </a>
                            @endif
                        </div>
                    </div>

                    <form action="{{ route('mahasiswa.laporan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        <input type="hidden" name="praktikum_id" value="{{ $praktikum->id }}">

                        <div>
                            <label for="file" class="block text-sm font-medium text-gray-700">File Laporan (PDF)</label>
                            <input type="file" name="file" id="file" accept=".pdf" required
                                class="mt-1 block w-full @error('file') border-red-500 @enderror">
                            <p class="mt-1 text-sm text-gray-500">Max. 10MB</p>
                            @error('file')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="catatan" class="block text-sm font-medium text-gray-700">Catatan (Opsional)</label>
                            <textarea name="catatan" id="catatan" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('catatan') border-red-500 @enderror">{{ old('catatan') }}</textarea>
                            @error('catatan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Submit Laporan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-maha-layout>