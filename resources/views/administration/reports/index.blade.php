@extends('layouts.dashboard.administration')

@section('content')
<form method="GET">
<select name="type">
    <option value="students" {{ $type === 'students' ? 'selected' : '' }}>Siswa</option>
    <option value="teachers" {{ $type === 'teachers' ? 'selected' : '' }}>Guru</option>
    <option value="payments" {{ $type === 'payments' ? 'selected' : '' }}>Pembayaran</option>
    <option value="schedules" {{ $type === 'schedules' ? 'selected' : '' }}>Jadwal</option>
</select>

@if($type === 'payments')
<input type="date" name="from" value="{{ $from }}">
<input type="date" name="to" value="{{ $to }}">
@endif

<button>Tampilkan</button>
</form>

@php
    $queryString = http_build_query(request()->query());
    $pdfUrl = url('administrasi/laporan/pdf') . ($queryString ? ('?' . $queryString) : '');
@endphp

<a href="{{ $pdfUrl }}">Export PDF</a>

<button onclick="window.print()">Cetak</button>

@if(isset($summary['count']))
<p>Total data: {{ $summary['count'] }}</p>
@endif
@if(isset($summary['total']))
<p>Total pembayaran: {{ $summary['total'] }}</p>
@endif

@if($type === 'students')
<table border="1">
<tr>
    <th>Nama</th>
    <th>Email</th>
    <th>NIS</th>
    <th>Kelas</th>
    <th>Tahun Masuk</th>
</tr>
@foreach($data as $student)
<tr>
    <td>{{ $student->user->name ?? '-' }}</td>
    <td>{{ $student->user->email ?? '-' }}</td>
    <td>{{ $student->nis }}</td>
    <td>{{ $student->classRoom->name ?? '-' }}</td>
    <td>{{ $student->entry_year }}</td>
</tr>
@endforeach
</table>
@elseif($type === 'teachers')
<table border="1">
<tr>
    <th>Nama</th>
    <th>Email</th>
    <th>NIP</th>
    <th>Keahlian</th>
</tr>
@foreach($data as $teacher)
<tr>
    <td>{{ $teacher->user->name ?? '-' }}</td>
    <td>{{ $teacher->user->email ?? '-' }}</td>
    <td>{{ $teacher->nip }}</td>
    <td>{{ $teacher->expertise }}</td>
</tr>
@endforeach
</table>
@elseif($type === 'payments')
<table border="1">
<tr>
    <th>Siswa</th>
    <th>Jenis</th>
    <th>Jumlah</th>
    <th>Tanggal</th>
</tr>
@foreach($data as $payment)
<tr>
    <td>{{ $payment->student->user->name ?? '-' }}</td>
    <td>{{ $payment->type }}</td>
    <td>{{ $payment->amount }}</td>
    <td>{{ $payment->payment_date }}</td>
</tr>
@endforeach
</table>
@elseif($type === 'schedules')
<table border="1">
<tr>
    <th>Hari</th>
    <th>Waktu</th>
    <th>Kelas</th>
    <th>Mata Pelajaran</th>
    <th>Guru</th>
</tr>
@foreach($data as $schedule)
<tr>
    <td>{{ $schedule->day }}</td>
    <td>{{ $schedule->start_time }} - {{ $schedule->end_time }}</td>
    <td>{{ $schedule->classRoom->name ?? '-' }}</td>
    <td>{{ $schedule->subject->name ?? '-' }}</td>
    <td>{{ $schedule->teacher->user->name ?? '-' }}</td>
</tr>
@endforeach
</table>
@endif
@endsection

