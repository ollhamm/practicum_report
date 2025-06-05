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
                    <span>Mahasiswa</span>
                    <span class="pointer-events-none mx-2 text-gray-600">
                        /
                    </span>
                </li>
                <li class="flex cursor-pointer items-center text-sm text-gray-600 transition-colors duration-300 hover:text-gray-400">
                    <a href="/admin/mahasiswa">Manajemen Mahasiswa</a>
                    <span class="pointer-events-none mx-2 text-gray-600">
                        /
                    </span>
                </li>
                <li class="flex items-center text-sm text-gray-700 transition-colors duration-300">
                    <span>Edit Data Mahasiswa</span>
                </li>
            </ol>
        </div>
        <div class="w-full mx-auto px-2">
            <div class="bg-white overflow-hidden shadow-sm rounded-sm">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Edit Data Mahasiswa</h2>
                        <a href="{{ route('admin.mahasiswa.index') }}"
                            class="flex items-center justify-center transition-all duration-300 border border-gray-400 p-2 rounded-sm text-gray-600 hover:bg-gray-500 hover:text-white w-8 h-8">
                            <i class="fas fa-arrow-left fa-sm"></i>
                        </a>
                    </div>

                    <form action="{{ route('admin.mahasiswa.update', $mahasiswa) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                            <!-- Basic Information -->
                            <div class=" border border-gray-200 rounded-sm p-6">
                                <div class="flex items-center mb-4 pb-2 border-b border-b-gray-300">
                                    <i class="fas fa-user-graduate text-gray-500 mr-2"></i>
                                    <h3 class="text-sm font-semibold text-gray-800">Informasi Dasar</h3>
                                </div>

                                <div class="space-y-4">
                                    <!-- Name -->
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                            Nama Lengkap <span class="text-red-500">*</span>
                                            <input type="text" name="name" id="name" value="{{ old('name', $mahasiswa->name) }}" required
                                                class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500">
                                            @error('name')
                                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                            @enderror
                                    </div>

                                    <!-- Email (Readonly) -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Email<span class="text-red-500">*</span> </label>
                                        <input type="text" value="{{ $mahasiswa->email }}" disabled readonly
                                            class="w-full px-3 py-2 border bg-gray-100 border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500">
                                    </div>

                                    <!-- NIP (Readonly) -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">NIP <span class="text-red-500">*</span></label>
                                        <input type="text" value="{{ $mahasiswa->nip }}" disabled readonly
                                            class="w-full px-3 py-2 border bg-gray-100 border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500">
                                    </div>

                                    <!-- Password -->
                                    <div>
                                        <label for="password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                                        <input type="password" name="password" id="password"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500">
                                        <p class="mt-1 text-xs text-orange-600">Kosongkan jika tidak ingin mengubah password</p>
                                        @error('password')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Password Confirmation -->
                                    <div>
                                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
                                        <input type="password" name="password_confirmation" id="password_confirmation"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500">
                                        <p class="mt-1 text-xs text-orange-600">Kosongkan jika tidak ingin mengubah password</p>

                                    </div>
                                </div>
                            </div>

                            <!-- Personal Information -->
                            <div class="border border-gray-200 rounded-sm p-6">
                                <div class="flex items-center mb-4 pb-2 border-b border-b-gray-300">
                                    <i class="fas fa-address-card text-gray-500 mr-2"></i>
                                    <h3 class="text-sm font-semibold text-gray-800"> Informasi Pribadi</h3>
                                </div>

                                <div class="space-y-4">
                                    <!-- Tempat Lahir -->
                                    <div>
                                        <label for="tempat_lahir" class="block text-sm font-medium text-gray-700">Tempat Lahir <span class="text-red-500">*</span></label>
                                        <input type="text" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir', $mahasiswa->tempat_lahir) }}" required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500">
                                        @error('tempat_lahir')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Tanggal Lahir -->
                                    <div>
                                        <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700">Tanggal Lahir <span class="text-red-500">*</span></label>
                                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir', $mahasiswa->tanggal_lahir) }}" required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500">
                                        @error('tanggal_lahir')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Jenis Kelamin -->
                                    <div>
                                        <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700">Jenis Kelamin <span class="text-red-500">*</span></label>
                                        <select name="jenis_kelamin" id="jenis_kelamin" required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500">
                                            <option value="L" {{ old('jenis_kelamin', $mahasiswa->jenis_kelamin) === 'L' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="P" {{ old('jenis_kelamin', $mahasiswa->jenis_kelamin) === 'P' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                        @error('jenis_kelamin')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Agama -->
                                    <div>
                                        <label for="agama" class="block text-sm font-medium text-gray-700">Agama <span class="text-red-500">*</span></label>
                                        <select name="agama" id="agama" required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:shadow-outline @error('agama') border-red-500 @enderror">
                                            <option value="">Pilih Agama</option>
                                            <option value="Islam" {{ old('agama', $mahasiswa->agama) == 'Islam' ? 'selected' : '' }}>Islam</option>
                                            <option value="Kristen" {{ old('agama', $mahasiswa->agama) == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                            <option value="Katolik" {{ old('agama', $mahasiswa->agama) == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                            <option value="Hindu" {{ old('agama', $mahasiswa->agama) == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                            <option value="Buddha" {{ old('agama', $mahasiswa->agama) == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                            <option value="Konghucu" {{ old('agama', $mahasiswa->agama) == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                        </select>
                                        @error('agama')
                                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Nomor Telepon -->
                                    <div>
                                        <label for="nomor_telepon" class="block text-sm font-medium text-gray-700">Nomor Telepon <span class="text-red-500">*</span></label>
                                        <input type="text" name="nomor_telepon" id="nomor_telepon" value="{{ old('nomor_telepon', $mahasiswa->nomor_telepon) }}" required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500">
                                        @error('nomor_telepon')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Alamat KTP -->
                                    <div>
                                        <label for="alamat_ktp" class="block text-sm font-medium text-gray-700">Alamat KTP <span class="text-red-500">*</span></label>
                                        <textarea name="alamat_ktp" id="alamat_ktp" rows="3" required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500">{{ old('alamat_ktp', $mahasiswa->alamat_ktp) }}</textarea>
                                        @error('alamat_ktp')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="submit" id="submitBtn"
                                class="flex items-center justify-center transition-all text-sm cursor-pointer duration-300 border border-blue-500 px-4 py-2 rounded-sm text-blue-500 hover:bg-blue-500 hover:text-white min-w-[120px]">
                                <i class="fas fa-save mr-2 fa-lg"></i>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>