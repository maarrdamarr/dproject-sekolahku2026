<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ContentManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = Content::query();
        $q = $request->get('q');

        if ($q) {
            $query->where(function ($builder) use ($q) {
                $builder->where('title', 'like', '%' . $q . '%')
                    ->orWhere('slug', 'like', '%' . $q . '%');
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'published') {
                $query->where('is_published', true);
            } elseif ($request->status === 'draft') {
                $query->where('is_published', false);
            }
        }

        return view('admin.contents.index', [
            'contents' => $query->orderBy('id', 'desc')->paginate(10)->withQueryString(),
        ]);
    }

    public function create()
    {
        return view('admin.contents.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:contents,slug',
            'body' => 'required|string',
            'is_published' => 'nullable|boolean',
        ]);

        Content::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'body' => $request->body,
            'is_published' => (bool) $request->get('is_published', false),
        ]);

        return redirect('admin/contents')->with('success', 'Konten berhasil ditambahkan');
    }

    public function edit(Content $content)
    {
        return view('admin.contents.edit', [
            'content' => $content,
        ]);
    }

    public function update(Request $request, Content $content)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('contents', 'slug')->ignore($content->id),
            ],
            'body' => 'required|string',
            'is_published' => 'nullable|boolean',
        ]);

        $content->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'body' => $request->body,
            'is_published' => (bool) $request->get('is_published', false),
        ]);

        return redirect('admin/contents')->with('success', 'Konten berhasil diperbarui');
    }

    public function destroy(Content $content)
    {
        $content->delete();

        return back()->with('success', 'Konten berhasil dihapus');
    }
}
