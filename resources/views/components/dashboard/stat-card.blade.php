@props([
    'label',
    'value',
    'hint' => null,
    'tone' => 'blue',
])

@php
    $tones = [
        'blue' => 'bg-blue-50 text-blue-700 ring-blue-100',
        'gray' => 'bg-gray-100 text-gray-700 ring-gray-200',
        'green' => 'bg-emerald-50 text-emerald-700 ring-emerald-100',
        'amber' => 'bg-amber-50 text-amber-700 ring-amber-100',
        'red' => 'bg-rose-50 text-rose-700 ring-rose-100',
    ];
@endphp

<article {{ $attributes->merge(['class' => 'rounded-xl border border-gray-200 bg-white p-5 shadow-sm shadow-gray-200/60']) }}>
    <div class="flex items-start justify-between gap-4">
        <div class="min-w-0">
            <p class="text-sm font-medium text-gray-500">{{ $label }}</p>
            <p class="mt-2 break-words text-2xl font-semibold tracking-normal text-gray-950">{{ $value }}</p>
        </div>
        <span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl ring-1 {{ $tones[$tone] ?? $tones['blue'] }}">
            <span class="h-2.5 w-2.5 rounded-full bg-current"></span>
        </span>
    </div>

    @if ($hint)
        <p class="mt-3 text-xs font-medium text-gray-500">{{ $hint }}</p>
    @endif
</article>
