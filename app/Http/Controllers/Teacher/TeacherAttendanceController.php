<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\ClassRoom;
use App\Models\Student;
use Illuminate\Http\Request;

class TeacherAttendanceController extends Controller
{
    public function index(Request $request)
    {
        $teacher = auth()->user()->teacher;

        if (!$teacher) {
            abort(404);
        }

        $classIds = $teacher->schedules()->pluck('class_id')->unique()->filter()->values();
        $classes = $classIds->isEmpty()
            ? collect()
            : ClassRoom::whereIn('id', $classIds)->orderBy('name')->get();

        $classId = $request->get('class_id');
        if (!$classId && $classes->isNotEmpty()) {
            $classId = $classes->first()->id;
        }

        if ($classId && !$classIds->contains((int) $classId)) {
            $classId = $classes->first()->id ?? null;
        }

        $date = $request->get('date', now()->toDateString());

        $students = collect();
        $attendanceMap = collect();

        if ($classId) {
            $students = Student::with('user')
                ->where('class_id', $classId)
                ->orderBy('id')
                ->get();

            if ($students->isNotEmpty()) {
                $attendanceMap = Attendance::whereIn('student_id', $students->pluck('id'))
                    ->whereDate('date', $date)
                    ->get()
                    ->keyBy('student_id');
            }
        }

        return view('teacher.attendance', [
            'classes' => $classes,
            'classId' => $classId,
            'date' => $date,
            'students' => $students,
            'attendanceMap' => $attendanceMap,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|integer|exists:classes,id',
            'date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*' => 'required|in:hadir,izin,sakit,alpha',
        ]);

        $teacher = auth()->user()->teacher;

        if (!$teacher) {
            abort(404);
        }

        $classIds = $teacher->schedules()->pluck('class_id')->unique()->filter()->values()->all();

        if (!in_array((int) $request->class_id, $classIds, true)) {
            return back()->with('error', 'Kelas tidak sesuai dengan jadwal mengajar.');
        }

        $studentIds = Student::where('class_id', $request->class_id)
            ->whereIn('id', array_keys($request->attendance))
            ->pluck('id')
            ->all();

        foreach ($studentIds as $studentId) {
            Attendance::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'date' => $request->date,
                ],
                [
                    'status' => $request->attendance[$studentId],
                ]
            );
        }

        return back()->with('success', 'Absensi berhasil disimpan')
            ->withInput([
                'class_id' => $request->class_id,
                'date' => $request->date,
            ]);
    }
}
