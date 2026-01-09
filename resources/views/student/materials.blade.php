@extends('layouts.dashboard.student')

@section('content')
<ul>
@foreach($materials as $m)
<li>
{{ $m->subject->name }} - {{ $m->title }}
@if($m->file)
<a href="{{ asset('storage/'.$m->file) }}">Download</a>
@endif
</li>
@endforeach
</ul>
{{ $materials->links() }}
@endsection

