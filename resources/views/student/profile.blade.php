<h1>Profil Siswa</h1>

@if(session('success'))
<p>{{ session('success') }}</p>
@endif

<form method="POST">
@csrf
<input name="full_name" value="{{ $profile->full_name ?? '' }}" placeholder="Nama">
<input name="phone" value="{{ $profile->phone ?? '' }}" placeholder="HP">
<textarea name="address">{{ $profile->address ?? '' }}</textarea>
<button>Simpan</button>
</form>
