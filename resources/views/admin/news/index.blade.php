@extends('layouts.dashboard.admin')

@section('content')
@if(session('success'))
<p>{{ session('success') }}</p>
@endif

<form method="GET" class="dashboard-card space-y-4">
    <div class="grid gap-3 md:grid-cols-[1fr_auto_auto]">
        <input name="q" value="{{ request('q') }}" placeholder="Cari judul berita atau pengumuman">
        <button type="submit">Filter</button>
        <a href="{{ url('admin/berita') }}">Reset</a>
    </div>
</form>

<a href="{{ url('admin/berita/create') }}">Tambah Berita</a>
<a href="{{ url('admin/pengumuman/create') }}">Tambah Pengumuman</a>

<h3>Berita</h3>
<table border="1">
<tr>
    <th>Judul</th>
    <th>Thumbnail</th>
    <th>Aksi</th>
</tr>
@foreach($news as $item)
<tr>
    <td>{{ $item->title }}</td>
    <td>
        @if($item->thumbnail)
            <a href="{{ asset('storage/'.$item->thumbnail) }}">Lihat</a>
        @endif
    </td>
    <td>
        <a href="{{ url('admin/berita/'.$item->id.'/edit') }}">Edit</a>
        <form method="POST" action="{{ url('admin/berita/'.$item->id) }}" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit">Hapus</button>
        </form>
    </td>
</tr>
@endforeach
</table>

{{ $news->links() }}

<h3>Pengumuman</h3>
<table border="1">
<tr>
    <th>Judul</th>
    <th>Aksi</th>
</tr>
@foreach($announcements as $announcement)
<tr>
    <td>{{ $announcement->title }}</td>
    <td>
        <a href="{{ url('admin/pengumuman/'.$announcement->id.'/edit') }}">Edit</a>
        <form method="POST" action="{{ url('admin/pengumuman/'.$announcement->id) }}" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit">Hapus</button>
        </form>
    </td>
</tr>
@endforeach
</table>

{{ $announcements->links() }}
@endsection

