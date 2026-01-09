@extends('layouts.dashboard.admin')

@section('content')
@if(session('success'))
<p>{{ session('success') }}</p>
@endif

<form method="POST" action="{{ url('admin/backups') }}">
@csrf
<button>Buat Backup</button>
</form>

<table border="1">
<tr>
    <th>File</th>
    <th>Ukuran</th>
    <th>Terakhir Diubah</th>
    <th>Aksi</th>
</tr>
@foreach($files as $file)
<tr>
    <td>{{ $file['name'] }}</td>
    <td>{{ $file['size'] }} bytes</td>
    <td>{{ date('Y-m-d H:i:s', $file['last_modified']) }}</td>
    <td>
        <a href="{{ url('admin/backups/'.$file['name']) }}">Download</a>
        <form method="POST" action="{{ url('admin/backups/'.$file['name']) }}" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit">Hapus</button>
        </form>
    </td>
</tr>
@endforeach
</table>
@endsection

