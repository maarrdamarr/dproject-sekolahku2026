@extends('layouts.public')

@section('title', 'Berita Sekolah')

@section('content')
<div class="grid gap-6 lg:grid-cols-[1.1fr_0.9fr]">
    <section class="space-y-4">
        <div class="public-card p-6">
            <h1 class="font-display text-2xl text-slate-900">Berita Sekolah</h1>
            <p class="mt-2 text-sm text-slate-600">Ikuti informasi terbaru seputar kegiatan sekolah, prestasi, dan agenda penting.</p>
        </div>

        @forelse($news as $item)
            <article class="public-card overflow-hidden">
                <div class="grid gap-0 md:grid-cols-[0.4fr_0.6fr]">
                    <div class="h-full">
                        @if($item->thumbnail)
                            <img src="{{ asset('storage/'.$item->thumbnail) }}" alt="{{ $item->title }}" class="h-full w-full object-cover">
                        @else
                            <div class="flex h-full items-center justify-center bg-slate-100 text-sm text-slate-500">Tidak ada thumbnail</div>
                        @endif
                    </div>
                    <div class="p-6">
                        <p class="text-xs uppercase tracking-[0.2em] text-slate-400">{{ $item->created_at->format('d M Y') }}</p>
                        <h2 class="mt-2 font-display text-xl text-slate-900">{{ $item->title }}</h2>
                        <p class="mt-3 text-sm text-slate-600">{{ \Illuminate\Support\Str::limit(strip_tags($item->content), 160) }}</p>
                        <a href="{{ url('/berita/'.$item->id) }}" class="mt-4 inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.2em] text-emerald-600">
                            Baca Selengkapnya
                            <span aria-hidden="true">&rarr;</span>
                        </a>
                    </div>
                </div>
            </article>
        @empty
            <div class="public-card p-6">
                <p class="text-sm text-slate-500">Belum ada berita dipublikasikan.</p>
            </div>
        @endforelse

        <div class="public-card p-4">
            {{ $news->links() }}
        </div>
    </section>

    <aside class="space-y-4">
        <div class="public-card p-6">
            <h2 class="font-display text-xl text-slate-900">Pengumuman</h2>
            <div class="mt-4 space-y-4">
                @forelse($announcements as $announcement)
                    <div class="rounded-2xl border border-slate-200/80 bg-white p-4">
                        <p class="font-display text-lg text-slate-900">{{ $announcement->title }}</p>
                        <p class="mt-2 text-sm text-slate-600">{{ \Illuminate\Support\Str::limit(strip_tags($announcement->content), 120) }}</p>
                    </div>
                @empty
                    <p class="text-sm text-slate-500">Belum ada pengumuman.</p>
                @endforelse
            </div>
        </div>
    </aside>
</div>
@endsection
