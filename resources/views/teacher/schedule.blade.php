@extends('layouts.dashboard.teacher')

@section('content')
<ul>
@foreach($schedules as $s)
<li>
{{ $s->day }} | {{ $s->start_time }} - {{ $s->end_time }} |
{{ $s->classRoom->name ?? '-' }} | {{ $s->subject->name ?? '-' }}
</li>
@endforeach
</ul>
@endsection

