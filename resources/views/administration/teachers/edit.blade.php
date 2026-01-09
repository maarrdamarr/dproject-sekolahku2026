@extends('layouts.dashboard.administration')

@section('content')
@if($errors->any())
<ul>
@foreach($errors->all() as $error)
    <li>{{ $error }}</li>
@endforeach
</ul>
@endif

<form method="POST" action="{{ url('administrasi/guru/'.$teacher->id) }}">
@csrf
@method('PUT')
<input name="name" value="{{ old('name', $teacher->user->name ?? '') }}" placeholder="Nama">
<input name="email" value="{{ old('email', $teacher->user->email ?? '') }}" placeholder="Email">
<input type="password" name="password" placeholder="Password baru (opsional)">
<input name="nip" value="{{ old('nip', $teacher->nip) }}" placeholder="NIP">
<input name="expertise" value="{{ old('expertise', $teacher->expertise) }}" placeholder="Keahlian">
<button>Perbarui</button>
</form>

<a href="{{ url('administrasi/guru') }}">Kembali</a>
@endsection

