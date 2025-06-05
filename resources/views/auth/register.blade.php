<x-auth-layout>
    <div class="min-h-screen flex flex-col justify-center items-center pt-6 sm:pt-0">
        <div class="w-full sm:max-w-md py-8 px-8 bg-white border border-gray-100 shadow-none md:shadow-sm overflow-hidden rounded-sm">
            <!-- Header with Logo -->
            <div class="flex flex-row items-center justify-center mb-8">
                <div class="flex items-center">
                    <div class="flex items-center justify-center">
                        <div class="flex items-center justify-center">
                            <i class="fas fa-graduation-cap text-gray-600 fa-xl"></i>
                        </div>
                    </div>
                    <div class="ml-1 flex flex-row items-center">
                        <span class="text-lg font-semibold text-gray-600">Praktikum</span>
                    </div>
                </div>
            </div>

            <!-- Progress Indicator -->
            <div class="mb-6">
                <div class="flex items-center justify-center space-x-2 mb-2">
                    <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                    <div class="w-8 h-1 bg-gray-200 rounded"></div>
                    <div class="w-3 h-3 bg-gray-200 rounded-full"></div>
                    <div class="w-8 h-1 bg-gray-200 rounded"></div>
                    <div class="w-3 h-3 bg-gray-200 rounded-full"></div>
                </div>
                <p class="text-center text-xs text-gray-500">Step 1 of 3 - Basic Information</p>
            </div>

            <form method="POST" action="{{ route('register') }}" id="registerForm">
                @csrf

                <!-- Step 1: Basic Information -->
                <div id="step1" class="step-content">
                    <h3 class="text-lg font-medium text-gray-700 mb-6 text-center">Create Your Account</h3>

                    <div class="mb-4">
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required autocomplete="off"
                            class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:shadow-outline @error('name') border-red-500 @enderror"
                            placeholder="Full Name">
                        @error('name')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required autocomplete="off"
                            class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:shadow-outline @error('email') border-red-500 @enderror"
                            placeholder="Email Address">
                        @error('email')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <select name="role" id="role" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:shadow-outline @error('role') border-red-500 @enderror">
                            <option value="">Select Your Role</option>
                            <option value="dosen" {{ old('role') == 'dosen' ? 'selected' : '' }}>Dosen (Lecturer)</option>
                            <option value="mahasiswa" {{ old('role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa (Student)</option>
                        </select>
                        @error('role')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="button" onclick="nextStep()"
                        class="bg-blue-500 text-white cursor-pointer hover:bg-blue-600 font-medium transition-all duration-300 text-sm py-2 px-2 rounded focus:outline-none focus:shadow-outline w-full mb-4">
                        Continue
                    </button>
                </div>

                <!-- Step 2: ID & Verification -->
                <div id="step2" class="step-content hidden">
                    <h3 class="text-lg font-medium text-gray-700 mb-6 text-center">Verification Details</h3>

                    <div class="mb-4">
                        <input type="text" name="nip" id="nip" value="{{ old('nip') }}" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:shadow-outline @error('nip') border-red-500 @enderror"
                            placeholder="NIP/NIM">
                        <p class="text-xs text-gray-500 mt-1">Enter your Employee ID (NIP) or Student ID (NIM)</p>
                        @error('nip')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <input type="text" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir') }}" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:shadow-outline @error('tempat_lahir') border-red-500 @enderror"
                                placeholder="Tempat Lahir">
                            @error('tempat_lahir')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:shadow-outline @error('tanggal_lahir') border-red-500 @enderror"
                                placeholder="Tanggal Lahir">
                            @error('tanggal_lahir')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <select name="jenis_kelamin" id="jenis_kelamin" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:shadow-outline @error('jenis_kelamin') border-red-500 @enderror">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <select name="agama" id="agama" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:shadow-outline @error('agama') border-red-500 @enderror">
                                <option value="">Pilih Agama</option>
                                <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                            </select>
                            @error('agama')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <input type="tel" name="nomor_telepon" id="nomor_telepon" value="{{ old('nomor_telepon') }}" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:shadow-outline @error('nomor_telepon') border-red-500 @enderror"
                            placeholder="Nomor Telepon / HP">
                        @error('nomor_telepon')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <textarea name="alamat_ktp" id="alamat_ktp" required rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:shadow-outline @error('alamat_ktp') border-red-500 @enderror"
                            placeholder="Alamat Sesuai KTP">{{ old('alamat_ktp') }}</textarea>
                        @error('alamat_ktp')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex space-x-3">
                        <button type="button" onclick="prevStep()"
                            class="bg-gray-300 text-gray-700 cursor-pointer hover:bg-gray-400 font-medium transition-all duration-300 text-sm py-2 px-2 rounded focus:outline-none focus:shadow-outline w-full">
                            Back
                        </button>
                        <button type="button" onclick="nextStep()"
                            class="bg-blue-500 text-white cursor-pointer hover:bg-blue-600 font-medium transition-all duration-300 text-sm py-2 px-2 rounded focus:outline-none focus:shadow-outline w-full">
                            Continue
                        </button>
                    </div>
                </div>

                <!-- Step 3: Password Setup -->
                <div id="step3" class="step-content hidden">
                    <h3 class="text-lg font-medium text-gray-700 mb-6 text-center">Secure Your Account</h3>

                    <div class="mb-4">
                        <input type="password" name="password" id="password" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:shadow-outline @error('password') border-red-500 @enderror"
                            placeholder="Password">
                        <div class="mt-2">
                            <div class="flex items-center space-x-2">
                                <div id="strength-bar" class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                    <div id="strength-fill" class="h-full bg-red-400 transition-all duration-300" style="width: 0%"></div>
                                </div>
                                <span id="strength-text" class="text-xs text-gray-500">Weak</span>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Use at least 8 characters with letters and numbers</p>
                        </div>
                        @error('password')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:shadow-outline"
                            placeholder="Confirm Password">
                        <div id="match-indicator" class="mt-1 text-xs hidden">
                            <span id="match-text"></span>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" name="terms" id="terms" required class="mr-2 rounded">
                            <span class="text-sm text-gray-600">
                                I agree to the <a href="#" class="text-blue-600 hover:text-blue-800">Terms of Service</a>
                                and <a href="#" class="text-blue-600 hover:text-blue-800">Privacy Policy</a>
                            </span>
                        </label>
                    </div>

                    <div class="flex space-x-3">
                        <button type="button" onclick="prevStep()"
                            class="bg-gray-300 text-gray-700 cursor-pointer hover:bg-gray-400 font-medium transition-all duration-300 text-sm py-2 px-2 rounded focus:outline-none focus:shadow-outline w-full">
                            Back
                        </button>
                        <button type="submit"
                            class="bg-green-500 text-white cursor-pointer hover:bg-green-600 font-medium transition-all duration-300 text-sm py-2 px-2 rounded focus:outline-none focus:shadow-outline w-full">
                            Create Account
                        </button>
                    </div>
                </div>

                <!-- Login Link -->
                <div class="mt-6">
                    <p class="text-center text-gray-600 text-sm">
                        Already have an account?
                        <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800">Login</a>
                    </p>
                </div>
            </form>
        </div>
    </div>

    <script>
        let currentStep = 1;
        const totalSteps = 3;

        function updateProgressBar() {
            const progressDots = document.querySelectorAll('.flex.items-center.justify-center.space-x-2 > div');
            const progressBars = document.querySelectorAll('.w-8.h-1');

            // Reset all
            progressDots.forEach((dot, index) => {
                if (index % 2 === 0) { // Only dots (every other element)
                    const dotIndex = Math.floor(index / 2) + 1;
                    if (dotIndex <= currentStep) {
                        dot.className = 'w-3 h-3 bg-blue-500 rounded-full';
                    } else {
                        dot.className = 'w-3 h-3 bg-gray-200 rounded-full';
                    }
                }
            });

            progressBars.forEach((bar, index) => {
                if (index + 1 < currentStep) {
                    bar.className = 'w-8 h-1 bg-blue-500 rounded';
                } else {
                    bar.className = 'w-8 h-1 bg-gray-200 rounded';
                }
            });

            // Update step text
            const stepText = document.querySelector('.text-center.text-xs.text-gray-500');
            const stepTitles = ['Basic Information', 'Verification Details', 'Account Security'];
            stepText.textContent = `Step ${currentStep} of ${totalSteps} - ${stepTitles[currentStep - 1]}`;
        }

        function nextStep() {
            if (validateCurrentStep()) {
                document.getElementById(`step${currentStep}`).classList.add('hidden');
                currentStep++;
                document.getElementById(`step${currentStep}`).classList.remove('hidden');
                updateProgressBar();
            }
        }

        function prevStep() {
            document.getElementById(`step${currentStep}`).classList.add('hidden');
            currentStep--;
            document.getElementById(`step${currentStep}`).classList.remove('hidden');
            updateProgressBar();
        }

        function validateCurrentStep() {
            const currentStepElement = document.getElementById(`step${currentStep}`);
            const requiredFields = currentStepElement.querySelectorAll('input[required], select[required]');

            for (let field of requiredFields) {
                if (!field.value.trim()) {
                    field.focus();
                    field.classList.add('border-red-500');
                    return false;
                }
                field.classList.remove('border-red-500');
            }
            return true;
        }

        // Password strength checker
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strengthBar = document.getElementById('strength-fill');
            const strengthText = document.getElementById('strength-text');

            let strength = 0;
            let strengthLabel = 'Weak';
            let color = 'bg-red-400';

            if (password.length >= 8) strength += 25;
            if (/[a-z]/.test(password)) strength += 25;
            if (/[A-Z]/.test(password)) strength += 25;
            if (/[0-9]/.test(password)) strength += 25;

            if (strength >= 75) {
                strengthLabel = 'Strong';
                color = 'bg-green-400';
            } else if (strength >= 50) {
                strengthLabel = 'Medium';
                color = 'bg-yellow-400';
            }

            strengthBar.style.width = strength + '%';
            strengthBar.className = `h-full transition-all duration-300 ${color}`;
            strengthText.textContent = strengthLabel;
        });

        // Password confirmation checker
        document.getElementById('password_confirmation').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmation = this.value;
            const indicator = document.getElementById('match-indicator');
            const matchText = document.getElementById('match-text');

            if (confirmation.length > 0) {
                indicator.classList.remove('hidden');
                if (password === confirmation) {
                    matchText.textContent = '✓ Passwords match';
                    matchText.className = 'text-green-600';
                } else {
                    matchText.textContent = '✗ Passwords do not match';
                    matchText.className = 'text-red-600';
                }
            } else {
                indicator.classList.add('hidden');
            }
        });

        // Role-based placeholder update
        document.getElementById('role').addEventListener('change', function() {
            const nipField = document.getElementById('nip');
            if (this.value === 'dosen') {
                nipField.placeholder = 'NIP (Employee ID)';
            } else if (this.value === 'mahasiswa') {
                nipField.placeholder = 'NIM (Student ID)';
            } else {
                nipField.placeholder = 'NIP/NIM';
            }
        });

        // Initialize
        updateProgressBar();
    </script>
</x-auth-layout>