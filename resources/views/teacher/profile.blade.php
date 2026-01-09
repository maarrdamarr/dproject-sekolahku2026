@extends('layouts.dashboard.teacher')

@section('content')
@if(session('success'))
<p>{{ session('success') }}</p>
@endif

<p>NIP: {{ $teacher->nip ?? '-' }}</p>
<p>Keahlian: {{ $teacher->expertise ?? '-' }}</p>

<form method="POST" enctype="multipart/form-data">
@csrf
<input name="full_name" value="{{ $profile->full_name ?? '' }}" placeholder="Nama">
<input name="phone" value="{{ $profile->phone ?? '' }}" placeholder="HP">
<textarea name="address" placeholder="Alamat">{{ $profile->address ?? '' }}</textarea>
@if(!empty($profile?->photo))
<div>
    <img src="{{ asset('storage/'.$profile->photo) }}" alt="Foto profil" width="120">
</div>
@endif
<input type="file" name="photo">
<button>Simpan</button>
</form>
@endsection

