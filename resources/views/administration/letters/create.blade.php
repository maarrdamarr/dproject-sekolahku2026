@extends('layouts.dashboard.administration')

@section('content')
@if($errors->any())
<ul>
@foreach($errors->all() as $error)
    <li>{{ $error }}</li>
@endforeach
</ul>
@endif

<form method="POST" action="{{ url('administrasi/surat') }}" enctype="multipart/form-data">
@csrf
<input name="number" value="{{ old('number') }}" placeholder="Nomor surat">
<select name="type">
    <option value="">-- Pilih Jenis --</option>
    <option value="masuk" {{ old('type') === 'masuk' ? 'selected' : '' }}>Masuk</option>
    <option value="keluar" {{ old('type') === 'keluar' ? 'selected' : '' }}>Keluar</option>
</select>
<input name="subject" value="{{ old('subject') }}" placeholder="Perihal">
<input name="recipient" value="{{ old('recipient') }}" placeholder="Penerima">
<input type="date" name="date" value="{{ old('date') }}">
<textarea name="description" placeholder="Keterangan">{{ old('description') }}</textarea>
<input type="file" name="file">
<button>Simpan</button>
</form>

<a href="{{ url('administrasi/surat') }}">Kembali</a>
@endsection

