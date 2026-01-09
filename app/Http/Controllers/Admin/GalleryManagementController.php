<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = Gallery::query();
        $q = $request->get('q');

        if ($q) {
            $query->where('title', 'like', '%' . $q . '%');
        }

        return view('admin.galleries.index', [
            'galleries' => $query->orderBy('id', 'desc')->paginate(12)->withQueryString(),
        ]);
    }

    public function create()
    {
        return view('admin.galleries.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|file|image|max:5120',
        ]);

        $path = $request->file('image')->store('galleries', 'public');

        Gallery::create([
            'title' => $request->title,
            'image' => $path,
        ]);

        return redirect('admin/galleries')->with('success', 'Galeri berhasil ditambahkan');
    }

    public function edit(Gallery $gallery)
    {
        return view('admin.galleries.edit', [
            'gallery' => $gallery,
        ]);
    }

    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|file|image|max:5120',
        ]);

        $path = $gallery->image;
        if ($request->hasFile('image')) {
            if ($path) {
                Storage::disk('public')->delete($path);
            }
            $path = $request->file('image')->store('galleries', 'public');
        }

        $gallery->update([
            'title' => $request->title,
            'image' => $path,
        ]);

        return redirect('admin/galleries')->with('success', 'Galeri berhasil diperbarui');
    }

    public function destroy(Gallery $gallery)
    {
        if ($gallery->image) {
            Storage::disk('public')->delete($gallery->image);
        }

        $gallery->delete();

        return back()->with('success', 'Galeri berhasil dihapus');
    }
}
