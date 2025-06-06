<x-maha-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Detail Laporan Praktikum</h2>
                        <div class="space-x-2">
                            @if($laporan->status !== 'reviewed')
                            <a href="{{ route('mahasiswa.laporan.edit', $laporan) }}"
                                class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                                Edit
                            </a>
                            @endif
                            <a href="{{ route('mahasiswa.laporan.index') }}"
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Back
                            </a>
                        </div>
                    </div>

                    <!-- Praktikum Info -->
                    <div class="mb-6 bg-gray-50 p-4 rounded-lg">
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

                        <div class="mt-4 space-y-2">
                            @if($laporan->praktikum->panduan_path)
                            <a href="{{ route('dosen.praktikum.download-panduan', $laporan->praktikum) }}"
                                class="inline-flex items-center text-blue-600 hover:text-blue-800">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v4.586l-2.293-2.293a1 1 0 10-1.414 1.414l4 4a1 1 0 001.414 0l4-4a1 1 0 00-1.414-1.414L11 11.586V7z"></path>
                                </svg>
                                Download Panduan
                            </a>
                            @endif
                            @if($laporan->praktikum->template_path)
                            <a href="{{ route('dosen.praktikum.download-template', $laporan->praktikum) }}"
                                class="inline-flex items-center text-blue-600 hover:text-blue-800">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v4.586l-2.293-2.293a1 1 0 10-1.414 1.414l4 4a1 1 0 001.414 0l4-4a1 1 0 00-1.414-1.414L11 11.586V7z"></path>
                                </svg>
                                Download Template
                            </a>
                            @endif
                        </div>
                    </div>

                    <!-- Laporan Info -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Laporan</h3>

                        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                            <div class="px-4 py-5 sm:p-6">
                                <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">File Laporan</dt>
                                        <dd class="mt-1">
                                            <a href="{{ route('mahasiswa.laporan.download', $laporan) }}"
                                                class="text-blue-600 hover:text-blue-800">
                                                Download Laporan
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