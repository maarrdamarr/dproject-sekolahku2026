<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Schedule;

class TeacherScheduleController extends Controller
{
    public function index()
    {
        $teacher = auth()->user()->teacher;

        if (!$teacher) {
            abort(404);
        }

        return view('teacher.schedule', [
            'schedules' => Schedule::with(['subject', 'classRoom'])
                ->where('teacher_id', $teacher->id)
                ->orderBy('day')
                ->orderBy('start_time')
                ->get(),
        ]);
    }
}
