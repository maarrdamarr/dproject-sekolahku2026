@extends('layouts.public')

@section('title', 'Galeri')

@section('content')
<div class="space-y-8">
    <section class="public-card p-6">
        <h1 class="font-display text-2xl text-slate-900">Galeri Kegiatan</h1>
        <p class="mt-2 text-sm text-slate-600">Dokumentasi kegiatan sekolah, lomba, dan agenda penting.</p>
    </section>

    <section class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @forelse($galleries as $gallery)
            <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white">
                @if($gallery->image)
                    <img src="{{ asset('storage/'.$gallery->image) }}" alt="{{ $gallery->title }}" class="h-52 w-full object-cover">
                @else
                    <div class="flex h-52 items-center justify-center bg-slate-100 text-sm text-slate-500">Tidak ada gambar</div>
                @endif
                <div class="p-4">
                    <p class="font-display text-lg text-slate-900">{{ $gallery->title }}</p>
                </div>
            </div>
        @empty
            <div class="public-card p-6">
                <p class="text-sm text-slate-500">Belum ada galeri yang tersedia.</p>
            </div>
        @endforelse
    </section>

    <div class="public-card p-4">
        {{ $galleries->links() }}
    </div>
</div>
@endsection
