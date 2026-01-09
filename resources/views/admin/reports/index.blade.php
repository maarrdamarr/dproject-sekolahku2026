@extends('layouts.dashboard.admin')

@section('content')
<form method="GET">
<select name="type">
    <option value="users" {{ $type === 'users' ? 'selected' : '' }}>User</option>
    <option value="students" {{ $type === 'students' ? 'selected' : '' }}>Siswa</option>
    <option value="teachers" {{ $type === 'teachers' ? 'selected' : '' }}>Guru</option>
    <option value="payments" {{ $type === 'payments' ? 'selected' : '' }}>Pembayaran</option>
    <option value="schedules" {{ $type === 'schedules' ? 'selected' : '' }}>Jadwal</option>
    <option value="news" {{ $type === 'news' ? 'selected' : '' }}>Berita</option>
    <option value="announcements" {{ $type === 'announcements' ? 'selected' : '' }}>Pengumuman</option>
    <option value="galleries" {{ $type === 'galleries' ? 'selected' : '' }}>Galeri</option>
    <option value="letters" {{ $type === 'letters' ? 'selected' : '' }}>Surat</option>
    <option value="contents" {{ $type === 'contents' ? 'selected' : '' }}>Konten</option>
    <option value="settings" {{ $type === 'settings' ? 'selected' : '' }}>Setting</option>
</select>

@if($type === 'payments')
<input type="date" name="from" value="{{ $from }}">
<input type="date" name="to" value="{{ $to }}">
@endif

<button>Tampilkan</button>
</form>

@php
    $queryString = http_build_query(request()->query());
    $pdfUrl = url('admin/reports/pdf') . ($queryString ? ('?' . $queryString) : '');
@endphp

<a href="{{ $pdfUrl }}">Export PDF</a>

<button onclick="window.print()">Cetak</button>

@if(isset($summary['count']))
<p>Total data: {{ $summary['count'] }}</p>
@endif
@if(isset($summary['total']))
<p>Total pembayaran: {{ $summary['total'] }}</p>
@endif

@if($type === 'users')
<table border="1">
<tr>
    <th>Nama</th>
    <th>Email</th>
    <th>Role</th>
</tr>
@foreach($data as $user)
<tr>
    <td>{{ $user->name }}</td>
    <td>{{ $user->email }}</td>
    <td>{{ $user->role }}</td>
</tr>
@endforeach
</table>
@elseif($type === 'students')
<table border="1">
<tr>
    <th>Nama</th>
    <th>Email</th>
    <th>NIS</th>
    <th>Kelas</th>
</tr>
@foreach($data as $student)
<tr>
    <td>{{ $student->user->name ?? '-' }}</td>
    <td>{{ $student->user->email ?? '-' }}</td>
    <td>{{ $student->nis }}</td>
    <td>{{ $student->classRoom->name ?? '-' }}</td>
</tr>
@endforeach
</table>
@elseif($type === 'teachers')
<table border="1">
<tr>
    <th>Nama</th>
    <th>Email</th>
    <th>NIP</th>
    <th>Keahlian</th>
</tr>
@foreach($data as $teacher)
<tr>
    <td>{{ $teacher->user->name ?? '-' }}</td>
    <td>{{ $teacher->user->email ?? '-' }}</td>
    <td>{{ $teacher->nip }}</td>
    <td>{{ $teacher->expertise }}</td>
</tr>
@endforeach
</table>
@elseif($type === 'payments')
<table border="1">
<tr>
    <th>Siswa</th>
    <th>Jenis</th>
    <th>Jumlah</th>
    <th>Tanggal</th>
</tr>
@foreach($data as $payment)
<tr>
    <td>{{ $payment->student->user->name ?? '-' }}</td>
    <td>{{ $payment->type }}</td>
    <td>{{ $payment->amount }}</td>
    <td>{{ $payment->payment_date }}</td>
</tr>
@endforeach
</table>
@elseif($type === 'schedules')
<table border="1">
<tr>
    <th>Hari</th>
    <th>Waktu</th>
    <th>Kelas</th>
    <th>Mata Pelajaran</th>
    <th>Guru</th>
</tr>
@foreach($data as $schedule)
<tr>
    <td>{{ $schedule->day }}</td>
    <td>{{ $schedule->start_time }} - {{ $schedule->end_time }}</td>
    <td>{{ $schedule->classRoom->name ?? '-' }}</td>
    <td>{{ $schedule->subject->name ?? '-' }}</td>
    <td>{{ $schedule->teacher->user->name ?? '-' }}</td>
</tr>
@endforeach
</table>
@elseif($type === 'news')
<table border="1">
<tr>
    <th>Judul</th>
    <th>Thumbnail</th>
</tr>
@foreach($data as $item)
<tr>
    <td>{{ $item->title }}</td>
    <td>
        @if($item->thumbnail)
            <a href="{{ asset('storage/'.$item->thumbnail) }}">Lihat</a>
        @endif
    </td>
</tr>
@endforeach
</table>
@elseif($type === 'announcements')
<table border="1">
<tr>
    <th>Judul</th>
    <th>Konten</th>
</tr>
@foreach($data as $announcement)
<tr>
    <td>{{ $announcement->title }}</td>
    <td>{{ $announcement->content }}</td>
</tr>
@endforeach
</table>
@elseif($type === 'galleries')
<table border="1">
<tr>
    <th>Judul</th>
    <th>Gambar</th>
</tr>
@foreach($data as $gallery)
<tr>
    <td>{{ $gallery->title }}</td>
    <td>
        @if($gallery->image)
            <a href="{{ asset('storage/'.$gallery->image) }}">Lihat</a>
        @endif
    </td>
</tr>
@endforeach
</table>
@elseif($type === 'letters')
<table border="1">
<tr>
    <th>Nomor</th>
    <th>Jenis</th>
    <th>Perihal</th>
    <th>Penerima</th>
    <th>Tanggal</th>
</tr>
@foreach($data as $letter)
<tr>
    <td>{{ $letter->number }}</td>
    <td>{{ $letter->type }}</td>
    <td>{{ $letter->subject }}</td>
    <td>{{ $letter->recipient }}</td>
    <td>{{ $letter->date }}</td>
</tr>
@endforeach
</table>
@elseif($type === 'contents')
<table border="1">
<tr>
    <th>Judul</th>
    <th>Slug</th>
    <th>Status</th>
</tr>
@foreach($data as $content)
<tr>
    <td>{{ $content->title }}</td>
    <td>{{ $content->slug }}</td>
    <td>{{ $content->is_published ? 'Publish' : 'Draft' }}</td>
</tr>
@endforeach
</table>
@elseif($type === 'settings')
<table border="1">
<tr>
    <th>Key</th>
    <th>Value</th>
    <th>Keterangan</th>
</tr>
@foreach($data as $setting)
<tr>
    <td>{{ $setting->key }}</td>
    <td>{{ $setting->value }}</td>
    <td>{{ $setting->description }}</td>
</tr>
@endforeach
</table>
@endif
@endsection

