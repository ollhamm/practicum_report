<x-app-layout>
    <div class="py-12">
        <div class="w-full mx-auto px-2">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-md">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Tambah Kelas</h2>
                        <a href="{{ route('admin.kelas.index') }}"
                            class="flex items-center justify-center transition-all duration-300 border border-gray-400 p-2 rounded-sm text-gray-600 hover:bg-gray-500 hover:text-white w-8 h-8">
                            <i class="fas fa-arrow-left fa-sm"></i>
                        </a>
                    </div>

                    @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                        <strong class="font-bold">Ada kesalahan!</strong>
                        <ul class="mt-2">
                            @foreach($errors->all() as $error)
                            <li class="text-xs">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('admin.kelas.store') }}" method="POST" class="space-y-6" id="kelasForm">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="nama_kelas" class="block text-xs font-medium text-gray-700 mb-2">
                                    Nama Kelas <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nama_kelas" id="nama_kelas" value="{{ old('nama_kelas') }}" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nama_kelas') border-red-500 focus:ring-red-500 @enderror"
                                    placeholder="Masukkan nama kelas">
                                @error('nama_kelas')
                                <p class="mt-1 text-xs text-red-500 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>

                            <div>
                                <label for="kode" class="block text-xs font-medium text-gray-700 mb-2">
                                    Kode Kelas <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="kode" id="kode" value="{{ old('kode') }}" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('kode') border-red-500 focus:ring-red-500 @enderror"
                                    placeholder="Masukkan kode kelas">
                                @error('kode')
                                <p class="mt-1 text-xs text-red-500 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>

                            <div>
                                <label for="tahun_ajaran" class="block text-xs font-medium text-gray-700 mb-2">
                                    Tahun Ajaran <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="tahun_ajaran" id="tahun_ajaran" value="{{ old('tahun_ajaran') }}" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('tahun_ajaran') border-red-500 focus:ring-red-500 @enderror"
                                    placeholder="2023/2024">
                                @error('tahun_ajaran')
                                <p class="mt-1 text-xs text-red-500 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>

                            <div>
                                <label for="semester" class="block text-xs font-medium text-gray-700 mb-2">
                                    Semester <span class="text-red-500">*</span>
                                </label>
                                <select name="semester" id="semester" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('semester') border-red-500 focus:ring-red-500 @enderror">
                                    <option value="">Pilih Semester</option>
                                    <option value="ganjil" {{ old('semester') == 'ganjil' ? 'selected' : '' }}>Ganjil</option>
                                    <option value="genap" {{ old('semester') == 'genap' ? 'selected' : '' }}>Genap</option>
                                </select>
                                @error('semester')
                                <p class="mt-1 text-xs text-red-500 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>

                            <div>
                                <label for="angkatan" class="block text-xs font-medium text-gray-700 mb-2">
                                    Angkatan <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="angkatan" id="angkatan" value="{{ old('angkatan') }}" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('angkatan') border-red-500 focus:ring-red-500 @enderror"
                                    placeholder="2023">
                                @error('angkatan')
                                <p class="mt-1 text-xs text-red-500 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>
                        </div>

                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-xs font-medium text-gray-500 mb-4">Pengaturan Kelas</h3>

                            <div class="space-y-6">
                                <div>
                                    <label for="dosen_ids" class="block text-xs font-medium text-gray-700 mb-2">
                                        Dosen Pengajar <span class="text-red-500">*</span>
                                    </label>
                                    <select name="dosen_ids[]" id="dosen_ids" multiple required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('dosen_ids') border-red-500 focus:ring-red-500 @enderror">
                                        @foreach($dosen as $d)
                                        <option value="{{ $d->id }}" {{ in_array($d->id, old('dosen_ids', [])) ? 'selected' : '' }}>
                                            {{ $d->name }} ({{ $d->nip }})
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('dosen_ids')
                                    <p class="mt-1 text-xs text-red-500 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="mahasiswa_ids" class="block text-xs font-medium text-gray-700 mb-2">
                                        Mahasiswa <span class="text-red-500">*</span>
                                    </label>
                                    <select name="mahasiswa_ids[]" id="mahasiswa_ids" multiple required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('mahasiswa_ids') border-red-500 focus:ring-red-500 @enderror">
                                        @foreach($mahasiswa as $m)
                                        <option value="{{ $m->id }}" {{ in_array($m->id, old('mahasiswa_ids', [])) ? 'selected' : '' }}>
                                            {{ $m->name }} ({{ $m->nip }})
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('mahasiswa_ids')
                                    <p class="mt-1 text-xs text-red-500 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-row items-center justify-end gap-3 pt-6 border-t border-gray-200">
                            <a href="{{ route('admin.kelas.index') }}"
                                class="flex items-center justify-center transition-all text-xs duration-300 border border-red-500 px-4 py-2 rounded-sm text-red-500 hover:bg-red-500 hover:text-white min-w-[120px]">
                                <i class="fas fa-times mr-2 fa-xs"></i>
                                Batal
                            </a>
                            <button type="submit"
                                class="flex items-center justify-center transition-all text-xs cursor-pointer duration-300 border border-blue-500 px-4 py-2 rounded-sm text-blue-500 hover:bg-blue-500 hover:text-white min-w-[120px]">
                                <i class="fas fa-save mr-2 fa-xs"></i>
                                Simpan
                            </button>
                        </div>
                    </form>

                    @if(session('error'))
                    <div class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Error!</strong>
                        <span class="block sm:inline text-xs">{{ session('error') }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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

        document.getElementById('kelasForm').addEventListener('submit', function(e) {
            console.log('Form submitting...');
            console.log('Form data:', {
                nama_kelas: document.getElementById('nama_kelas').value,
                kode: document.getElementById('kode').value,
                tahun_ajaran: document.getElementById('tahun_ajaran').value,
                semester: document.getElementById('semester').value,
                angkatan: document.getElementById('angkatan').value,
                dosen_ids: $('#dosen_ids').val(),
                mahasiswa_ids: $('#mahasiswa_ids').val()
            });
        });
    </script>
</x-app-layout>