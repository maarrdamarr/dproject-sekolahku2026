@extends('layouts.dashboard.admin')

@section('content')
<div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
    <div class="dashboard-card">
        <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Total User</p>
        <p class="font-display text-2xl text-slate-900">{{ $userCount }}</p>
    </div>
    <div class="dashboard-card">
        <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Admin</p>
        <p class="font-display text-2xl text-slate-900">{{ $adminCount }}</p>
    </div>
    <div class="dashboard-card">
        <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Administrasi</p>
        <p class="font-display text-2xl text-slate-900">{{ $administrationCount }}</p>
    </div>
    <div class="dashboard-card">
        <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Guru</p>
        <p class="font-display text-2xl text-slate-900">{{ $teacherCount }}</p>
    </div>
    <div class="dashboard-card">
        <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Siswa</p>
        <p class="font-display text-2xl text-slate-900">{{ $studentCount }}</p>
    </div>
    <div class="dashboard-card">
        <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Berita</p>
        <p class="font-display text-2xl text-slate-900">{{ $newsCount }}</p>
    </div>
    <div class="dashboard-card">
        <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Pengumuman</p>
        <p class="font-display text-2xl text-slate-900">{{ $announcementCount }}</p>
    </div>
    <div class="dashboard-card">
        <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Galeri</p>
        <p class="font-display text-2xl text-slate-900">{{ $galleryCount }}</p>
    </div>
    <div class="dashboard-card">
        <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Konten</p>
        <p class="font-display text-2xl text-slate-900">{{ $contentCount }}</p>
    </div>
    <div class="dashboard-card">
        <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Setting</p>
        <p class="font-display text-2xl text-slate-900">{{ $settingCount }}</p>
    </div>
    <div class="dashboard-card sm:col-span-2 lg:col-span-2">
        <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Total Pembayaran</p>
        <p class="font-display text-2xl text-slate-900">{{ $paymentTotal }}</p>
    </div>
</div>

<div class="grid gap-6 lg:grid-cols-2">
    <div class="dashboard-card">
        <h3 class="font-display text-xl text-slate-900">User Terbaru</h3>
        <ul class="mt-4 space-y-2 text-sm text-slate-600">
            @forelse($latestUsers as $user)
                <li class="flex items-center justify-between rounded-xl border border-slate-200/80 bg-white px-4 py-3">
                    <span>{{ $user->name }}</span>
                    <span class="text-xs uppercase tracking-[0.2em] text-slate-400">{{ $user->role }}</span>
                </li>
            @empty
                <li class="text-sm text-slate-500">Belum ada user terbaru.</li>
            @endforelse
        </ul>
    </div>

    <div class="dashboard-card">
        <h3 class="font-display text-xl text-slate-900">Berita Terbaru</h3>
        <ul class="mt-4 space-y-2 text-sm text-slate-600">
            @forelse($latestNews as $item)
                <li class="rounded-xl border border-slate-200/80 bg-white px-4 py-3">{{ $item->title }}</li>
            @empty
                <li class="text-sm text-slate-500">Belum ada berita terbaru.</li>
            @endforelse
        </ul>
    </div>
</div>
@endsection

