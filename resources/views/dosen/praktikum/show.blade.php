<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-semibold text-gray-800">Detail Praktikum</h2>
                    <div class="space-x-2">
                        <a href="{{ route('dosen.praktikum.edit', $praktikum) }}"
                            class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                            Edit
                        </a>
                        <a href="{{ route('dosen.kelas.show', $praktikum->kelas) }}"
                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Back
                        </a>
                    </div>
                </div>
            </div>

            <!-- Praktikum Info -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Informasi Praktikum</h3>
                            <dl class="mt-2 space-y-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Judul</dt>
                                    <dd class="text-sm text-gray-900">{{ $praktikum->judul }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Kelas</dt>
                                    <dd class="text-sm text-gray-900">
                                        {{ $praktikum->kelas->nama }} ({{ $praktikum->kelas->kode }})
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Deadline</dt>
                                    <dd class="text-sm">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            {{ $praktikum->deadline < now() ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                            {{ $praktikum->deadline->format('d M Y H:i') }}
                                        </span>
                                    </dd>
                                </div>
                            </dl>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">File Praktikum</h3>
                            <div class="mt-2 space-y-2">
                                @if($praktikum->panduan_path)
                                    <div>
                                        <a href="{{ route('dosen.praktikum.download-panduan', $praktikum) }}"
                                            class="inline-flex items-center text-blue-600 hover:text-blue-800">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v4.586l-2.293-2.293a1 1 0 10-1.414 1.414l4 4a1 1 0 001.414 0l4-4a1 1 0 00-1.414-1.414L11 11.586V7z"></path>
                                            </svg>
                                            Download Panduan
                                        </a>
                                    </div>
                                @endif
                                @if($praktikum->template_path)
                                    <div>
                                        <a href="{{ route('dosen.praktikum.download-template', $praktikum) }}"
                                            class="inline-flex items-center text-blue-600 hover:text-blue-800">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v4.586l-2.293-2.293a1 1 0 10-1.414 1.414l4 4a1 1 0 001.414 0l4-4a1 1 0 00-1.414-1.414L11 11.586V7z"></path>
                                            </svg>
                                            Download Template
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-gray-900">Deskripsi</h3>
                        <div class="mt-2 prose max-w-none">
                            {{ $praktikum->deskripsi }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Laporan Mahasiswa -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Laporan Mahasiswa</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mahasiswa</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu Pengumpulan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($praktikum->kelas->mahasiswa as $mahasiswa)
                                    @php
                                        $laporan = $praktikum->laporan_praktikum->where('mahasiswa_id', $mahasiswa->id)->first();
                                    @endphp
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $mahasiswa->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $mahasiswa->email }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($laporan)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Submitted
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    Not Submitted
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $laporan ? $laporan->created_at->format('d M Y H:i') : '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @if($laporan)
                                                <a href="#" class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                                                @if($laporan->respon_praktikum)
                                                    <a href="#" class="text-green-600 hover:text-green-900">Edit Response</a>
                                                @else
                                                    <a href="#" class="text-yellow-600 hover:text-yellow-900">Add Response</a>
                                                @endif
                                            @else
                                                <span class="text-gray-400">No actions available</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 