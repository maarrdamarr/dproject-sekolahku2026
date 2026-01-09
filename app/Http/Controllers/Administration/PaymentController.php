<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Student;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with('student.user');
        $q = $request->get('q');

        if ($q) {
            $query->whereHas('student.user', function ($userQuery) use ($q) {
                $userQuery->where('name', 'like', '%' . $q . '%')
                    ->orWhere('email', 'like', '%' . $q . '%');
            });
        }

        if ($request->filled('student_id')) {
            $query->where('student_id', $request->student_id);
        }

        if ($request->filled('type')) {
            $query->where('type', 'like', '%' . $request->type . '%');
        }

        if ($request->filled('from')) {
            $query->whereDate('payment_date', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('payment_date', '<=', $request->to);
        }

        return view('administration.payments.index', [
            'payments' => $query->orderBy('payment_date', 'desc')
                ->orderBy('id', 'desc')
                ->paginate(10)
                ->withQueryString(),
            'students' => Student::with('user')->orderBy('id')->get(),
        ]);
    }

    public function create()
    {
        return view('administration.payments.create', [
            'students' => Student::with('user')->orderBy('id')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|integer|exists:students,id',
            'type' => 'required|string|max:100',
            'amount' => 'required|integer|min:0',
            'payment_date' => 'required|date',
        ]);

        Payment::create([
            'student_id' => $request->student_id,
            'type' => $request->type,
            'amount' => $request->amount,
            'payment_date' => $request->payment_date,
        ]);

        return redirect('administrasi/pembayaran')->with('success', 'Pembayaran berhasil ditambahkan');
    }

    public function edit(Payment $payment)
    {
        return view('administration.payments.edit', [
            'payment' => $payment->load('student.user'),
            'students' => Student::with('user')->orderBy('id')->get(),
        ]);
    }

    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'student_id' => 'required|integer|exists:students,id',
            'type' => 'required|string|max:100',
            'amount' => 'required|integer|min:0',
            'payment_date' => 'required|date',
        ]);

        $payment->update([
            'student_id' => $request->student_id,
            'type' => $request->type,
            'amount' => $request->amount,
            'payment_date' => $request->payment_date,
        ]);

        return redirect('administrasi/pembayaran')->with('success', 'Pembayaran berhasil diperbarui');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        return back()->with('success', 'Pembayaran berhasil dihapus');
    }
}
