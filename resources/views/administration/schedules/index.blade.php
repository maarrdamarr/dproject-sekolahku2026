@extends('layouts.dashboard.administration')

@section('content')
@if(session('success'))
<p>{{ session('success') }}</p>
@endif

<form method="GET" class="dashboard-card space-y-4">
    <div class="grid gap-3 md:grid-cols-5">
        <select name="class_id">
            <option value="">Semua Kelas</option>
            @foreach($classes as $class)
                <option value="{{ $class->id }}" {{ (string) $class->id === request('class_id') ? 'selected' : '' }}>
                    {{ $class->name }}
                </option>
            @endforeach
        </select>
        <select name="subject_id">
            <option value="">Semua Mapel</option>
            @foreach($subjects as $subject)
                <option value="{{ $subject->id }}" {{ (string) $subject->id === request('subject_id') ? 'selected' : '' }}>
                    {{ $subject->name }}
                </option>
            @endforeach
        </select>
        <select name="teacher_id">
            <option value="">Semua Guru</option>
            @foreach($teachers as $teacher)
                <option value="{{ $teacher->id }}" {{ (string) $teacher->id === request('teacher_id') ? 'selected' : '' }}>
                    {{ $teacher->user->name ?? '-' }}
                </option>
            @endforeach
        </select>
        <select name="day">
            <option value="">Semua Hari</option>
            @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $day)
                <option value="{{ $day }}" {{ request('day') === $day ? 'selected' : '' }}>{{ $day }}</option>
            @endforeach
        </select>
        <div class="flex items-center gap-2">
            <button type="submit">Filter</button>
            <a href="{{ url('administrasi/jadwal') }}">Reset</a>
        </div>
    </div>
</form>

<a href="{{ url('administrasi/jadwal/create') }}">Tambah Jadwal</a>

<table border="1">
<tr>
    <th>Hari</th>
    <th>Waktu</th>
    <th>Kelas</th>
    <th>Mata Pelajaran</th>
    <th>Guru</th>
    <th>Aksi</th>
</tr>
@foreach($schedules as $schedule)
<tr>
    <td>{{ $schedule->day }}</td>
    <td>{{ $schedule->start_time }} - {{ $schedule->end_time }}</td>
    <td>{{ $schedule->classRoom->name ?? '-' }}</td>
    <td>{{ $schedule->subject->name ?? '-' }}</td>
    <td>{{ $schedule->teacher->user->name ?? '-' }}</td>
    <td>
        <a href="{{ url('administrasi/jadwal/'.$schedule->id.'/edit') }}">Edit</a>
        <form method="POST" action="{{ url('administrasi/jadwal/'.$schedule->id) }}" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit">Hapus</button>
        </form>
    </td>
</tr>
@endforeach
</table>

{{ $schedules->links() }}
@endsection

