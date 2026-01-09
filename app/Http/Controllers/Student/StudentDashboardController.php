<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Grade;
use Illuminate\Support\Facades\Auth;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $student = auth::user()->student;

        return view('student.dashboard', [
            'announcements' => Announcement::latest()->take(5)->get(),
            'average' => $student?->grades()->avg('score') ?? 0,
        ]);
    }
}
