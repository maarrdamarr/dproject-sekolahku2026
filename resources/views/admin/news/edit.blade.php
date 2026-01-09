@extends('layouts.dashboard.admin')

@section('content')
@if($errors->any())
<ul>
@foreach($errors->all() as $error)
    <li>{{ $error }}</li>
@endforeach
</ul>
@endif

<form method="POST" action="{{ url('admin/berita/'.$news->id) }}" enctype="multipart/form-data">
@csrf
@method('PUT')
<input name="title" value="{{ old('title', $news->title) }}" placeholder="Judul">
<textarea name="content" placeholder="Isi berita">{{ old('content', $news->content) }}</textarea>
<input type="file" name="thumbnail">
@if($news->thumbnail)
<p>Thumbnail saat ini: <a href="{{ asset('storage/'.$news->thumbnail) }}">Lihat</a></p>
@endif
<button>Perbarui</button>
</form>

<a href="{{ url('admin/berita') }}">Kembali</a>
@endsection

