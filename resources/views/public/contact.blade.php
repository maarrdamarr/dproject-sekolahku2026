@extends('layouts.public')

@section('title', 'Kontak')

@section('content')
<div class="grid gap-6 lg:grid-cols-[1.1fr_0.9fr]">
    <section class="public-card p-6 md:p-8">
        <h1 class="font-display text-2xl text-slate-900">Hubungi Kami</h1>
        <p class="mt-2 text-sm text-slate-600">Sampaikan pertanyaan atau masukan Anda melalui formulir berikut.</p>

        @if(session('success'))
            <div class="mt-4 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <ul class="mt-4 list-disc space-y-1 pl-5 text-sm text-rose-600">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form method="POST" action="{{ url('/kontak') }}" class="mt-6 space-y-4">
            @csrf
            <div class="grid gap-4 md:grid-cols-2">
                <x-form.field label="Nama" name="name" required>
                    <x-form.input name="name" placeholder="Nama lengkap" required />
                </x-form.field>
                <x-form.field label="Email" name="email" required>
                    <x-form.input name="email" type="email" placeholder="alamat@email.com" required />
                </x-form.field>
            </div>
            <x-form.field label="Pesan" name="message" required>
                <x-form.textarea name="message" rows="5" placeholder="Tuliskan pesan Anda" required />
            </x-form.field>
            <x-form.button>kirim pesan</x-form.button>
        </form>
    </section>

    <aside class="space-y-4">
        <div class="public-card p-6">
            <h2 class="font-display text-xl text-slate-900">Informasi Kontak</h2>
            <div class="mt-4 space-y-3 text-sm text-slate-600">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Alamat</p>
                    <p class="mt-1">Jl. Pendidikan No. 123, Kota Edukasi</p>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Telepon</p>
                    <p class="mt-1">(021) 555-1234</p>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Email</p>
                    <p class="mt-1">info@sekolahku.sch.id</p>
                </div>
            </div>
        </div>
        <div class="public-card p-6">
            <h2 class="font-display text-xl text-slate-900">Jam Layanan</h2>
            <ul class="mt-4 space-y-2 text-sm text-slate-600">
                <li>Senin - Jumat: 07.30 - 16.00</li>
                <li>Sabtu: 08.00 - 12.00</li>
                <li>Minggu: Tutup</li>
            </ul>
        </div>
    </aside>
</div>
@endsection
