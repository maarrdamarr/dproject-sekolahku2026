<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Announcement;
use App\Models\Gallery;

class HomeController extends Controller
{
    public function index()
    {
        return view('public.home', [
            'announcements' => Announcement::latest()->take(5)->get(),
            'news' => News::latest()->take(3)->get(),
            'galleries' => Gallery::latest()->take(6)->get(),
        ]);
    }
}
