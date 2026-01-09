<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Material;

class StudentMaterialController extends Controller
{
    public function index()
    {
        return view('student.materials', [
            'materials' => Material::with('subject')->get(),
        ]);
    }
}
