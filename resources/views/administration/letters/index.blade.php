@extends('layouts.dashboard.administration')

@section('content')
@if(session('success'))
<p>{{ session('success') }}</p>
@endif

<form method="GET" class="dashboard-card space-y-4">
    <div class="grid gap-3 md:grid-cols-5">
        <input name="q" value="{{ request('q') }}" placeholder="Cari nomor, perihal, penerima">
        <select name="type">
            <option value="">Semua Jenis</option>
            <option value="masuk" {{ request('type') === 'masuk' ? 'selected' : '' }}>Masuk</option>
            <option value="keluar" {{ request('type') === 'keluar' ? 'selected' : '' }}>Keluar</option>
        </select>
        <input type="date" name="from" value="{{ request('from') }}">
        <input type="date" name="to" value="{{ request('to') }}">
        <div class="flex items-center gap-2">
            <button type="submit">Filter</button>
            <a href="{{ url('administrasi/surat') }}">Reset</a>
        </div>
    </div>
</form>

<a href="{{ url('administrasi/surat/create') }}">Tambah Surat</a>

<table border="1">
<tr>
    <th>Nomor</th>
    <th>Jenis</th>
    <th>Perihal</th>
    <th>Penerima</th>
    <th>Tanggal</th>
    <th>File</th>
    <th>Aksi</th>
</tr>
@foreach($letters as $letter)
<tr>
    <td>{{ $letter->number }}</td>
    <td>{{ $letter->type }}</td>
    <td>{{ $letter->subject }}</td>
    <td>{{ $letter->recipient }}</td>
    <td>{{ $letter->date }}</td>
    <td>
        @if($letter->file)
            <a href="{{ asset('storage/'.$letter->file) }}">Download</a>
        @endif
    </td>
    <td>
        <a href="{{ url('administrasi/surat/'.$letter->id.'/edit') }}">Edit</a>
        <form method="POST" action="{{ url('administrasi/surat/'.$letter->id) }}" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit">Hapus</button>
        </form>
    </td>
</tr>
@endforeach
</table>

{{ $letters->links() }}
@endsection

