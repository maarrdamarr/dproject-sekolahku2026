@extends('layouts.public')

@section('title', $news->title)

@section('content')
<div class="space-y-8">
    <section class="public-card overflow-hidden">
        @if($news->thumbnail)
            <img src="{{ asset('storage/'.$news->thumbnail) }}" alt="{{ $news->title }}" class="h-64 w-full object-cover">
        @endif
        <div class="p-6 md:p-10">
            <p class="text-xs uppercase tracking-[0.2em] text-slate-400">{{ $news->created_at->format('d M Y') }}</p>
            <h1 class="mt-2 font-display text-3xl text-slate-900">{{ $news->title }}</h1>
            <div class="mt-6 space-y-4 text-base leading-relaxed text-slate-700">
                {!! nl2br(e($news->content)) !!}
            </div>
        </div>
    </section>

    <div class="public-card flex flex-wrap items-center justify-between gap-4 p-6">
        <p class="text-sm text-slate-600">Kembali ke daftar berita sekolah.</p>
        <a href="{{ url('/berita') }}" class="rounded-full border border-emerald-600/40 px-5 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-emerald-700">Lihat Semua Berita</a>
    </div>
</div>
@endsection
