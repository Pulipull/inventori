@props([
    'title',
    'description' => null,
])

<section {{ $attributes->merge(['class' => 'rounded-xl border border-gray-200 bg-white shadow-sm shadow-gray-200/60']) }}>
    <div class="flex flex-col gap-1 border-b border-gray-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-base font-semibold text-gray-950">{{ $title }}</h2>
            @if ($description)
                <p class="mt-1 text-sm text-gray-500">{{ $description }}</p>
            @endif
        </div>
        @isset($actions)
            <div class="shrink-0">
                {{ $actions }}
            </div>
        @endisset
    </div>
    <div class="p-5">
        {{ $slot }}
    </div>
</section>
