<h1>Jadwal</h1>

<ul>
@foreach($schedules as $s)
<li>
{{ $s->day }} |
{{ $s->subject->name }} |
{{ $s->teacher->user->name }}
</li>
@endforeach
</ul>
