@extends('layouts.app')

@section('title', 'Feedback')

@section('actions')
<a href="{{ route('feedback.create') }}" class="rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm shadow-blue-200 transition hover:bg-blue-700">Kirim Feedback</a>
@endsection

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

<x-dashboard.panel title="Submitted Feedback" description="Status feedback dan balasan dari tim CRM">
    @if ($feedbacks->isEmpty())
        <div class="rounded-2xl border border-dashed border-gray-300 bg-gray-50 p-8 text-center">
            <h3 class="font-semibold text-gray-950">Belum ada feedback</h3>
            <p class="mt-1 text-sm text-gray-500">Bagikan pengalaman produk, pengiriman, service, atau pembayaran.</p>
            <a href="{{ route('feedback.create') }}" class="mt-4 inline-flex rounded-xl bg-gray-950 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700">Kirim Feedback</a>
        </div>
    @else
        <div class="grid gap-4">
            @foreach ($feedbacks as $feedback)
                <article class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm shadow-gray-200/70">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="rounded-full px-2.5 py-1 text-xs font-semibold ring-1 {{ $statusStyles[$feedback->status] ?? $statusStyles['pending'] }}">{{ ucfirst($feedback->status) }}</span>
                                <span class="rounded-full px-2.5 py-1 text-xs font-semibold ring-1 {{ $categoryStyles[$feedback->category] ?? $categoryStyles['other'] }}">{{ ucfirst($feedback->category) }}</span>
                                <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-700 ring-1 ring-gray-200">Rating {{ $feedback->rating }}/5</span>
                            </div>
                            <h3 class="mt-3 text-base font-semibold text-gray-950">{{ $feedback->title }}</h3>
                            <p class="mt-2 text-sm leading-6 text-gray-600">{{ $feedback->feedback }}</p>
                        </div>
                        <div class="shrink-0 text-left text-xs text-gray-500 sm:text-right">
                            <p>{{ $feedback->created_at->format('d M Y H:i') }}</p>
                            <p class="mt-1">{{ $feedback->order?->invoice_number ?: 'Tanpa order' }}</p>
                        </div>
                    </div>

                    @if ($feedback->admin_reply)
                        <div class="mt-4 rounded-2xl border border-blue-100 bg-blue-50 p-4">
                            <p class="text-xs font-semibold uppercase tracking-normal text-blue-700">Admin Reply</p>
                            <p class="mt-2 text-sm leading-6 text-blue-950">{{ $feedback->admin_reply }}</p>
                            @if ($feedback->replier)
                                <p class="mt-2 text-xs text-blue-700">Oleh {{ $feedback->replier->name }}{{ $feedback->replied_at ? ' pada '.$feedback->replied_at->format('d M Y H:i') : '' }}</p>
                            @endif
                        </div>
                    @endif
                </article>
            @endforeach
        </div>

        <div class="mt-5">{{ $feedbacks->links() }}</div>
    @endif
</x-dashboard.panel>
@endsection
