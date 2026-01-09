<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <title>Laporan Admin</title>
        <style>
            body {
                font-family: DejaVu Sans, sans-serif;
                font-size: 12px;
                color: #0f172a;
            }
            h1, h2 {
                margin: 0 0 8px 0;
            }
            .meta {
                margin-bottom: 16px;
                font-size: 11px;
                color: #475569;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 12px;
            }
            th, td {
                border: 1px solid #cbd5f5;
                padding: 6px 8px;
                text-align: left;
            }
            th {
                background: #e2e8f0;
            }
        </style>
    </head>
    <body>
        <h1>Laporan Admin</h1>
        <div class="meta">
            <div>Tipe: {{ ucfirst($type) }}</div>
            @if($from || $to)
                <div>Periode: {{ $from ?: '-' }} sampai {{ $to ?: '-' }}</div>
            @endif
            <div>Total data: {{ $summary['count'] ?? 0 }}</div>
            @if(isset($summary['total']))
                <div>Total pembayaran: {{ $summary['total'] }}</div>
            @endif
        </div>

        @if($type === 'users')
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @elseif($type === 'students')
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>NIS</th>
                        <th>Kelas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $student)
                        <tr>
                            <td>{{ $student->user->name ?? '-' }}</td>
                            <td>{{ $student->user->email ?? '-' }}</td>
                            <td>{{ $student->nis }}</td>
                            <td>{{ $student->classRoom->name ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @elseif($type === 'teachers')
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>NIP</th>
                        <th>Keahlian</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $teacher)
                        <tr>
                            <td>{{ $teacher->user->name ?? '-' }}</td>
                            <td>{{ $teacher->user->email ?? '-' }}</td>
                            <td>{{ $teacher->nip }}</td>
                            <td>{{ $teacher->expertise }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @elseif($type === 'payments')
            <table>
                <thead>
                    <tr>
                        <th>Siswa</th>
                        <th>Jenis</th>
                        <th>Jumlah</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $payment)
                        <tr>
                            <td>{{ $payment->student->user->name ?? '-' }}</td>
                            <td>{{ $payment->type }}</td>
                            <td>{{ $payment->amount }}</td>
                            <td>{{ $payment->payment_date }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @elseif($type === 'schedules')
            <table>
                <thead>
                    <tr>
                        <th>Hari</th>
                        <th>Waktu</th>
                        <th>Kelas</th>
                        <th>Mata Pelajaran</th>
                        <th>Guru</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $schedule)
                        <tr>
                            <td>{{ $schedule->day }}</td>
                            <td>{{ $schedule->start_time }} - {{ $schedule->end_time }}</td>
                            <td>{{ $schedule->classRoom->name ?? '-' }}</td>
                            <td>{{ $schedule->subject->name ?? '-' }}</td>
                            <td>{{ $schedule->teacher->user->name ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @elseif($type === 'news')
            <table>
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $item)
                        <tr>
                            <td>{{ $item->title }}</td>
                            <td>{{ $item->created_at?->format('d M Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @elseif($type === 'announcements')
            <table>
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Konten</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $announcement)
                        <tr>
                            <td>{{ $announcement->title }}</td>
                            <td>{{ $announcement->content }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @elseif($type === 'galleries')
            <table>
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Gambar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $gallery)
                        <tr>
                            <td>{{ $gallery->title }}</td>
                            <td>{{ $gallery->image }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @elseif($type === 'letters')
            <table>
                <thead>
                    <tr>
                        <th>Nomor</th>
                        <th>Jenis</th>
                        <th>Perihal</th>
                        <th>Penerima</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $letter)
                        <tr>
                            <td>{{ $letter->number }}</td>
                            <td>{{ $letter->type }}</td>
                            <td>{{ $letter->subject }}</td>
                            <td>{{ $letter->recipient }}</td>
                            <td>{{ $letter->date }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @elseif($type === 'contents')
            <table>
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Slug</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $content)
                        <tr>
                            <td>{{ $content->title }}</td>
                            <td>{{ $content->slug }}</td>
                            <td>{{ $content->is_published ? 'Publish' : 'Draft' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @elseif($type === 'settings')
            <table>
                <thead>
                    <tr>
                        <th>Key</th>
                        <th>Value</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $setting)
                        <tr>
                            <td>{{ $setting->key }}</td>
                            <td>{{ $setting->value }}</td>
                            <td>{{ $setting->description }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </body>
</html>
