@php
    $user = auth()->user();
    $dashboardUrl = null;

    if ($user) {
        if ($user->role === 'admin') {
            $dashboardUrl = url('admin/dashboard');
        } elseif ($user->role === 'administrasi') {
            $dashboardUrl = url('administrasi/dashboard');
        } elseif ($user->role === 'guru') {
            $dashboardUrl = url('guru/dashboard');
        } else {
            $dashboardUrl = url('siswa/dashboard');
        }
    }
@endphp

<nav class="border-b border-slate-200/80 bg-white/80 backdrop-blur">
    <div class="mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-4 px-4 py-4">
        <div class="flex items-center gap-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-emerald-500/10 text-emerald-600">
                <span class="font-display text-lg">SK</span>
            </div>
            <div>
                <p class="font-display text-lg text-slate-900">{{ config('app.name', 'Sekolahku') }}</p>
                <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Portal Sekolah</p>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-4 text-sm font-medium text-slate-600">
            <a href="{{ url('/') }}" class="hover:text-slate-900">Beranda</a>
            <a href="{{ url('/profil-sekolah') }}" class="hover:text-slate-900">Profil</a>
            <a href="{{ url('/berita') }}" class="hover:text-slate-900">Berita</a>
            <a href="{{ url('/galeri') }}" class="hover:text-slate-900">Galeri</a>
            <a href="{{ url('/kontak') }}" class="hover:text-slate-900">Kontak</a>
        </div>

        <div class="flex items-center gap-3">
            @auth
                @if($dashboardUrl)
                    <a href="{{ $dashboardUrl }}" class="rounded-full border border-emerald-500/30 bg-emerald-500/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-emerald-700">
                        Dashboard
                    </a>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="rounded-full border border-slate-300 px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-slate-600">
                        Keluar
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="rounded-full border border-slate-300 px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-slate-600">
                    Masuk
                </a>
            @endauth
        </div>
    </div>
</nav>
