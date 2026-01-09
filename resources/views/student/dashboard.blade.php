<h1>Dashboard Siswa</h1>
<p>Rata-rata nilai: {{ $average }}</p>

<ul>
@foreach($announcements as $a)
    <li>{{ $a->title }}</li>
@endforeach
</ul>
