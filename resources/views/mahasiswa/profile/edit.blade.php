<x-maha-layout>
    <div class="py-6">
        <div class="w-full mx-auto px-2">
            <!-- Header -->
            <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Edit Biodata</h1>
                    <p class="text-gray-600 mt-1">Perbarui informasi profil Anda</p>
                </div>
                <div>
                    <a href="{{ route('mahasiswa.profile.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 focus:bg-gray-600 active:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali
                    </a>
                </div>
            </div>

            <!-- Edit Form -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-center">
                        <i class="fas fa-edit text-gray-400 mr-2"></i>
                        <h3 class="text-lg font-semibold text-gray-900">Form Edit Biodata</h3>
                    </div>
                    <p class="text-sm text-gray-600 mt-1">Email dan NIM tidak dapat diubah</p>
                </div>

                <form action="{{ route('mahasiswa.profile.update') }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Personal Information -->
                        <div class="space-y-4">
                            <h4 class="text-md font-semibold text-gray-900 mb-4">Informasi Pribadi</h4>

                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 focus:ring-red-500 @enderror"
                                    placeholder="Masukkan nama lengkap">
                                @error('name')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="tempat_lahir" class="block text-sm font-medium text-gray-700 mb-2">
                                    Tempat Lahir <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir', $user->tempat_lahir) }}" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-transparent @error('tempat_lahir') border-red-500 focus:ring-red-500 @enderror"
                                    placeholder="Masukkan tempat lahir">
                                @error('tempat_lahir')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-2">
                                    Tanggal Lahir <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir', $user->tanggal_lahir) }}" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-transparent @error('tanggal_lahir') border-red-500 focus:ring-red-500 @enderror">
                                @error('tanggal_lahir')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-2">
                                    Jenis Kelamin <span class="text-red-500">*</span>
                                </label>
                                <select name="jenis_kelamin" id="jenis_kelamin" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-transparent @error('jenis_kelamin') border-red-500 focus:ring-red-500 @enderror">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div class="space-y-4">
                            <h4 class="text-md font-semibold text-gray-900 mb-4">Informasi Tambahan</h4>

                            <div>
                                <label for="agama" class="block text-sm font-medium text-gray-700 mb-2">
                                    Agama <span class="text-red-500">*</span>
                                </label>
                                <select name="agama" id="agama" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-transparent @error('agama') border-red-500 focus:ring-red-500 @enderror">
                                    <option value="">Pilih Agama</option>
                                    <option value="Islam" {{ old('agama', $user->agama) == 'Islam' ? 'selected' : '' }}>Islam</option>
                                    <option value="Kristen" {{ old('agama', $user->agama) == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                    <option value="Katolik" {{ old('agama', $user->agama) == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                    <option value="Hindu" {{ old('agama', $user->agama) == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                    <option value="Buddha" {{ old('agama', $user->agama) == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                    <option value="Konghucu" {{ old('agama', $user->agama) == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                </select>
                                @error('agama')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="nomor_telepon" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nomor Telepon <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nomor_telepon" id="nomor_telepon" value="{{ old('nomor_telepon', $user->nomor_telepon) }}" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-transparent @error('nomor_telepon') border-red-500 focus:ring-red-500 @enderror"
                                    placeholder="Masukkan nomor telepon">
                                @error('nomor_telepon')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="alamat_ktp" class="block text-sm font-medium text-gray-700 mb-2">
                                    Alamat KTP <span class="text-red-500">*</span>
                                </label>
                                <textarea name="alamat_ktp" id="alamat_ktp" rows="3" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-transparent @error('alamat_ktp') border-red-500 focus:ring-red-500 @enderror"
                                    placeholder="Masukkan alamat lengkap sesuai KTP">{{ old('alamat_ktp', $user->alamat_ktp) }}</textarea>
                                @error('alamat_ktp')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Password Section -->


                    <!-- Read-only Information -->
                    <div class="mt-8 border-t border-gray-200 pt-6">
                        <h4 class="text-md font-semibold text-gray-900 mb-4">Informasi yang Tidak Dapat Diubah</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" value="{{ $user->email }}" disabled
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm bg-gray-100 text-gray-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">NIM</label>
                                <input type="text" value="{{ $user->nip }}" disabled
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm bg-gray-100 text-gray-500">
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="mt-8 flex justify-end space-x-3">
                        <a href="{{ route('mahasiswa.profile.index') }}"
                            class="px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition-all duration-300 text-sm">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-all duration-300 text-sm">
                            <i class="fas fa-save mr-2"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-maha-layout>