@extends('layouts.dashboard.administration')

@section('content')
@if($errors->any())
<ul>
@foreach($errors->all() as $error)
    <li>{{ $error }}</li>
@endforeach
</ul>
@endif

<form method="POST" action="{{ url('administrasi/surat/'.$letter->id) }}" enctype="multipart/form-data">
@csrf
@method('PUT')
<input name="number" value="{{ old('number', $letter->number) }}" placeholder="Nomor surat">
<select name="type">
    <option value="">-- Pilih Jenis --</option>
    <option value="masuk" {{ old('type', $letter->type) === 'masuk' ? 'selected' : '' }}>Masuk</option>
    <option value="keluar" {{ old('type', $letter->type) === 'keluar' ? 'selected' : '' }}>Keluar</option>
</select>
<input name="subject" value="{{ old('subject', $letter->subject) }}" placeholder="Perihal">
<input name="recipient" value="{{ old('recipient', $letter->recipient) }}" placeholder="Penerima">
<input type="date" name="date" value="{{ old('date', $letter->date) }}">
<textarea name="description" placeholder="Keterangan">{{ old('description', $letter->description) }}</textarea>
<input type="file" name="file">
@if($letter->file)
<p>File saat ini: <a href="{{ asset('storage/'.$letter->file) }}">Download</a></p>
@endif
<button>Perbarui</button>
</form>

<a href="{{ url('administrasi/surat') }}">Kembali</a>
@endsection

