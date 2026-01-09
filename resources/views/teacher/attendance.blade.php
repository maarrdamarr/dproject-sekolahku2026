@extends('layouts.dashboard.teacher')

@section('content')
@if(session('success'))
<p>{{ session('success') }}</p>
@endif

@if(session('error'))
<p>{{ session('error') }}</p>
@endif

@php
    $selectedClassId = old('class_id', $classId);
@endphp

<form method="GET">
<label>Kelas</label>
<select name="class_id">
@foreach($classes as $c)
    <option value="{{ $c->id }}" {{ (string) $c->id === (string) $selectedClassId ? 'selected' : '' }}>
        {{ $c->name }}
    </option>
@endforeach
</select>

<label>Tanggal</label>
<input type="date" name="date" value="{{ old('date', $date) }}">
<button>Filter</button>
</form>

@if($selectedClassId)
@if($students->isEmpty())
<p>Tidak ada siswa di kelas ini.</p>
@else
<form method="POST">
@csrf
<input type="hidden" name="class_id" value="{{ $selectedClassId }}">
<input type="hidden" name="date" value="{{ old('date', $date) }}">

<table border="1">
<tr>
    <th>Nama</th>
    <th>Status</th>
</tr>
@foreach($students as $student)
@php
    $status = optional($attendanceMap->get($student->id))->status ?? 'hadir';
@endphp
<tr>
    <td>{{ $student->user->name ?? 'Tanpa Nama' }}</td>
    <td>
        <select name="attendance[{{ $student->id }}]">
            <option value="hadir" {{ $status === 'hadir' ? 'selected' : '' }}>Hadir</option>
            <option value="izin" {{ $status === 'izin' ? 'selected' : '' }}>Izin</option>
            <option value="sakit" {{ $status === 'sakit' ? 'selected' : '' }}>Sakit</option>
            <option value="alpha" {{ $status === 'alpha' ? 'selected' : '' }}>Alpha</option>
        </select>
    </td>
</tr>
@endforeach
</table>

<button>Simpan</button>
</form>
@endif
@else
<p>Belum ada kelas terdaftar.</p>
@endif
@endsection

