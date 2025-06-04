<x-app-layout>
    <div class="py-12">
        <div class="w-full mx-auto px-2">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-md">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Edit Praktikum</h2>
                        <a href="{{ route('admin.praktikum.index') }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md text-sm">
                            Kembali
                        </a>
                    </div>

                    @if($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <ul class="list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.praktikum.update', $praktikum) }}" method="POST" class="space-y-6" id="praktikumForm">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="kelas_id" class="block text-sm font-medium text-gray-700">Kelas</label>
                                <select id="kelas_id" name="kelas_id" required
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="">Pilih Kelas</option>
                                    @foreach($kelas_list as $kelas)
                                        <option value="{{ $kelas->id }}" {{ old('kelas_id', $praktikum->kelas_id) == $kelas->id ? 'selected' : '' }}>
                                            {{ $kelas->nama_kelas }} ({{ $kelas->kode }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('kelas_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="dosen_id" class="block text-sm font-medium text-gray-700">Dosen Pengajar</label>
                                <select id="dosen_id" name="dosen_id" required
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="">Pilih Dosen</option>
                                    @foreach($praktikum->kelas->dosen as $dosen)
                                        <option value="{{ $dosen->id }}" {{ old('dosen_id', $dosen_id ?? '') == $dosen->id ? 'selected' : '' }}>
                                            {{ $dosen->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('dosen_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="judul" class="block text-sm font-medium text-gray-700">Judul Praktikum</label>
                                <input type="text" name="judul" id="judul" required
                                    value="{{ old('judul', $praktikum->judul) }}"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('judul')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="deadline" class="block text-sm font-medium text-gray-700">Deadline</label>
                                <input type="datetime-local" name="deadline" id="deadline" required
                                    value="{{ old('deadline', $praktikum->deadline ? $praktikum->deadline->format('Y-m-d\TH:i') : '') }}"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('deadline')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                            <textarea id="deskripsi" name="deskripsi" rows="4" required
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('deskripsi', $praktikum->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md text-sm">
                                Update Praktikum
                            </button>
                        </div>
                    </form>
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