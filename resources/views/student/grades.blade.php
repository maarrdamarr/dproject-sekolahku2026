<h1>Nilai</h1>

<table border="1">
@foreach($grades as $g)
<tr>
    <td>{{ $g->subject->name }}</td>
    <td>{{ $g->score }}</td>
</tr>
@endforeach
</table>
