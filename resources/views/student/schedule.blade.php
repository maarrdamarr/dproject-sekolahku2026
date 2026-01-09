@extends('layouts.dashboard.student')

@section('content')
<ul>
@foreach($schedules as $s)
<li>
{{ $s->day }} |
{{ $s->subject->name }} |
{{ $s->teacher->user->name }}
</li>
@endforeach
</ul>
@endsection

