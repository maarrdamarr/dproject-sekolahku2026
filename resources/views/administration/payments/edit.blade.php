@extends('layouts.dashboard.administration')

@section('content')
@if($errors->any())
<ul>
@foreach($errors->all() as $error)
    <li>{{ $error }}</li>
@endforeach
</ul>
@endif

<form method="POST" action="{{ url('administrasi/pembayaran/'.$payment->id) }}">
@csrf
@method('PUT')
<select name="student_id">
    <option value="">-- Pilih Siswa --</option>
    @foreach($students as $student)
        <option value="{{ $student->id }}" {{ (string) $student->id === (string) old('student_id', $payment->student_id) ? 'selected' : '' }}>
            {{ $student->user->name ?? '-' }}
        </option>
    @endforeach
</select>
<input name="type" value="{{ old('type', $payment->type) }}" placeholder="Jenis pembayaran">
<input type="number" name="amount" value="{{ old('amount', $payment->amount) }}" placeholder="Jumlah">
<input type="date" name="payment_date" value="{{ old('payment_date', $payment->payment_date) }}">
<button>Perbarui</button>
</form>

<a href="{{ url('administrasi/pembayaran') }}">Kembali</a>
@endsection

