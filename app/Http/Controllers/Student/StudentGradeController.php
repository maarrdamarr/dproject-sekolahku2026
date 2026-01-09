<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class StudentGradeController extends Controller
{
    public function index()
    {
        return view('student.grades', [
            'grades' => auth::user()->student->grades()->with('subject')->paginate(10),
        ]);
    }
}
