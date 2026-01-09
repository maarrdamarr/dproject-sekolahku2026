@extends('layouts.dashboard.student')

@section('content')
@foreach($announcements as $a)
<h3>{{ $a->title }}</h3>
<p>{{ $a->content }}</p>
@endforeach

{{ $announcements->links() }}
@endsection

