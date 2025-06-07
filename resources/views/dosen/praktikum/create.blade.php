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
                                <label for="matakuliah" class="block text-sm font-medium text-gray-700 mb-2">
                                    Mata Kuliah <span class="text-red-500">*</span>
                                </label>
                                <select name="matakuliah" id="matakuliah" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-transparent @error('matakuliah') border-red-500 focus:ring-red-500 @enderror">
                                    <option value="">Pilih Mata Kuliah</option>

                                    <!-- Mata Kuliah Dasar Umum -->
                                    <optgroup label="Mata Kuliah Dasar Umum">
                                        <option value="Pancasila" {{ old('matakuliah') == 'Pancasila' ? 'selected' : '' }}>Pancasila</option>
                                        <option value="Pendidikan Kewarganegaraan" {{ old('matakuliah') == 'Pendidikan Kewarganegaraan' ? 'selected' : '' }}>Pendidikan Kewarganegaraan</option>
                                        <option value="Bahasa Indonesia" {{ old('matakuliah') == 'Bahasa Indonesia' ? 'selected' : '' }}>Bahasa Indonesia</option>
                                        <option value="Bahasa Inggris" {{ old('matakuliah') == 'Bahasa Inggris' ? 'selected' : '' }}>Bahasa Inggris</option>
                                        <option value="Agama Islam" {{ old('matakuliah') == 'Agama Islam' ? 'selected' : '' }}>Agama Islam</option>
                                        <option value="Agama Kristen" {{ old('matakuliah') == 'Agama Kristen' ? 'selected' : '' }}>Agama Kristen</option>
                                        <option value="Agama Katolik" {{ old('matakuliah') == 'Agama Katolik' ? 'selected' : '' }}>Agama Katolik</option>
                                        <option value="Agama Hindu" {{ old('matakuliah') == 'Agama Hindu' ? 'selected' : '' }}>Agama Hindu</option>
                                        <option value="Agama Buddha" {{ old('matakuliah') == 'Agama Buddha' ? 'selected' : '' }}>Agama Buddha</option>
                                        <option value="Agama Khonghucu" {{ old('matakuliah') == 'Agama Khonghucu' ? 'selected' : '' }}>Agama Khonghucu</option>
                                    </optgroup>

                                    <!-- Matematika dan Sains -->
                                    <optgroup label="Matematika dan Sains">
                                        <option value="Matematika Dasar" {{ old('matakuliah') == 'Matematika Dasar' ? 'selected' : '' }}>Matematika Dasar</option>
                                        <option value="Kalkulus" {{ old('matakuliah') == 'Kalkulus' ? 'selected' : '' }}>Kalkulus</option>
                                        <option value="Aljabar Linear" {{ old('matakuliah') == 'Aljabar Linear' ? 'selected' : '' }}>Aljabar Linear</option>
                                        <option value="Statistika" {{ old('matakuliah') == 'Statistika' ? 'selected' : '' }}>Statistika</option>
                                        <option value="Fisika Dasar" {{ old('matakuliah') == 'Fisika Dasar' ? 'selected' : '' }}>Fisika Dasar</option>
                                        <option value="Kimia Dasar" {{ old('matakuliah') == 'Kimia Dasar' ? 'selected' : '' }}>Kimia Dasar</option>
                                        <option value="Biologi Dasar" {{ old('matakuliah') == 'Biologi Dasar' ? 'selected' : '' }}>Biologi Dasar</option>
                                    </optgroup>

                                    <!-- Teknologi Informasi -->
                                    <optgroup label="Teknologi Informasi">
                                        <option value="Algoritma dan Pemrograman" {{ old('matakuliah') == 'Algoritma dan Pemrograman' ? 'selected' : '' }}>Algoritma dan Pemrograman</option>
                                        <option value="Struktur Data" {{ old('matakuliah') == 'Struktur Data' ? 'selected' : '' }}>Struktur Data</option>
                                        <option value="Basis Data" {{ old('matakuliah') == 'Basis Data' ? 'selected' : '' }}>Basis Data</option>
                                        <option value="Jaringan Komputer" {{ old('matakuliah') == 'Jaringan Komputer' ? 'selected' : '' }}>Jaringan Komputer</option>
                                        <option value="Pemrograman Web" {{ old('matakuliah') == 'Pemrograman Web' ? 'selected' : '' }}>Pemrograman Web</option>
                                        <option value="Pemrograman Mobile" {{ old('matakuliah') == 'Pemrograman Mobile' ? 'selected' : '' }}>Pemrograman Mobile</option>
                                        <option value="Sistem Operasi" {{ old('matakuliah') == 'Sistem Operasi' ? 'selected' : '' }}>Sistem Operasi</option>
                                        <option value="Rekayasa Perangkat Lunak" {{ old('matakuliah') == 'Rekayasa Perangkat Lunak' ? 'selected' : '' }}>Rekayasa Perangkat Lunak</option>
                                        <option value="Kecerdasan Buatan" {{ old('matakuliah') == 'Kecerdasan Buatan' ? 'selected' : '' }}>Kecerdasan Buatan</option>
                                        <option value="Machine Learning" {{ old('matakuliah') == 'Machine Learning' ? 'selected' : '' }}>Machine Learning</option>
                                        <option value="Data Mining" {{ old('matakuliah') == 'Data Mining' ? 'selected' : '' }}>Data Mining</option>
                                        <option value="Cyber Security" {{ old('matakuliah') == 'Cyber Security' ? 'selected' : '' }}>Cyber Security</option>
                                    </optgroup>

                                    <!-- Ekonomi dan Bisnis -->
                                    <optgroup label="Ekonomi dan Bisnis">
                                        <option value="Pengantar Ekonomi" {{ old('matakuliah') == 'Pengantar Ekonomi' ? 'selected' : '' }}>Pengantar Ekonomi</option>
                                        <option value="Akuntansi Dasar" {{ old('matakuliah') == 'Akuntansi Dasar' ? 'selected' : '' }}>Akuntansi Dasar</option>
                                        <option value="Manajemen" {{ old('matakuliah') == 'Manajemen' ? 'selected' : '' }}>Manajemen</option>
                                        <option value="Pemasaran" {{ old('matakuliah') == 'Pemasaran' ? 'selected' : '' }}>Pemasaran</option>
                                        <option value="Keuangan" {{ old('matakuliah') == 'Keuangan' ? 'selected' : '' }}>Keuangan</option>
                                        <option value="Sumber Daya Manusia" {{ old('matakuliah') == 'Sumber Daya Manusia' ? 'selected' : '' }}>Sumber Daya Manusia</option>
                                        <option value="Entrepreneurship" {{ old('matakuliah') == 'Entrepreneurship' ? 'selected' : '' }}>Entrepreneurship</option>
                                    </optgroup>

                                    <!-- Teknik -->
                                    <optgroup label="Teknik">
                                        <option value="Gambar Teknik" {{ old('matakuliah') == 'Gambar Teknik' ? 'selected' : '' }}>Gambar Teknik</option>
                                        <option value="Mekanika Teknik" {{ old('matakuliah') == 'Mekanika Teknik' ? 'selected' : '' }}>Mekanika Teknik</option>
                                        <option value="Elektronika Dasar" {{ old('matakuliah') == 'Elektronika Dasar' ? 'selected' : '' }}>Elektronika Dasar</option>
                                        <option value="Rangkaian Listrik" {{ old('matakuliah') == 'Rangkaian Listrik' ? 'selected' : '' }}>Rangkaian Listrik</option>
                                        <option value="Termodinamika" {{ old('matakuliah') == 'Termodinamika' ? 'selected' : '' }}>Termodinamika</option>
                                        <option value="Mesin-Mesin Listrik" {{ old('matakuliah') == 'Mesin-Mesin Listrik' ? 'selected' : '' }}>Mesin-Mesin Listrik</option>
                                        <option value="Teknik Digital" {{ old('matakuliah') == 'Teknik Digital' ? 'selected' : '' }}>Teknik Digital</option>
                                    </optgroup>

                                    <!-- Sosial dan Humaniora -->
                                    <optgroup label="Sosial dan Humaniora">
                                        <option value="Sosiologi" {{ old('matakuliah') == 'Sosiologi' ? 'selected' : '' }}>Sosiologi</option>
                                        <option value="Psikologi" {{ old('matakuliah') == 'Psikologi' ? 'selected' : '' }}>Psikologi</option>
                                        <option value="Antropologi" {{ old('matakuliah') == 'Antropologi' ? 'selected' : '' }}>Antropologi</option>
                                        <option value="Sejarah" {{ old('matakuliah') == 'Sejarah' ? 'selected' : '' }}>Sejarah</option>
                                        <option value="Filsafat" {{ old('matakuliah') == 'Filsafat' ? 'selected' : '' }}>Filsafat</option>
                                        <option value="Komunikasi" {{ old('matakuliah') == 'Komunikasi' ? 'selected' : '' }}>Komunikasi</option>
                                    </optgroup>

                                    <!-- Kesehatan -->
                                    <optgroup label="Kesehatan">
                                        <option value="Anatomi" {{ old('matakuliah') == 'Anatomi' ? 'selected' : '' }}>Anatomi</option>
                                        <option value="Fisiologi" {{ old('matakuliah') == 'Fisiologi' ? 'selected' : '' }}>Fisiologi</option>
                                        <option value="Farmakologi" {{ old('matakuliah') == 'Farmakologi' ? 'selected' : '' }}>Farmakologi</option>
                                        <option value="Kesehatan Masyarakat" {{ old('matakuliah') == 'Kesehatan Masyarakat' ? 'selected' : '' }}>Kesehatan Masyarakat</option>
                                        <option value="Gizi" {{ old('matakuliah') == 'Gizi' ? 'selected' : '' }}>Gizi</option>
                                    </optgroup>

                                    <!-- Pertanian -->
                                    <optgroup label="Pertanian">
                                        <option value="Ilmu Tanah" {{ old('matakuliah') == 'Ilmu Tanah' ? 'selected' : '' }}>Ilmu Tanah</option>
                                        <option value="Budidaya Tanaman" {{ old('matakuliah') == 'Budidaya Tanaman' ? 'selected' : '' }}>Budidaya Tanaman</option>
                                        <option value="Hama dan Penyakit" {{ old('matakuliah') == 'Hama dan Penyakit' ? 'selected' : '' }}>Hama dan Penyakit</option>
                                        <option value="Agronomi" {{ old('matakuliah') == 'Agronomi' ? 'selected' : '' }}>Agronomi</option>
                                    </optgroup>

                                    <!-- Pendidikan -->
                                    <optgroup label="Pendidikan">
                                        <option value="Kurikulum dan Pembelajaran" {{ old('matakuliah') == 'Kurikulum dan Pembelajaran' ? 'selected' : '' }}>Kurikulum dan Pembelajaran</option>
                                        <option value="Psikologi Pendidikan" {{ old('matakuliah') == 'Psikologi Pendidikan' ? 'selected' : '' }}>Psikologi Pendidikan</option>
                                        <option value="Metodologi Penelitian" {{ old('matakuliah') == 'Metodologi Penelitian' ? 'selected' : '' }}>Metodologi Penelitian</option>
                                        <option value="Evaluasi Pembelajaran" {{ old('matakuliah') == 'Evaluasi Pembelajaran' ? 'selected' : '' }}>Evaluasi Pembelajaran</option>
                                    </optgroup>
                                </select>
                                @error('matakuliah')
                                <p class="mt-1 text-sm text-red-500 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
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