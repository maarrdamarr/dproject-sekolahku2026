@extends('layouts.dashboard.administration')

@section('content')
@if($errors->any())
<ul>
@foreach($errors->all() as $error)
    <li>{{ $error }}</li>
@endforeach
</ul>
@endif

<form method="POST" action="{{ url('administrasi/guru') }}">
@csrf
<input name="name" value="{{ old('name') }}" placeholder="Nama">
<input name="email" value="{{ old('email') }}" placeholder="Email">
<input type="password" name="password" placeholder="Password">
<input name="nip" value="{{ old('nip') }}" placeholder="NIP">
<input name="expertise" value="{{ old('expertise') }}" placeholder="Keahlian">
<button>Simpan</button>
</form>

<a href="{{ url('administrasi/guru') }}">Kembali</a>
@endsection

