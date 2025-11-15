<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth_register.auth');
});
Route::get('/dashboard',function(){
    return view('dashboard.mahasiswa.dashboard');
})->name('dashboard');
Route::get('/form',function(){
    return view('dashboard.formulir_pendaftaran');
})->name('formulir');
Route::get('/data-diri',function(){
    return view('dashboard.data_diri');
})->name('data-diri');
Route::get('/data-akademik',function(){
    return view('dashboard.data_akademik');
})->name('data-akademik');
Route::get('/pengelompokan-mhs',function(){
    return view('dashboard.pengelompokan_mhs');
})->name('pengelompokan');
Route::get('/pelaporan-harian',function(){
    return view('dashboard.form_daily_pelaporan');
})->name('pelaporan-harian');
Route::get('/pelaporan-akhir',function(){
    return view('dashboard.form_pelaporan_akhir');
})->name('pelaporan-akhir');
Route::get('/penilaian-logbook',function(){
    return view('dashboard.dashboard_penilaian_logbook');
})->name('penilaian-logbook');
Route::get('/penilaian-laporan-akhir',function(){
    return view('dashboard.dashboard_penilaian_laporan_akhir');
})->name('penilaian-laporan-akhir');
