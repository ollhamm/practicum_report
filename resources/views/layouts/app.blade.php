<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Lab In</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo-labin.ico') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/logo-labin.ico') }}">

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


<body class="bg-gray-200 h-screen font-[Poppins]">
    <!-- Sidebar -->
    <x-sidebar-navigation />

    <!-- Top Navigation -->
    <nav class="fixed top-0 w-full right-0 h-16 bg-white shadow-md z-30 flex items-center justify-between px-6">
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
                            class="cursor-pointer border border-red-500 hover:bg-red-500 text-red-600 hover:text-white transition-all duration-300 font-medium py-2 px-4 rounded-md w-full text-xs">
                            <i class="fas fa-sign-out-alt mr-1"></i>
                            Logout
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
    @if(session('success'))
    <script>
        window.onload = function() {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Berhasil!',
                    icon: 'success',
                    html: `{{ session('success') }}`,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                })
            } else {
                console.error('SweetAlert2 tidak dimuat');
                alert(`{{ session('success') }}`);
            }
        };
    </script>
    @endif
</body>

</html>