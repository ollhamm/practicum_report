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
                <li class="flex cursor-pointer items-center text-sm text-gray-600 transition-colors duration-300 hover:text-gray-400">
                    <a href="{{ route('admin.users.index') }}">Pengguna</a>
                    <span class="pointer-events-none mx-2 text-gray-600">
                        /
                    </span>
                </li>
                <li class="flex items-center text-sm text-gray-700 transition-colors duration-300">
                    <span>Tambah Pengguna</span>
                </li>
            </ol>
        </div>
        <div class="w-full mx-auto px-2">
            <div class="bg-white overflow-hidden shadow-sm rounded-sm">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Tambah Pengguna Baru</h2>
                        <a href="{{ route('admin.users.index') }}"
                            class="flex items-center justify-center transition-all duration-300 border border-gray-400 p-2 rounded-sm text-gray-600 hover:bg-gray-500 hover:text-white w-8 h-8">
                            <i class="fas fa-arrow-left fa-sm"></i>
                        </a>
                    </div>

                    <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Basic Information -->
                        <div class="bg-gray-50 p-4 rounded-md">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Dasar</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-transparen">
                                    @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-transparen">
                                    @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password <span class="text-red-500">*</span></label>
                                    <input type="password" name="password" id="password" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-transparen">
                                    @error('password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password <span class="text-red-500">*</span></label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-transparen">
                                </div>

                                <div>
                                    <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Role <span class="text-red-500">*</span></label>
                                    <select name="role" id="role" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-transparen">
                                        <option value="">Pilih Role</option>
                                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="dosen" {{ old('role') === 'dosen' ? 'selected' : '' }}>Dosen</option>
                                        <option value="mahasiswa" {{ old('role') === 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                                    </select>
                                    @error('role')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="nip" class="block text-sm font-medium text-gray-700 mb-2">NIP/NIM <span class="text-red-500">*</span></label>
                                    <input type="text" name="nip" id="nip" value="{{ old('nip') }}" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-transparen"
                                        placeholder="NIP untuk dosen, NIM untuk mahasiswa">
                                    @error('nip')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Personal Information -->
                        <div class="bg-gray-50 p-4 rounded-md">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Pribadi</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="tempat_lahir" class="block text-sm font-medium text-gray-700 mb-2">Tempat Lahir <span class="text-red-500">*</span></label>
                                    <input type="text" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir') }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-transparen" required>
                                    @error('tempat_lahir')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir <span class="text-red-500">*</span></label>
                                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-transparen" required>
                                    @error('tanggal_lahir')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin <span class="text-red-500">*</span></label>
                                    <select name="jenis_kelamin" id="jenis_kelamin"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-transparen" required>
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="L" {{ old('jenis_kelamin') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ old('jenis_kelamin') === 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="agama" class="block text-sm font-medium text-gray-700 mb-2">Agama <span class="text-red-500">*</span></label>
                                    <select name="agama" id="agama"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-transparent" required>
                                        <option value="">Pilih Agama</option>
                                        <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                        <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                        <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                        <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                        <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                        <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                    </select>
                                    @error('agama')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="nomor_telepon" class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                                    <input type="text" name="nomor_telepon" id="nomor_telepon" value="{{ old('nomor_telepon') }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-transparen">
                                    @error('nomor_telepon')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-4">
                                <label for="alamat_ktp" class="block text-sm font-medium text-gray-700 mb-2">Alamat (Sesuia KTP) <span class="text-red-500">*</span></label>
                                <textarea name="alamat_ktp" id="alamat_ktp" rows="3"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-transparen" required>{{ old('alamat_ktp') }}</textarea>
                                @error('alamat_ktp')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end space-x-3">
                            <button type="submit"
                                class="flex items-center justify-center transition-all text-sm cursor-pointer duration-300 border border-blue-500 px-4 py-2 rounded-sm text-blue-500 hover:bg-blue-500 hover:text-white min-w-[120px]">
                                <i class="fas fa-save mr-2 fa-lg"></i>
                                Tambah Pengguna
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>