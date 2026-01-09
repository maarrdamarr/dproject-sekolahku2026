@extends('layouts.dashboard.admin')

@section('content')
@if($errors->any())
<ul>
@foreach($errors->all() as $error)
    <li>{{ $error }}</li>
@endforeach
</ul>
@endif

<form method="POST" action="{{ url('admin/contents/'.$content->id) }}">
@csrf
@method('PUT')
<input name="title" value="{{ old('title', $content->title) }}" placeholder="Judul">
<input name="slug" value="{{ old('slug', $content->slug) }}" placeholder="Slug">
<textarea name="body" placeholder="Isi konten">{{ old('body', $content->body) }}</textarea>
<label>
    <input type="checkbox" name="is_published" value="1" {{ old('is_published', $content->is_published) ? 'checked' : '' }}>
    Publish
</label>
<button>Perbarui</button>
</form>

<a href="{{ url('admin/contents') }}">Kembali</a>
@endsection

