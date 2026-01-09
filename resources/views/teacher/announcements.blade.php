@extends('layouts.dashboard.teacher')

@section('content')
@if(session('success'))
<p>{{ session('success') }}</p>
@endif

<form method="POST">
@csrf
<input name="title" placeholder="Judul">
<textarea name="content" placeholder="Isi pengumuman"></textarea>
<button>Publikasikan</button>
</form>

@foreach($announcements as $a)
<h3>{{ $a->title }}</h3>
<p>{{ $a->content }}</p>
@endforeach

{{ $announcements->links() }}
@endsection

