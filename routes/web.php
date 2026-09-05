<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminPklController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PklController;
use App\Http\Controllers\StudentAcademicController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\TeacherAcademicController;
use App\Http\Controllers\TeacherDashboardController;
use App\Http\Controllers\TeacherPklController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'create'])->name('login');
Route::post('/login', [AuthController::class, 'store'])->name('login.store');
Route::post('/logout', [AuthController::class, 'destroy'])->middleware('auth')->name('logout');

Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/', [StudentDashboardController::class, 'index'])->name('student.dashboard');
    Route::get('/dashboard-murid', [StudentDashboardController::class, 'index']);

    Route::controller(StudentDashboardController::class)->prefix('murid')->name('student.')->group(function () {
        Route::get('/jadwal', 'schedule')->name('schedule');
        Route::get('/nilai', 'grades')->name('grades');
        Route::get('/materi', 'materials')->name('materials');
        Route::get('/surat-izin', 'permits')->name('permits');
        Route::post('/surat-izin', 'storePermit')->name('permits.store');
        Route::get('/pkl', [PklController::class, 'index'])->name('pkl');
        Route::post('/pkl/{lokerPkl}/pilih', [PklController::class, 'apply'])->name('pkl.apply');
        Route::post('/pkl/{application}/laporan', [PklController::class, 'storeReport'])->name('pkl.report.store');
    });

    Route::controller(StudentAcademicController::class)->prefix('murid')->name('student.')->group(function () {
        Route::get('/tugas', 'assignments')->name('assignments');
        Route::post('/tugas/{assignment}/kumpulkan', 'submit')->name('assignments.submit');
        Route::get('/chat-guru', 'chat')->name('chat');
        Route::post('/chat-guru', 'sendChat')->name('chat.send');
    });
});

Route::middleware(['auth', 'role:teacher'])->prefix('guru')->name('teacher.')->group(function () {
    Route::get('/dashboard', [TeacherDashboardController::class, 'index'])->name('dashboard');
    Route::controller(TeacherAcademicController::class)->group(function () {
        Route::get('/tugas', 'assignments')->name('assignments');
        Route::post('/tugas', 'storeAssignment')->name('assignments.store');
        Route::get('/tugas/{assignment}/penilaian', 'gradebook')->name('assignments.gradebook');
        Route::patch('/pengumpulan/{submission}/nilai', 'updateGrade')->name('submissions.grade');
    });
    Route::controller(TeacherPklController::class)->group(function () {
        Route::get('/saran-pkl', 'suggest')->name('pkl.suggest');
        Route::post('/saran-pkl', 'storeSuggestion')->name('pkl.suggest.store');
    });
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/murid', [AdminUserController::class, 'students'])->name('students');
    Route::post('/murid', [AdminUserController::class, 'storeStudent'])->name('students.store');
    Route::get('/guru', [AdminUserController::class, 'teachers'])->name('teachers');
    Route::post('/guru', [AdminUserController::class, 'storeTeacher'])->name('teachers.store');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    Route::get('/kelas', [AdminController::class, 'classes'])->name('classes');
    Route::post('/kelas', [AdminController::class, 'storeClass'])->name('classes.store');
    Route::get('/pkl', [AdminPklController::class, 'index'])->name('pkl');
    Route::post('/pkl/pengaturan', [AdminPklController::class, 'updateSetting'])->name('pkl.settings.update');
    Route::post('/pkl/rekomendasi', [AdminPklController::class, 'storeLoker'])->name('pkl.lokers.store');
    Route::post('/pkl/saran/{loker}/setujui', [AdminPklController::class, 'approveSuggestion'])->name('pkl.suggest.approve');
    Route::post('/pkl/saran/{loker}/tolak', [AdminPklController::class, 'rejectSuggestion'])->name('pkl.suggest.reject');
    Route::delete('/pkl/{loker}', [AdminPklController::class, 'destroy'])->name('pkl.destroy');
    Route::patch('/pkl/pilihan/{application}', [AdminPklController::class, 'decideApplication'])->name('pkl.applications.decide');
    Route::patch('/pkl/laporan/{report}', [AdminPklController::class, 'reviewReport'])->name('pkl.reports.review');
    Route::post('/pkl/laporan/{report}/sidang', [AdminPklController::class, 'scheduleDefense'])->name('pkl.defenses.schedule');
});
