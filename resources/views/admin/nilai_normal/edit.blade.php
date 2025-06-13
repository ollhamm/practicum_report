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
                    <span>Laporan</span>
                    <span class="pointer-events-none mx-2 text-gray-600">
                        /
                    </span>
                </li>
                <li class="flex cursor-pointer items-center text-sm text-gray-600 transition-colors duration-300 hover:text-gray-400">
                    <a href="{{ route('admin.nilai-normal.index') }}">Manajemen Nilai Normal</a>
                    <span class="pointer-events-none mx-2 text-gray-600">
                        /
                    </span>
                </li>
                <li class="flex items-center text-sm text-gray-700 transition-colors duration-300">
                    <span>Edit Nilai Normal</span>
                </li>
            </ol>
        </div>
        <div class="w-full mx-auto px-2">
            <div class="bg-white overflow-hidden shadow-sm rounded-sm">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Edit Nilai Normal</h2>
                        <a href="{{ route('admin.nilai-normal.index') }}"
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

                    <form action="{{ route('admin.nilai-normal.update', $nilaiNormal) }}" method="POST" class="space-y-6" id="nilaiNormalForm">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="test_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Test <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="test_name" name="test_name" required maxlength="100"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-transparent @error('test_name') border-red-500 focus:ring-red-500 @enderror"
                                    placeholder="Contoh: Hematologi Rutin"
                                    value="{{ old('test_name', $nilaiNormal->test_name) }}">
                                @error('test_name')
                                <p class="mt-1 text-sm text-red-500 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>

                            <div>
                                <label for="parameter" class="block text-sm font-medium text-gray-700 mb-2">
                                    Parameter <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="parameter" name="parameter" required maxlength="100"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-transparent @error('parameter') border-red-500 focus:ring-red-500 @enderror"
                                    placeholder="Contoh: Hemoglobin"
                                    value="{{ old('parameter', $nilaiNormal->parameter) }}">
                                @error('parameter')
                                <p class="mt-1 text-sm text-red-500 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>

                            <div>
                                <label for="unit" class="block text-sm font-medium text-gray-700 mb-2">
                                    Unit <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="unit" name="unit" required maxlength="20"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-transparent @error('unit') border-red-500 focus:ring-red-500 @enderror"
                                    placeholder="Contoh: g/dL, mg/dL, %"
                                    value="{{ old('unit', $nilaiNormal->unit) }}">
                                @error('unit')
                                <p class="mt-1 text-sm text-red-500 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>

                            <div>
                                <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">
                                    Jenis Kelamin
                                </label>
                                <select id="gender" name="gender"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-transparent @error('gender') border-red-500 focus:ring-red-500 @enderror">
                                    <option value="">Semua</option>
                                    <option value="L" {{ old('gender', $nilaiNormal->gender) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('gender', $nilaiNormal->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('gender')
                                <p class="mt-1 text-sm text-red-500 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>

                            <div>
                                <label for="normal_min" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nilai Normal Min
                                </label>
                                <input type="number" id="normal_min" name="normal_min" step="0.01"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-transparent @error('normal_min') border-red-500 focus:ring-red-500 @enderror"
                                    placeholder="Contoh: 13.5"
                                    value="{{ old('normal_min', $nilaiNormal->normal_min) }}">
                                @error('normal_min')
                                <p class="mt-1 text-sm text-red-500 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>

                            <div>
                                <label for="normal_max" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nilai Normal Max
                                </label>
                                <input type="number" id="normal_max" name="normal_max" step="0.01"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-transparent @error('normal_max') border-red-500 focus:ring-red-500 @enderror"
                                    placeholder="Contoh: 17.5"
                                    value="{{ old('normal_max', $nilaiNormal->normal_max) }}">
                                @error('normal_max')
                                <p class="mt-1 text-sm text-red-500 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>

                            <div>
                                <label for="age_min" class="block text-sm font-medium text-gray-700 mb-2">
                                    Umur Min (tahun) <span class="text-red-500">*</span>
                                </label>
                                <input type="number" id="age_min" name="age_min" required min="0"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-transparent @error('age_min') border-red-500 focus:ring-red-500 @enderror"
                                    placeholder="Contoh: 18"
                                    value="{{ old('age_min', $nilaiNormal->age_min) }}">
                                @error('age_min')
                                <p class="mt-1 text-sm text-red-500 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>

                            <div>
                                <label for="age_max" class="block text-sm font-medium text-gray-700 mb-2">
                                    Umur Max (tahun) <span class="text-red-500">*</span>
                                </label>
                                <input type="number" id="age_max" name="age_max" required min="0"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-transparent @error('age_max') border-red-500 focus:ring-red-500 @enderror"
                                    placeholder="Contoh: 65"
                                    value="{{ old('age_max', $nilaiNormal->age_max) }}">
                                @error('age_max')
                                <p class="mt-1 text-sm text-red-500 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="referensi" class="block text-sm font-medium text-gray-700 mb-2">
                                    Referensi <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="referensi" name="referensi" required maxlength="100"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-transparent @error('referensi') border-red-500 focus:ring-red-500 @enderror"
                                    placeholder="Contoh: WHO 2011, Henry's Lab"
                                    value="{{ old('referensi', $nilaiNormal->referensi) }}">
                                @error('referensi')
                                <p class="mt-1 text-sm text-red-500 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>
                        </div>

                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-sm font-medium text-gray-500 mb-4">Catatan Tambahan</h3>

                            <div>
                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                                    Notes
                                </label>
                                <textarea id="notes" name="notes" rows="4"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:border-transparent @error('notes') border-red-500 focus:ring-red-500 @enderror"
                                    placeholder="Masukkan catatan tambahan (opsional)">{{ old('notes', $nilaiNormal->notes) }}</textarea>
                                @error('notes')
                                <p class="mt-1 text-sm text-red-500 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex flex-row items-center justify-end gap-3 pt-6 border-t border-gray-200">
                            <a href="{{ route('admin.nilai-normal.index') }}"
                                class="flex items-center justify-center transition-all text-sm cursor-pointer duration-300 border border-gray-400 px-4 py-2 rounded-sm text-gray-600 hover:bg-gray-500 hover:text-white min-w-[120px]">
                                <i class="fas fa-times mr-2 fa-lg"></i>
                                Batal
                            </a>
                            <button type="submit" id="submitBtn"
                                class="flex items-center justify-center transition-all text-sm cursor-pointer duration-300 border border-blue-500 px-4 py-2 rounded-sm text-blue-500 hover:bg-blue-500 hover:text-white min-w-[120px]">
                                <i class="fas fa-save mr-2 fa-lg"></i>
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Validation for age range
            const ageMin = document.getElementById('age_min');
            const ageMax = document.getElementById('age_max');

            function validateAgeRange() {
                const minVal = parseInt(ageMin.value) || 0;
                const maxVal = parseInt(ageMax.value) || 0;

                if (minVal > maxVal && maxVal > 0) {
                    ageMax.setCustomValidity('Umur maksimal harus lebih besar dari umur minimal');
                } else {
                    ageMax.setCustomValidity('');
                }
            }

            ageMin.addEventListener('input', validateAgeRange);
            ageMax.addEventListener('input', validateAgeRange);

            // Validation for normal range
            const normalMin = document.getElementById('normal_min');
            const normalMax = document.getElementById('normal_max');

            function validateNormalRange() {
                const minVal = parseFloat(normalMin.value) || 0;
                const maxVal = parseFloat(normalMax.value) || 0;

                if (minVal > maxVal && maxVal > 0 && minVal > 0) {
                    normalMax.setCustomValidity('Nilai maksimal harus lebih besar dari nilai minimal');
                } else {
                    normalMax.setCustomValidity('');
                }
            }

            normalMin.addEventListener('input', validateNormalRange);
            normalMax.addEventListener('input', validateNormalRange);

            // Form submission confirmation (optional)
            const form = document.getElementById('nilaiNormalForm');
            form.addEventListener('submit', function(e) {
                const submitBtn = document.getElementById('submitBtn');
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2 fa-lg"></i>Updating...';
                submitBtn.disabled = true;
            });
        });
    </script>
</x-app-layout>