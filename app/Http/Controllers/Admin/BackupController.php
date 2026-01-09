<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
    public function index()
    {
        $files = collect(Storage::disk('local')->files('backups'))
            ->map(function ($path) {
                return [
                    'path' => $path,
                    'name' => basename($path),
                    'size' => Storage::disk('local')->size($path),
                    'last_modified' => Storage::disk('local')->lastModified($path),
                ];
            })
            ->sortByDesc('last_modified')
            ->values();

        return view('admin.backups.index', [
            'files' => $files,
        ]);
    }

    public function store()
    {
        $tables = [
            'users',
            'profiles',
            'students',
            'teachers',
            'classes',
            'subjects',
            'schedules',
            'grades',
            'attendance',
            'announcements',
            'materials',
            'news',
            'galleries',
            'payments',
            'letters',
            'contents',
            'settings',
        ];

        $payload = [
            'created_at' => now()->toDateTimeString(),
            'tables' => [],
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                $payload['tables'][$table] = DB::table($table)->get();
            }
        }

        $filename = 'backups/backup-' . now()->format('Ymd-His') . '.json';
        Storage::disk('local')->put($filename, json_encode($payload, JSON_PRETTY_PRINT));

        return back()->with('success', 'Backup berhasil dibuat');
    }

    public function download($file)
    {
        $safeName = basename($file);
        $path = 'backups/' . $safeName;

        if (!Storage::disk('local')->exists($path)) {
            abort(404);
        }

        return response()->download(storage_path('app/' . $path));
    }

    public function destroy($file)
    {
        $safeName = basename($file);
        $path = 'backups/' . $safeName;

        if (Storage::disk('local')->exists($path)) {
            Storage::disk('local')->delete($path);
        }

        return back()->with('success', 'Backup berhasil dihapus');
    }
}
