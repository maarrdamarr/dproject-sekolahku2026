@extends('layouts.dashboard.admin')

@section('content')
@if($errors->any())
<ul>
@foreach($errors->all() as $error)
    <li>{{ $error }}</li>
@endforeach
</ul>
@endif

<form method="POST" action="{{ url('admin/galleries') }}" enctype="multipart/form-data">
@csrf
<input name="title" value="{{ old('title') }}" placeholder="Judul">
<input type="file" name="image">
<button>Simpan</button>
</form>

<a href="{{ url('admin/galleries') }}">Kembali</a>
@endsection

