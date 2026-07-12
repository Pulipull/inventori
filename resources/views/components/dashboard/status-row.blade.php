@props([
    'label',
    'value',
    'tone' => 'gray',
    'meta' => null,
])

@php
    $tones = [
        'blue' => 'bg-blue-50 text-blue-700',
        'green' => 'bg-emerald-50 text-emerald-700',
        'amber' => 'bg-amber-50 text-amber-700',
        'red' => 'bg-rose-50 text-rose-700',
        'gray' => 'bg-gray-100 text-gray-700',
    ];
@endphp

<div class="flex items-center justify-between gap-4 border-b border-gray-100 py-3 last:border-0">
    <div class="min-w-0">
        <p class="truncate text-sm font-medium text-gray-800">{{ $label }}</p>
        @if ($meta)
            <p class="mt-0.5 truncate text-xs text-gray-500">{{ $meta }}</p>
        @endif
    </div>
    <span class="shrink-0 rounded-full px-2.5 py-1 text-xs font-semibold {{ $tones[$tone] ?? $tones['gray'] }}">
        {{ $value }}
    </span>
</div>
