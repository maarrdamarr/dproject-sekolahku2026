@extends('layouts.dashboard.teacher')

@section('content')
@if(session('success'))
<p>{{ session('success') }}</p>
@endif

@if(session('error'))
<p>{{ session('error') }}</p>
@endif

@if($subjects->isEmpty() || $students->isEmpty())
<p>Data mata pelajaran atau siswa belum tersedia.</p>
@else
<form method="POST">
@csrf
<label>Mata Pelajaran</label>
<select name="subject_id">
@foreach($subjects as $subject)
    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
@endforeach
</select>

<label>Siswa</label>
<select name="student_id">
@foreach($students as $student)
    <option value="{{ $student->id }}">
        {{ $student->user->name ?? 'Tanpa Nama' }} ({{ $student->classRoom->name ?? '-' }})
    </option>
@endforeach
</select>

<label>Nilai</label>
<input type="number" name="score" min="0" max="100">

<button>Simpan</button>
</form>
@endif

<h3>Daftar Nilai</h3>

<table border="1">
<tr>
    <th>Siswa</th>
    <th>Mata Pelajaran</th>
    <th>Nilai</th>
</tr>
@foreach($grades as $g)
<tr>
    <td>{{ $g->student->user->name ?? 'Tanpa Nama' }}</td>
    <td>{{ $g->subject->name ?? '-' }}</td>
    <td>{{ $g->score }}</td>
</tr>
@endforeach
</table>
@if(method_exists($grades, 'links'))
{{ $grades->links() }}
@endif
@endsection

