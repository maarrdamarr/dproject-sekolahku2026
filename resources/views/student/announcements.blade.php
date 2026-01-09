<h1>Pengumuman</h1>

@foreach($announcements as $a)
<h3>{{ $a->title }}</h3>
<p>{{ $a->content }}</p>
@endforeach

{{ $announcements->links() }}
