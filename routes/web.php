<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Dosen\KelasController;
use App\Http\Controllers\Dosen\PraktikumController;
use App\Http\Controllers\Mahasiswa\LaporanController;
use App\Http\Controllers\Mahasiswa\HasilNormalController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return redirect()->route('login');
    });

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
    });

    // Dosen routes
    Route::middleware(['approved', 'role:dosen'])->prefix('dosen')->name('dosen.')->group(function () {
        Route::get('/dashboard', [KelasController::class, 'index'])->name('dashboard');
        Route::resource('kelas', KelasController::class);
        Route::get('praktikum', [PraktikumController::class, 'index'])->name('praktikum.index');
        Route::get('praktikum/create', [PraktikumController::class, 'create'])->name('praktikum.create');
        Route::post('praktikum', [PraktikumController::class, 'store'])->name('praktikum.store');
        Route::get('praktikum/{praktikum}', [PraktikumController::class, 'show'])->name('praktikum.show');
        Route::get('praktikum/{praktikum}/edit', [PraktikumController::class, 'edit'])->name('praktikum.edit');
        Route::put('praktikum/{praktikum}', [PraktikumController::class, 'update'])->name('praktikum.update');
        Route::delete('praktikum/{praktikum}', [PraktikumController::class, 'destroy'])->name('praktikum.destroy');
        Route::get('praktikum/{praktikum}/download-panduan', [PraktikumController::class, 'downloadPanduan'])->name('praktikum.download-panduan');
        Route::get('praktikum/{praktikum}/download-template', [PraktikumController::class, 'downloadTemplate'])->name('praktikum.download-template');
    });

    // Mahasiswa routes
    Route::middleware(['role:mahasiswa'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
        Route::get('/dashboard', [LaporanController::class, 'index'])->name('dashboard');
        Route::resource('laporan', LaporanController::class);
        Route::get('laporan/{laporan}/download', [LaporanController::class, 'download'])->name('laporan.download');
        Route::get('/hasil-normal', [HasilNormalController::class, 'index'])->name('hasil-normal.index');
    });
});
