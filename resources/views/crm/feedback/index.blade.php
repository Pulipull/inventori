@extends('layouts.app')

@section('title', 'CRM Feedback')

@section('content')
@php
    $statusStyles = [
        'pending' => 'bg-amber-50 text-amber-700 ring-amber-100',
        'reviewed' => 'bg-blue-50 text-blue-700 ring-blue-100',
        'resolved' => 'bg-emerald-50 text-emerald-700 ring-emerald-100',
    ];

    $categoryStyles = [
        'product' => 'bg-sky-50 text-sky-700 ring-sky-100',
        'delivery' => 'bg-violet-50 text-violet-700 ring-violet-100',
        'service' => 'bg-emerald-50 text-emerald-700 ring-emerald-100',
        'payment' => 'bg-amber-50 text-amber-700 ring-amber-100',
        'other' => 'bg-gray-100 text-gray-700 ring-gray-200',
    ];
@endphp

<x-dashboard.panel title="Feedback Management" description="Search, filter, reply, and resolve customer feedback">
    <form class="grid gap-3 rounded-2xl border border-gray-100 bg-gray-50/70 p-3 xl:grid-cols-[minmax(260px,1fr)_160px_160px_130px_auto]">
        <input name="search" value="{{ request('search') }}" placeholder="Search customer, email, invoice, or feedback" class="h-11 rounded-xl border-gray-200 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500">
        <select name="category" class="h-11 rounded-xl border-gray-200 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500">
            <option value="">All categories</option>
            @foreach ($categories as $category)
                <option value="{{ $category }}" @selected(request('category') === $category)>{{ ucfirst($category) }}</option>
            @endforeach
        </select>
        <select name="status" class="h-11 rounded-xl border-gray-200 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500">
            <option value="">All status</option>
            @foreach ($statuses as $status)
                <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
            @endforeach
        </select>
        <select name="rating" class="h-11 rounded-xl border-gray-200 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500">
            <option value="">All rating</option>
            @for ($rating = 5; $rating >= 1; $rating--)
                <option value="{{ $rating }}" @selected((string) request('rating') === (string) $rating)>{{ $rating }} / 5</option>
            @endfor
        </select>
        <button class="h-11 rounded-xl bg-gray-950 px-4 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">Search</button>
    </form>

    <div class="mt-5 grid gap-4">
        @forelse ($feedbacks as $feedback)
            <article class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm shadow-gray-200/70">
                <div class="flex flex-col gap-4 xl:flex-row xl:items-start xl:justify-between">
                    <div class="min-w-0 flex-1">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="rounded-full px-2.5 py-1 text-xs font-semibold ring-1 {{ $statusStyles[$feedback->status] ?? $statusStyles['pending'] }}">{{ ucfirst($feedback->status) }}</span>
                            <span class="rounded-full px-2.5 py-1 text-xs font-semibold ring-1 {{ $categoryStyles[$feedback->category] ?? $categoryStyles['other'] }}">{{ ucfirst($feedback->category) }}</span>
                            <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-700 ring-1 ring-gray-200">Rating {{ $feedback->rating }}/5</span>
                        </div>
                        <h3 class="mt-3 text-base font-semibold text-gray-950">{{ $feedback->title }}</h3>
                        <p class="mt-2 text-sm leading-6 text-gray-600">{{ $feedback->feedback }}</p>

                        <div class="mt-4 grid gap-3 text-sm text-gray-600 md:grid-cols-3">
                            <div class="rounded-xl bg-gray-50 p-3">
                                <p class="text-xs font-semibold uppercase tracking-normal text-gray-400">Customer</p>
                                <p class="mt-1 font-semibold text-gray-950">{{ $feedback->customer?->name ?? $feedback->user?->name ?? '-' }}</p>
                                <p class="mt-0.5 truncate text-xs text-gray-500">{{ $feedback->customer?->email ?? $feedback->user?->email ?? '-' }}</p>
                            </div>
                            <div class="rounded-xl bg-gray-50 p-3">
                                <p class="text-xs font-semibold uppercase tracking-normal text-gray-400">Order</p>
                                <p class="mt-1 font-semibold text-gray-950">{{ $feedback->order?->invoice_number ?: '-' }}</p>
                                <p class="mt-0.5 truncate text-xs text-gray-500">{{ $feedback->order?->item?->name ?? $feedback->order?->description ?? 'No linked order' }}</p>
                            </div>
                            <div class="rounded-xl bg-gray-50 p-3">
                                <p class="text-xs font-semibold uppercase tracking-normal text-gray-400">Submitted</p>
                                <p class="mt-1 font-semibold text-gray-950">{{ $feedback->created_at->format('d M Y') }}</p>
                                <p class="mt-0.5 text-xs text-gray-500">{{ $feedback->created_at->format('H:i') }}</p>
                            </div>
                        </div>

                        @if ($feedback->admin_reply)
                            <div class="mt-4 rounded-2xl border border-blue-100 bg-blue-50 p-4">
                                <p class="text-xs font-semibold uppercase tracking-normal text-blue-700">Current Reply</p>
                                <p class="mt-2 text-sm leading-6 text-blue-950">{{ $feedback->admin_reply }}</p>
                                <p class="mt-2 text-xs text-blue-700">{{ $feedback->replier?->name ?: 'Admin' }}{{ $feedback->replied_at ? ' - '.$feedback->replied_at->format('d M Y H:i') : '' }}</p>
                            </div>
                        @endif
                    </div>

                    <form method="post" action="{{ route('crm.feedback.update', $feedback) }}" class="w-full shrink-0 rounded-2xl border border-gray-100 bg-gray-50/80 p-4 xl:w-80">
                        @csrf
                        @method('PATCH')
                        <div class="grid gap-3">
                            <label class="grid gap-2">
                                <span class="text-xs font-semibold uppercase tracking-normal text-gray-500">Status</span>
                                <select name="status" class="rounded-xl border-gray-200 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status }}" @selected($feedback->status === $status)>{{ ucfirst($status) }}</option>
                                    @endforeach
                                </select>
                            </label>
                            <label class="grid gap-2">
                                <span class="text-xs font-semibold uppercase tracking-normal text-gray-500">Reply</span>
                                <textarea name="admin_reply" rows="5" class="rounded-xl border-gray-200 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('admin_reply', $feedback->admin_reply) }}</textarea>
                            </label>
                            <button class="rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm shadow-blue-200 transition hover:bg-blue-700">Save Reply</button>
                        </div>
                    </form>
                </div>

                @if ($feedback->status !== 'resolved')
                    <form method="post" action="{{ route('crm.feedback.resolve', $feedback) }}" class="mt-4">
                        @csrf
                        @method('PATCH')
                        <button class="rounded-xl border border-emerald-200 px-4 py-2.5 text-sm font-semibold text-emerald-700 transition hover:bg-emerald-50">Mark Resolved</button>
                    </form>
                @endif
            </article>
        @empty
            <div class="rounded-2xl border border-dashed border-gray-300 bg-gray-50 p-8 text-center text-sm text-gray-500">
                Belum ada feedback customer.
            </div>
        @endforelse
    </div>

    <div class="mt-5">{{ $feedbacks->links() }}</div>
</x-dashboard.panel>
@endsection
