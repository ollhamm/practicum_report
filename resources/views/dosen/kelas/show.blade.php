<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-semibold text-gray-800">Detail Kelas</h2>
                    <div class="space-x-2">
                        <a href="{{ route('dosen.kelas.edit', $kelas) }}"
                            class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                            Edit Kelas
                        </a>
                        <a href="{{ route('dosen.kelas.index') }}"
                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Back
                        </a>
                    </div>
                </div>
            </div>

            <!-- Kelas Info -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Informasi Kelas</h3>
                            <dl class="mt-2 space-y-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Kode Kelas</dt>
                                    <dd class="text-sm text-gray-900">{{ $kelas->kode }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Nama Kelas</dt>
                                    <dd class="text-sm text-gray-900">{{ $kelas->nama }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Tahun Ajaran</dt>
                                    <dd class="text-sm text-gray-900">{{ $kelas->tahun_ajaran }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Semester</dt>
                                    <dd class="text-sm text-gray-900">{{ ucfirst($kelas->semester) }}</dd>
                                </div>
                            </dl>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Statistik</h3>
                            <dl class="mt-2 space-y-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Jumlah Mahasiswa</dt>
                                    <dd class="text-sm text-gray-900">{{ $kelas->mahasiswa->count() }} Mahasiswa</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Jumlah Praktikum</dt>
                                    <dd class="text-sm text-gray-900">{{ $kelas->praktikum->count() }} Praktikum</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Praktikum List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Daftar Praktikum</h3>
                        <a href="{{ route('dosen.praktikum.create', ['kelas_id' => $kelas->id]) }}"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Tambah Praktikum
                        </a>
                    </div>

                    @if($kelas->praktikum->isEmpty())
                        <p class="text-gray-500">Belum ada praktikum yang dibuat.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deadline</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Laporan</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($kelas->praktikum as $praktikum)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $praktikum->judul }}</td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900 line-clamp-2">{{ $praktikum->deskripsi }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                    {{ $praktikum->deadline < now() ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                                    {{ $praktikum->deadline->format('d M Y H:i') }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                    {{ $praktikum->laporan_praktikum_count }} / {{ $kelas->mahasiswa->count() }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <a href="{{ route('dosen.praktikum.show', $praktikum) }}"
                                                    class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                                                <a href="{{ route('dosen.praktikum.edit', $praktikum) }}"
                                                    class="text-yellow-600 hover:text-yellow-900 mr-3">Edit</a>
                                                <form action="{{ route('dosen.praktikum.destroy', $praktikum) }}" method="POST" class="inline"
                                                    onsubmit="return confirm('Are you sure you want to delete this practicum?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Mahasiswa List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Daftar Mahasiswa</h3>

                    @if($kelas->mahasiswa->isEmpty())
                        <p class="text-gray-500">Belum ada mahasiswa yang terdaftar.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Progress</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($kelas->mahasiswa as $mahasiswa)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $mahasiswa->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $mahasiswa->email }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                    {{ $mahasiswa->laporan_praktikum->where('kelas_id', $kelas->id)->count() }} / {{ $kelas->praktikum->count() }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 