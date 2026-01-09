@props([
    'name' => null,
    'value' => null,
    'placeholder' => null,
    'rows' => 4,
    'required' => false,
])

<textarea
    name="{{ $name }}"
    id="{{ $name }}"
    rows="{{ $rows }}"
    @if($placeholder) placeholder="{{ $placeholder }}" @endif
    @if($required) required @endif
    {{ $attributes->merge(['class' => 'w-full rounded-xl border border-slate-200 bg-white/90 px-3 py-2 text-sm text-slate-900 placeholder:text-slate-400 focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200']) }}
>{{ old($name, $value) }}</textarea>
