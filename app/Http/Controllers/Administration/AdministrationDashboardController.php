<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\Teacher;

class AdministrationDashboardController extends Controller
{
    public function index()
    {
        return view('administration.dashboard', [
            'studentCount' => Student::count(),
            'teacherCount' => Teacher::count(),
            'scheduleCount' => Schedule::count(),
            'paymentCount' => Payment::count(),
            'paymentTotal' => Payment::sum('amount'),
            'latestPayments' => Payment::with('student.user')->latest()->take(5)->get(),
        ]);
    }
}
