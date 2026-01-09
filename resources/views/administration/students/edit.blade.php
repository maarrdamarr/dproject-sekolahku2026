@extends('layouts.dashboard.administration')

@section('content')
@if($errors->any())
<ul>
@foreach($errors->all() as $error)
    <li>{{ $error }}</li>
@endforeach
</ul>
@endif

<form method="POST" action="{{ url('administrasi/siswa/'.$student->id) }}">
@csrf
@method('PUT')
<input name="name" value="{{ old('name', $student->user->name ?? '') }}" placeholder="Nama">
<input name="email" value="{{ old('email', $student->user->email ?? '') }}" placeholder="Email">
<input type="password" name="password" placeholder="Password baru (opsional)">
<input name="nis" value="{{ old('nis', $student->nis) }}" placeholder="NIS">
<input name="entry_year" value="{{ old('entry_year', $student->entry_year) }}" placeholder="Tahun Masuk">
<select name="class_id">
    <option value="">-- Pilih Kelas --</option>
    @foreach($classes as $class)
        <option value="{{ $class->id }}" {{ (string) $class->id === (string) old('class_id', $student->class_id) ? 'selected' : '' }}>
            {{ $class->name }}
        </option>
    @endforeach
</select>
<button>Perbarui</button>
</form>

<a href="{{ url('administrasi/siswa') }}">Kembali</a>
@endsection

