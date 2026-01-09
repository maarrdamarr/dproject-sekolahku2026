@extends('layouts.dashboard.student')

@section('content')
<table border="1">
@foreach($grades as $g)
<tr>
    <td>{{ $g->subject->name }}</td>
    <td>{{ $g->score }}</td>
</tr>
@endforeach
</table>
{{ $grades->links() }}
@endsection

