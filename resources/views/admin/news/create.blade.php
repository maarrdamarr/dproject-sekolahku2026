@extends('layouts.dashboard.admin')

@section('content')
@if($errors->any())
<ul>
@foreach($errors->all() as $error)
    <li>{{ $error }}</li>
@endforeach
</ul>
@endif

<form method="POST" action="{{ url('admin/berita') }}" enctype="multipart/form-data">
@csrf
<input name="title" value="{{ old('title') }}" placeholder="Judul">
<textarea name="content" placeholder="Isi berita">{{ old('content') }}</textarea>
<input type="file" name="thumbnail">
<button>Simpan</button>
</form>

<a href="{{ url('admin/berita') }}">Kembali</a>
@endsection

