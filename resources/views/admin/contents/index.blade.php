@extends('layouts.dashboard.admin')

@section('content')
@if(session('success'))
<p>{{ session('success') }}</p>
@endif

<form method="GET" class="dashboard-card space-y-4">
    <div class="grid gap-3 md:grid-cols-3">
        <input name="q" value="{{ request('q') }}" placeholder="Cari judul atau slug">
        <select name="status">
            <option value="">Semua Status</option>
            <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Publish</option>
            <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
        </select>
        <div class="flex items-center gap-2">
            <button type="submit">Filter</button>
            <a href="{{ url('admin/contents') }}">Reset</a>
        </div>
    </div>
</form>

<a href="{{ url('admin/contents/create') }}">Tambah Konten</a>

<table border="1">
<tr>
    <th>Judul</th>
    <th>Slug</th>
    <th>Status</th>
    <th>Aksi</th>
</tr>
@foreach($contents as $content)
<tr>
    <td>{{ $content->title }}</td>
    <td>{{ $content->slug }}</td>
    <td>{{ $content->is_published ? 'Publish' : 'Draft' }}</td>
    <td>
        <a href="{{ url('admin/contents/'.$content->id.'/edit') }}">Edit</a>
        <form method="POST" action="{{ url('admin/contents/'.$content->id) }}" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit">Hapus</button>
        </form>
    </td>
</tr>
@endforeach
</table>

{{ $contents->links() }}
@endsection

