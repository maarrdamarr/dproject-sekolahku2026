@extends('layouts.dashboard.teacher')

@section('content')
<div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
    <div class="dashboard-card">
        <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Jumlah Kelas</p>
        <p class="font-display text-2xl text-slate-900">{{ $classCount }}</p>
    </div>
    <div class="dashboard-card">
        <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Jadwal Mengajar</p>
        <p class="font-display text-2xl text-slate-900">{{ $scheduleCount }}</p>
    </div>
    <div class="dashboard-card">
        <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Materi Mapel</p>
        <p class="font-display text-2xl text-slate-900">{{ $materialCount }}</p>
    </div>
    <div class="dashboard-card">
        <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Nilai Tercatat</p>
        <p class="font-display text-2xl text-slate-900">{{ $gradeCount }}</p>
    </div>
</div>

<div class="dashboard-card">
    <h3 class="font-display text-xl text-slate-900">Pengumuman Terbaru</h3>
    <ul class="mt-4 space-y-2 text-sm text-slate-600">
        @forelse($announcements as $a)
            <li class="rounded-xl border border-slate-200/80 bg-white px-4 py-3">{{ $a->title }}</li>
        @empty
            <li class="text-sm text-slate-500">Belum ada pengumuman terbaru.</li>
        @endforelse
    </ul>
</div>
@endsection

