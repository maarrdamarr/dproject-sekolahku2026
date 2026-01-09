<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileSchoolController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Student\StudentDashboardController;
use App\Http\Controllers\Student\StudentProfileController;
use App\Http\Controllers\Student\StudentGradeController;
use App\Http\Controllers\Student\StudentScheduleController;
use App\Http\Controllers\Student\StudentAnnouncementController;
use App\Http\Controllers\Student\StudentMaterialController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES (GUEST)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index']);

Route::get('/profil-sekolah', [ProfileSchoolController::class, 'index']);

Route::get('/berita', [NewsController::class, 'index']);
Route::get('/berita/{id}', [NewsController::class, 'show']);

Route::get('/galeri', [GalleryController::class, 'index']);

Route::get('/kontak', [ContactController::class, 'index']);
Route::post('/kontak', [ContactController::class, 'send']);

/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------
    | Profile (Laravel Breeze default)
    |--------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |--------------------------------------------------
    | ADMIN
    |--------------------------------------------------
    */
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', function () {
            return 'Dashboard Admin';
        })->name('admin.dashboard');
    });

    /*
    |--------------------------------------------------
    | GURU
    |--------------------------------------------------
    */
    Route::middleware('role:guru')->prefix('guru')->group(function () {
        Route::get('/dashboard', function () {
            return 'Dashboard Guru';
        })->name('guru.dashboard');
    });

    /*
    |--------------------------------------------------
    | ADMINISTRASI
    |--------------------------------------------------
    */
    Route::middleware('role:administrasi')->prefix('administrasi')->group(function () {
        Route::get('/dashboard', function () {
            return 'Dashboard Administrasi';
        })->name('administrasi.dashboard');
    });

    /*
    |--------------------------------------------------
    | SISWA
    |--------------------------------------------------
    */
    Route::middleware(['auth','role:siswa'])->prefix('siswa')->group(function () {

        Route::get('/dashboard', [StudentDashboardController::class, 'index']);

        Route::get('/profile', [StudentProfileController::class, 'edit']);
        Route::post('/profile', [StudentProfileController::class, 'update']);

        Route::get('/nilai', [StudentGradeController::class, 'index']);

        Route::get('/jadwal', [StudentScheduleController::class, 'index']);

        Route::get('/pengumuman', [StudentAnnouncementController::class, 'index']);

        Route::get('/materi', [StudentMaterialController::class, 'index']);
    });


});

/*
|--------------------------------------------------------------------------
| Auth Routes (Laravel Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';
