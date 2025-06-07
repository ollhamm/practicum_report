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
                    <span>Praktikum</span>
                    <span class="pointer-events-none mx-2 text-gray-600">
                        /
                    </span>
                </li>
                <li class="flex cursor-pointer items-center text-sm text-gray-600 transition-colors duration-300 hover:text-gray-400">
                    <a href="/admin/praktikum">Manajemen Praktikum</a>
                    <span class="pointer-events-none mx-2 text-gray-600">
                        /
                    </span>
                </li>
                <li class="flex items-center text-sm text-gray-700 transition-colors duration-300">
                    <span>Detail Data Praktikum</span>
                </li>
            </ol>
        </div>
        <div class="w-full mx-auto px-2">
            <div class="bg-white overflow-hidden shadow-sm rounded-sm">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Detail Data Praktikum</h2>
                        <a href="{{ route('admin.praktikum.index') }}"
                            class="flex items-center justify-center transition-all duration-300 border border-gray-400 p-2 rounded-sm text-gray-600 hover:bg-gray-500 hover:text-white w-8 h-8">
                            <i class="fas fa-arrow-left fa-sm"></i>
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 border border-gray-200 rounded-sm p-6">
                            <h3 class="text-sm font-semibold text-gray-800 mb-4 border-b border-b-gray-300 pb-2">Informasi Praktikum</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Judul Praktikum</label>
                                    <p class="mt-1 text-gray-900 text-sm">{{ $praktikum->judul }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Pertemuan</label>
                                    <p class="mt-1 text-gray-900 text-sm">Pertemuan {{ $praktikum->pertemuan }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Deadline</label>
                                    <p class="mt-1 text-gray-900 text-sm">{{ \Carbon\Carbon::parse($praktikum->deadline)->format('d/m/Y H:i') }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Deskripsi</label>
                                    <p class="mt-1 text-gray-900 text-sm whitespace-pre-line">{{ $praktikum->deskripsi }}</p>
                                </div>
                                <div class="mt-2 space-y-2">
                                    @if($praktikum->panduan_path)
                                    <div>
                                        <a href="{{ route('dosen.praktikum.download-panduan', $praktikum) }}"
                                            class="inline-flex items-center text-blue-500 text-sm font-medium hover:text-blue-600">
                                            <i class="fas fa-circle fa-xs mr-2"></i>
                                            Unduh Panduan
                                        </a>
                                    </div>
                                    @endif
                                    @if($praktikum->template_path)
                                    <div>
                                        <a href="{{ route('dosen.praktikum.download-template', $praktikum) }}"
                                            class="inline-flex items-center text-sm font-medium text-blue-500 hover:text-blue-600">
                                            <i class="fas fa-circle fa-xs mr-2"></i>
                                            Download Template
                                        </a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 border border-gray-200 rounded-sm p-6">
                            <h3 class="text-sm font-semibold text-gray-800 mb-4">Informasi Kelas</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Nama Kelas</label>
                                    <p class="mt-1 text-gray-900 text-sm">{{ $praktikum->kelas->nama_kelas }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Kode Kelas</label>
                                    <p class="mt-1 text-gray-900 text-sm">{{ $praktikum->kelas->kode }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Tahun Ajaran</label>
                                    <p class="mt-1 text-gray-900 text-sm">{{ $praktikum->kelas->tahun_ajaran }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Semester</label>
                                    <p class="mt-1 text-gray-900 text-sm capitalize">{{ $praktikum->kelas->semester }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <div class="bg-gray-50 border border-gray-200 rounded-sm p-6">
                            <h3 class="text-sm font-semibold text-gray-800 mb-4">Dosen Pengajar</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

                                @if($praktikum->dosen)
                                <div class="bg-white gap-2 flex flex-row items-center p-4 rounded-sm border border-gray-200 shadow-sm">
                                    <div class="w-10 h-10 bg-gray-600 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user text-white"></i>
                                    </div>
                                    <div class="flex-col flex items-start text-start">
                                        <p class="font-medium text-sm text-gray-900">{{ $praktikum->dosen->name }}</p>
                                        <p class="text-sm text-gray-500">NIP: {{ $praktikum->dosen->nip ?? '-' }}</p>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <div class="bg-gray-50 border border-gray-200 rounded-sm p-6">
                            <h3 class="text-sm font-semibold text-gray-800 mb-4">Daftar Mahasiswa</h3>
                            <div class="overflow-x-auto">
                                <table id="daftar-siswa" class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-200">
                                        <tr>
                                            <th class="uppercase tracking-wider">No</th>
                                            <th class="uppercase tracking-wider">Nama</th>
                                            <th class="uppercase tracking-wider">NIM</th>
                                            <th class="uppercase tracking-wider">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse($praktikum->kelas->mahasiswa as $index => $mahasiswa)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                                                {{ $index + 1 }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="text-gray-950 font-medium">
                                                    {{ $mahasiswa->name }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap ">
                                                {{ $mahasiswa->nip }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @php
                                                $laporan = $praktikum->laporan_praktikum->where('mahasiswa_id', $mahasiswa->id)->first();
                                                @endphp
                                                @if($laporan)
                                                <span class="p-1 inline-flex text-xs leading-5 rounded-sm 
                                                            {{ $laporan->status === 'reviewed' ? 'bg-green-600 text-white' : 'bg-yellow-600 text-white' }}">
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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            $("#customSearch").on("keyup", function() {
                daftarSiswa.search(this.value).draw();
            });
            var daftarSiswa = $("#daftar-siswa").DataTable({
                info: false,
                responsive: true,
                dom: "trip",
                stripeClasses: [],
                ordering: false
            });
        });
    </script>
</x-app-layout>