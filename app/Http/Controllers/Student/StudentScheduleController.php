<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;

class StudentScheduleController extends Controller
{
    public function index()
    {
        $classId = auth::user()->student->class_id;

        return view('student.schedule', [
            'schedules' => Schedule::with('subject','teacher.user')
                ->where('class_id', $classId)
                ->orderBy('day')
                ->get(),
        ]);
    }
}
