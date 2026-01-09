@extends('layouts.dashboard.administration')

@section('content')
<div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
    <div class="dashboard-card">
        <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Total Siswa</p>
        <p class="font-display text-2xl text-slate-900">{{ $studentCount }}</p>
    </div>
    <div class="dashboard-card">
        <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Total Guru</p>
        <p class="font-display text-2xl text-slate-900">{{ $teacherCount }}</p>
    </div>
    <div class="dashboard-card">
        <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Total Jadwal</p>
        <p class="font-display text-2xl text-slate-900">{{ $scheduleCount }}</p>
    </div>
    <div class="dashboard-card">
        <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Pembayaran</p>
        <p class="font-display text-2xl text-slate-900">{{ $paymentCount }}</p>
    </div>
    <div class="dashboard-card">
        <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Akumulasi</p>
        <p class="font-display text-2xl text-slate-900">{{ $paymentTotal }}</p>
    </div>
</div>

<div class="dashboard-card">
    <h3 class="font-display text-xl text-slate-900">Pembayaran Terbaru</h3>
    <ul class="mt-4 space-y-2 text-sm text-slate-600">
        @forelse($latestPayments as $payment)
            <li class="rounded-xl border border-slate-200/80 bg-white px-4 py-3">
                <span class="font-semibold text-slate-900">{{ $payment->student->user->name ?? 'Tanpa Nama' }}</span>
                <span class="text-slate-500"> - {{ $payment->type }} - {{ $payment->amount }}</span>
                <span class="text-xs uppercase tracking-[0.2em] text-slate-400">({{ $payment->payment_date }})</span>
            </li>
        @empty
            <li class="text-sm text-slate-500">Belum ada pembayaran terbaru.</li>
        @endforelse
    </ul>
</div>
@endsection

