@extends('layouts.dashboard.student')

@section('content')
<div class="grid gap-4 sm:grid-cols-2">
    <div class="dashboard-card">
        <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Rata-rata Nilai</p>
        <p class="font-display text-2xl text-slate-900">{{ number_format($average, 2) }}</p>
    </div>
    <div class="dashboard-card">
        <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Akses Cepat</p>
        <div class="mt-4 flex flex-wrap gap-2 text-xs text-slate-600">
            <span class="rounded-full border border-slate-200 px-3 py-1">Lihat Jadwal</span>
            <span class="rounded-full border border-slate-200 px-3 py-1">Unduh Materi</span>
            <span class="rounded-full border border-slate-200 px-3 py-1">Cek Nilai</span>
        </div>
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

