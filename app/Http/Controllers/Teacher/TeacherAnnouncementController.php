<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;

class TeacherAnnouncementController extends Controller
{
    public function index()
    {
        return view('teacher.announcements', [
            'announcements' => Announcement::latest()->paginate(10),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Announcement::create([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return back()->with('success', 'Pengumuman berhasil dibuat');
    }
}
