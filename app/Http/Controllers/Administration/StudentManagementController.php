<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StudentManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::with(['user', 'classRoom']);
        $q = $request->get('q');

        if ($q) {
            $query->where(function ($builder) use ($q) {
                $builder->where('nis', 'like', '%' . $q . '%')
                    ->orWhereHas('user', function ($userQuery) use ($q) {
                        $userQuery->where('name', 'like', '%' . $q . '%')
                            ->orWhere('email', 'like', '%' . $q . '%');
                    });
            });
        }

        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        if ($request->filled('entry_year')) {
            $query->where('entry_year', $request->entry_year);
        }

        return view('administration.students.index', [
            'students' => $query->orderBy('id', 'desc')->paginate(10)->withQueryString(),
            'classes' => ClassRoom::orderBy('name')->get(),
        ]);
    }

    public function create()
    {
        return view('administration.students.create', [
            'classes' => ClassRoom::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'nis' => 'required|string|max:50|unique:students,nis',
            'class_id' => 'nullable|integer|exists:classes,id',
            'entry_year' => 'required|integer|min:2000|max:2100',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'siswa',
        ]);

        Student::create([
            'user_id' => $user->id,
            'nis' => $request->nis,
            'class_id' => $request->class_id,
            'entry_year' => $request->entry_year,
        ]);

        return redirect('administrasi/siswa')->with('success', 'Siswa berhasil ditambahkan');
    }

    public function edit(Student $student)
    {
        return view('administration.students.edit', [
            'student' => $student->load(['user', 'classRoom']),
            'classes' => ClassRoom::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($student->user_id),
            ],
            'password' => 'nullable|string|min:6',
            'nis' => [
                'required',
                'string',
                'max:50',
                Rule::unique('students', 'nis')->ignore($student->id),
            ],
            'class_id' => 'nullable|integer|exists:classes,id',
            'entry_year' => 'required|integer|min:2000|max:2100',
        ]);

        $user = $student->user;

        if ($user) {
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'role' => 'siswa',
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $user->update($userData);
        }

        $student->update([
            'nis' => $request->nis,
            'class_id' => $request->class_id,
            'entry_year' => $request->entry_year,
        ]);

        return redirect('administrasi/siswa')->with('success', 'Data siswa berhasil diperbarui');
    }

    public function destroy(Student $student)
    {
        $student->grades()->delete();
        $student->attendances()->delete();
        $student->payments()->delete();

        $user = $student->user;

        if ($user) {
            $user->delete();
        } else {
            $student->delete();
        }

        return back()->with('success', 'Siswa berhasil dihapus');
    }
}
