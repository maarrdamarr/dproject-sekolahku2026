@extends('layouts.dashboard.admin')

@section('content')
@if($errors->any())
<ul>
@foreach($errors->all() as $error)
    <li>{{ $error }}</li>
@endforeach
</ul>
@endif

<form method="POST" action="{{ url('admin/galleries/'.$gallery->id) }}" enctype="multipart/form-data">
@csrf
@method('PUT')
<input name="title" value="{{ old('title', $gallery->title) }}" placeholder="Judul">
<input type="file" name="image">
@if($gallery->image)
<p>Gambar saat ini: <a href="{{ asset('storage/'.$gallery->image) }}">Lihat</a></p>
@endif
<button>Perbarui</button>
</form>

<a href="{{ url('admin/galleries') }}">Kembali</a>
@endsection

