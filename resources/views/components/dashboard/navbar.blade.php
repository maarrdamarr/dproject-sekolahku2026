@props(['role' => 'Dashboard'])

@php
    $user = auth()->user();
@endphp

<header class="dashboard-topbar">
    <div class="mx-auto flex w-full max-w-[1200px] flex-wrap items-center justify-between gap-4 px-6 py-4">
        <div class="flex items-center gap-3">
            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white/10 text-white">
                <span class="font-display text-lg">{{ strtoupper(substr($role, 0, 2)) }}</span>
            </div>
            <div>
                <p class="font-display text-xl text-white">{{ config('app.name', 'Sekolahku') }}</p>
                <p class="text-xs uppercase tracking-[0.3em] text-white/70">{{ $role }}</p>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-3 text-sm text-white/90">
            <div class="rounded-full bg-white/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em]">
                {{ $user->role ?? 'User' }}
            </div>
            <div class="text-sm font-medium">{{ $user->name ?? 'Pengguna' }}</div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="rounded-full border border-white/30 px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-white">
                    Keluar
                </button>
            </form>
        </div>
    </div>
</header>

<style>
    .dashboard-topbar {
        background: linear-gradient(135deg, var(--banner-start), var(--banner-end));
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.2);
    }
</style>
