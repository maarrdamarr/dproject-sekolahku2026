@extends('layouts.dashboard.admin')

@section('content')
@if($errors->any())
<ul>
@foreach($errors->all() as $error)
    <li>{{ $error }}</li>
@endforeach
</ul>
@endif

<form method="POST" action="{{ url('admin/settings/'.$setting->id) }}">
@csrf
@method('PUT')
<input name="key" value="{{ old('key', $setting->key) }}" placeholder="Key">
<textarea name="value" placeholder="Value">{{ old('value', $setting->value) }}</textarea>
<input name="description" value="{{ old('description', $setting->description) }}" placeholder="Keterangan">
<button>Perbarui</button>
</form>

<a href="{{ url('admin/settings') }}">Kembali</a>
@endsection

