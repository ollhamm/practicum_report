<?php

use App\Http\Controllers\Admin\AdminPraktikumController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\DosenManagementController;
use App\Http\Controllers\Admin\MahasiswaManagementController;
use App\Http\Controllers\Dosen\DashboardController;
use App\Http\Controllers\Dosen\KelasController;
use App\Http\Controllers\Dosen\PraktikumController;
use App\Http\Controllers\Mahasiswa\LaporanController;
use App\Http\Controllers\Mahasiswa\HasilNormalController;
use App\Http\Controllers\Admin\KelasManagementController;
use App\Http\Controllers\Admin\PraktikumManagementController;
use App\Http\Controllers\Mahasiswa\KelasController as MahasiswaKelasController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isDosen()) {
            return redirect()->route('dosen.dashboard');
        } elseif ($user->isMahasiswa()) {
            return redirect()->route('mahasiswa.dashboard');
        }
    }

    return redirect()->route('login');
});

// Public routes
Route::middleware('guest')->group(function () {

    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    // Password Reset Routes
    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
});

// Auth routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Admin routes
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('users', UserManagementController::class);
        Route::post('/users/{user}/approve', [UserManagementController::class, 'approve'])->name('users.approve');
        Route::post('/users/{user}/reject', [UserManagementController::class, 'reject'])->name('users.reject');
        Route::resource('dosen', DosenManagementController::class)->except(['create', 'store']);
        Route::resource('mahasiswa', MahasiswaManagementController::class)->except(['create', 'store']);
        Route::resource('kelas', KelasManagementController::class);
        Route::get('kelas/{kelas}/dosen', [PraktikumManagementController::class, 'getDosenByKelas'])->name('kelas.dosen');
        Route::resource('praktikum', PraktikumManagementController::class);

        // File Download Routes (NEW)
        Route::get('praktikum/{praktikum}/download-panduan', [PraktikumManagementController::class, 'downloadPanduan'])->name('praktikum.download-panduan');
        Route::get('praktikum/{praktikum}/download-template', [PraktikumManagementController::class, 'downloadTemplate'])->name('praktikum.download-template');

        // File View Routes (NEW)
        Route::get('praktikum/{praktikum}/view-panduan', [PraktikumManagementController::class, 'viewPanduan'])->name('praktikum.view-panduan');
        Route::get('praktikum/{praktikum}/view-template', [PraktikumManagementController::class, 'viewTemplate'])->name('praktikum.view-template');

        // Laporan Routes (NEW)
        Route::get('praktikum/laporan/{laporan}/view', [PraktikumManagementController::class, 'viewLaporan'])->name('praktikum.view-laporan');
        Route::get('praktikum/laporan/{laporan}/download-koreksi', [PraktikumManagementController::class, 'downloadKoreksi'])->name('praktikum.download-koreksi');
    });

    // Dosen routes
    Route::middleware(['role:dosen'])->prefix('dosen')->name('dosen.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Kelas Routes (view only)
        Route::resource('kelas', KelasController::class)->only(['index', 'show']);

        // Praktikum Routes (full CRUD)
        Route::resource('praktikum', App\Http\Controllers\Dosen\PraktikumController::class);

        // File Download Routes
        Route::get('praktikum/{praktikum}/download-panduan', [App\Http\Controllers\Dosen\PraktikumController::class, 'downloadPanduan'])->name('praktikum.download-panduan');
        Route::get('praktikum/{praktikum}/download-template', [App\Http\Controllers\Dosen\PraktikumController::class, 'downloadTemplate'])->name('praktikum.download-template');

        // File View Routes (NEW)
        Route::get('praktikum/{praktikum}/view-panduan', [App\Http\Controllers\Dosen\PraktikumController::class, 'viewPanduan'])->name('praktikum.view-panduan');
        Route::get('praktikum/{praktikum}/view-template', [App\Http\Controllers\Dosen\PraktikumController::class, 'viewTemplate'])->name('praktikum.view-template');

        // Penilaian Routes
        Route::get('praktikum/{praktikum}/penilaian/{mahasiswa}', [App\Http\Controllers\Dosen\PraktikumController::class, 'penilaian'])->name('praktikum.penilaian');
        Route::put('praktikum/penilaian/{laporan}', [App\Http\Controllers\Dosen\PraktikumController::class, 'submitPenilaian'])->name('praktikum.submit-penilaian');
        Route::get('praktikum/laporan/{laporan}/view', [App\Http\Controllers\Dosen\PraktikumController::class, 'viewLaporan'])->name('praktikum.view-laporan');
        Route::get('praktikum/laporan/{laporan}/download-koreksi', [App\Http\Controllers\Dosen\PraktikumController::class, 'downloadKoreksi'])->name('praktikum.download-koreksi');
    });

    Route::middleware(['role:mahasiswa'])
        ->prefix('mahasiswa')
        ->name('mahasiswa.')
        ->group(function () {
            Route::scopeBindings()->group(function () {
                Route::get('/dashboard', [\App\Http\Controllers\Mahasiswa\DashboardController::class, 'index'])->name('dashboard');
                Route::resource('laporan', LaporanController::class);
                Route::resource('kelas', MahasiswaKelasController::class)->only(['index', 'show']);

                // File Download Routes
                Route::get('laporan/{praktikum}/download-panduan', [LaporanController::class, 'downloadPanduan'])->name('laporan.download-panduan');
                Route::get('laporan/{praktikum}/download-template', [LaporanController::class, 'downloadTemplate'])->name('laporan.download-template');
                // File View Routes
                Route::get('laporan/{praktikum}/view-panduan', [LaporanController::class, 'viewPanduan'])->name('laporan.view-panduan');
                Route::get('laporan/{praktikum}/view-template', [LaporanController::class, 'viewTemplate'])->name('laporan.view-template');

                // File Download Routes
                Route::get('laporan/{laporan}/download', [LaporanController::class, 'download'])->name('laporan.download');
                Route::get('laporan/{laporan}/download-koreksi', [LaporanController::class, 'downloadKoreksi'])->name('laporan.download-koreksi');
                Route::get('laporan/{laporan}/koreksi', [LaporanController::class, 'viewKoreksi'])->name('laporan.koreksi');
                Route::get('laporan/{laporan}/view-file', [LaporanController::class, 'viewFile'])->name('laporan.view-file');
                Route::get('laporan/{laporan}/view-koreksi-file', [LaporanController::class, 'viewKoreksiFile'])->name('laporan.view-koreksi-file');
                Route::get('/hasil-normal', [HasilNormalController::class, 'index'])->name('hasil-normal.index');

                // profile
                Route::get('/profile', [\App\Http\Controllers\Mahasiswa\ProfileController::class, 'index'])->name('profile.index');
            });
        });
});
