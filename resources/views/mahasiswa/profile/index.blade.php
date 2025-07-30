<x-maha-layout>
    <div class="py-6">
        <div class="w-full mx-auto px-2">
            <!-- Header -->
            <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4" data-aos="fade-down" data-aos-duration="400">
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Biodata Mahasiswa</h1>
                    <p class="text-gray-600 mt-1">Informasi profil pengguna</p>
                </div>
                <div>
                    <a href="{{ route('mahasiswa.profile.edit') }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 focus:bg-blue-600 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Biodata
                    </a>
                </div>
            </div>

            <!-- Profile Cards -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Profile Picture Card -->
                <div class="lg:col-span-1" data-aos="fade-up" data-aos-duration="500">
                    <div class="bg-white rounded-lg h-full shadow-sm border border-gray-200">
                        <div class="p-6 text-center">
                            <div class="w-32 h-32 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                @if($user->foto_profile)
                                <img src="{{ asset('storage/' . $user->foto_profile) }}"
                                    alt="Profile Photo"
                                    class="w-32 h-32 rounded-full object-cover">
                                @else
                                <i class="fas fa-user text-4xl text-gray-400"></i>
                                @endif
                            </div>
                            <h4 class="text-lg font-semibold text-gray-900">{{ $user->name }}</h4>
                            <p class="text-sm text-gray-500">{{ $user->nip }}</p>
                            <p class="text-xs text-gray-400 mt-1">Mahasiswa</p>

                        </div>
                    </div>
                </div>

                <!-- Personal Information Card -->
                <div class="lg:col-span-2" data-aos="fade-down" data-aos-duration="600">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                        <div class="p-6 border-b border-gray-100">
                            <div class="flex items-center">
                                <i class="fas fa-id-card text-gray-400 mr-2"></i>
                                <h3 class="text-lg font-semibold text-gray-900">Informasi Pribadi</h3>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-4">
                                    <div>
                                        <label class="text-sm font-medium text-gray-600">Nama Lengkap</label>
                                        <p class="text-sm text-gray-900 mt-1 p-2 bg-gray-50 rounded-lg">{{ $user->name }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-600">NIM</label>
                                        <p class="text-sm text-gray-900 mt-1 p-2 bg-gray-50 rounded-lg">{{ $user->nip }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-600">Email</label>
                                        <p class="text-sm text-gray-900 mt-1 p-2 bg-gray-50 rounded-lg">{{ $user->email }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-600">Jenis Kelamin</label>
                                        <p class="text-sm text-gray-900 mt-1 p-2 bg-gray-50 rounded-lg capitalize">
                                            {{ $user->jenis_kelamin ?? 'Belum diisi' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="space-y-4">
                                    <div>
                                        <label class="text-sm font-medium text-gray-600">Tempat Lahir</label>
                                        <p class="text-sm text-gray-900 mt-1 p-2 bg-gray-50 rounded-lg">
                                            {{ $user->tempat_lahir ?? 'Belum diisi' }}
                                        </p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-600">Tanggal Lahir</label>
                                        <p class="text-sm text-gray-900 mt-1 p-2 bg-gray-50 rounded-lg">
                                            {{ $user->tanggal_lahir ? \Carbon\Carbon::parse($user->tanggal_lahir)->format('d M Y') : 'Belum diisi' }}
                                        </p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-600">Agama</label>
                                        <p class="text-sm text-gray-900 mt-1 p-2 bg-gray-50 rounded-lg capitalize">
                                            {{ $user->agama ?? 'Belum diisi' }}
                                        </p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-600">Nomor Telepon</label>
                                        <p class="text-sm text-gray-900 mt-1 p-2 bg-gray-50 rounded-lg">
                                            {{ $user->nomor_telepon ?? 'Belum diisi' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Address Information Card -->
            <div class="mt-6" data-aos="fade-down" data-aos-duration="700">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex items-center">
                            <i class="fas fa-map-marker-alt text-gray-400 mr-2"></i>
                            <h3 class="text-lg font-semibold text-gray-900">Alamat</h3>
                        </div>
                    </div>
                    <div class="p-6" data-aos="fade-down" data-aos-delay="200">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-sm text-gray-900">
                                {{ $user->alamat_ktp ?? 'Alamat belum diisi. Silakan lengkapi profil Anda.' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Account Information Card -->
            <div class="mt-6" data-aos="fade-down" data-aos-duration="800">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex items-center">
                            <i class="fas fa-cog text-gray-400 mr-2"></i>
                            <h3 class="text-lg font-semibold text-gray-900">Informasi Akun</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-xs text-gray-600 uppercase tracking-wide">Status Email</p>
                                        @if($user->approved_by_admin)
                                        <div class="flex items-center mt-1">
                                            <i class="fas fa-check-circle text-green-500 text-sm mr-1"></i>
                                            <span class="text-sm font-medium text-green-700">Terverifikasi</span>
                                        </div>
                                        @else
                                        <div class="flex items-center mt-1">
                                            <i class="fas fa-exclamation-circle text-yellow-500 text-sm mr-1"></i>
                                            <span class="text-sm font-medium text-yellow-700">Belum Terverifikasi</span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-xs text-gray-600 uppercase tracking-wide">Bergabung Sejak</p>
                                        <p class="text-sm font-medium text-gray-900 mt-1">
                                            {{ \Carbon\Carbon::parse($user->created_at)->format('M Y') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-xs text-gray-600 uppercase tracking-wide">Terakhir Update</p>
                                        <p class="text-sm font-medium text-gray-900 mt-1">
                                            {{ \Carbon\Carbon::parse($user->updated_at)->format('d M Y') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('logout') ?? '#' }}">
                            @csrf
                            <button type="submit"
                                class="cursor-pointer border mt-8 bg-red-100 border-red-500 hover:bg-red-500 text-red-600 hover:text-white transition-all duration-300 font-medium py-2 px-4 rounded-md w-fit text-xs">
                                <i class="fas fa-sign-out-alt mr-1"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Profile image hover effect */
        .group:hover img {
            transform: scale(1.05);
        }
    </style>
</x-maha-layout>