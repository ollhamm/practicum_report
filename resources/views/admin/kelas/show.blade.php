<x-app-layout>
    <div class="py-12">
        <div class="w-full mx-auto px-2">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Detail Kelas</h2>
                        <a href="{{ route('admin.kelas.index') }}"
                            class="flex items-center justify-center transition-all duration-300 border border-gray-400 p-2 rounded-sm text-gray-600 hover:bg-gray-500 hover:text-white w-8 h-8">
                            <i class="fas fa-arrow-left fa-sm"></i>
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-sm font-semibold mb-4 border-b border-b-gray-300 pb-2">Informasi Kelas</h3>
                            <div class="space-y-3">
                                <div>
                                    <span class="text-gray-600 font-medium text-xs">Nama Kelas:</span>
                                    <span class="ml-2 text-xs">{{ $kela->nama_kelas }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600 font-medium text-xs">Kode Kelas:</span>
                                    <span class="ml-2 text-xs">{{ $kela->kode }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600 font-medium text-xs">Tahun Ajaran:</span>
                                    <span class="ml-2 text-xs">{{ $kela->tahun_ajaran }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600 font-medium text-xs">Semester:</span>
                                    <span class="ml-2 text-xs capitalize">{{ $kela->semester }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600 font-medium text-xs">Angkatan:</span>
                                    <span class="ml-2 text-xs">{{ $kela->angkatan }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-sm font-semibold mb-4">Dosen Pengajar</h3>
                            <div class="space-y-2">
                                @forelse($kela->dosen as $dosen)
                                <div class="flex items-center bg-white p-2 rounded">
                                    <div>
                                        <span class="font-medium text-xs">{{ $dosen->name }}</span>
                                        <span class="text-xs text-gray-500 block">NIP: {{ $dosen->nip }}</span>
                                    </div>
                                </div>
                                @empty
                                <p class="text-gray-500">Belum ada dosen yang ditugaskan</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-sm font-semibold mb-4">Daftar Mahasiswa</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs text-gray-600 uppercase tracking-wider">No</th>
                                        <th class="px-6 py-3 text-left text-xs text-gray-600 uppercase tracking-wider">Nama</th>
                                        <th class="px-6 py-3 text-left text-xs text-gray-600 uppercase tracking-wider">NIM</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($kela->mahasiswa as $index => $mahasiswa)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $index + 1 }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $mahasiswa->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm ">
                                            {{ $mahasiswa->nip }}
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-center">
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
</x-app-layout>