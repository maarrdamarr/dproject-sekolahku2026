@props([
    'type' => 'submit',
    'variant' => 'primary',
])

@php
    $base = 'rounded-full px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] transition';
    $variants = [
        'primary' => 'bg-slate-900 text-white hover:bg-slate-800',
        'secondary' => 'border border-slate-300 text-slate-700 hover:border-slate-400',
        'ghost' => 'text-slate-600 hover:text-slate-900',
    ];
    $classes = $variants[$variant] ?? $variants['primary'];
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => $base . ' ' . $classes]) }}>
    {{ $slot }}
</button>
