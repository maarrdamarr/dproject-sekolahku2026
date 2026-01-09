@extends('layouts.dashboard.admin')

@section('content')
@if($errors->any())
<ul>
@foreach($errors->all() as $error)
    <li>{{ $error }}</li>
@endforeach
</ul>
@endif

<form method="POST" action="{{ url('admin/pengumuman/'.$announcement->id) }}">
@csrf
@method('PUT')
<input name="title" value="{{ old('title', $announcement->title) }}" placeholder="Judul">
<textarea name="content" placeholder="Isi pengumuman">{{ old('content', $announcement->content) }}</textarea>
<button>Perbarui</button>
</form>

<a href="{{ url('admin/berita') }}">Kembali</a>
@endsection

