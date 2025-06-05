<x-app-layout>
    <div class="py-6">
        <div class="px-2 mb-4">
            <ol class="flex w-full flex-wrap items-center">
                <li class="flex cursor-pointer items-center text-sm text-gray-600 transition-colors duration-300 hover:text-gray-400">
                    <a href="/admin/dashboard">Dashboard</a>
                    <span class="pointer-events-none mx-2 text-gray-600">
                        /
                    </span>
                </li>
                <li class="flex active items-center text-sm text-gray-500 transition-colors duration-300 ">
                    <span>Kelas</span>
                    <span class="pointer-events-none mx-2 text-gray-600">
                        /
                    </span>
                </li>
                <li class="flex cursor-pointer items-center text-sm text-gray-600 transition-colors duration-300 hover:text-gray-400">
                    <a href="/admin/kelas">Manajemen Kelas</a>
                    <span class="pointer-events-none mx-2 text-gray-600">
                        /
                    </span>
                </li>
                <li class="flex items-center text-sm text-gray-700 transition-colors duration-300">
                    <span>Edit Data Kelas</span>
                </li>
            </ol>
        </div>
        <div class="w-full mx-auto px-2">
            <div class="bg-white overflow-hidden shadow-sm rounded-sm">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Edit Data Kelas</h2>
                        <a href="{{ route('admin.kelas.index') }}"
                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Kembali
                        </a>
                    </div>

                    <form action="{{ route('admin.kelas.update', $kela) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="nama_kelas" class="block text-sm font-medium text-gray-700">Nama Kelas</label>
                                <input type="text" name="nama_kelas" id="nama_kelas" value="{{ old('nama_kelas', $kela->nama_kelas) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('nama_kelas') border-red-500 @enderror">
                                @error('nama_kelas')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="kode" class="block text-sm font-medium text-gray-700">Kode Kelas</label>
                                <input type="text" name="kode" id="kode" value="{{ old('kode', $kela->kode) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('kode') border-red-500 @enderror">
                                @error('kode')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="tahun_ajaran" class="block text-sm font-medium text-gray-700">Tahun Ajaran</label>
                                <input type="text" name="tahun_ajaran" id="tahun_ajaran" value="{{ old('tahun_ajaran', $kela->tahun_ajaran) }}" required
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
                                    <option value="ganjil" {{ old('semester', $kela->semester) == 'ganjil' ? 'selected' : '' }}>Ganjil</option>
                                    <option value="genap" {{ old('semester', $kela->semester) == 'genap' ? 'selected' : '' }}>Genap</option>
                                </select>
                                @error('semester')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="angkatan" class="block text-sm font-medium text-gray-700">Angkatan</label>
                                <input type="text" name="angkatan" id="angkatan" value="{{ old('angkatan', $kela->angkatan) }}" required
                                    placeholder="2023"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('angkatan') border-red-500 @enderror">
                                @error('angkatan')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="space-y-6 mt-6">
                            <div>
                                <label for="dosen_ids" class="block text-sm font-medium text-gray-700">Dosen Pengajar</label>
                                <select name="dosen_ids[]" id="dosen_ids" multiple required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('dosen_ids') border-red-500 @enderror">
                                    @foreach($dosen as $d)
                                    <option value="{{ $d->id }}" {{ in_array($d->id, old('dosen_ids', $selectedDosen)) ? 'selected' : '' }}>
                                        {{ $d->name }} ({{ $d->nip }})
                                    </option>
                                    @endforeach
                                </select>
                                @error('dosen_ids')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="mahasiswa_ids" class="block text-sm font-medium text-gray-700">Mahasiswa</label>
                                <select name="mahasiswa_ids[]" id="mahasiswa_ids" multiple required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('mahasiswa_ids') border-red-500 @enderror">
                                    @foreach($mahasiswa as $m)
                                    <option value="{{ $m->id }}" {{ in_array($m->id, old('mahasiswa_ids', $selectedMahasiswa)) ? 'selected' : '' }}>
                                        {{ $m->name }} ({{ $m->nip }})
                                    </option>
                                    @endforeach
                                </select>
                                @error('mahasiswa_ids')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
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

    <!-- Include Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Include Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#dosen_ids').select2({
                placeholder: 'Pilih Dosen',
                allowClear: true,
                width: '100%'
            });

            $('#mahasiswa_ids').select2({
                placeholder: 'Pilih Mahasiswa',
                allowClear: true,
                width: '100%'
            });
        });
    </script>
</x-app-layout>