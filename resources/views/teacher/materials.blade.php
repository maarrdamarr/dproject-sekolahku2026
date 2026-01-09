@extends('layouts.dashboard.teacher')

@section('content')
@if(session('success'))
<p>{{ session('success') }}</p>
@endif

@if(session('error'))
<p>{{ session('error') }}</p>
@endif

@if($subjects->isEmpty())
<p>Belum ada mata pelajaran untuk diunggah.</p>
@else
<form method="POST" enctype="multipart/form-data">
@csrf
<select name="subject_id">
@foreach($subjects as $subject)
    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
@endforeach
</select>
<input name="title" placeholder="Judul materi">
<input type="file" name="file">
<button>Upload</button>
</form>
@endif

<h3>Daftar Materi</h3>

<ul>
@foreach($materials as $m)
<li>
{{ $m->subject->name ?? '-' }} - {{ $m->title }}
@if($m->file)
<a href="{{ asset('storage/'.$m->file) }}">Download</a>
@endif
</li>
@endforeach
</ul>
@if(method_exists($materials, 'links'))
{{ $materials->links() }}
@endif
@endsection

