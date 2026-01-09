@props([
    'name' => null,
    'type' => 'text',
    'value' => null,
    'placeholder' => null,
    'required' => false,
    'readonly' => false,
    'min' => null,
    'max' => null,
    'step' => null,
])

@php
    $inputValue = $type === 'password' || $type === 'file' ? null : old($name, $value);
@endphp

<input
    type="{{ $type }}"
    name="{{ $name }}"
    id="{{ $name }}"
    @if($inputValue !== null) value="{{ $inputValue }}" @endif
    @if($placeholder) placeholder="{{ $placeholder }}" @endif
    @if($required) required @endif
    @if($readonly) readonly @endif
    @if($min !== null) min="{{ $min }}" @endif
    @if($max !== null) max="{{ $max }}" @endif
    @if($step !== null) step="{{ $step }}" @endif
    {{ $attributes->merge(['class' => 'w-full rounded-xl border border-slate-200 bg-white/90 px-3 py-2 text-sm text-slate-900 placeholder:text-slate-400 focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200']) }}
>
