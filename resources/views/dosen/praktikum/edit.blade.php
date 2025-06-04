<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Edit Praktikum</h2>
                        <a href="{{ route('dosen.kelas.show', $praktikum->kelas) }}"
                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Back
                        </a>
                    </div>

                    <form action="{{ route('dosen.praktikum.update', $praktikum) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="kelas_id" class="block text-sm font-medium text-gray-700">Kelas</label>
                            <select name="kelas_id" id="kelas_id" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('kelas_id') border-red-500 @enderror">
                                <option value="">Pilih Kelas</option>
                                @foreach($kelas_list as $kelas)
                                    <option value="{{ $kelas->id }}" {{ (old('kelas_id', $praktikum->kelas_id) == $kelas->id) ? 'selected' : '' }}>
                                        {{ $kelas->nama }} ({{ $kelas->kode }}) - {{ $kelas->tahun_ajaran }} {{ ucfirst($kelas->semester) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kelas_id')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="judul" class="block text-sm font-medium text-gray-700">Judul Praktikum</label>
                            <input type="text" name="judul" id="judul" value="{{ old('judul', $praktikum->judul) }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('judul') border-red-500 @enderror">
                            @error('judul')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" rows="4" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi', $praktikum->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="deadline" class="block text-sm font-medium text-gray-700">Deadline</label>
                            <input type="datetime-local" name="deadline" id="deadline" 
                                value="{{ old('deadline', $praktikum->deadline ? $praktikum->deadline->format('Y-m-d\TH:i') : '') }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('deadline') border-red-500 @enderror">
                            @error('deadline')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="panduan" class="block text-sm font-medium text-gray-700">File Panduan (PDF)</label>
                            @if($praktikum->panduan_path)
                                <div class="mt-2 flex items-center space-x-2">
                                    <span class="text-sm text-gray-500">File saat ini:</span>
                                    <a href="{{ route('dosen.praktikum.download-panduan', $praktikum) }}" 
                                        class="text-blue-600 hover:text-blue-800 text-sm">
                                        Download Panduan
                                    </a>
                                </div>
                            @endif
                            <input type="file" name="panduan" id="panduan" accept=".pdf"
                                class="mt-1 block w-full @error('panduan') border-red-500 @enderror">
                            <p class="mt-1 text-sm text-gray-500">Max. 10MB</p>
                            @error('panduan')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="template" class="block text-sm font-medium text-gray-700">File Template (DOC/DOCX/PDF)</label>
                            @if($praktikum->template_path)
                                <div class="mt-2 flex items-center space-x-2">
                                    <span class="text-sm text-gray-500">File saat ini:</span>
                                    <a href="{{ route('dosen.praktikum.download-template', $praktikum) }}" 
                                        class="text-blue-600 hover:text-blue-800 text-sm">
                                        Download Template
                                    </a>
                                </div>
                            @endif
                            <input type="file" name="template" id="template" accept=".doc,.docx,.pdf"
                                class="mt-1 block w-full @error('template') border-red-500 @enderror">
                            <p class="mt-1 text-sm text-gray-500">Max. 10MB</p>
                            @error('template')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update Praktikum
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 