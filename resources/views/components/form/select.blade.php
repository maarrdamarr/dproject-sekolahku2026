@props([
    'name' => null,
    'options' => [],
    'selected' => null,
    'placeholder' => null,
    'required' => false,
])

@php
    $selectedValue = old($name, $selected);
@endphp

<select
    name="{{ $name }}"
    id="{{ $name }}"
    @if($required) required @endif
    {{ $attributes->merge(['class' => 'w-full rounded-xl border border-slate-200 bg-white/90 px-3 py-2 text-sm text-slate-900 focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200']) }}
>
    @if($placeholder)
        <option value="">{{ $placeholder }}</option>
    @endif

    @foreach($options as $value => $label)
        <option value="{{ $value }}" {{ (string) $value === (string) $selectedValue ? 'selected' : '' }}>
            {{ $label }}
        </option>
    @endforeach

    {{ $slot }}
</select>
