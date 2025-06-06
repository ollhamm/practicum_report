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

<body class="bg-gray-200 font-[Poppins]">

    <!-- Navigation Bar -->
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

    <!-- Main Content Container -->
    <div class="pt-16 pb-20 md:pb-0 min-h-screen md:mb-24 mb-0">
        <main id="main-content" class="px-4 py-4">
            <!-- Page Content -->
            {{ $slot }}
        </main>
    </div>

    <!-- Mobile Footer Menu -->
    <footer class="fixed bottom-0 left-0 right-0 bg-white shadow-lg border-t border-gray-200 z-40 block ">
        <div class="flex justify-around items-center py-2">
            <!-- Home Menu -->
            <a href="#" class="footer-menu-item flex flex-col items-center py-2 px-3 rounded-lg transition-all duration-200 {{ request()->routeIs('dashboard') ? 'text-blue-600 bg-blue-50' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">
                <i class="fas fa-home text-xl mb-1"></i>
                <span class="text-xs font-medium">Home</span>
            </a>

            <!-- Praktikum Menu -->
            <a href="/mahasiswa/laporan" class="footer-menu-item flex flex-col items-center py-2 px-3 rounded-lg transition-all duration-200 {{ request()->routeIs('praktikum.*') ? 'text-blue-600 bg-blue-50' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">
                <i class="fas fa-flask text-xl mb-1"></i>
                <span class="text-xs font-medium">Praktikum</span>
            </a>

            <!-- Kelas Menu -->
            <a href="#" class="footer-menu-item flex flex-col items-center py-2 px-3 rounded-lg transition-all duration-200 {{ request()->routeIs('kelas.*') ? 'text-blue-600 bg-blue-50' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">
                <i class="fas fa-users text-xl mb-1"></i>
                <span class="text-xs font-medium">Kelas</span>
            </a>

            <!-- Profile Menu -->
            <a href="#" class="footer-menu-item flex flex-col items-center py-2 px-3 rounded-lg transition-all duration-200 {{ request()->routeIs('profile.*') ? 'text-blue-600 bg-blue-50' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">
                <i class="fas fa-user text-xl mb-1"></i>
                <span class="text-xs font-medium">Profile</span>
            </a>
        </div>
    </footer>

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

    <style>
        /* Footer menu interactions */
        .footer-menu-item:active {
            transform: scale(0.95);
        }

        /* Optional: Add notification badge support */
        .footer-menu-item .badge {
            position: absolute;
            top: -2px;
            right: -2px;
            background-color: #ef4444;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        /* Ensure footer is always visible on mobile */
        @media (max-width: 768px) {
            body {
                padding-bottom: 0;
            }
        }
    </style>

    <!-- JavaScript for footer menu interactions and profile dropdown -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Footer menu interactions
            const menuItems = document.querySelectorAll('.footer-menu-item');

            menuItems.forEach(item => {
                item.addEventListener('touchstart', function(e) {
                    this.style.transform = 'scale(0.95)';
                });

                item.addEventListener('touchend', function(e) {
                    this.style.transform = 'scale(1)';
                });
            });

            // Profile dropdown functionality
            const profileToggle = document.getElementById('profile-menu-toggle');
            const profileDropdown = document.getElementById('profile-dropdown');

            if (profileToggle && profileDropdown) {
                profileToggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    profileDropdown.classList.toggle('hidden');
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!profileToggle.contains(e.target)) {
                        profileDropdown.classList.add('hidden');
                    }
                });
            }
        });
    </script>
</body>

</html>