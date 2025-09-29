<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth_register.auth');
});
Route::get('/dashboard',function(){
    return view('dashboard.dashboard');
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
})->name('pengelompokan-mhs');
