<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Announcement;

class StudentAnnouncementController extends Controller
{
    public function index()
    {
        return view('student.announcements', [
            'announcements' => Announcement::latest()->paginate(10),
        ]);
    }
}
