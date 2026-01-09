@extends('layouts.dashboard.administration')

@section('content')
@if(session('success'))
<p>{{ session('success') }}</p>
@endif

<form method="GET" class="dashboard-card space-y-4">
    <div class="grid gap-3 md:grid-cols-6">
        <input name="q" value="{{ request('q') }}" placeholder="Cari nama siswa">
        <select name="student_id">
            <option value="">Semua Siswa</option>
            @foreach($students as $student)
                <option value="{{ $student->id }}" {{ (string) $student->id === request('student_id') ? 'selected' : '' }}>
                    {{ $student->user->name ?? '-' }}
                </option>
            @endforeach
        </select>
        <input name="type" value="{{ request('type') }}" placeholder="Jenis pembayaran">
        <input type="date" name="from" value="{{ request('from') }}">
        <input type="date" name="to" value="{{ request('to') }}">
        <div class="flex items-center gap-2">
            <button type="submit">Filter</button>
            <a href="{{ url('administrasi/pembayaran') }}">Reset</a>
        </div>
    </div>
</form>

<a href="{{ url('administrasi/pembayaran/create') }}">Tambah Pembayaran</a>

<table border="1">
<tr>
    <th>Siswa</th>
    <th>Jenis</th>
    <th>Jumlah</th>
    <th>Tanggal</th>
    <th>Aksi</th>
</tr>
@foreach($payments as $payment)
<tr>
    <td>{{ $payment->student->user->name ?? '-' }}</td>
    <td>{{ $payment->type }}</td>
    <td>{{ $payment->amount }}</td>
    <td>{{ $payment->payment_date }}</td>
    <td>
        <a href="{{ url('administrasi/pembayaran/'.$payment->id.'/edit') }}">Edit</a>
        <form method="POST" action="{{ url('administrasi/pembayaran/'.$payment->id) }}" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit">Hapus</button>
        </form>
    </td>
</tr>
@endforeach
</table>

{{ $payments->links() }}
@endsection

