<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileSchoolController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AllReportController;
use App\Http\Controllers\Admin\BackupController;
use App\Http\Controllers\Admin\ContentManagementController;
use App\Http\Controllers\Admin\GalleryManagementController;
use App\Http\Controllers\Admin\NewsManagementController;
use App\Http\Controllers\Admin\SystemSettingController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Administration\AdministrationDashboardController;
use App\Http\Controllers\Administration\LetterController;
use App\Http\Controllers\Administration\PaymentController;
use App\Http\Controllers\Administration\ReportController;
use App\Http\Controllers\Administration\ScheduleManagementController;
use App\Http\Controllers\Administration\StudentManagementController;
use App\Http\Controllers\Administration\TeacherManagementController;
use App\Http\Controllers\Student\StudentAnnouncementController;
use App\Http\Controllers\Student\StudentDashboardController;
use App\Http\Controllers\Student\StudentGradeController;
use App\Http\Controllers\Student\StudentMaterialController;
use App\Http\Controllers\Student\StudentProfileController;
use App\Http\Controllers\Student\StudentScheduleController;
use App\Http\Controllers\Teacher\TeacherAnnouncementController;
use App\Http\Controllers\Teacher\TeacherAttendanceController;
use App\Http\Controllers\Teacher\TeacherDashboardController;
use App\Http\Controllers\Teacher\TeacherGradeController;
use App\Http\Controllers\Teacher\TeacherMaterialController;
use App\Http\Controllers\Teacher\TeacherProfileController;
use App\Http\Controllers\Teacher\TeacherScheduleController;

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
    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

        Route::resource('users', UserManagementController::class)->except(['show']);
        Route::resource('contents', ContentManagementController::class)->except(['show']);

        Route::get('/berita', [NewsManagementController::class, 'index']);
        Route::get('/berita/create', [NewsManagementController::class, 'createNews']);
        Route::post('/berita', [NewsManagementController::class, 'storeNews']);
        Route::get('/berita/{news}/edit', [NewsManagementController::class, 'editNews']);
        Route::put('/berita/{news}', [NewsManagementController::class, 'updateNews']);
        Route::delete('/berita/{news}', [NewsManagementController::class, 'destroyNews']);

        Route::get('/pengumuman/create', [NewsManagementController::class, 'createAnnouncement']);
        Route::post('/pengumuman', [NewsManagementController::class, 'storeAnnouncement']);
        Route::get('/pengumuman/{announcement}/edit', [NewsManagementController::class, 'editAnnouncement']);
        Route::put('/pengumuman/{announcement}', [NewsManagementController::class, 'updateAnnouncement']);
        Route::delete('/pengumuman/{announcement}', [NewsManagementController::class, 'destroyAnnouncement']);

        Route::resource('galleries', GalleryManagementController::class)->except(['show']);
        Route::resource('settings', SystemSettingController::class)->except(['show']);

        Route::get('/backups', [BackupController::class, 'index']);
        Route::post('/backups', [BackupController::class, 'store']);
        Route::get('/backups/{file}', [BackupController::class, 'download']);
        Route::delete('/backups/{file}', [BackupController::class, 'destroy']);

        Route::get('/reports', [AllReportController::class, 'index']);
        Route::get('/reports/pdf', [AllReportController::class, 'exportPdf']);
    });

    /*
    |--------------------------------------------------
    | GURU
    |--------------------------------------------------
    */
    Route::middleware(['role:guru'])->prefix('guru')->group(function () {
        Route::get('/dashboard', [TeacherDashboardController::class, 'index'])->name('guru.dashboard');

        Route::get('/profile', [TeacherProfileController::class, 'edit']);
        Route::post('/profile', [TeacherProfileController::class, 'update']);

        Route::get('/nilai', [TeacherGradeController::class, 'index']);
        Route::post('/nilai', [TeacherGradeController::class, 'store']);

        Route::get('/materi', [TeacherMaterialController::class, 'index']);
        Route::post('/materi', [TeacherMaterialController::class, 'store']);

        Route::get('/jadwal', [TeacherScheduleController::class, 'index']);

        Route::get('/absensi', [TeacherAttendanceController::class, 'index']);
        Route::post('/absensi', [TeacherAttendanceController::class, 'store']);

        Route::get('/pengumuman', [TeacherAnnouncementController::class, 'index']);
        Route::post('/pengumuman', [TeacherAnnouncementController::class, 'store']);
    });

    /*
    |--------------------------------------------------
    | ADMINISTRASI
    |--------------------------------------------------
    */
    Route::middleware(['role:administrasi'])->prefix('administrasi')->group(function () {
        Route::get('/dashboard', [AdministrationDashboardController::class, 'index'])
            ->name('administrasi.dashboard');

        Route::resource('siswa', StudentManagementController::class)
            ->except(['show'])
            ->parameters(['siswa' => 'student']);
        Route::resource('guru', TeacherManagementController::class)
            ->except(['show'])
            ->parameters(['guru' => 'teacher']);
        Route::resource('jadwal', ScheduleManagementController::class)
            ->except(['show'])
            ->parameters(['jadwal' => 'schedule']);
        Route::resource('pembayaran', PaymentController::class)
            ->except(['show'])
            ->parameters(['pembayaran' => 'payment']);
        Route::resource('surat', LetterController::class)
            ->except(['show'])
            ->parameters(['surat' => 'letter']);

        Route::get('/laporan', [ReportController::class, 'index']);
        Route::get('/laporan/pdf', [ReportController::class, 'exportPdf']);
    });

    /*
    |--------------------------------------------------
    | SISWA
    |--------------------------------------------------
    */
    Route::middleware(['role:siswa'])->prefix('siswa')->group(function () {
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
