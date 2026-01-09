@extends('layouts.public')

@section('title', 'Profil Sekolah')

@section('content')
<div class="space-y-10">
    <section class="public-card p-8 md:p-12">
        <div class="space-y-4">
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-emerald-600">Profil Sekolah</p>
            <h1 class="font-display text-3xl text-slate-900">Sekolah yang memadukan akademik, karakter, dan inovasi.</h1>
            <p class="text-base text-slate-600">
                Kami berkomitmen membangun lingkungan belajar yang aman, kreatif, dan terukur.
                Program unggulan kami memadukan kurikulum nasional dengan penguatan literasi digital.
            </p>
        </div>
        <div class="mt-8 grid gap-4 md:grid-cols-3">
            <div class="rounded-2xl border border-emerald-100 bg-white p-5">
                <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Visi</p>
                <p class="mt-2 text-sm text-slate-700">Menjadi sekolah berprestasi dengan karakter unggul dan berdaya saing global.</p>
            </div>
            <div class="rounded-2xl border border-emerald-100 bg-white p-5">
                <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Misi</p>
                <p class="mt-2 text-sm text-slate-700">Menguatkan pembelajaran kolaboratif, budaya riset, dan layanan bimbingan terarah.</p>
            </div>
            <div class="rounded-2xl border border-emerald-100 bg-white p-5">
                <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Nilai</p>
                <p class="mt-2 text-sm text-slate-700">Integritas, kepedulian, kemandirian, dan inovasi.</p>
            </div>
        </div>
    </section>

    <section class="grid gap-6 lg:grid-cols-[1.1fr_0.9fr]">
        <div class="public-card p-6">
            <h2 class="font-display text-xl text-slate-900">Program Unggulan</h2>
            <ul class="mt-4 space-y-3 text-sm text-slate-600">
                <li class="flex items-start gap-3"><span class="mt-1 h-2 w-2 rounded-full bg-emerald-500"></span> Kelas digital dengan perangkat pembelajaran modern.</li>
                <li class="flex items-start gap-3"><span class="mt-1 h-2 w-2 rounded-full bg-emerald-500"></span> Klinik belajar untuk pendampingan akademik.</li>
                <li class="flex items-start gap-3"><span class="mt-1 h-2 w-2 rounded-full bg-emerald-500"></span> Program karakter dan kepemimpinan siswa.</li>
                <li class="flex items-start gap-3"><span class="mt-1 h-2 w-2 rounded-full bg-emerald-500"></span> Kemitraan industri dan kampus.</li>
            </ul>
        </div>
        <div class="public-card p-6">
            <h2 class="font-display text-xl text-slate-900">Fasilitas</h2>
            <div class="mt-4 grid gap-3 text-sm text-slate-600 sm:grid-cols-2">
                <div class="rounded-xl border border-slate-200/80 bg-white p-4">Laboratorium Komputer</div>
                <div class="rounded-xl border border-slate-200/80 bg-white p-4">Perpustakaan Digital</div>
                <div class="rounded-xl border border-slate-200/80 bg-white p-4">Studio Kreatif</div>
                <div class="rounded-xl border border-slate-200/80 bg-white p-4">Lapangan Olahraga</div>
            </div>
        </div>
    </section>
</div>
@endsection
