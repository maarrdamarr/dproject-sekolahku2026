@extends('layouts.dashboard.student')

@section('content')
@if(session('success'))
<p>{{ session('success') }}</p>
@endif

<form method="POST" enctype="multipart/form-data">
@csrf
<input name="full_name" value="{{ $profile->full_name ?? '' }}" placeholder="Nama">
<input name="phone" value="{{ $profile->phone ?? '' }}" placeholder="HP">
<textarea name="address">{{ $profile->address ?? '' }}</textarea>
@if(!empty($profile?->photo))
<div>
    <img src="{{ asset('storage/'.$profile->photo) }}" alt="Foto profil" width="120">
</div>
@endif
<input type="file" name="photo">
<button>Simpan</button>
</form>
@endsection

