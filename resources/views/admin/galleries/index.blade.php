@extends('layouts.dashboard.admin')

@section('content')
@if(session('success'))
<p>{{ session('success') }}</p>
@endif

<form method="GET" class="dashboard-card space-y-4">
    <div class="grid gap-3 md:grid-cols-[1fr_auto_auto]">
        <input name="q" value="{{ request('q') }}" placeholder="Cari judul galeri">
        <button type="submit">Filter</button>
        <a href="{{ url('admin/galleries') }}">Reset</a>
    </div>
</form>

<a href="{{ url('admin/galleries/create') }}">Tambah Galeri</a>

<table border="1">
<tr>
    <th>Judul</th>
    <th>Gambar</th>
    <th>Aksi</th>
</tr>
@foreach($galleries as $gallery)
<tr>
    <td>{{ $gallery->title }}</td>
    <td>
        @if($gallery->image)
            <a href="{{ asset('storage/'.$gallery->image) }}">Lihat</a>
        @endif
    </td>
    <td>
        <a href="{{ url('admin/galleries/'.$gallery->id.'/edit') }}">Edit</a>
        <form method="POST" action="{{ url('admin/galleries/'.$gallery->id) }}" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit">Hapus</button>
        </form>
    </td>
</tr>
@endforeach
</table>

{{ $galleries->links() }}
@endsection

