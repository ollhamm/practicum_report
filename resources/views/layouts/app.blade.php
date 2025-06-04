<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Practicum Report') }}</title>

    <link rel="stylesheet" href="{{ asset('css/datatable.css') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Poppins:400,500,600&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- jQuery first -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>

    <!-- Then DataTables -->
    <script src="{{ asset('js/datatable.js') }}"></script>

    <!-- Sweet allert 2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>


<body class="bg-gray-100 h-screen font-[Poppins]">
    <!-- Sidebar -->
    <aside class="flex flex-col w-52 h-screen fixed top-0 left-0 z-50 shadow-lg px-5 py-8 overflow-y-scroll scrollbar-hide bg-white">
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
                    <span class="text-lg font-semibold text-gray-600">Practicum</span>
                </div>
            </div>
        </div>

        <div class="flex flex-col justify-between flex-1 mt-6">
            <nav class="-mx-3 space-y-6">
                <!-- Dashboard Section -->
                <div class="space-y-3">
                    <a class="flex items-center px-3 py-2 mb-5 transition-colors duration-300 transform rounded-sm text-gray-800 font-medium
                    {{ request()->is('admin/dashboard') || request()->is('admin/dashboard*') ? 'bg-gray-200 text-gray-600' : 'hover:bg-gray-200' }}" href="/admin/dashboard">
                        <i class="fas fa-tachometer-alt {{ request()->is('/') || request()->is('dashboard*') ? 'text-gray-600' : 'text-gray-600 hover:text-gray-600' }} font-medium w-5"></i>
                        <span class="mx-2 text-xs">Dashboard</span>
                    </a>
                </div>

                <!-- User Management Section -->
                <div class="space-y-3">
                    <label class="px-3 text-xs text-gray-500 uppercase">Manajemen Pengguna</label>

                    <a class="flex items-center px-3 py-2 transition-colors duration-300 transform rounded-sm text-gray-800 font-medium
                        {{ request()->is('admin/users*') ? 'bg-gray-200 text-gray-600' : 'hover:bg-gray-200' }}"
                        href="{{ route('admin.users.index') }}">
                        <i class="fas fa-users {{ request()->is('users*') ? 'text-gray-600' : 'text-gray-600 hover:text-gray-600' }} font-medium w-5"></i>
                        <span class="mx-2 text-xs">Pengguna</span>
                    </a>

                    <a class="flex items-center px-3 py-2 transition-colors duration-300 transform rounded-sm text-gray-800 font-medium
                        {{ request()->is('admin/dosen*') ? 'bg-gray-200 text-gray-600' : 'hover:bg-gray-200' }}"
                        href="{{ route('admin.dosen.index') }}">
                        <i class="fas fa-chalkboard-teacher {{ request()->is('dosen*') ? 'text-gray-600' : 'text-gray-600 hover:text-gray-600' }} font-medium w-5"></i>
                        <span class="mx-2 text-xs">Dosen</span>
                    </a>
                </div>

                <!-- Academic Section -->
                <div class="space-y-3">
                    <label class="px-3 text-xs text-gray-500 uppercase">Akademik</label>

                    <a class="flex items-center px-3 py-2 transition-colors duration-300 transform rounded-sm text-gray-800 font-medium
                        {{ request()->is('admin/mahasiswa*') ? 'bg-gray-200 text-gray-600' : 'hover:bg-gray-200' }}"
                        href="{{ route('admin.mahasiswa.index') }}">
                        <i class="fas fa-user-graduate {{ request()->is('mahasiswa*') ? 'text-gray-600' : 'text-gray-600 hover:text-gray-600' }} font-medium w-5"></i>
                        <span class="mx-2 text-xs">Mahasiswa</span>
                    </a>

                    <a class="flex items-center px-3 py-2 transition-colors duration-300 transform rounded-sm text-gray-800 font-medium
                        {{ request()->is('admin/kelas*') ? 'bg-gray-200 text-gray-600' : 'hover:bg-gray-200' }}"
                        href="{{ route('admin.kelas.index') }}">
                        <i class="fas fa-door-open {{ request()->is('admin/kelas*') ? 'text-gray-600' : 'text-gray-600 hover:text-gray-600' }} font-medium w-5"></i>
                        <span class="mx-2 text-xs">Kelas</span>
                    </a>

                    <a class="flex items-center px-3 py-2 transition-colors duration-300 transform rounded-sm text-gray-800 font-medium
                        {{ request()->is('admin/praktikum*') ? 'bg-gray-200 text-gray-600' : 'hover:bg-gray-200' }}"
                        href="{{ route('admin.praktikum.index') }}">
                        <i class="fas fa-flask {{ request()->is('admin/praktikum*') ? 'text-gray-600' : 'text-gray-600 hover:text-gray-600' }} font-medium w-5"></i>
                        <span class="mx-2 text-xs">Praktikum</span>
                    </a>
                </div>

                <!-- Reports Section -->
                <div class="space-y-3">
                    <label class="px-3 text-xs text-gray-500 uppercase">Laporan</label>

                    <a class="flex items-center px-3 py-2 transition-colors duration-300 transform rounded-sm text-gray-800 font-medium
                        {{ request()->is('laporan*') ? 'bg-gray-200 text-gray-600' : 'hover:bg-gray-200' }}"
                        href="#">
                        <i class="fas fa-file-alt {{ request()->is('laporan*') ? 'text-gray-600' : 'text-gray-600 hover:text-gray-600' }} font-medium w-5"></i>
                        <span class="mx-2 text-xs">Laporan</span>
                    </a>
                </div>
            </nav>
        </div>
    </aside>

    <!-- Top Navigation -->
    <nav class="fixed top-0 w-full right-0 h-16 bg-white shadow-md z-40 flex items-center justify-between px-6">
        <div class="flex items-center gap-2 ml-auto">
            <!-- Profile Menu -->
            <div id="profile-menu-toggle" class="relative inline-block cursor-pointer">
                <div class="flex flex-row gap-2 items-center">
                    <div class="flex flex-col text-end items-end">
                        <p class="text-gray-700 font-medium text-xs">{{ auth()->user()->name ?? 'User Name' }}</p>
                        <span class="text-gray-500 text-xs capitalize">{{ auth()->user()->role ?? 'admin' }}</span>
                    </div>
                    <div class="w-10 h-10 bg-gray-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-white"></i>
                    </div>
                </div>

                <!-- Profile Dropdown -->
                <div id="profile-dropdown"
                    class="absolute right-0 mt-2 bg-white rounded shadow-md w-40 p-3 hidden z-50">
                    <form method="POST" action="{{ route('logout') ?? '#' }}">
                        @csrf
                        <button type="submit"
                            class="bg-red-100 cursor-pointer hover:bg-red-50 text-red-600 transition-all duration-300 font-medium py-2 px-4 rounded-md w-full text-xs">
                            <i class="fas fa-sign-out-alt mr-1"></i>
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="w-full h-full flex items-center justify-center">
        <div id="main-content" class="transition-all duration-300 px-4 w-full h-full lg:ml-52 md:ml-48 sm:ml-0 pt-16">
            <!-- Page Content -->
            {{ $slot }}
        </div>
    </main>

    <!-- Loading Overlay -->
    <div id="loading-overlay" class="fixed inset-0 bg-gray-200/40 flex items-center justify-center z-50 hidden">
        <div class="bg-white p-5 rounded-lg shadow-lg text-center">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-gray-500 mx-auto mb-3"></div>
            <p class="text-gray-700">Loading...</p>
        </div>
    </div>
</body>

</html>