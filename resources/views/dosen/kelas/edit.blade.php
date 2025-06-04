<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Edit Kelas</h2>
                        <a href="{{ route('dosen.kelas.index') }}"
                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Back
                        </a>
                    </div>

                    <form action="{{ route('dosen.kelas.update', $kelas) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="nama" class="block text-sm font-medium text-gray-700">Nama Kelas</label>
                            <input type="text" name="nama" id="nama" value="{{ old('nama', $kelas->nama) }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('nama') border-red-500 @enderror">
                            @error('nama')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="kode" class="block text-sm font-medium text-gray-700">Kode Kelas</label>
                            <input type="text" name="kode" id="kode" value="{{ old('kode', $kelas->kode) }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('kode') border-red-500 @enderror">
                            @error('kode')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="tahun_ajaran" class="block text-sm font-medium text-gray-700">Tahun Ajaran</label>
                            <input type="text" name="tahun_ajaran" id="tahun_ajaran" value="{{ old('tahun_ajaran', $kelas->tahun_ajaran) }}" required
                                placeholder="2023/2024"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('tahun_ajaran') border-red-500 @enderror">
                            @error('tahun_ajaran')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="semester" class="block text-sm font-medium text-gray-700">Semester</label>
                            <select name="semester" id="semester" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('semester') border-red-500 @enderror">
                                <option value="">Pilih Semester</option>
                                <option value="ganjil" {{ old('semester', $kelas->semester) === 'ganjil' ? 'selected' : '' }}>Ganjil</option>
                                <option value="genap" {{ old('semester', $kelas->semester) === 'genap' ? 'selected' : '' }}>Genap</option>
                            </select>
                            @error('semester')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="mahasiswa" class="block text-sm font-medium text-gray-700">Mahasiswa</label>
                            <select name="mahasiswa[]" id="mahasiswa" multiple required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('mahasiswa') border-red-500 @enderror">
                                @foreach($mahasiswa as $mhs)
                                    <option value="{{ $mhs->id }}" {{ in_array($mhs->id, old('mahasiswa', $selectedMahasiswa)) ? 'selected' : '' }}>
                                        {{ $mhs->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('mahasiswa')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                            @error('mahasiswa.*')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update Kelas
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Initialize multiple select
        const selectElement = document.getElementById('mahasiswa');
        if (selectElement) {
            new Choices(selectElement, {
                removeItemButton: true,
                searchEnabled: true,
                searchPlaceholderValue: 'Cari mahasiswa...',
                placeholder: true,
                placeholderValue: 'Pilih mahasiswa',
            });
        }
    </script>
    @endpush
</x-app-layout> 