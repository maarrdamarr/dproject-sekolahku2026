@extends('layouts.dashboard.administration')

@section('content')
@if(session('success'))
<p>{{ session('success') }}</p>
@endif

<form method="GET" class="dashboard-card space-y-4">
    <div class="grid gap-3 md:grid-cols-[1fr_auto_auto]">
        <input name="q" value="{{ request('q') }}" placeholder="Cari nama, email, NIP, atau keahlian">
        <button type="submit">Filter</button>
        <a href="{{ url('administrasi/guru') }}">Reset</a>
    </div>
</form>

<a href="{{ url('administrasi/guru/create') }}">Tambah Guru</a>

<table border="1">
<tr>
    <th>Nama</th>
    <th>Email</th>
    <th>NIP</th>
    <th>Keahlian</th>
    <th>Aksi</th>
</tr>
@foreach($teachers as $teacher)
<tr>
    <td>{{ $teacher->user->name ?? '-' }}</td>
    <td>{{ $teacher->user->email ?? '-' }}</td>
    <td>{{ $teacher->nip }}</td>
    <td>{{ $teacher->expertise }}</td>
    <td>
        <a href="{{ url('administrasi/guru/'.$teacher->id.'/edit') }}">Edit</a>
        <form method="POST" action="{{ url('administrasi/guru/'.$teacher->id) }}" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit">Hapus</button>
        </form>
    </td>
</tr>
@endforeach
</table>

{{ $teachers->links() }}
@endsection

