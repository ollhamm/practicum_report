@php
$user = auth()->user();
$role = $user->role;
@endphp

<aside class="flex fixed flex-col w-52 h-screen top-0 left-0 z-40 shadow-lg px-5 py-8 overflow-y-scroll scrollbar-hide bg-white">
    <button id="sidebar-toggle"
        class="h-6 w-6 cursor-pointer rounded-full bg-gray-200 flex items-center justify-center absolute top-4 right-1 self-end">
        <i class="fas fa-chevron-left text-gray-600 text-sm"></i>
    </button>

    <!-- Logo -->
    <div class="flex flex-row items-center gap-2">
        <div class="flex items-center">
            <div class="flex items-center justify-center">
                <div class="w-8 h-8 bg-gray-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-graduation-cap text-white fa-sm"></i>
                </div>
            </div>
            <div class="ml-3 flex flex-row items-center">
                <span class="text-lg font-semibold text-gray-600">Praktikum</span>
            </div>
        </div>
    </div>

    <div class="flex flex-col justify-between flex-1 mt-6">
        <nav class="-mx-3 space-y-6">
            @if($role === 'admin')
            <!-- Admin Navigation -->
            <!-- Dashboard Section -->
            <div class="space-y-3">
                <a class="flex items-center px-3 py-2 mb-5 transition-colors duration-300 transform rounded-sm text-gray-800 font-medium
                    {{ request()->is('admin/dashboard') || request()->is('admin/dashboard*') ? 'bg-gray-200 text-gray-600' : 'hover:bg-gray-200' }}"
                    href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-tachometer-alt text-gray-600 font-medium w-5"></i>
                    <span class="mx-2 text-sm">Dashboard</span>
                </a>
            </div>

            <!-- User Management Section -->
            <div class="space-y-3">
                <label class="px-3 text-xs text-gray-400 uppercase">Manajemen Pengguna</label>

                <a class="flex items-center px-3 py-2 transition-colors duration-300 transform rounded-sm text-gray-800 font-medium
                        {{ request()->is('admin/users*') ? 'bg-gray-200 text-gray-600' : 'hover:bg-gray-200' }}"
                    href="{{ route('admin.users.index') }}">
                    <i class="fas fa-users text-gray-600 font-medium w-5"></i>
                    <span class="mx-2 text-sm">Pengguna</span>
                </a>

                <a class="flex items-center px-3 py-2 transition-colors duration-300 transform rounded-sm text-gray-800 font-medium
                        {{ request()->is('admin/dosen*') ? 'bg-gray-200 text-gray-600' : 'hover:bg-gray-200' }}"
                    href="{{ route('admin.dosen.index') }}">
                    <i class="fas fa-chalkboard-teacher text-gray-600 font-medium w-5"></i>
                    <span class="mx-2 text-sm">Dosen</span>
                </a>

                <a class="flex items-center px-3 py-2 transition-colors duration-300 transform rounded-sm text-gray-800 font-medium
                        {{ request()->is('admin/mahasiswa*') ? 'bg-gray-200 text-gray-600' : 'hover:bg-gray-200' }}"
                    href="{{ route('admin.mahasiswa.index') }}">
                    <i class="fas fa-user-graduate text-gray-600 font-medium w-5"></i>
                    <span class="mx-2 text-sm">Mahasiswa</span>
                </a>
            </div>

            <!-- Academic Section -->
            <div class="space-y-3">
                <label class="px-3 text-xs text-gray-400 uppercase">Akademik</label>
                <a class="flex items-center px-3 py-2 transition-colors duration-300 transform rounded-sm text-gray-800 font-medium
                        {{ request()->is('admin/kelas*') ? 'bg-gray-200 text-gray-600' : 'hover:bg-gray-200' }}"
                    href="{{ route('admin.kelas.index') }}">
                    <i class="fas fa-door-open text-gray-600 font-medium w-5"></i>
                    <span class="mx-2 text-sm">Kelas</span>
                </a>

                <a class="flex items-center px-3 py-2 transition-colors duration-300 transform rounded-sm text-gray-800 font-medium
                        {{ request()->is('admin/praktikum*') ? 'bg-gray-200 text-gray-600' : 'hover:bg-gray-200' }}"
                    href="{{ route('admin.praktikum.index') }}">
                    <i class="fas fa-flask text-gray-600 font-medium w-5"></i>
                    <span class="mx-2 text-sm">Praktikum</span>
                </a>
            </div>

            <!-- Reports Section -->
            <div class="space-y-3">
                <label class="px-3 text-xs text-gray-400 uppercase">Laporan</label>

                <a class="flex items-center px-3 py-2 transition-colors duration-300 transform rounded-sm text-gray-800 font-medium
                        {{ request()->is('laporan*') ? 'bg-gray-200 text-gray-600' : 'hover:bg-gray-200' }}"
                    href="#">
                    <i class="fas fa-file-alt text-gray-600 font-medium w-5"></i>
                    <span class="mx-2 text-sm">Laporan</span>
                </a>
                <a class="flex items-center px-3 py-2 transition-colors duration-300 transform rounded-sm text-gray-800 font-medium
                        {{ request()->is('laporan*') ? 'bg-gray-200 text-gray-600' : 'hover:bg-gray-200' }}"
                    href="#">
                    <i class="fa-solid fa-table-list text-gray-600 font-medium w-5"></i>
                    <span class="mx-2 text-sm">Nilai Normal</span>
                </a>
            </div>
            @elseif($role === 'dosen')
            <!-- Dosen Navigation -->
            <!-- Dashboard Section -->
            <div class="space-y-3">
                <a class="flex items-center px-3 py-2 mb-5 transition-colors duration-300 transform rounded-sm text-gray-800 font-medium
                    {{ request()->is('dosen/dashboard') || request()->is('dosen/dashboard*') ? 'bg-gray-200 text-gray-600' : 'hover:bg-gray-200' }}"
                    href="{{ route('dosen.dashboard') }}">
                    <i class="fas fa-tachometer-alt text-gray-600 font-medium w-5"></i>
                    <span class="mx-2 text-sm">Dashboard</span>
                </a>
            </div>

            <!-- Academic Section -->
            <div class="space-y-3">
                <label class="px-3 text-xs text-gray-400 uppercase">Akademik</label>
                <a class="flex items-center px-3 py-2 transition-colors duration-300 transform rounded-sm text-gray-800 font-medium
                        {{ request()->is('dosen/kelas*') ? 'bg-gray-200 text-gray-600' : 'hover:bg-gray-200' }}"
                    href="{{ route('dosen.kelas.index') }}">
                    <i class="fas fa-door-open text-gray-600 font-medium w-5"></i>
                    <span class="mx-2 text-sm">Kelas</span>
                </a>

                <a class="flex items-center px-3 py-2 transition-colors duration-300 transform rounded-sm text-gray-800 font-medium relative
                {{ request()->is('dosen/praktikum*') ? 'bg-gray-200 text-gray-600' : 'hover:bg-gray-200' }}"
                    href="{{ route('dosen.praktikum.index') }}">
                    <i class="fas fa-flask text-gray-600 font-medium w-5"></i>
                    <span class="mx-2 text-sm">Praktikum</span>

                    {{-- Notification Badge untuk laporan yang belum dinilai --}}
                    @if(isset($unreviewedReportsCount) && $unreviewedReportsCount > 0)
                    <span class="absolute -top-1 -right-1 bg-orange-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-medium shadow-lg">
                        {{ $unreviewedReportsCount }}
                    </span>
                    @endif
                </a>
            </div>

            <!-- Reports Section -->
            <div class="space-y-3">
                <label class="px-3 text-xs text-gray-400 uppercase">Laporan</label>

                <a class="flex items-center px-3 py-2 transition-colors duration-300 transform rounded-sm text-gray-800 font-medium
                        {{ request()->is('dosen/laporan*') ? 'bg-gray-200 text-gray-600' : 'hover:bg-gray-200' }}"
                    href="#">
                    <i class="fas fa-file-alt text-gray-600 font-medium w-5"></i>
                    <span class="mx-2 text-sm">Laporan</span>
                </a>
            </div>
            @endif
        </nav>
    </div>
</aside>