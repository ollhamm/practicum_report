<x-app-layout>
    <div class="py-6">
        <div class="w-full mx-auto px-2">
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
                        <a href="/dosen/praktikum">Manajemen Praktikum</a>
                        <span class="pointer-events-none mx-2 text-gray-600">/</span>
                    </li>
                    <li class="flex items-center text-sm text-gray-700 transition-colors duration-300">
                        <span>Tambah Praktikum</span>
                    </li>
                </ol>
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-sm">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Tambah Praktikum</h2>
                        <a href="{{ route('dosen.praktikum.index') }}"
                            class="flex items-center justify-center transition-all duration-300 border border-gray-400 p-2 rounded-sm text-gray-600 hover:bg-gray-500 hover:text-white w-8 h-8">
                            <i class="fas fa-arrow-left fa-sm"></i>
                        </a>
                    </div>

                    <form action="{{ route('dosen.praktikum.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @if($kelas)
                        <input type="hidden" name="from_kelas" value="1">
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="kelas_id" class="block text-sm font-medium text-gray-700 mb-2">Kelas <span class="text-red-500">*</span></label>
                                <select name="kelas_id" id="kelas_id" required {{ $kelas ? 'disabled' : '' }}
                                    class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-transparent @error('kelas_id') border-red-500 @enderror" aria-required="true">
                                    <option value="">Pilih Kelas</option>
                                    @foreach($kelas_list as $kelas_item)
                                    <option value="{{ $kelas_item->id }}" {{ (old('kelas_id', optional($kelas)->id) == $kelas_item->id) ? 'selected' : '' }}>
                                        {{ $kelas_item->nama_kelas }} ({{ $kelas_item->kode }}) - {{ $kelas_item->tahun_ajaran }} {{ ucfirst($kelas_item->semester) }}
                                    </option>
                                    @endforeach
                                </select>
                                @if($kelas)
                                <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">
                                @endif
                                @error('kelas_id')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="judul" class="block text-sm font-medium text-gray-700 mb-2">Judul Praktikum <span class="text-red-500">*</span></label>
                                <input type="text" name="judul" id="judul" value="{{ old('judul') }}" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-transparent @error('judul') border-red-500 @enderror">
                                @error('judul')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="deadline" class="block text-sm font-medium text-gray-700 mb-2">Deadline <span class="text-red-500">*</span></label>
                                <input type="datetime-local" name="deadline" id="deadline" value="{{ old('deadline') }}" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-transparent @error('deadline') border-red-500 @enderror">
                                @error('deadline')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="border-t border-gray-200 mt-8 pt-6">
                            <h3 class="text-sm text-gray-500 mb-4">Detail Praktikum</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="panduan" class="block text-sm font-medium text-gray-700 mb-2">File Panduan <span class="text-[11px]">(PDF)</span></label>
                                    <input type="file" name="panduan" id="panduan" accept=".pdf"
                                        class="w-full px-3 py-2 bg-gray-200 rounded-sm @error('panduan') border-red-500 @enderror">
                                    <p class="mt-1 text-sm text-gray-500">Max. 10MB</p>
                                    @error('panduan')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="template" class="block text-sm font-medium text-gray-700 mb-2">File Template <span class="text-[11px]">(DOC/DOCX/PDF)</span></label>
                                    <input type="file" name="template" id="template" accept=".doc,.docx,.pdf"
                                        class="w-full px-3 py-2 bg-gray-200 rounded-sm @error('template') border-red-500 @enderror">
                                    <p class="mt-1 text-sm text-gray-500">Max. 10MB</p>
                                    @error('template')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi <span class="text-red-500">*</span></label>
                            <textarea name="deskripsi" id="deskripsi" rows="4" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-transparent @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end pt-6">
                            <button type="submit"
                                class="flex items-center justify-center transition-all text-sm cursor-pointer duration-300 border border-blue-500 px-4 py-2 rounded-sm text-blue-500 hover:bg-blue-500 hover:text-white min-w-[120px]">
                                <i class="fas fa-save mr-2 fa-lg"></i>
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>