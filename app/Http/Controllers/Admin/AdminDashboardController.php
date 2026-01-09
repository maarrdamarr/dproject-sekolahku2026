<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Content;
use App\Models\Gallery;
use App\Models\News;
use App\Models\Payment;
use App\Models\Setting;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'userCount' => User::count(),
            'adminCount' => User::where('role', 'admin')->count(),
            'administrationCount' => User::where('role', 'administrasi')->count(),
            'teacherCount' => Teacher::count(),
            'studentCount' => Student::count(),
            'newsCount' => News::count(),
            'announcementCount' => Announcement::count(),
            'galleryCount' => Gallery::count(),
            'contentCount' => Content::count(),
            'settingCount' => Setting::count(),
            'paymentTotal' => Payment::sum('amount'),
            'latestUsers' => User::latest()->take(5)->get(),
            'latestNews' => News::latest()->take(5)->get(),
        ]);
    }
}
