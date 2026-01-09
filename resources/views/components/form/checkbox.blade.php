@props([
    'name' => null,
    'value' => 1,
    'checked' => false,
    'label' => null,
])

@php
    $isChecked = old($name, $checked) ? true : false;
@endphp

<label class="flex items-center gap-2 text-sm text-slate-700">
    <input
        type="checkbox"
        name="{{ $name }}"
        value="{{ $value }}"
        @if($isChecked) checked @endif
        {{ $attributes->merge(['class' => 'h-4 w-4 rounded border-slate-300 text-slate-700 focus:ring-slate-200']) }}
    >
    <span>{{ $label }}</span>
</label>
