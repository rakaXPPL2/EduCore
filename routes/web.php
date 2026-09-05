<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Perpustakaan\AdminSirkulasiController;
use App\Http\Controllers\Perpustakaan\DashboardController as PerpustakaanDashboardController;
use App\Http\Controllers\Perpustakaan\LoanController;
use App\Http\Controllers\StudentAcademicController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\TeacherAcademicController;
use App\Http\Controllers\TeacherDashboardController;
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

Route::middleware('auth')->prefix('perpustakaan')->name('library.')->group(function () {
    Route::get('/', [PerpustakaanDashboardController::class, 'index'])->name('dashboard');
    Route::get('/katalog', [PerpustakaanDashboardController::class, 'catalog'])->name('catalog');
    Route::get('/buku/{book}', [PerpustakaanDashboardController::class, 'show'])->name('books.show');
    Route::get('/profil', [PerpustakaanDashboardController::class, 'profile'])->name('profile');
    Route::get('/peminjaman', [LoanController::class, 'index'])->name('loans');
    Route::get('/peminjaman-kelas', [LoanController::class, 'classLoans'])->middleware('role:teacher')->name('class-loans');
    Route::post('/peminjaman-kelas', [LoanController::class, 'storeClassRequest'])->middleware('role:teacher')->name('class-loans.store');
    Route::post('/buku/{book}/pinjam', [LoanController::class, 'store'])->middleware('role:student')->name('loans.store');

    Route::middleware('role:admin')->prefix('admin/sirkulasi')->name('admin.')->group(function () {
        Route::get('/', [AdminSirkulasiController::class, 'index'])->name('circulation');
        Route::get('/buku', [AdminSirkulasiController::class, 'books'])->name('books');
        Route::post('/buku', [AdminSirkulasiController::class, 'storeBook'])->name('books.store');
        Route::get('/suggest-books', [AdminSirkulasiController::class, 'suggestBooks'])->name('suggest-books');
        Route::patch('/{loan}/{action}', [AdminSirkulasiController::class, 'update'])->name('circulation.update');
    });
});
