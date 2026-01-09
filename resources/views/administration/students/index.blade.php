@extends('layouts.dashboard.administration')

@section('content')
@if(session('success'))
<p>{{ session('success') }}</p>
@endif

<form method="GET" class="dashboard-card space-y-4">
    <div class="grid gap-3 md:grid-cols-4">
        <input name="q" value="{{ request('q') }}" placeholder="Cari nama, email, atau NIS">
        <select name="class_id">
            <option value="">Semua Kelas</option>
            @foreach($classes as $class)
                <option value="{{ $class->id }}" {{ (string) $class->id === request('class_id') ? 'selected' : '' }}>
                    {{ $class->name }}
                </option>
            @endforeach
        </select>
        <input name="entry_year" value="{{ request('entry_year') }}" placeholder="Tahun Masuk">
        <div class="flex items-center gap-2">
            <button type="submit">Filter</button>
            <a href="{{ url('administrasi/siswa') }}">Reset</a>
        </div>
    </div>
</form>

<a href="{{ url('administrasi/siswa/create') }}">Tambah Siswa</a>

<table border="1">
<tr>
    <th>Nama</th>
    <th>Email</th>
    <th>NIS</th>
    <th>Kelas</th>
    <th>Tahun Masuk</th>
    <th>Aksi</th>
</tr>
@foreach($students as $student)
<tr>
    <td>{{ $student->user->name ?? '-' }}</td>
    <td>{{ $student->user->email ?? '-' }}</td>
    <td>{{ $student->nis }}</td>
    <td>{{ $student->classRoom->name ?? '-' }}</td>
    <td>{{ $student->entry_year }}</td>
    <td>
        <a href="{{ url('administrasi/siswa/'.$student->id.'/edit') }}">Edit</a>
        <form method="POST" action="{{ url('administrasi/siswa/'.$student->id) }}" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit">Hapus</button>
        </form>
    </td>
</tr>
@endforeach
</table>

{{ $students->links() }}
@endsection

