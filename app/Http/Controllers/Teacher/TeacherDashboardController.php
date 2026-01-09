<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Grade;
use App\Models\Material;
use App\Models\Schedule;

class TeacherDashboardController extends Controller
{
    public function index()
    {
        $teacher = auth()->user()->teacher;

        if (!$teacher) {
            abort(404);
        }

        $subjectIds = $teacher->schedules()->pluck('subject_id')->unique()->filter()->values();
        $classIds = $teacher->schedules()->pluck('class_id')->unique()->filter()->values();

        return view('teacher.dashboard', [
            'scheduleCount' => Schedule::where('teacher_id', $teacher->id)->count(),
            'classCount' => $classIds->count(),
            'materialCount' => $subjectIds->isEmpty() ? 0 : Material::whereIn('subject_id', $subjectIds)->count(),
            'gradeCount' => $subjectIds->isEmpty() || $classIds->isEmpty()
                ? 0
                : Grade::whereIn('subject_id', $subjectIds)
                    ->whereHas('student', function ($query) use ($classIds) {
                        $query->whereIn('class_id', $classIds);
                    })
                    ->count(),
            'announcements' => Announcement::latest()->take(5)->get(),
        ]);
    }
}
