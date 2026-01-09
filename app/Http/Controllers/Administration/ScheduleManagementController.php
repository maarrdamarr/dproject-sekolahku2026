<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\Schedule;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;

class ScheduleManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = Schedule::with(['classRoom', 'subject', 'teacher.user']);

        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }

        if ($request->filled('teacher_id')) {
            $query->where('teacher_id', $request->teacher_id);
        }

        if ($request->filled('day')) {
            $query->where('day', $request->day);
        }

        return view('administration.schedules.index', [
            'schedules' => $query->orderBy('day')->orderBy('start_time')->paginate(10)->withQueryString(),
            'classes' => ClassRoom::orderBy('name')->get(),
            'subjects' => Subject::orderBy('name')->get(),
            'teachers' => Teacher::with('user')->orderBy('id')->get(),
        ]);
    }

    public function create()
    {
        return view('administration.schedules.create', [
            'classes' => ClassRoom::orderBy('name')->get(),
            'subjects' => Subject::orderBy('name')->get(),
            'teachers' => Teacher::with('user')->orderBy('id')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|integer|exists:classes,id',
            'subject_id' => 'required|integer|exists:subjects,id',
            'teacher_id' => 'required|integer|exists:teachers,id',
            'day' => 'required|string|max:20',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        Schedule::create([
            'class_id' => $request->class_id,
            'subject_id' => $request->subject_id,
            'teacher_id' => $request->teacher_id,
            'day' => $request->day,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return redirect('administrasi/jadwal')->with('success', 'Jadwal berhasil ditambahkan');
    }

    public function edit(Schedule $schedule)
    {
        return view('administration.schedules.edit', [
            'schedule' => $schedule->load(['classRoom', 'subject', 'teacher.user']),
            'classes' => ClassRoom::orderBy('name')->get(),
            'subjects' => Subject::orderBy('name')->get(),
            'teachers' => Teacher::with('user')->orderBy('id')->get(),
        ]);
    }

    public function update(Request $request, Schedule $schedule)
    {
        $request->validate([
            'class_id' => 'required|integer|exists:classes,id',
            'subject_id' => 'required|integer|exists:subjects,id',
            'teacher_id' => 'required|integer|exists:teachers,id',
            'day' => 'required|string|max:20',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $schedule->update([
            'class_id' => $request->class_id,
            'subject_id' => $request->subject_id,
            'teacher_id' => $request->teacher_id,
            'day' => $request->day,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return redirect('administrasi/jadwal')->with('success', 'Jadwal berhasil diperbarui');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return back()->with('success', 'Jadwal berhasil dihapus');
    }
}
