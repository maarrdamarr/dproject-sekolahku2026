@extends('layouts.dashboard.admin')

@section('content')
@if(session('success'))
<p>{{ session('success') }}</p>
@endif
@if(session('error'))
<p>{{ session('error') }}</p>
@endif

<form method="GET" class="dashboard-card space-y-4">
    <div class="grid gap-3 md:grid-cols-3">
        <input name="q" value="{{ request('q') }}" placeholder="Cari nama atau email">
        <select name="role">
            <option value="">Semua Role</option>
            @foreach(['admin','administrasi','guru','siswa'] as $role)
                <option value="{{ $role }}" {{ request('role') === $role ? 'selected' : '' }}>{{ ucfirst($role) }}</option>
            @endforeach
        </select>
        <div class="flex items-center gap-2">
            <button type="submit">Filter</button>
            <a href="{{ url('admin/users') }}">Reset</a>
        </div>
    </div>
</form>

<a href="{{ url('admin/users/create') }}">Tambah User</a>

<table border="1">
<tr>
    <th>Nama</th>
    <th>Email</th>
    <th>Role</th>
    <th>Aksi</th>
</tr>
@foreach($users as $user)
<tr>
    <td>{{ $user->name }}</td>
    <td>{{ $user->email }}</td>
    <td>{{ $user->role }}</td>
    <td>
        <a href="{{ url('admin/users/'.$user->id.'/edit') }}">Edit</a>
        <form method="POST" action="{{ url('admin/users/'.$user->id) }}" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit">Hapus</button>
        </form>
    </td>
</tr>
@endforeach
</table>

{{ $users->links() }}
@endsection

