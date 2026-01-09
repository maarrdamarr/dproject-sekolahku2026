<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <title>Laporan Administrasi</title>
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
        <h1>Laporan Administrasi</h1>
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

        @if($type === 'students')
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
        @endif
    </body>
</html>
