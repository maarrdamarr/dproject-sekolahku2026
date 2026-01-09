@props(['label' => null, 'name' => null, 'hint' => null, 'required' => false])

<div class="space-y-1">
    @if($label)
        <label for="{{ $name }}" class="text-sm font-medium text-slate-700">
            {{ $label }}@if($required) <span class="text-rose-600">*</span>@endif
        </label>
    @endif

    {{ $slot }}

    @if($hint)
        <p class="text-xs text-slate-500">{{ $hint }}</p>
    @endif

    @if($name && $errors->has($name))
        <p class="text-xs text-rose-600">{{ $errors->first($name) }}</p>
    @endif
</div>
