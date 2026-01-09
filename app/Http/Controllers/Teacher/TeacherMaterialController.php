<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\Subject;
use Illuminate\Http\Request;

class TeacherMaterialController extends Controller
{
    public function index()
    {
        $teacher = auth()->user()->teacher;

        if (!$teacher) {
            abort(404);
        }

        $subjectIds = $teacher->schedules()->pluck('subject_id')->unique()->filter()->values();

        $subjects = $subjectIds->isEmpty()
            ? collect()
            : Subject::whereIn('id', $subjectIds)->orderBy('name')->get();

        $materials = $subjectIds->isEmpty()
            ? collect()
            : Material::with('subject')
                ->whereIn('subject_id', $subjectIds)
                ->latest()
                ->paginate(10)
                ->withQueryString();

        return view('teacher.materials', [
            'subjects' => $subjects,
            'materials' => $materials,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|integer|exists:subjects,id',
            'title' => 'required|string|max:255',
            'file' => 'nullable|file|max:10240',
        ]);

        $teacher = auth()->user()->teacher;

        if (!$teacher) {
            abort(404);
        }

        $allowedSubjectIds = $teacher->schedules()->pluck('subject_id')->unique()->filter()->values()->all();

        if (!in_array((int) $request->subject_id, $allowedSubjectIds, true)) {
            return back()->with('error', 'Mata pelajaran tidak sesuai dengan jadwal mengajar.');
        }

        $path = null;
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('materials', 'public');
        }

        Material::create([
            'subject_id' => $request->subject_id,
            'title' => $request->title,
            'file' => $path,
        ]);

        return back()->with('success', 'Materi berhasil diunggah');
    }
}
