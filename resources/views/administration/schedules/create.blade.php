@extends('layouts.dashboard.administration')

@section('content')
@if($errors->any())
<ul>
@foreach($errors->all() as $error)
    <li>{{ $error }}</li>
@endforeach
</ul>
@endif

<form method="POST" action="{{ url('administrasi/jadwal') }}">
@csrf
<select name="class_id">
    <option value="">-- Pilih Kelas --</option>
    @foreach($classes as $class)
        <option value="{{ $class->id }}" {{ (string) $class->id === old('class_id') ? 'selected' : '' }}>
            {{ $class->name }}
        </option>
    @endforeach
</select>
<select name="subject_id">
    <option value="">-- Pilih Mata Pelajaran --</option>
    @foreach($subjects as $subject)
        <option value="{{ $subject->id }}" {{ (string) $subject->id === old('subject_id') ? 'selected' : '' }}>
            {{ $subject->name }}
        </option>
    @endforeach
</select>
<select name="teacher_id">
    <option value="">-- Pilih Guru --</option>
    @foreach($teachers as $teacher)
        <option value="{{ $teacher->id }}" {{ (string) $teacher->id === old('teacher_id') ? 'selected' : '' }}>
            {{ $teacher->user->name ?? '-' }}
        </option>
    @endforeach
</select>
<select name="day">
    <option value="">-- Pilih Hari --</option>
    @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $day)
        <option value="{{ $day }}" {{ $day === old('day') ? 'selected' : '' }}>{{ $day }}</option>
    @endforeach
</select>
<input type="time" name="start_time" value="{{ old('start_time') }}">
<input type="time" name="end_time" value="{{ old('end_time') }}">
<button>Simpan</button>
</form>

<a href="{{ url('administrasi/jadwal') }}">Kembali</a>
@endsection

