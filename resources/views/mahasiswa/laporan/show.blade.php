<x-maha-layout>
    <div class="py-6">
        <div class="w-full mx-auto px-2">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6" data-aos="fade-down" data-aos-duration="400">
                        <h2 class="text-2xl font-semibold text-gray-800">Detail Laporan Praktikum</h2>
                        <div class="space-x-2 flex flex-row items-center">
                            @if($laporan->status !== 'reviewed')
                            <a href="{{ route('mahasiswa.laporan.edit', $laporan) }}"
                                class="flex items-center justify-center transition-all duration-300 border border-yellow-500 p-2 rounded-sm text-yellow-500 hover:bg-yellow-500 hover:text-white w-8 h-8">
                                <i class="fas fa-edit fa-md"></i>
                            </a>
                            @endif
                            <a href="{{ route('mahasiswa.laporan.index') }}"
                                class="flex items-center justify-center transition-all duration-300 border border-gray-400 p-2 rounded-sm text-gray-600 hover:bg-gray-500 hover:text-white w-8 h-8">
                                <i class="fas fa-arrow-left fa-sm"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Praktikum Info -->
                    <div class="mb-6 bg-purple-50 border border-purple-200 p-4 rounded-lg" data-aos="fade-up" data-aos-duration="500">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Informasi Praktikum</h3>
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Judul</dt>
                                <dd class="text-sm text-gray-900">{{ $laporan->praktikum->judul }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Kelas</dt>
                                <dd class="text-sm text-gray-900">{{ $laporan->praktikum->kelas->nama }} ({{ $laporan->praktikum->kelas->kode }})</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Deadline</dt>
                                <dd class="text-sm">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        {{ $laporan->praktikum->deadline < now() ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                        {{ $laporan->praktikum->deadline->format('d M Y H:i') }}
                                    </span>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                <dd class="text-sm">
                                    @if($laporan->status === 'reviewed')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Sudah Dinilai
                                    </span>
                                    @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Menunggu Penilaian
                                    </span>
                                    @endif
                                </dd>
                            </div>
                        </dl>
                        <div class="mt-4">
                            <dt class="text-sm font-medium text-gray-500">Deskripsi</dt>
                            <dd class="text-sm text-gray-900">{{ $laporan->praktikum->deskripsi }}</dd>
                        </div>

                        <div class="mt-4 space-y-2">
                            @if($laporan->praktikum->panduan_path)

                            <a href="{{ route('mahasiswa.laporan.view-panduan', $laporan->praktikum) }}"
                                target="_blank"
                                class="text-purple-600 flex flex-row gap-2 items-center w-fit font-medium hover:text-purple-800 text-sm">
                                <i class="fa-solid fa-eye"></i>
                                <span>Panduan Praktikum</span>
                            </a>
                            @endif
                        </div>
                    </div>

                    <!-- Laporan Info -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Laporan</h3>
                        <div class="bg-white border border-gray-200 shadow overflow-hidden sm:rounded-lg">
                            <div class="px-4 py-5 sm:p-6">
                                <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">File Laporan Praktikum Yang Di Unggah</dt>
                                        <dd class="mt-1">
                                            <a href="{{ route('mahasiswa.laporan.view-file', $laporan) }}"
                                                target="_blank"
                                                class="text-purple-600 flex flex-row gap-2 items-center w-fit font-medium hover:text-purple-800 text-sm">
                                                <i class="fa-solid fa-eye"></i>
                                                <span>File Laporan Praktikum Anda </span>
                                            </a>
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Waktu Pengumpulan</dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            {{ $laporan->created_at->format('d M Y H:i') }}
                                            @if($laporan->isLate())
                                            <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Terlambat
                                            </span>
                                            @endif
                                        </dd>
                                    </div>
                                    @if($laporan->catatan)
                                    <div class="sm:col-span-2">
                                        <dt class="text-sm font-medium text-gray-500">Catatan</dt>
                                        <dd class="mt-1 text-sm text-gray-900 whitespace-pre-line">{{ $laporan->catatan }}</dd>
                                    </div>
                                    @endif
                                </dl>
                            </div>
                        </div>
                    </div>

                    <!-- Penilaian -->
                    @if($laporan->respon_praktikum)
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Penilaian</h3>

                        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                            <div class="px-4 py-5 sm:p-6">
                                <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Nilai</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $laporan->respon_praktikum->nilai }}</dd>
                                    </div>
                                    @if($laporan->respon_praktikum->komentar)
                                    <div class="sm:col-span-2">
                                        <dt class="text-sm font-medium text-gray-500">Komentar</dt>
                                        <dd class="mt-1 text-sm text-gray-900 whitespace-pre-line">{{ $laporan->respon_praktikum->komentar }}</dd>
                                    </div>
                                    @endif
                                </dl>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-maha-layout>