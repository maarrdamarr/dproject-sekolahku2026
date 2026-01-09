<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Route
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------
    | Profile (Breeze default)
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
    Route::middleware('role:siswa')->prefix('siswa')->group(function () {
        Route::get('/dashboard', function () {
            return 'Dashboard Siswa';
        })->name('siswa.dashboard');
    });

});

/*
|--------------------------------------------------------------------------
| Auth Routes (Laravel Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';
