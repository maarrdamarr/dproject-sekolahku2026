<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class TeacherManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = Teacher::with('user');
        $q = $request->get('q');

        if ($q) {
            $query->where(function ($builder) use ($q) {
                $builder->where('nip', 'like', '%' . $q . '%')
                    ->orWhere('expertise', 'like', '%' . $q . '%')
                    ->orWhereHas('user', function ($userQuery) use ($q) {
                        $userQuery->where('name', 'like', '%' . $q . '%')
                            ->orWhere('email', 'like', '%' . $q . '%');
                    });
            });
        }

        return view('administration.teachers.index', [
            'teachers' => $query->orderBy('id', 'desc')->paginate(10)->withQueryString(),
        ]);
    }

    public function create()
    {
        return view('administration.teachers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'nip' => 'required|string|max:50|unique:teachers,nip',
            'expertise' => 'required|string|max:255',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'guru',
        ]);

        Teacher::create([
            'user_id' => $user->id,
            'nip' => $request->nip,
            'expertise' => $request->expertise,
        ]);

        return redirect('administrasi/guru')->with('success', 'Guru berhasil ditambahkan');
    }

    public function edit(Teacher $teacher)
    {
        return view('administration.teachers.edit', [
            'teacher' => $teacher->load('user'),
        ]);
    }

    public function update(Request $request, Teacher $teacher)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($teacher->user_id),
            ],
            'password' => 'nullable|string|min:6',
            'nip' => [
                'required',
                'string',
                'max:50',
                Rule::unique('teachers', 'nip')->ignore($teacher->id),
            ],
            'expertise' => 'required|string|max:255',
        ]);

        $user = $teacher->user;

        if ($user) {
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'role' => 'guru',
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $user->update($userData);
        }

        $teacher->update([
            'nip' => $request->nip,
            'expertise' => $request->expertise,
        ]);

        return redirect('administrasi/guru')->with('success', 'Data guru berhasil diperbarui');
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->schedules()->delete();

        $user = $teacher->user;

        if ($user) {
            $user->delete();
        } else {
            $teacher->delete();
        }

        return back()->with('success', 'Guru berhasil dihapus');
    }
}
