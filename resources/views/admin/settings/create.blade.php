@extends('layouts.dashboard.admin')

@section('content')
@if($errors->any())
<ul>
@foreach($errors->all() as $error)
    <li>{{ $error }}</li>
@endforeach
</ul>
@endif

<form method="POST" action="{{ url('admin/settings') }}">
@csrf
<input name="key" value="{{ old('key') }}" placeholder="Key">
<textarea name="value" placeholder="Value">{{ old('value') }}</textarea>
<input name="description" value="{{ old('description') }}" placeholder="Keterangan">
<button>Simpan</button>
</form>

<a href="{{ url('admin/settings') }}">Kembali</a>
@endsection

