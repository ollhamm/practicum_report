<x-app-layout>
    <div class="py-12">
        <div class="w-full mx-auto px-2">
            <div class="bg-white overflow-hidden shadow-sm rounded-sm">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Tambah Praktikum</h2>
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

                    <form action="{{ route('admin.praktikum.store') }}" method="POST" class="space-y-6" id="praktikumForm">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="kelas_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Kelas <span class="text-red-500">*</span>
                                </label>
                                <select id="kelas_id" name="kelas_id" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-transparent @error('kelas_id') border-red-500 focus:ring-red-500 @enderror">
                                    <option value="">Pilih Kelas</option>
                                    @foreach($kelas_list as $kelas)
                                    <option value="{{ $kelas->id }}" {{ old('kelas_id') == $kelas->id ? 'selected' : '' }}>
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
                                <input type="text" name="judul" id="judul" required value="{{ old('judul') }}"
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
                                <label for="deadline" class="block text-sm font-medium text-gray-700 mb-2">
                                    Deadline <span class="text-red-500">*</span>
                                </label>
                                <input type="datetime-local" name="deadline" id="deadline" required
                                    value="{{ old('deadline') }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-transparent @error('deadline') border-red-500 focus:ring-red-500 @enderror">
                                @error('deadline')
                                <p class="mt-1 text-sm text-red-500 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>
                        </div>

                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-sm font-medium text-gray-500 mb-4">Detail Praktikum</h3>

                            <div>
                                <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                                    Deskripsi <span class="text-red-500">*</span>
                                </label>
                                <textarea id="deskripsi" name="deskripsi" rows="4" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-transparent @error('deskripsi') border-red-500 focus:ring-red-500 @enderror"
                                    placeholder="Masukkan deskripsi praktikum">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                <p class="mt-1 text-sm text-red-500 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex flex-row items-center justify-end gap-3 pt-6 border-t border-gray-200">
                            <a href="{{ route('admin.praktikum.index') }}"
                                class="flex items-center justify-center transition-all text-sm duration-300 border border-red-500 px-4 py-2 rounded-sm text-red-500 hover:bg-red-500 hover:text-white min-w-[120px]">
                                <i class="fas fa-times mr-2 fa-xs"></i>
                                Batal
                            </a>
                            <button type="submit" id="submitBtn"
                                class="flex items-center justify-center transition-all text-sm cursor-pointer duration-300 border border-blue-500 px-4 py-2 rounded-sm text-blue-500 hover:bg-blue-500 hover:text-white min-w-[120px]">
                                <i class="fas fa-save mr-2 fa-xs"></i>
                                Simpan
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

            // Handle kelas change
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