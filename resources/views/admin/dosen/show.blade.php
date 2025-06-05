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
                    <span>Dosen</span>
                    <span class="pointer-events-none mx-2 text-gray-600">
                        /
                    </span>
                </li>
                <li class="flex cursor-pointer items-center text-sm text-gray-600 transition-colors duration-300 hover:text-gray-400">
                    <a href="/admin/dosen">Manajemen Dosen</a>
                    <span class="pointer-events-none mx-2 text-gray-600">
                        /
                    </span>
                </li>
                <li class="flex items-center text-sm text-gray-700 transition-colors duration-300">
                    <span>Detail Data Dosen</span>
                </li>
            </ol>
        </div>
        <div class="w-full mx-auto px-2">
            <div class="bg-white overflow-hidden shadow-sm rounded-sm">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Detail Data Dosen</h2>
                        <a href="{{ route('admin.dosen.index') }}"
                            class="flex items-center justify-center transition-all duration-300 border border-gray-400 p-2 rounded-sm text-gray-600 hover:bg-gray-500 hover:text-white w-8 h-8">
                            <i class="fas fa-arrow-left fa-sm"></i>
                        </a>
                    </div>

                    <!-- m Profile Header -->
                    <div class="bg-gradient-to-r bg-gray-100 border border-gray-200 rounded-sm p-6 mb-2">
                        <div class="flex items-center space-x-6">
                            <div class="w-24 h-24 bg-gradient-to-br from-gray-600 to-gray-700 rounded-sm flex items-center justify-center shadow-lg">
                                <i class="fas fa-user text-white text-4xl"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $dosen->name }}</h3>
                                <div class="flex items-center space-x-4 text-sm text-gray-600">
                                    <div class="flex items-center space-x-1">
                                        <i class="fas fa-envelope text-gray-500"></i>
                                        <span>{{ $dosen->email }}</span>
                                    </div>
                                    <div class="flex items-center space-x-1">
                                        <i class="fas fa-id-card text-gray-500"></i>
                                        <span>{{ $dosen->nip }}</span>
                                    </div>
                                    <div class="flex items-center space-x-1">
                                        <i class="fas fa-m-tag text-gray-500"></i>
                                        <span class="capitalize">{{ $dosen->role }}</span>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <span class="p-1 text-sm font-medium rounded-sm
                                        {{ $dosen->approved_by_admin === 2 ? 'bg-green-500 text-white' : 
                                           ($dosen->approved_by_admin === 1 ? 'bg-red-500 text-white' : 
                                            'bg-yellow-500 text-white') }}">
                                        {{ $dosen->getApprovalStatusText() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        <div class="bg-gray-50 border border-gray-200 rounded-sm p-6">
                            <div class="flex items-center mb-4 pb-2 border-b border-b-gray-300">
                                <i class="fas fa-info-circle text-gray-500 mr-2"></i>
                                <h3 class="text-sm font-semibold text-gray-800">Informasi Dasar</h3>
                            </div>
                            <div class="space-y-4">
                                <div class="flex items-start space-x-3">
                                    <i class="fas fa-user text-gray-400 mt-1 w-4"></i>
                                    <div class="flex-1">
                                        <label class="text-sm font-medium text-gray-500">Nama Lengkap</label>
                                        <p class="mt-1 text-gray-900 text-sm font-medium">{{ $dosen->name }}</p>
                                    </div>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <i class="fas fa-envelope text-gray-400 mt-1 w-4"></i>
                                    <div class="flex-1">
                                        <label class="text-sm font-medium text-gray-500">Email</label>
                                        <p class="mt-1 text-gray-900 text-sm">{{ $dosen->email }}</p>
                                    </div>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <i class="fas fa-user-tag text-gray-400 mt-1 w-4"></i>
                                    <div class="flex-1">
                                        <label class="text-sm font-medium text-gray-500">Role</label>
                                        <p class="mt-1 text-gray-900 text-sm capitalize">{{ $dosen->role }}</p>
                                    </div>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <i class="fas fa-id-card text-gray-400 mt-1 w-4"></i>
                                    <div class="flex-1">
                                        <label class="text-sm font-medium text-gray-500">NIP/NIM</label>
                                        <p class="mt-1 text-gray-900 text-sm ">{{ $dosen->nip }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 border border-gray-200 rounded-sm p-6">
                            <div class="flex items-center mb-4 pb-2 border-b border-b-gray-300">
                                <i class="fas fa-address-card text-gray-500 mr-2"></i>
                                <h3 class="text-sm font-semibold text-gray-800">Informasi Pribadi</h3>
                            </div>
                            <div class="space-y-4">
                                <div class="flex items-start space-x-3">
                                    <i class="fas fa-map-marker-alt text-gray-400 mt-1 w-4"></i>
                                    <div class="flex-1">
                                        <label class="text-sm font-medium text-gray-500">Tempat, Tanggal Lahir</label>
                                        <p class="mt-1 text-gray-900 text-sm">
                                            {{ $dosen->tempat_lahir }}, {{ $dosen->tanggal_lahir ? date('d F Y', strtotime($dosen->tanggal_lahir)) : '-' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <i class="fas fa-venus-mars text-gray-400 mt-1 w-4"></i>
                                    <div class="flex-1">
                                        <label class="text-sm font-medium text-gray-500">Jenis Kelamin</label>
                                        <p class="mt-1 text-gray-900 text-sm">
                                            {{ $dosen->jenis_kelamin === 'L' ? 'Laki-laki' : ($dosen->jenis_kelamin === 'P' ? 'Perempuan' : '-') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <i class="fas fa-pray text-gray-400 mt-1 w-4"></i>
                                    <div class="flex-1">
                                        <label class="text-sm font-medium text-gray-500">Agama</label>
                                        <p class="mt-1 text-gray-900 text-sm">{{ $dosen->agama ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <i class="fas fa-phone text-gray-400 mt-1 w-4"></i>
                                    <div class="flex-1">
                                        <label class="text-sm font-medium text-gray-500">Nomor Telepon</label>
                                        <p class="mt-1 text-gray-900 text-sm">{{ $dosen->nomor_telepon ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <i class="fas fa-home text-gray-400 mt-1 w-4"></i>
                                    <div class="flex-1">
                                        <label class="text-sm font-medium text-gray-500">Alamat KTP</label>
                                        <p class="mt-1 text-gray-900 text-sm">{{ $dosen->alamat_ktp ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Info Section -->
                    <div class="mt-2">
                        <div class="bg-gray-50 border border-gray-200 rounded-sm p-6">
                            <div class="flex items-center mb-4 pb-2 border-b border-b-gray-300">
                                <i class="fas fa-clock text-gray-500 mr-2"></i>
                                <h3 class="text-sm font-semibold text-gray-800">Informasi Sistem</h3>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="flex items-start space-x-3">
                                    <i class="fas fa-calendar-plus text-gray-400 mt-1 w-4"></i>
                                    <div class="flex-1">
                                        <label class="text-sm font-medium text-gray-500">Tanggal Registrasi</label>
                                        <p class="mt-1 text-gray-900 text-sm">
                                            {{ \Carbon\Carbon::parse($dosen->created_at)->locale('id')->translatedFormat('l, d F Y') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <i class="fas fa-edit text-gray-400 mt-1 w-4"></i>
                                    <div class="flex-1">
                                        <label class="text-sm font-medium text-gray-500">Terakhir Diperbarui</label>
                                        <p class="mt-1 text-gray-900 text-sm">
                                            {{ $dosen->updated_at ? \Carbon\Carbon::parse($dosen->updated_at)->locale('id')->translatedFormat('l, d F Y') : '-' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>