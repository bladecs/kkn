<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\mahasiswa\MahasiswaController;

Route::post('/form-submit', [MahasiswaController::class, 'pendaftaran'])->name('form-submit');