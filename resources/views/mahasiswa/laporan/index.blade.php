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
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $praktikum->judul }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $praktikum->kelas->nama }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $praktikum->deadline->format('d M Y H:i') }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($praktikum->laporan_praktikum->isEmpty())
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                        Belum Mengumpulkan
                                                    </span>
                                                @else
                                                    @php $laporan = $praktikum->laporan_praktikum->first(); @endphp
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold 
                                                        {{ $laporan->status === 'reviewed' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                                        {{ ucfirst($laporan->status) }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                @if($praktikum->laporan_praktikum->isEmpty())
                                                    <a href="{{ route('mahasiswa.laporan.create', ['praktikum_id' => $praktikum->id]) }}" 
                                                        class="text-blue-500 hover:text-blue-700">
                                                        Upload Laporan
                                                    </a>
                                                @else
                                                    @php $laporan = $praktikum->laporan_praktikum->first(); @endphp
                                                    <div class="flex space-x-3">
                                                        @if($laporan->status === 'reviewed')
                                                            <a href="{{ route('mahasiswa.laporan.koreksi', $laporan) }}" 
                                                                class="text-green-500 hover:text-green-700">
                                                                <i class="fas fa-eye mr-1"></i>Lihat Koreksi
                                                            </a>
                                                        @else
                                                            <a href="{{ route('mahasiswa.laporan.show', $laporan) }}" 
                                                                class="text-blue-500 hover:text-blue-700">
                                                                <i class="fas fa-eye mr-1"></i>Lihat
                                                            </a>
                                                            @if($praktikum->deadline > now())
                                                                <a href="{{ route('mahasiswa.laporan.edit', $laporan) }}" 
                                                                    class="text-yellow-500 hover:text-yellow-700">
                                                                    <i class="fas fa-edit mr-1"></i>Edit
                                                                </a>
                                                            @endif
                                                        @endif
                                                    </div>
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