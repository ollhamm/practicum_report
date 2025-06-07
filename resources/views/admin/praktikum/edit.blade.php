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
                    <span>Praktikum</span>
                    <span class="pointer-events-none mx-2 text-gray-600">
                        /
                    </span>
                </li>
                <li class="flex cursor-pointer items-center text-sm text-gray-600 transition-colors duration-300 hover:text-gray-400">
                    <a href="/admin/praktikum">Manajemen Praktikum</a>
                    <span class="pointer-events-none mx-2 text-gray-600">
                        /
                    </span>
                </li>
                <li class="flex items-center text-sm text-gray-700 transition-colors duration-300">
                    <span>Edit Data Praktikum</span>
                </li>
            </ol>
        </div>
        <div class="w-full mx-auto px-2">
            <div class="bg-white overflow-hidden shadow-sm rounded-sm">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Edit Data Praktikum</h2>
                        <a href="{{ route('admin.praktikum.index') }}"
                            class="flex items-center justify-center transition-all duration-300 border border-gray-400 p-2 rounded-sm text-gray-600 hover:bg-gray-500 hover:text-white w-8 h-8">
                            <i class="fas fa-arrow-left fa-sm"></i>
                        </a>
                    </div>

                    @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                        <strong class="font-bold">Ada kesalahan!</strong>
                        <ul class="mt-2">
                            @foreach($errors->all() as $error)
                            <li class="text-sm">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('admin.praktikum.update', $praktikum) }}" method="POST" class="space-y-6" id="praktikumForm">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="kelas_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Kelas <span class="text-red-500">*</span>
                                </label>
                                <select id="kelas_id" name="kelas_id" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-transparent @error('kelas_id') border-red-500 focus:ring-red-500 @enderror">
                                    <option value="">Pilih Kelas</option>
                                    @foreach($kelas_list as $kelas)
                                    <option value="{{ $kelas->id }}" {{ old('kelas_id', $praktikum->kelas_id) == $kelas->id ? 'selected' : '' }}>
                                        {{ $kelas->nama_kelas }} ({{ $kelas->kode }})
                                    </option>
                                    @endforeach
                                </select>
                                @error('kelas_id')
                                <p class="mt-1 text-sm text-red-500 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>

                            <div>
                                <label for="dosen_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Dosen Pengajar <span class="text-red-500">*</span>
                                </label>
                                <select id="dosen_id" name="dosen_id" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-transparent @error('dosen_id') border-red-500 focus:ring-red-500 @enderror">
                                    <option value="">Pilih Dosen</option>
                                    @foreach($praktikum->kelas->dosen as $dosen)
                                    <option value="{{ $dosen->id }}" {{ old('dosen_id', $dosen_id ?? '') == $dosen->id ? 'selected' : '' }}>
                                        {{ $dosen->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('dosen_id')
                                <p class="mt-1 text-sm text-red-500 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>

                            <div>
                                <label for="judul" class="block text-sm font-medium text-gray-700 mb-2">
                                    Judul Praktikum <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="judul" id="judul" required value="{{ old('judul', $praktikum->judul) }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-transparent @error('judul') border-red-500 focus:ring-red-500 @enderror"
                                    placeholder="Masukkan judul praktikum">
                                @error('judul')
                                <p class="mt-1 text-sm text-red-500 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>

                            <div>
                                <label for="matakuliah" class="block text-sm font-medium text-gray-700 mb-2">
                                    Mata Kuliah <span class="text-red-500">*</span>
                                </label>
                                <select name="matakuliah" id="matakuliah" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-transparent @error('matakuliah') border-red-500 focus:ring-red-500 @enderror">
                                    <option value="">Pilih Mata Kuliah</option>

                                    @php
                                    $selectedMatakuliah = old('matakuliah') ?? $praktikum->matakuliah ?? '';
                                    @endphp

                                    <!-- Mata Kuliah Dasar Umum -->
                                    <optgroup label="Mata Kuliah Dasar Umum">
                                        <option value="Pancasila" {{ $selectedMatakuliah == 'Pancasila' ? 'selected' : '' }}>Pancasila</option>
                                        <option value="Pendidikan Kewarganegaraan" {{ $selectedMatakuliah == 'Pendidikan Kewarganegaraan' ? 'selected' : '' }}>Pendidikan Kewarganegaraan</option>
                                        <option value="Bahasa Indonesia" {{ $selectedMatakuliah == 'Bahasa Indonesia' ? 'selected' : '' }}>Bahasa Indonesia</option>
                                        <option value="Bahasa Inggris" {{ $selectedMatakuliah == 'Bahasa Inggris' ? 'selected' : '' }}>Bahasa Inggris</option>
                                        <option value="Agama Islam" {{ $selectedMatakuliah == 'Agama Islam' ? 'selected' : '' }}>Agama Islam</option>
                                        <option value="Agama Kristen" {{ $selectedMatakuliah == 'Agama Kristen' ? 'selected' : '' }}>Agama Kristen</option>
                                        <option value="Agama Katolik" {{ $selectedMatakuliah == 'Agama Katolik' ? 'selected' : '' }}>Agama Katolik</option>
                                        <option value="Agama Hindu" {{ $selectedMatakuliah == 'Agama Hindu' ? 'selected' : '' }}>Agama Hindu</option>
                                        <option value="Agama Buddha" {{ $selectedMatakuliah == 'Agama Buddha' ? 'selected' : '' }}>Agama Buddha</option>
                                        <option value="Agama Khonghucu" {{ $selectedMatakuliah == 'Agama Khonghucu' ? 'selected' : '' }}>Agama Khonghucu</option>
                                    </optgroup>

                                    <!-- Matematika dan Sains -->
                                    <optgroup label="Matematika dan Sains">
                                        <option value="Matematika Dasar" {{ $selectedMatakuliah == 'Matematika Dasar' ? 'selected' : '' }}>Matematika Dasar</option>
                                        <option value="Kalkulus" {{ $selectedMatakuliah == 'Kalkulus' ? 'selected' : '' }}>Kalkulus</option>
                                        <option value="Aljabar Linear" {{ $selectedMatakuliah == 'Aljabar Linear' ? 'selected' : '' }}>Aljabar Linear</option>
                                        <option value="Statistika" {{ $selectedMatakuliah == 'Statistika' ? 'selected' : '' }}>Statistika</option>
                                        <option value="Fisika Dasar" {{ $selectedMatakuliah == 'Fisika Dasar' ? 'selected' : '' }}>Fisika Dasar</option>
                                        <option value="Kimia Dasar" {{ $selectedMatakuliah == 'Kimia Dasar' ? 'selected' : '' }}>Kimia Dasar</option>
                                        <option value="Biologi Dasar" {{ $selectedMatakuliah == 'Biologi Dasar' ? 'selected' : '' }}>Biologi Dasar</option>
                                    </optgroup>

                                    <!-- Teknologi Informasi -->
                                    <optgroup label="Teknologi Informasi">
                                        <option value="Algoritma dan Pemrograman" {{ $selectedMatakuliah == 'Algoritma dan Pemrograman' ? 'selected' : '' }}>Algoritma dan Pemrograman</option>
                                        <option value="Struktur Data" {{ $selectedMatakuliah == 'Struktur Data' ? 'selected' : '' }}>Struktur Data</option>
                                        <option value="Basis Data" {{ $selectedMatakuliah == 'Basis Data' ? 'selected' : '' }}>Basis Data</option>
                                        <option value="Jaringan Komputer" {{ $selectedMatakuliah == 'Jaringan Komputer' ? 'selected' : '' }}>Jaringan Komputer</option>
                                        <option value="Pemrograman Web" {{ $selectedMatakuliah == 'Pemrograman Web' ? 'selected' : '' }}>Pemrograman Web</option>
                                        <option value="Pemrograman Mobile" {{ $selectedMatakuliah == 'Pemrograman Mobile' ? 'selected' : '' }}>Pemrograman Mobile</option>
                                        <option value="Sistem Operasi" {{ $selectedMatakuliah == 'Sistem Operasi' ? 'selected' : '' }}>Sistem Operasi</option>
                                        <option value="Rekayasa Perangkat Lunak" {{ $selectedMatakuliah == 'Rekayasa Perangkat Lunak' ? 'selected' : '' }}>Rekayasa Perangkat Lunak</option>
                                        <option value="Kecerdasan Buatan" {{ $selectedMatakuliah == 'Kecerdasan Buatan' ? 'selected' : '' }}>Kecerdasan Buatan</option>
                                        <option value="Machine Learning" {{ $selectedMatakuliah == 'Machine Learning' ? 'selected' : '' }}>Machine Learning</option>
                                        <option value="Data Mining" {{ $selectedMatakuliah == 'Data Mining' ? 'selected' : '' }}>Data Mining</option>
                                        <option value="Cyber Security" {{ $selectedMatakuliah == 'Cyber Security' ? 'selected' : '' }}>Cyber Security</option>
                                    </optgroup>

                                    <!-- Ekonomi dan Bisnis -->
                                    <optgroup label="Ekonomi dan Bisnis">
                                        <option value="Pengantar Ekonomi" {{ $selectedMatakuliah == 'Pengantar Ekonomi' ? 'selected' : '' }}>Pengantar Ekonomi</option>
                                        <option value="Akuntansi Dasar" {{ $selectedMatakuliah == 'Akuntansi Dasar' ? 'selected' : '' }}>Akuntansi Dasar</option>
                                        <option value="Manajemen" {{ $selectedMatakuliah == 'Manajemen' ? 'selected' : '' }}>Manajemen</option>
                                        <option value="Pemasaran" {{ $selectedMatakuliah == 'Pemasaran' ? 'selected' : '' }}>Pemasaran</option>
                                        <option value="Keuangan" {{ $selectedMatakuliah == 'Keuangan' ? 'selected' : '' }}>Keuangan</option>
                                        <option value="Sumber Daya Manusia" {{ $selectedMatakuliah == 'Sumber Daya Manusia' ? 'selected' : '' }}>Sumber Daya Manusia</option>
                                        <option value="Entrepreneurship" {{ $selectedMatakuliah == 'Entrepreneurship' ? 'selected' : '' }}>Entrepreneurship</option>
                                    </optgroup>

                                    <!-- Teknik -->
                                    <optgroup label="Teknik">
                                        <option value="Gambar Teknik" {{ $selectedMatakuliah == 'Gambar Teknik' ? 'selected' : '' }}>Gambar Teknik</option>
                                        <option value="Mekanika Teknik" {{ $selectedMatakuliah == 'Mekanika Teknik' ? 'selected' : '' }}>Mekanika Teknik</option>
                                        <option value="Elektronika Dasar" {{ $selectedMatakuliah == 'Elektronika Dasar' ? 'selected' : '' }}>Elektronika Dasar</option>
                                        <option value="Rangkaian Listrik" {{ $selectedMatakuliah == 'Rangkaian Listrik' ? 'selected' : '' }}>Rangkaian Listrik</option>
                                        <option value="Termodinamika" {{ $selectedMatakuliah == 'Termodinamika' ? 'selected' : '' }}>Termodinamika</option>
                                        <option value="Mesin-Mesin Listrik" {{ $selectedMatakuliah == 'Mesin-Mesin Listrik' ? 'selected' : '' }}>Mesin-Mesin Listrik</option>
                                        <option value="Teknik Digital" {{ $selectedMatakuliah == 'Teknik Digital' ? 'selected' : '' }}>Teknik Digital</option>
                                    </optgroup>

                                    <!-- Sosial dan Humaniora -->
                                    <optgroup label="Sosial dan Humaniora">
                                        <option value="Sosiologi" {{ $selectedMatakuliah == 'Sosiologi' ? 'selected' : '' }}>Sosiologi</option>
                                        <option value="Psikologi" {{ $selectedMatakuliah == 'Psikologi' ? 'selected' : '' }}>Psikologi</option>
                                        <option value="Antropologi" {{ $selectedMatakuliah == 'Antropologi' ? 'selected' : '' }}>Antropologi</option>
                                        <option value="Sejarah" {{ $selectedMatakuliah == 'Sejarah' ? 'selected' : '' }}>Sejarah</option>
                                        <option value="Filsafat" {{ $selectedMatakuliah == 'Filsafat' ? 'selected' : '' }}>Filsafat</option>
                                        <option value="Komunikasi" {{ $selectedMatakuliah == 'Komunikasi' ? 'selected' : '' }}>Komunikasi</option>
                                    </optgroup>

                                    <!-- Kesehatan -->
                                    <optgroup label="Kesehatan">
                                        <option value="Anatomi" {{ $selectedMatakuliah == 'Anatomi' ? 'selected' : '' }}>Anatomi</option>
                                        <option value="Fisiologi" {{ $selectedMatakuliah == 'Fisiologi' ? 'selected' : '' }}>Fisiologi</option>
                                        <option value="Farmakologi" {{ $selectedMatakuliah == 'Farmakologi' ? 'selected' : '' }}>Farmakologi</option>
                                        <option value="Kesehatan Masyarakat" {{ $selectedMatakuliah == 'Kesehatan Masyarakat' ? 'selected' : '' }}>Kesehatan Masyarakat</option>
                                        <option value="Gizi" {{ $selectedMatakuliah == 'Gizi' ? 'selected' : '' }}>Gizi</option>
                                    </optgroup>

                                    <!-- Pertanian -->
                                    <optgroup label="Pertanian">
                                        <option value="Ilmu Tanah" {{ $selectedMatakuliah == 'Ilmu Tanah' ? 'selected' : '' }}>Ilmu Tanah</option>
                                        <option value="Budidaya Tanaman" {{ $selectedMatakuliah == 'Budidaya Tanaman' ? 'selected' : '' }}>Budidaya Tanaman</option>
                                        <option value="Hama dan Penyakit" {{ $selectedMatakuliah == 'Hama dan Penyakit' ? 'selected' : '' }}>Hama dan Penyakit</option>
                                        <option value="Agronomi" {{ $selectedMatakuliah == 'Agronomi' ? 'selected' : '' }}>Agronomi</option>
                                    </optgroup>

                                    <!-- Pendidikan -->
                                    <optgroup label="Pendidikan">
                                        <option value="Kurikulum dan Pembelajaran" {{ $selectedMatakuliah == 'Kurikulum dan Pembelajaran' ? 'selected' : '' }}>Kurikulum dan Pembelajaran</option>
                                        <option value="Psikologi Pendidikan" {{ $selectedMatakuliah == 'Psikologi Pendidikan' ? 'selected' : '' }}>Psikologi Pendidikan</option>
                                        <option value="Metodologi Penelitian" {{ $selectedMatakuliah == 'Metodologi Penelitian' ? 'selected' : '' }}>Metodologi Penelitian</option>
                                        <option value="Evaluasi Pembelajaran" {{ $selectedMatakuliah == 'Evaluasi Pembelajaran' ? 'selected' : '' }}>Evaluasi Pembelajaran</option>
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
                                <label for="deadline" class="block text-sm font-medium text-gray-700 mb-2">
                                    Deadline <span class="text-red-500">*</span>
                                </label>
                                <input type="datetime-local" name="deadline" id="deadline" required
                                    value="{{ old('deadline', $praktikum->deadline ? $praktikum->deadline->format('Y-m-d\TH:i') : '') }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-transparent @error('deadline') border-red-500 focus:ring-red-500 @enderror">
                                @error('deadline')
                                <p class="mt-1 text-sm text-red-500 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>
                        </div>

                        <div class="border-t border-gray-200 mt-8 pt-6">
                            <h3 class="text-sm text-gray-500 mb-4">Detail Praktikum</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="panduan" class="block text-sm font-medium text-gray-700 mb-2">File Panduan <span class="text-[11px]">(PDF)</span></label>
                                    @if($praktikum->panduan_path)
                                    <div class="mb-2 flex items-center space-x-2">
                                        <span class="text-sm text-gray-500">File saat ini:</span>
                                        <a href="{{ route('admin.praktikum.view-panduan', $praktikum) }}"
                                            target="_blank"
                                            class="text-purple-600 hover:text-purple-800 text-sm">
                                            Lihat Panduan
                                        </a>
                                        <a href="{{ route('admin.praktikum.download-panduan', $praktikum) }}"
                                            class="text-blue-600 hover:text-blue-800 text-sm">
                                            Download Panduan
                                        </a>
                                    </div>
                                    @endif
                                    <input type="file" name="panduan" id="panduan" accept=".pdf"
                                        class="w-full px-3 py-2 bg-gray-200 rounded-sm @error('panduan') border-red-500 @enderror">
                                    <p class="mt-1 text-sm text-gray-500">Max. 10MB</p>
                                    @error('panduan')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="template" class="block text-sm font-medium text-gray-700 mb-2">File Template <span class="text-[11px]">(DOC/DOCX/PDF)</span></label>
                                    @if($praktikum->template_path)
                                    <div class="mb-2 flex items-center space-x-2">
                                        <span class="text-sm text-gray-500">File saat ini:</span>
                                        <a href="{{ route('admin.praktikum.view-template', $praktikum) }}"
                                            target="_blank"
                                            class="text-purple-600 hover:text-purple-800 text-sm">
                                            Lihat Template
                                        </a>
                                        <a href="{{ route('admin.praktikum.download-template', $praktikum) }}"
                                            class="text-blue-600 hover:text-blue-800 text-sm">
                                            Download Template
                                        </a>
                                    </div>
                                    @endif
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
                                class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-transparent @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi', $praktikum->deskripsi) }}</textarea>
                            @error('deskripsi')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex flex-row items-center justify-end gap-3 pt-6 border-t border-gray-200">
                            <button type="submit" id="submitBtn"
                                class="flex items-center justify-center transition-all text-sm cursor-pointer duration-300 border border-blue-500 px-4 py-2 rounded-sm text-blue-500 hover:bg-blue-500 hover:text-white min-w-[120px]">
                                <i class="fas fa-save mr-2 fa-lg"></i>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>

                    <!-- Log Container -->
                    <div id="logContainer" class="mt-8 hidden">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Log Sistem</h3>
                        <div class="bg-gray-100 p-4 rounded-md">
                            <pre id="logContent" class="text-sm text-gray-800 whitespace-pre-wrap"></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const kelasSelect = document.getElementById('kelas_id');
            const dosenSelect = document.getElementById('dosen_id');

            kelasSelect.addEventListener('change', function() {
                const kelasId = this.value;
                if (kelasId) {
                    console.log('Fetching dosen for kelas:', kelasId);
                    fetch(`{{ url('/admin/kelas') }}/${kelasId}/dosen`)
                        .then(response => {
                            console.log('Response status:', response.status);
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log('Received dosen data:', data);
                            dosenSelect.innerHTML = '<option value="">Pilih Dosen</option>';
                            if (data && data.length > 0) {
                                data.forEach(dosen => {
                                    dosenSelect.innerHTML += `<option value="${dosen.id}">${dosen.name}</option>`;
                                });
                            } else {
                                dosenSelect.innerHTML = '<option value="">Tidak ada dosen tersedia</option>';
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            dosenSelect.innerHTML = '<option value="">Error mengambil data dosen</option>';
                        });
                } else {
                    dosenSelect.innerHTML = '<option value="">Pilih Dosen</option>';
                }
            });
        });
    </script>
</x-app-layout>