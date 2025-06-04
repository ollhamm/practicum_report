<x-app-layout>
    <div class="py-12">
        <div class="w-full mx-auto px-2">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Detail Praktikum</h2>
                        <a href="{{ route('admin.praktikum.index') }}"
                            class="flex items-center justify-center transition-all duration-300 border border-gray-400 p-2 rounded-sm text-gray-600 hover:bg-gray-500 hover:text-white w-8 h-8">
                            <i class="fas fa-arrow-left fa-sm"></i>
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-sm font-semibold text-gray-800 mb-4 border-b border-b-gray-300 pb-2">Informasi Praktikum</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="text-xs font-medium text-gray-500">Judul Praktikum</label>
                                    <p class="mt-1 text-gray-900 text-xs">{{ $praktikum->judul }}</p>
                                </div>
                                <div>
                                    <label class="text-xs font-medium text-gray-500">Pertemuan</label>
                                    <p class="mt-1 text-gray-900 text-xs">Pertemuan {{ $praktikum->pertemuan }}</p>
                                </div>
                                <div>
                                    <label class="text-xs font-medium text-gray-500">Deadline</label>
                                    <p class="mt-1 text-gray-900 text-xs">{{ \Carbon\Carbon::parse($praktikum->deadline)->format('d/m/Y H:i') }}</p>
                                </div>
                                <div>
                                    <label class="text-xs font-medium text-gray-500">Deskripsi</label>
                                    <p class="mt-1 text-gray-900 text-xs whitespace-pre-line">{{ $praktikum->deskripsi }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-sm font-semibold text-gray-800 mb-4">Informasi Kelas</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="text-xs font-medium text-gray-500">Nama Kelas</label>
                                    <p class="mt-1 text-gray-900 text-xs">{{ $praktikum->kelas->nama_kelas }}</p>
                                </div>
                                <div>
                                    <label class="text-xs font-medium text-gray-500">Kode Kelas</label>
                                    <p class="mt-1 text-gray-900 text-xs">{{ $praktikum->kelas->kode }}</p>
                                </div>
                                <div>
                                    <label class="text-xs font-medium text-gray-500">Tahun Ajaran</label>
                                    <p class="mt-1 text-gray-900 text-xs">{{ $praktikum->kelas->tahun_ajaran }}</p>
                                </div>
                                <div>
                                    <label class="text-xs font-medium text-gray-500">Semester</label>
                                    <p class="mt-1 text-gray-900 text-xs capitalize">{{ $praktikum->kelas->semester }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-sm font-semibold text-gray-800 mb-4">Dosen Pengajar</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

                                @forelse($praktikum->kelas->dosen as $dosen)
                                <div class="bg-white gap-2 flex flex-row items-center p-4 rounded-lg shadow-sm">
                                    <div class="w-10 h-10 bg-gray-600 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user text-white"></i>
                                    </div>
                                    <div class="flex-col flex items-start text-start">
                                        <p class="font-medium text-xs text-gray-900">{{ $dosen->name }}</p>
                                        <p class="text-xs text-gray-500">NIP: {{ $dosen->nip }}</p>
                                    </div>
                                </div>
                                @empty
                                <p class="text-gray-500">Belum ada dosen yang ditugaskan</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-sm font-semibold text-gray-800 mb-4">Daftar Mahasiswa</h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs text-gray-600 uppercase tracking-wider">No</th>
                                            <th class="px-6 py-3 text-left text-xs text-gray-600 uppercase tracking-wider">Nama</th>
                                            <th class="px-6 py-3 text-left text-xs text-gray-600 uppercase tracking-wider">NIM</th>
                                            <th class="px-6 py-3 text-left text-xs text-gray-600 uppercase tracking-wider">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse($praktikum->kelas->mahasiswa as $index => $mahasiswa)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                                                {{ $index + 1 }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ $mahasiswa->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap ">
                                                {{ $mahasiswa->nip }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @php
                                                $laporan = $praktikum->laporan_praktikum->where('mahasiswa_id', $mahasiswa->id)->first();
                                                @endphp
                                                @if($laporan)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                            {{ $laporan->status === 'reviewed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                    {{ $laporan->status === 'reviewed' ? 'Sudah Dinilai' : 'Belum Dinilai' }}
                                                </span>
                                                @else
                                                <span class="p-1 inline-flex text-xs leading-5 rounded-sm bg-red-500 text-white">
                                                    Belum Mengumpulkan
                                                </span>
                                                @endif
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                                Belum ada mahasiswa yang terdaftar
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>