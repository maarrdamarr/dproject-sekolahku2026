<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SystemSettingController extends Controller
{
    public function index(Request $request)
    {
        $query = Setting::query();
        $q = $request->get('q');

        if ($q) {
            $query->where(function ($builder) use ($q) {
                $builder->where('key', 'like', '%' . $q . '%')
                    ->orWhere('description', 'like', '%' . $q . '%')
                    ->orWhere('value', 'like', '%' . $q . '%');
            });
        }

        return view('admin.settings.index', [
            'settings' => $query->orderBy('key')->paginate(10)->withQueryString(),
        ]);
    }

    public function create()
    {
        return view('admin.settings.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|string|max:100|unique:settings,key',
            'value' => 'nullable|string',
            'description' => 'nullable|string|max:255',
        ]);

        Setting::create([
            'key' => $request->key,
            'value' => $request->value,
            'description' => $request->description,
        ]);

        return redirect('admin/settings')->with('success', 'Setting berhasil ditambahkan');
    }

    public function edit(Setting $setting)
    {
        return view('admin.settings.edit', [
            'setting' => $setting,
        ]);
    }

    public function update(Request $request, Setting $setting)
    {
        $request->validate([
            'key' => [
                'required',
                'string',
                'max:100',
                Rule::unique('settings', 'key')->ignore($setting->id),
            ],
            'value' => 'nullable|string',
            'description' => 'nullable|string|max:255',
        ]);

        $setting->update([
            'key' => $request->key,
            'value' => $request->value,
            'description' => $request->description,
        ]);

        return redirect('admin/settings')->with('success', 'Setting berhasil diperbarui');
    }

    public function destroy(Setting $setting)
    {
        $setting->delete();

        return back()->with('success', 'Setting berhasil dihapus');
    }
}
