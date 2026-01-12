<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\dosen\DosenController;
use App\Http\Controllers\dosen\DosenDashboardController;
use App\Http\Controllers\koordinator\KoordinatorController;
use App\Http\Controllers\koordinator\KoordinatorDashboarController;
use App\Http\Controllers\mahasiswa\DashboardController;
use App\Http\Controllers\mahasiswa\MahasiswaController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showAuthForm'])->name('loginPage');
Route::get('/login', [AuthController::class, 'showAuthForm'])->name('authForm');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/get-prodi/{jurusan_id}', [AuthController::class, 'getProdi'])
    ->name('get.prodi');

Route::middleware(['auth', 'role:mahasiswa'])->group(function () {
    Route::get('/dashboard-mhs', [DashboardController::class, 'index'])->name('dashboard_mhs');
    Route::get('/form', [DashboardController::class, 'pendaftaran'])->name('formulir');
    Route::get('/data-diri', [DashboardController::class, 'dataDiri'])->name('data-diri');
    Route::get('/pelaporan-harian', [DashboardController::class, 'formLogbook'])->name('pelaporan-harian');
    Route::get('/pelaporan-akhir', [DashboardController::class, 'formLaporanAkhir'])->name('pelaporan-akhir');

    Route::post('/logbook-submit', [MahasiswaController::class, 'storeLaporanHarian'])->name('logbook-submit');
    Route::post('/form-submit', [MahasiswaController::class, 'pendaftaran'])->name('form-submit');
    Route::post('/update-data-diri', [MahasiswaController::class, 'updateDataDiri'])->name('update-data-diri');
    Route::post('/submit-laporan-akhir', [MahasiswaController::class, 'storeLaporanAkhir'])->name('submit-laporan-akhir');
});

Route::middleware('auth', 'role:koordinator')->group(function () {
    Route::get('/dashboard-koordinator', [KoordinatorDashboarController::class, 'index'])->name('dashboard_koordinator');
    Route::get('/form_schedule', [KoordinatorDashboarController::class, 'formSchedule'])->name('form_schedule');
    Route::post('/submit-schedule', [KoordinatorController::class, 'createSchedule'])->name('submit_schedule');
    Route::put('/update-schedule/{id}', [KoordinatorController::class, 'updateSchedule'])->name('update-schedule');
    Route::get('/form_schema', [KoordinatorDashboarController::class, 'formSchema'])->name('form_schema');
    Route::post('/submit-schema', [KoordinatorController::class, 'createSchema'])->name('submit_schema');
    Route::put('/update-schema/{id}', [KoordinatorController::class, 'updateSchema'])->name('update-schema');
    Route::get('/pendaftaran-kkn', [KoordinatorDashboarController::class, 'pendaftaranKKN'])->name('pendaftaran-kkn');
    Route::get('/pendaftaran-project', [KoordinatorDashboarController::class, 'pendaftaranProject'])->name('pendaftaran-project');
    Route::get('/pengelompokan-mhs', [KoordinatorDashboarController::class, 'pengelompokanMhs'])->name('pengelompokan');
    Route::get('/pengelompokan-mahasiswa', [KoordinatorController::class, 'pengelompokanMhs'])->name('pengelompokan.mahasiswa');
    Route::post('/buat-pengelompokan', [KoordinatorController::class, 'buatPengelompokan'])->name('buat-pengelompokan');
    Route::put('/update-pengelompokan', [KoordinatorController::class, 'editPengelompokan'])->name('update-pengelompokan');
    Route::get('/get-kelompok/{id}', [KoordinatorController::class, 'getKelompokData'])->name('get.kelompok.data');
    Route::delete('/delete-pengelompokan', [KoordinatorController::class, 'deletePengelompokan'])->name('delete-pengelompokan');
    Route::put('/verifikasi-pendaftaran', [KoordinatorController::class, 'verifikasiPendaftaran'])->name('verifikasi-pendaftaran');
    Route::put('/verifikasi-project', [KoordinatorController::class, 'verifikasiProject'])->name('verifikasi-project');
    Route::delete('/hapus-pendaftaran/{nim}', [KoordinatorController::class, 'deletePendaftaran'])->name('hapus-pendaftaran');
    Route::delete('/delete-schema/{id}', [KoordinatorController::class, 'destroySchema'])->name('delete_schema');
    Route::delete('/delete-schedule/{id}', [KoordinatorController::class, 'destroySchedule'])->name('delete_schedule');
});

Route::middleware('auth', 'role:dosen')->group(function () {
    Route::get('/dashboard-dosen', [DosenDashboardController::class, 'index'])->name('dashboard_dosen');
    Route::get('/form-pengajuan-kkn-dosen', [DosenDashboardController::class, 'formPengajuanProject'])->name('form-pengajuan-kkn-dosen');
    Route::post('/submit-pengajuan-project', [DosenController::class, 'pengajuanProject'])->name('submit-pengajuan-project');
    Route::get('/penilaian-logbook', [DosenDashboardController::class, 'penilaianLogbook'])->name('penilaian-logbook');
    Route::get('/panilaian-laporan-akhir', [DosenDashboardController::class, 'penilaianLaporanAkhir'])->name('penilaian-laporan-akhir');
    Route::put('/nilai-logbook', [DosenController::class, 'submitNilaiLogbook'])->name('nilai-logbook');
    Route::put('/nilai-laporan-akhir', [DosenController::class, 'submitNilaiLaporanAkhir'])->name('nilai-laporan-akhir');
});

Route::middleware('auth', 'role:admin')->group(function () {
    Route::get('/dashboard-dmin', [App\Http\Controllers\admin\AdminController::class, 'index'])->name('dashboard_admin');
    Route::get('/kelola-user', [App\Http\Controllers\admin\AdminController::class, 'kelolaUser'])->name('kelola_user');
    Route::get('/create-user', [App\Http\Controllers\admin\AdminController::class, 'createUser'])->name('create_user');
});

Route::post('/schema/get-available-kategori', [KoordinatorDashboarController::class, 'getAvailableKategori'])->name('schema.getAvailableKategori');
Route::post('/check-date-conflicts', [KoordinatorDashboarController::class, 'checkDateConflicts'])->name('schema.checkDateConflicts');
Route::post('/get-unavailable-dates', [KoordinatorDashboarController::class, 'getUnavailableDates'])->name('schema.getUnavailableDates');
Route::post('/validate-dates', [KoordinatorDashboarController::class, 'validateDates'])->name('schema.validateDates');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
