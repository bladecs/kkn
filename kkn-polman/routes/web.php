<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\dosen\DosenDashboardController;
use App\Http\Controllers\koordinator\KoordinatorDashboarController;
use App\Http\Controllers\koordinator\KoordinatorController;
use App\Http\Controllers\mahasiswa\DashboardController;
use App\Http\Controllers\mahasiswa\MahasiswaController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;


Route::get('/', [AuthController::class, 'showAuthForm'])->name('loginPage');
Route::get('/login', [AuthController::class, 'showAuthForm'])->name('authForm');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/login-dosen', [AuthController::class, 'showAuthFormDosen'])->name('login-dosen');
Route::post('/login-dosen', [AuthController::class, 'loginDosen'])->name('login-dosen-submit');

Route::middleware(['auth', 'role:mahasiswa'])->group(function () {
    Route::get('/dashboard-mhs', [DashboardController::class, 'index'])->name('dashboard_mhs');
    Route::get('/form', function () {
        return view('dashboard.mahasiswa.formulir_pendaftaran');
    })->name('formulir');
    Route::get('/data-diri', [DashboardController::class, 'dataDiri'])->name('data-diri');
    Route::get('/form-pengajuan-kkn', [DashboardController::class, 'formPengajuanProject'])->name('form-pengajuan-kkn');
    Route::get('/pelaporan-harian', function () {
        return view('dashboard.mahasiswa.form_daily_pelaporan');
    })->name('pelaporan-harian');
    Route::get('/pelaporan-akhir', function () {
        return view('dashboard.mahasiswa.form_pelaporan_akhir');
    })->name('pelaporan-akhir');

    Route::post('/form-submit', [MahasiswaController::class, 'pendaftaran'])->name('form-submit');
    Route::put('/update-data-diri', [MahasiswaController::class, 'updateDataDiri'])->name('update-data-diri');
});

Route::middleware('auth:dosen', 'role:koordinator')->group(function () {
    Route::get('/dashboard-koordinator', [KoordinatorDashboarController::class, 'index'])->name('dashboard_koordinator');
    Route::get('/pendaftaran-kkn', [KoordinatorDashboarController::class, 'pendaftaranKKN'])->name('pendaftaran-kkn');
    Route::put('/verifikasi-pendaftaran', [KoordinatorController::class, 'verifikasiPendaftaran'])->name('verifikasi-pendaftaran');
    Route::delete('/hapus-pendaftaran/{nim}', [KoordinatorController::class, 'deletePendaftaran'])->name('hapus-pendaftaran');
});
Route::middleware('auth:dosen', 'role:dosen')->group(function () {
    Route::get('/dashboard-dosen', [DosenDashboardController::class, 'index'])->name('dashboard_dosen');
    Route::get('/form-pengajuan-kkn-dosen', [DosenDashboardController::class, 'formPengajuanProject'])->name('form-pengajuan-kkn-dosen');
    Route::get('/pendaftaran-kkn', [KoordinatorDashboarController::class, 'pendaftaranKKN'])->name('pendaftaran-kkn');
    Route::put('/verifikasi-pendaftaran', [KoordinatorController::class, 'verifikasiPendaftaran'])->name('verifikasi-pendaftaran');
    Route::delete('/hapus-pendaftaran/{nim}', [KoordinatorController::class, 'deletePendaftaran'])->name('hapus-pendaftaran');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/pengelompokan-mhs', function () {
    return view('dashboard.pengelompokan_mhs');
})->name('pengelompokan');
Route::get('/penilaian-logbook', function () {
    return view('dashboard.dashboard_penilaian_logbook');
})->name('penilaian-logbook');
Route::get('/penilaian-laporan-akhir', function () {
    return view('dashboard.dashboard_penilaian_laporan_akhir');
})->name('penilaian-laporan-akhir');
