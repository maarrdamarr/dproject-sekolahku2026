@extends('layouts.dashboard.admin')

@section('content')
@if($errors->any())
<ul>
@foreach($errors->all() as $error)
    <li>{{ $error }}</li>
@endforeach
</ul>
@endif

<form method="POST" action="{{ url('admin/contents') }}">
@csrf
<input name="title" value="{{ old('title') }}" placeholder="Judul">
<input name="slug" value="{{ old('slug') }}" placeholder="Slug">
<textarea name="body" placeholder="Isi konten">{{ old('body') }}</textarea>
<label>
    <input type="checkbox" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}>
    Publish
</label>
<button>Simpan</button>
</form>

<a href="{{ url('admin/contents') }}">Kembali</a>
@endsection

