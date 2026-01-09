@extends('layouts.dashboard.admin')

@section('content')
@if($errors->any())
<ul>
@foreach($errors->all() as $error)
    <li>{{ $error }}</li>
@endforeach
</ul>
@endif

<form method="POST" action="{{ url('admin/users') }}">
@csrf
<input name="name" value="{{ old('name') }}" placeholder="Nama">
<input name="email" value="{{ old('email') }}" placeholder="Email">
<input type="password" name="password" placeholder="Password">
<select name="role">
    <option value="">-- Pilih Role --</option>
    @foreach(['admin','administrasi','guru','siswa'] as $role)
        <option value="{{ $role }}" {{ old('role') === $role ? 'selected' : '' }}>{{ ucfirst($role) }}</option>
    @endforeach
</select>
<button>Simpan</button>
</form>

<a href="{{ url('admin/users') }}">Kembali</a>
@endsection

