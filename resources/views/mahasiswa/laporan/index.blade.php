<x-maha-layout>
    <div class="py-6">
        <div class="w-full mx-auto px-2">
            <!-- Header -->
            <div class="mb-6">
                <h2 class="text-2xl font-semibold text-gray-800">Daftar Praktikum</h2>
                <p class="text-gray-600 mt-1">Kelola dan submit laporan praktikum Anda</p>
            </div>

            @if($praktikums->isEmpty())
            <!-- Empty State -->
            <div class="bg-white rounded-lg shadow-sm p-8 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-flask text-2xl text-gray-400"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Praktikum</h3>
                <p class="text-gray-500">Praktikum akan muncul di sini ketika tersedia.</p>
            </div>
            @else
            <!-- Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($praktikums as $praktikum)
                @php
                $laporan = $praktikum->laporan_praktikum->first();
                $isOverdue = $praktikum->deadline < now();
                    $daysLeft=now()->diffInDays($praktikum->deadline, false);
                    @endphp

                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200">
                        <!-- Card Header -->
                        <div class="p-6 border-b border-gray-100">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
                                        {{ $praktikum->judul }}
                                    </h3>
                                    <div class="flex items-center text-sm text-gray-600 mb-2">
                                        <i class="fas fa-users mr-2"></i>
                                        {{ $praktikum->kelas->nama }}
                                    </div>
                                </div>

                                <!-- Status Badge -->
                                <div class="ml-4">
                                    @if($praktikum->laporan_praktikum->isEmpty())
                                    <span class="px-3 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">
                                        Belum Submit
                                    </span>
                                    @else
                                    @php $laporan = $praktikum->laporan_praktikum->first(); @endphp
                                    <span class="px-3 py-1 text-xs font-medium rounded-full 
                                                {{ $laporan->status === 'reviewed' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ $laporan->status === 'reviewed' ? 'Selesai' : 'Submitted' }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-6">
                            <!-- Deadline Info -->
                            <div class="mb-4">
                                <div class="flex items-center text-sm mb-2">
                                    <i class="fas fa-clock mr-2 text-gray-400"></i>
                                    <span class="text-gray-600">Deadline</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-gray-900">
                                        {{ $praktikum->deadline->format('d M Y, H:i') }}
                                    </span>
                                    @if(!$isOverdue && $praktikum->laporan_praktikum->isEmpty())
                                    <span class="text-xs px-2 py-1 rounded-full 
                                                {{ $daysLeft <= 1 ? 'bg-red-100 text-red-700' : ($daysLeft <= 3 ? 'bg-orange-100 text-orange-700' : 'bg-green-100 text-green-700') }}">
                                        {{ $daysLeft > 0 ? $daysLeft . ' hari lagi' : 'Hari ini' }}
                                    </span>
                                    @elseif($isOverdue && $praktikum->laporan_praktikum->isEmpty())
                                    <span class="text-xs px-2 py-1 rounded-full bg-red-100 text-red-700">
                                        Terlambat
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Progress/Score Info (if available) -->
                            @if(!$praktikum->laporan_praktikum->isEmpty() && $laporan->status === 'reviewed')
                            <div class="mb-4 p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-600">Nilai</span>
                                    <span class="font-semibold text-green-600">
                                        {{ $laporan->nilai ?? 'Belum dinilai' }}
                                    </span>
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- Card Footer/Actions -->
                        <div class="px-6 pb-6">
                            @if($praktikum->laporan_praktikum->isEmpty())
                            <!-- Upload Action -->
                            <a href="{{ route('mahasiswa.laporan.create', ['praktikum_id' => $praktikum->id]) }}"
                                class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
                                <i class="fas fa-upload mr-2"></i>
                                Upload Laporan
                            </a>
                            @else
                            @php $laporan = $praktikum->laporan_praktikum->first(); @endphp
                            <div class="flex gap-2">
                                @if($laporan->status === 'reviewed')
                                <!-- View Correction -->
                                <a href="{{ route('mahasiswa.laporan.koreksi', $laporan) }}"
                                    class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors duration-200">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    Lihat Koreksi
                                </a>
                                @else
                                <!-- View Report -->
                                <a href="{{ route('mahasiswa.laporan.show', $laporan) }}"
                                    class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition-colors duration-200">
                                    <i class="fas fa-eye mr-2"></i>
                                    Lihat
                                </a>

                                <!-- Edit if not overdue -->
                                @if($praktikum->deadline > now())
                                <a href="{{ route('mahasiswa.laporan.edit', $laporan) }}"
                                    class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-yellow-600 text-white text-sm font-medium rounded-lg hover:bg-yellow-700 transition-colors duration-200">
                                    <i class="fas fa-edit mr-2"></i>
                                    Edit
                                </a>
                                @endif
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
            </div>

            <!-- Pagination -->
            @if($praktikums->hasPages())
            <div class="mt-8">
                {{ $praktikums->links() }}
            </div>
            @endif
            @endif
        </div>
    </div>

    <style>
        /* Line clamp utility for title truncation */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Hover effects for cards */
        .bg-white:hover {
            transform: translateY(-1px);
        }

        /* Responsive adjustments */
        @media (max-width: 640px) {
            .grid-cols-1 {
                gap: 1rem;
            }
        }
    </style>
</x-maha-layout>