<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentAcademicController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\TeacherAcademicController;
use App\Http\Controllers\TeacherDashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return Auth::user()->isTeacher()
            ? app(TeacherDashboardController::class)->index()
            : app(StudentDashboardController::class)->index();
    }

    return view('landing');
})->name('landing');

Route::get('/login', [AuthController::class, 'create'])->name('login');
Route::post('/login', [AuthController::class, 'store'])->name('login.store');
Route::post('/logout', [AuthController::class, 'destroy'])->middleware('auth')->name('logout');

Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/dashboard-murid', [StudentDashboardController::class, 'index'])->name('student.dashboard');

    Route::controller(StudentDashboardController::class)->prefix('murid')->name('student.')->group(function () {
        Route::get('/jadwal', 'schedule')->name('schedule');
        Route::get('/nilai', 'grades')->name('grades');
        Route::get('/materi', 'materials')->name('materials');
        Route::get('/surat-izin', 'permits')->name('permits');
        Route::post('/surat-izin', 'storePermit')->name('permits.store');
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
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/kelas', [AdminController::class, 'classes'])->name('classes');
    Route::post('/kelas', [AdminController::class, 'storeClass'])->name('classes.store');
});
