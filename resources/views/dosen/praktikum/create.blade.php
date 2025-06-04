<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Tambah Praktikum Baru</h2>
                        <a href="{{ $kelas ? route('dosen.kelas.show', $kelas) : route('dosen.praktikum.index') }}"
                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Back
                        </a>
                    </div>

                    <form action="{{ route('dosen.praktikum.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div>
                            <label for="kelas_id" class="block text-sm font-medium text-gray-700">Kelas</label>
                            <select name="kelas_id" id="kelas_id" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('kelas_id') border-red-500 @enderror">
                                <option value="">Pilih Kelas</option>
                                @foreach($kelas_list as $kelas_item)
                                    <option value="{{ $kelas_item->id }}" {{ (old('kelas_id', optional($kelas)->id) == $kelas_item->id) ? 'selected' : '' }}>
                                        {{ $kelas_item->nama }} ({{ $kelas_item->kode }}) - {{ $kelas_item->tahun_ajaran }} {{ ucfirst($kelas_item->semester) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kelas_id')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="judul" class="block text-sm font-medium text-gray-700">Judul Praktikum</label>
                            <input type="text" name="judul" id="judul" value="{{ old('judul') }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('judul') border-red-500 @enderror">
                            @error('judul')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" rows="4" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="deadline" class="block text-sm font-medium text-gray-700">Deadline</label>
                            <input type="datetime-local" name="deadline" id="deadline" value="{{ old('deadline') }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('deadline') border-red-500 @enderror">
                            @error('deadline')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="panduan" class="block text-sm font-medium text-gray-700">File Panduan (PDF)</label>
                            <input type="file" name="panduan" id="panduan" accept=".pdf"
                                class="mt-1 block w-full @error('panduan') border-red-500 @enderror">
                            <p class="mt-1 text-sm text-gray-500">Max. 10MB</p>
                            @error('panduan')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="template" class="block text-sm font-medium text-gray-700">File Template (DOC/DOCX/PDF)</label>
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
                                Buat Praktikum
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 