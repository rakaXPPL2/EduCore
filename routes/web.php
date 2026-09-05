<?php

use App\Http\Controllers\StudentDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [StudentDashboardController::class, 'index'])->name('student.dashboard');
Route::get('/dashboard-murid', [StudentDashboardController::class, 'index']);

Route::controller(StudentDashboardController::class)->prefix('murid')->name('student.')->group(function () {
    Route::get('/jadwal', 'schedule')->name('schedule');
    Route::get('/nilai', 'grades')->name('grades');
    Route::get('/materi', 'materials')->name('materials');
    Route::get('/surat-izin', 'permits')->name('permits');
    Route::post('/surat-izin', 'storePermit')->name('permits.store');
});
