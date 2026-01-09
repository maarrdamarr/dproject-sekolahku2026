@extends('layouts.public')

@section('title', 'Beranda')

@section('content')
<div class="space-y-12">
    <section class="public-card p-8 md:p-12">
        <div class="grid gap-8 md:grid-cols-[1.2fr_0.8fr] md:items-center">
            <div class="space-y-5">
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-emerald-600">Portal Sekolah</p>
                <h1 class="font-display text-3xl text-slate-900 md:text-4xl">Pusat informasi akademik dan layanan sekolah.</h1>
                <p class="text-base text-slate-600">
                    Jelajahi jadwal, pengumuman, berita sekolah, hingga galeri kegiatan dalam satu dashboard.
                    Semua layanan akademik disusun rapi untuk siswa, guru, administrasi, dan admin.
                </p>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ url('/profil-sekolah') }}" class="rounded-full bg-emerald-600 px-5 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-white">Profil Sekolah</a>
                    <a href="{{ url('/kontak') }}" class="rounded-full border border-emerald-600/40 px-5 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-emerald-700">Hubungi Kami</a>
                </div>
            </div>
            <div class="space-y-4">
                <div class="rounded-2xl bg-emerald-500/10 p-4">
                    <p class="text-xs uppercase tracking-[0.25em] text-emerald-700">Ringkasan</p>
                    <div class="mt-4 grid gap-4 sm:grid-cols-3">
                        <div class="rounded-xl bg-white p-4 shadow-sm">
                            <p class="text-xs text-slate-500">Pengumuman</p>
                            <p class="font-display text-2xl text-slate-900">{{ $announcements->count() }}</p>
                        </div>
                        <div class="rounded-xl bg-white p-4 shadow-sm">
                            <p class="text-xs text-slate-500">Berita</p>
                            <p class="font-display text-2xl text-slate-900">{{ $news->count() }}</p>
                        </div>
                        <div class="rounded-xl bg-white p-4 shadow-sm">
                            <p class="text-xs text-slate-500">Galeri</p>
                            <p class="font-display text-2xl text-slate-900">{{ $galleries->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="rounded-2xl border border-emerald-100 bg-white p-4">
                    <p class="text-xs uppercase tracking-[0.25em] text-slate-500">Akses Cepat</p>
                    <div class="mt-4 flex flex-wrap gap-3 text-sm">
                        <span class="rounded-full bg-slate-100 px-4 py-2">Dashboard Akademik</span>
                        <span class="rounded-full bg-slate-100 px-4 py-2">Manajemen Materi</span>
                        <span class="rounded-full bg-slate-100 px-4 py-2">Monitoring Kehadiran</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="grid gap-6 lg:grid-cols-[1.1fr_0.9fr]">
        <div class="public-card p-6">
            <div class="flex items-center justify-between">
                <h2 class="font-display text-xl text-slate-900">Pengumuman Terbaru</h2>
                <a href="{{ url('/berita') }}" class="text-xs font-semibold uppercase tracking-[0.2em] text-emerald-600">Lihat Semua</a>
            </div>
            <div class="mt-4 space-y-4">
                @forelse($announcements as $announcement)
                    <div class="rounded-2xl border border-slate-200/80 bg-white p-4">
                        <p class="font-display text-lg text-slate-900">{{ $announcement->title }}</p>
                        <p class="mt-1 text-sm text-slate-600">{{ \Illuminate\Support\Str::limit(strip_tags($announcement->content), 120) }}</p>
                    </div>
                @empty
                    <p class="text-sm text-slate-500">Belum ada pengumuman terbaru.</p>
                @endforelse
            </div>
        </div>

        <div class="public-card p-6">
            <h2 class="font-display text-xl text-slate-900">Berita Terkini</h2>
            <div class="mt-4 space-y-4">
                @forelse($news as $item)
                    <a href="{{ url('/berita/'.$item->id) }}" class="group block rounded-2xl border border-slate-200/80 bg-white p-4 transition hover:-translate-y-1 hover:shadow-lg">
                        <div class="flex items-center justify-between">
                            <p class="font-display text-lg text-slate-900 group-hover:text-emerald-700">{{ $item->title }}</p>
                            <span class="text-xs uppercase tracking-[0.2em] text-slate-400">{{ $item->created_at->format('d M') }}</span>
                        </div>
                        <p class="mt-2 text-sm text-slate-600">{{ \Illuminate\Support\Str::limit(strip_tags($item->content), 100) }}</p>
                    </a>
                @empty
                    <p class="text-sm text-slate-500">Belum ada berita terbaru.</p>
                @endforelse
            </div>
        </div>
    </section>

    <section class="public-card p-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <h2 class="font-display text-xl text-slate-900">Galeri Kegiatan</h2>
            <a href="{{ url('/galeri') }}" class="text-xs font-semibold uppercase tracking-[0.2em] text-emerald-600">Lihat Galeri</a>
        </div>
        <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($galleries as $gallery)
                <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white">
                    @if($gallery->image)
                        <img src="{{ asset('storage/'.$gallery->image) }}" alt="{{ $gallery->title }}" class="h-48 w-full object-cover">
                    @else
                        <div class="flex h-48 items-center justify-center bg-slate-100 text-sm text-slate-500">Tidak ada gambar</div>
                    @endif
                    <div class="p-4">
                        <p class="font-display text-lg text-slate-900">{{ $gallery->title }}</p>
                    </div>
                </div>
            @empty
                <p class="text-sm text-slate-500">Belum ada galeri kegiatan.</p>
            @endforelse
        </div>
    </section>
</div>
@endsection
