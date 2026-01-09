@extends('layouts.dashboard.admin')

@section('content')
@if($errors->any())
<ul>
@foreach($errors->all() as $error)
    <li>{{ $error }}</li>
@endforeach
</ul>
@endif

<form method="POST" action="{{ url('admin/users/'.$user->id) }}">
@csrf
@method('PUT')
<input name="name" value="{{ old('name', $user->name) }}" placeholder="Nama">
<input name="email" value="{{ old('email', $user->email) }}" placeholder="Email">
<input type="password" name="password" placeholder="Password baru (opsional)">
<select name="role">
    <option value="">-- Pilih Role --</option>
    @foreach(['admin','administrasi','guru','siswa'] as $role)
        <option value="{{ $role }}" {{ old('role', $user->role) === $role ? 'selected' : '' }}>{{ ucfirst($role) }}</option>
    @endforeach
</select>
<button>Perbarui</button>
</form>

<a href="{{ url('admin/users') }}">Kembali</a>
@endsection

