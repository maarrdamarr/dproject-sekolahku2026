<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Announcement;

class NewsController extends Controller
{
    public function index()
    {
        return view('public.news.index', [
            'news' => News::latest()->paginate(6),
            'announcements' => Announcement::latest()->get(),
        ]);
    }

    public function show($id)
    {
        return view('public.news.show', [
            'news' => News::findOrFail($id),
        ]);
    }
}
