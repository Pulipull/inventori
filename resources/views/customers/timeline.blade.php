@extends('layouts.app')

@section('title', 'Timeline '.$customer->name)
@section('actions')
<a href="{{ route('customers.show', $customer) }}" class="rounded bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-600">Kembali</a>
@endsection

@section('content')
<div class="space-y-3">
    @forelse ($activities as $activity)
        <div class="rounded-lg bg-white p-4 text-sm shadow-sm">
            <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
                <strong>{{ $activity->type }}</strong>
                <span class="text-xs text-gray-500">{{ $activity->created_at?->format('d M Y H:i') }} oleh {{ $activity->creator?->name ?: '-' }}</span>
            </div>
            @if ($activity->description)
                <p class="mt-2 text-gray-600">{{ $activity->description }}</p>
            @endif
        </div>
    @empty
        <p class="rounded-lg bg-white p-5 text-sm text-gray-500 shadow-sm">Belum ada aktivitas CRM.</p>
    @endforelse
    {{ $activities->links() }}
</div>
@endsection
