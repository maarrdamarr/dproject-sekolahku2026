<?php

namespace App\Http\Controllers;

use App\Models\Gallery;

class GalleryController extends Controller
{
    public function index()
    {
        return view('public.gallery', [
            'galleries' => Gallery::latest()->paginate(12),
        ]);
    }
}
