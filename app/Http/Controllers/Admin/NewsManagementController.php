<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsManagementController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');

        $newsQuery = News::query();
        $announcementQuery = Announcement::query();

        if ($q) {
            $newsQuery->where('title', 'like', '%' . $q . '%');
            $announcementQuery->where('title', 'like', '%' . $q . '%');
        }

        return view('admin.news.index', [
            'news' => $newsQuery->orderBy('id', 'desc')->paginate(8, ['*'], 'news_page')->withQueryString(),
            'announcements' => $announcementQuery->orderBy('id', 'desc')->paginate(8, ['*'], 'announcement_page')->withQueryString(),
        ]);
    }

    public function createNews()
    {
        return view('admin.news.create');
    }

    public function storeNews(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'thumbnail' => 'nullable|file|image|max:5120',
        ]);

        $path = null;
        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('news', 'public');
        }

        News::create([
            'title' => $request->title,
            'content' => $request->content,
            'thumbnail' => $path,
        ]);

        return redirect('admin/berita')->with('success', 'Berita berhasil ditambahkan');
    }

    public function editNews(News $news)
    {
        return view('admin.news.edit', [
            'news' => $news,
        ]);
    }

    public function updateNews(Request $request, News $news)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'thumbnail' => 'nullable|file|image|max:5120',
        ]);

        $path = $news->thumbnail;
        if ($request->hasFile('thumbnail')) {
            if ($path) {
                Storage::disk('public')->delete($path);
            }
            $path = $request->file('thumbnail')->store('news', 'public');
        }

        $news->update([
            'title' => $request->title,
            'content' => $request->content,
            'thumbnail' => $path,
        ]);

        return redirect('admin/berita')->with('success', 'Berita berhasil diperbarui');
    }

    public function destroyNews(News $news)
    {
        if ($news->thumbnail) {
            Storage::disk('public')->delete($news->thumbnail);
        }

        $news->delete();

        return back()->with('success', 'Berita berhasil dihapus');
    }

    public function createAnnouncement()
    {
        return view('admin.news.create-announcement');
    }

    public function storeAnnouncement(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Announcement::create([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect('admin/berita')->with('success', 'Pengumuman berhasil ditambahkan');
    }

    public function editAnnouncement(Announcement $announcement)
    {
        return view('admin.news.edit-announcement', [
            'announcement' => $announcement,
        ]);
    }

    public function updateAnnouncement(Request $request, Announcement $announcement)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $announcement->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect('admin/berita')->with('success', 'Pengumuman berhasil diperbarui');
    }

    public function destroyAnnouncement(Announcement $announcement)
    {
        $announcement->delete();

        return back()->with('success', 'Pengumuman berhasil dihapus');
    }
}
