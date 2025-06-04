<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Daftar Praktikum</h2>

                    @if($praktikums->isEmpty())
                        <p class="text-gray-500">Belum ada praktikum yang tersedia.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Praktikum</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deadline</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($praktikums as $praktikum)
                                        @php
                                            $laporan = $praktikum->laporan_praktikum->first();
                                        @endphp
                                        <tr>
                                            <td class="px-6 py-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $praktikum->judul }}</div>
                                                <div class="text-sm text-gray-500 line-clamp-1">{{ $praktikum->deskripsi }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $praktikum->kelas->nama }}</div>
                                                <div class="text-sm text-gray-500">{{ $praktikum->kelas->kode }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                    {{ $praktikum->deadline < now() ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                                    {{ $praktikum->deadline->format('d M Y H:i') }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($laporan)
                                                    @if($laporan->status === 'reviewed')
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                            Sudah Dinilai
                                                        </span>
                                                    @else
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                            Menunggu Penilaian
                                                        </span>
                                                    @endif
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                        Belum Dikumpulkan
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                @if($laporan)
                                                    <a href="{{ route('mahasiswa.laporan.show', $laporan) }}"
                                                        class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                                                    @if($laporan->status !== 'reviewed')
                                                        <a href="{{ route('mahasiswa.laporan.edit', $laporan) }}"
                                                            class="text-yellow-600 hover:text-yellow-900 mr-3">Edit</a>
                                                        <form action="{{ route('mahasiswa.laporan.destroy', $laporan) }}" method="POST" class="inline"
                                                            onsubmit="return confirm('Are you sure you want to delete this report?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                                        </form>
                                                    @endif
                                                @else
                                                    <a href="{{ route('mahasiswa.laporan.create', ['praktikum_id' => $praktikum->id]) }}"
                                                        class="text-green-600 hover:text-green-900">Submit</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $praktikums->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 