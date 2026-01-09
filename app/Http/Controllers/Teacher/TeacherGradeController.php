<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class TeacherGradeController extends Controller
{
    public function index()
    {
        $teacher = auth()->user()->teacher;

        if (!$teacher) {
            abort(404);
        }

        $subjectIds = $teacher->schedules()->pluck('subject_id')->unique()->filter()->values();
        $classIds = $teacher->schedules()->pluck('class_id')->unique()->filter()->values();

        $subjects = $subjectIds->isEmpty()
            ? collect()
            : Subject::whereIn('id', $subjectIds)->orderBy('name')->get();

        $students = $classIds->isEmpty()
            ? collect()
            : Student::with(['user', 'classRoom'])
                ->whereIn('class_id', $classIds)
                ->orderBy('class_id')
                ->orderBy('id')
                ->get();

        $grades = $subjectIds->isEmpty() || $classIds->isEmpty()
            ? collect()
            : Grade::with(['student.user', 'subject'])
                ->whereIn('subject_id', $subjectIds)
                ->whereHas('student', function ($query) use ($classIds) {
                    $query->whereIn('class_id', $classIds);
                })
                ->latest()
                ->paginate(10)
                ->withQueryString();

        return view('teacher.grades', [
            'subjects' => $subjects,
            'students' => $students,
            'grades' => $grades,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|integer|exists:students,id',
            'subject_id' => 'required|integer|exists:subjects,id',
            'score' => 'required|integer|min:0|max:100',
        ]);

        $teacher = auth()->user()->teacher;

        if (!$teacher) {
            abort(404);
        }

        $allowedSubjectIds = $teacher->schedules()->pluck('subject_id')->unique()->filter()->values()->all();
        $allowedClassIds = $teacher->schedules()->pluck('class_id')->unique()->filter()->values()->all();

        $student = Student::where('id', $request->student_id)
            ->whereIn('class_id', $allowedClassIds)
            ->first();

        if (!in_array((int) $request->subject_id, $allowedSubjectIds, true) || !$student) {
            return back()->with('error', 'Data tidak sesuai dengan jadwal mengajar.');
        }

        Grade::updateOrCreate(
            [
                'student_id' => $request->student_id,
                'subject_id' => $request->subject_id,
            ],
            [
                'score' => $request->score,
            ]
        );

        return back()->with('success', 'Nilai berhasil disimpan');
    }
}
