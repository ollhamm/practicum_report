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
                    <span>Detail Nilai Normal</span>
                </li>
            </ol>
        </div>
        <div class="w-full mx-auto px-2">
            <div class="bg-white overflow-hidden shadow-sm rounded-sm">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Detail Nilai Normal</h2>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.nilai-normal.edit', $nilaiNormal) }}"
                                class="flex items-center justify-center transition-all duration-300 border border-blue-500 p-2 rounded-sm text-blue-500 hover:bg-blue-500 hover:text-white w-8 h-8">
                                <i class="fas fa-edit fa-sm"></i>
                            </a>
                            <a href="{{ route('admin.nilai-normal.index') }}"
                                class="flex items-center justify-center transition-all duration-300 border border-gray-400 p-2 rounded-sm text-gray-600 hover:bg-gray-500 hover:text-white w-8 h-8">
                                <i class="fas fa-arrow-left fa-sm"></i>
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 border border-gray-200 rounded-sm p-6">
                            <h3 class="text-sm font-semibold text-gray-800 mb-4 border-b border-b-gray-300 pb-2">Informasi Test</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Nama Test</label>
                                    <p class="mt-1 text-gray-900 text-sm">{{ $nilaiNormal->test_name }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Parameter</label>
                                    <p class="mt-1 text-gray-900 text-sm">{{ $nilaiNormal->parameter }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Unit</label>
                                    <p class="mt-1 text-gray-900 text-sm">{{ $nilaiNormal->unit }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Jenis Kelamin</label>
                                    <p class="mt-1 text-gray-900 text-sm">
                                        @if($nilaiNormal->gender == 'L')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            <i class="fas fa-mars mr-1"></i>
                                            Laki-laki
                                        </span>
                                        @elseif($nilaiNormal->gender == 'P')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-pink-100 text-pink-800">
                                            <i class="fas fa-venus mr-1"></i>
                                            Perempuan
                                        </span>
                                        @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            <i class="fas fa-users mr-1"></i>
                                            Semua
                                        </span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 border border-gray-200 rounded-sm p-6">
                            <h3 class="text-sm font-semibold text-gray-800 mb-4 border-b border-b-gray-300 pb-2">Rentang Nilai Normal</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Nilai Minimum</label>
                                    <p class="mt-1 text-gray-900 text-sm">
                                        @if($nilaiNormal->normal_min)
                                        {{ number_format($nilaiNormal->normal_min, 2) }} {{ $nilaiNormal->unit }}
                                        @else
                                        <span class="text-gray-400">Tidak ditentukan</span>
                                        @endif
                                    </p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Nilai Maksimum</label>
                                    <p class="mt-1 text-gray-900 text-sm">
                                        @if($nilaiNormal->normal_max)
                                        {{ number_format($nilaiNormal->normal_max, 2) }} {{ $nilaiNormal->unit }}
                                        @else
                                        <span class="text-gray-400">Tidak ditentukan</span>
                                        @endif
                                    </p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Rentang Nilai</label>
                                    <div class="mt-1">
                                        @if($nilaiNormal->normal_min && $nilaiNormal->normal_max)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                            {{ number_format($nilaiNormal->normal_min, 2) }} - {{ number_format($nilaiNormal->normal_max, 2) }} {{ $nilaiNormal->unit }}
                                        </span>
                                        @elseif($nilaiNormal->normal_min)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                            ≥ {{ number_format($nilaiNormal->normal_min, 2) }} {{ $nilaiNormal->unit }}
                                        </span>
                                        @elseif($nilaiNormal->normal_max)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-orange-100 text-orange-800">
                                            ≤ {{ number_format($nilaiNormal->normal_max, 2) }} {{ $nilaiNormal->unit }}
                                        </span>
                                        @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                            Tidak ditentukan
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <div class="bg-gray-50 border border-gray-200 rounded-sm p-6">
                            <h3 class="text-sm font-semibold text-gray-800 mb-4 border-b border-b-gray-300 pb-2">Informasi Tambahan</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-4">
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Rentang Umur</label>
                                        <p class="mt-1 text-gray-900 text-sm">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                                <i class="fas fa-calendar mr-1"></i>
                                                {{ $nilaiNormal->age_min }} - {{ $nilaiNormal->age_max }} tahun
                                            </span>
                                        </p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Referensi</label>
                                        <p class="mt-1 text-gray-900 text-sm">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                <i class="fas fa-book mr-1"></i>
                                                {{ $nilaiNormal->referensi }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Catatan</label>
                                    @if($nilaiNormal->notes)
                                    <p class="mt-1 text-gray-900 text-sm whitespace-pre-line bg-white p-3 rounded border border-gray-200">{{ $nilaiNormal->notes }}</p>
                                    @else
                                    <p class="mt-1 text-gray-400 text-sm italic">Tidak ada catatan tambahan</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <div class="bg-gray-50 border border-gray-200 rounded-sm p-6">
                            <h3 class="text-sm font-semibold text-gray-800 mb-4 border-b border-b-gray-300 pb-2">Informasi Sistem</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-4">
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Dibuat Pada</label>
                                        <p class="mt-1 text-gray-900 text-sm">
                                            <i class="fas fa-calendar-plus mr-2 text-gray-400"></i>
                                            {{ \Carbon\Carbon::parse($nilaiNormal->created_at)->format('d/m/Y H:i:s') }}
                                        </p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Terakhir Diupdate</label>
                                        <p class="mt-1 text-gray-900 text-sm">
                                            <i class="fas fa-calendar-edit mr-2 text-gray-400"></i>
                                            {{ \Carbon\Carbon::parse($nilaiNormal->updated_at)->format('d/m/Y H:i:s') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="space-y-4">
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Status</label>
                                        <p class="mt-1">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-check-circle mr-1"></i>
                                                Aktif
                                            </span>
                                        </p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">ID Record</label>
                                        <p class="mt-1 text-gray-900 text-sm font-mono">
                                            #{{ str_pad($nilaiNormal->id, 6, '0', STR_PAD_LEFT) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-row items-center justify-end gap-3 pt-6 border-t border-gray-200 mt-6">
                        <a href="{{ route('admin.nilai-normal.index') }}"
                            class="flex items-center justify-center transition-all text-sm cursor-pointer duration-300 border border-gray-400 px-4 py-2 rounded-sm text-gray-600 hover:bg-gray-500 hover:text-white min-w-[120px]">
                            <i class="fas fa-arrow-left mr-2 fa-lg"></i>
                            Kembali
                        </a>
                        <a href="{{ route('admin.nilai-normal.edit', $nilaiNormal) }}"
                            class="flex items-center justify-center transition-all text-sm cursor-pointer duration-300 border border-blue-500 px-4 py-2 rounded-sm text-blue-500 hover:bg-blue-500 hover:text-white min-w-[120px]">
                            <i class="fas fa-edit mr-2 fa-lg"></i>
                            Edit
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>