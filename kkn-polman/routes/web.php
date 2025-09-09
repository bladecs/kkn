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
