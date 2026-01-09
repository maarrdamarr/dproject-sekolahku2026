@extends('layouts.dashboard.admin')

@section('content')
@if(session('success'))
<p>{{ session('success') }}</p>
@endif

<form method="GET" class="dashboard-card space-y-4">
    <div class="grid gap-3 md:grid-cols-[1fr_auto_auto]">
        <input name="q" value="{{ request('q') }}" placeholder="Cari key atau value">
        <button type="submit">Filter</button>
        <a href="{{ url('admin/settings') }}">Reset</a>
    </div>
</form>

<a href="{{ url('admin/settings/create') }}">Tambah Setting</a>

<table border="1">
<tr>
    <th>Key</th>
    <th>Value</th>
    <th>Keterangan</th>
    <th>Aksi</th>
</tr>
@foreach($settings as $setting)
<tr>
    <td>{{ $setting->key }}</td>
    <td>{{ $setting->value }}</td>
    <td>{{ $setting->description }}</td>
    <td>
        <a href="{{ url('admin/settings/'.$setting->id.'/edit') }}">Edit</a>
        <form method="POST" action="{{ url('admin/settings/'.$setting->id) }}" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit">Hapus</button>
        </form>
    </td>
</tr>
@endforeach
</table>

{{ $settings->links() }}
@endsection

