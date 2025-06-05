<x-app-layout>
    <div class="py-12">
        <div class="w-full mx-auto px-2">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="bg-white overflow-hidden shadow-sm rounded-sm">
                    <div class="p-6">
                        <div class="text-gray-600 text-xs">Total Pengguna</div>
                        <div class="text-2xl font-semibold">{{ $stats['total_users'] }}</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-sm">
                    <div class="p-6">
                        <div class="text-gray-600 text-xs">Pending Approval</div>
                        <div class="text-2xl font-semibold text-orange-600">{{ $stats['pending_users'] }}</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-sm">
                    <div class="p-6">
                        <div class="text-gray-600 text-xs">Total Dosen</div>
                        <div class="text-2xl font-semibold text-blue-600">{{ $stats['total_dosen'] }}</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-sm">
                    <div class="p-6">
                        <div class="text-gray-600 text-xs">Total Mahasiswa</div>
                        <div class="text-2xl font-semibold text-green-600">{{ $stats['total_mahasiswa'] }}</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-sm">
                    <div class="p-6">
                        <div class="text-gray-600 text-xs">Total Kelas</div>
                        <div class="text-2xl font-semibold text-purple-600">{{ $stats['total_kelas'] }}</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-sm">
                    <div class="p-6">
                        <div class="text-gray-600 text-xs">Total Praktikum</div>
                        <div class="text-2xl font-semibold text-indigo-600">{{ $stats['total_praktikum'] }}</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-sm">
                    <div class="p-6">
                        <div class="text-gray-600 text-xs">Total Laporan</div>
                        <div class="text-2xl font-semibold text-pink-600">{{ $stats['total_laporan'] }}</div>
                    </div>
                </div>
            </div>

            <!-- Pending Users -->
            <div class="bg-white overflow-hidden shadow-sm rounded-sm">
                <div class="p-6">
                    <h2 class="text-md font-semibold text-gray-800 mb-4">Pending Approval</h2>
                    @if($pendingUsers->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($pendingUsers as $user)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    {{ $user->role === 'dosen' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <form action="{{ route('admin.users.approve', $user) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-900 mr-3">Approve</button>
                                        </form>
                                        <form action="{{ route('admin.users.reject', $user) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-red-600 hover:text-red-900">Reject</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p class="text-gray-500 text-xs">Tidak ada pendding pengguna.</p>
                    @endif

                    <div class="mt-4">
                        <a href="{{ route('admin.users.index') }}" class="text-blue-600 text-xs font-medium hover:text-blue-900">Lihat semua pengguna →</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>