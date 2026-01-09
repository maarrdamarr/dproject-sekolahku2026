<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Models\Letter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class LetterController extends Controller
{
    public function index(Request $request)
    {
        $query = Letter::query();
        $q = $request->get('q');

        if ($q) {
            $query->where(function ($builder) use ($q) {
                $builder->where('number', 'like', '%' . $q . '%')
                    ->orWhere('subject', 'like', '%' . $q . '%')
                    ->orWhere('recipient', 'like', '%' . $q . '%');
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('from')) {
            $query->whereDate('date', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('date', '<=', $request->to);
        }

        return view('administration.letters.index', [
            'letters' => $query->orderBy('date', 'desc')
                ->orderBy('id', 'desc')
                ->paginate(10)
                ->withQueryString(),
        ]);
    }

    public function create()
    {
        return view('administration.letters.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'number' => 'required|string|max:100|unique:letters,number',
            'type' => 'required|string|max:50',
            'subject' => 'required|string|max:255',
            'recipient' => 'required|string|max:255',
            'date' => 'required|date',
            'description' => 'nullable|string',
            'file' => 'nullable|file|max:10240',
        ]);

        $path = null;
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('letters', 'public');
        }

        Letter::create([
            'number' => $request->number,
            'type' => $request->type,
            'subject' => $request->subject,
            'recipient' => $request->recipient,
            'date' => $request->date,
            'description' => $request->description,
            'file' => $path,
        ]);

        return redirect('administrasi/surat')->with('success', 'Surat berhasil ditambahkan');
    }

    public function edit(Letter $letter)
    {
        return view('administration.letters.edit', [
            'letter' => $letter,
        ]);
    }

    public function update(Request $request, Letter $letter)
    {
        $request->validate([
            'number' => [
                'required',
                'string',
                'max:100',
                Rule::unique('letters', 'number')->ignore($letter->id),
            ],
            'type' => 'required|string|max:50',
            'subject' => 'required|string|max:255',
            'recipient' => 'required|string|max:255',
            'date' => 'required|date',
            'description' => 'nullable|string',
            'file' => 'nullable|file|max:10240',
        ]);

        $path = $letter->file;
        if ($request->hasFile('file')) {
            if ($path) {
                Storage::disk('public')->delete($path);
            }
            $path = $request->file('file')->store('letters', 'public');
        }

        $letter->update([
            'number' => $request->number,
            'type' => $request->type,
            'subject' => $request->subject,
            'recipient' => $request->recipient,
            'date' => $request->date,
            'description' => $request->description,
            'file' => $path,
        ]);

        return redirect('administrasi/surat')->with('success', 'Surat berhasil diperbarui');
    }

    public function destroy(Letter $letter)
    {
        if ($letter->file) {
            Storage::disk('public')->delete($letter->file);
        }

        $letter->delete();

        return back()->with('success', 'Surat berhasil dihapus');
    }
}
