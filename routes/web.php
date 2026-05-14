<?php

use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\AbsensiController as AdminAbsensiController;
use App\Http\Controllers\Admin\HistoryController;
use App\Http\Controllers\Siswa\DashboardSiswaController;
use App\Http\Controllers\Siswa\AbsensiController as SiswaAbsensiController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

// Redirect berdasarkan role setelah login
Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->isAdmin()
            ? redirect()->route('admin.kelas.index')
            : redirect()->route('siswa.kelas.cari');
    }
    return redirect()->route('login');
});

// Auth routes (dari Breeze)
require __DIR__.'/auth.php';

// =====================
// ADMIN ROUTES
// =====================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    // Daftar kelas
    Route::resource('kelas', KelasController::class);

    // Dashboard kelas
    Route::prefix('kelas/{kelas}')->name('kelas.')->group(function () {
        Route::get('dashboard', [KelasController::class, 'dashboard'])->name('dashboard');

        // Kelola siswa dalam kelas
        Route::get('siswa', [SiswaController::class, 'index'])->name('siswa.index');
        Route::post('siswa', [SiswaController::class, 'store'])->name('siswa.store');
        Route::put('siswa/{siswa}', [SiswaController::class, 'update'])->name('siswa.update');
        Route::delete('siswa/{siswa}', [SiswaController::class, 'destroy'])->name('siswa.destroy');

        // Kelola absensi
        Route::get('absensi', [AdminAbsensiController::class, 'index'])->name('absensi.index');
        Route::post('absensi', [AdminAbsensiController::class, 'store'])->name('absensi.store');
        Route::put('absensi/{absensi}', [AdminAbsensiController::class, 'update'])->name('absensi.update');
        Route::get('absensi/data', [AdminAbsensiController::class, 'getData'])->name('absensi.data');

        // History absensi
        Route::get('history', [HistoryController::class, 'index'])->name('history.index');
        Route::get('history/export', [HistoryController::class, 'export'])->name('history.export');
    });
});

// =====================
// SISWA ROUTES
// =====================
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {

    // Cari/Masuk kelas
    Route::get('kelas/cari', [DashboardSiswaController::class, 'cariKelas'])->name('kelas.cari');
    Route::post('kelas/join', [DashboardSiswaController::class, 'joinKelas'])->name('kelas.join');

    // Dashboard kelas siswa
    Route::prefix('kelas/{kelas}')->name('kelas.')->group(function () {
        Route::get('dashboard', [DashboardSiswaController::class, 'dashboard'])->name('dashboard');
        Route::get('siswa', [DashboardSiswaController::class, 'daftarSiswa'])->name('siswa');

        // Absensi siswa
        Route::get('absensi', [SiswaAbsensiController::class, 'index'])->name('absensi.index');
        Route::post('absensi', [SiswaAbsensiController::class, 'presensi'])->name('absensi.store');
    });
});