<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\koordinator\KoordinatorDashboarController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\mahasiswa\MahasiswaController;
use App\Models\Mahasiswa;

Route::post('/form-submit', [MahasiswaController::class, 'pendaftaran'])->name('form-submit');
Route::get('/available-students', function(Request $request) {
    $excludeGroup = $request->get('exclude_group');
    
    $query = Mahasiswa::with(['prodi', 'jurusan'])
        ->whereHas('pendaftaranKkn', function($q) {
            $q->whereIn('status', ['complete', 'grouped']);
        })
        ->whereDoesntHave('anggotaKelompok');

    $students = $query->get();

    return response()->json([
        'success' => true,
        'data' => $students
    ]);
});

Route::post('/users/create', [AdminController::class, 'store']);
Route::post('/users/{id}/toggle-status', [AdminController::class, 'toggleStatus']);
Route::get('/users/statistics', [AdminController::class, 'getStatistics']);
Route::get('/users/datatable', [AdminController::class, 'datatable']);


Route::get('/schedules/{id}/schemas', [KoordinatorDashboarController::class, 'getSchemasBySchedule'])->name('schedule.schemas');