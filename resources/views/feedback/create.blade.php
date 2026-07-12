@extends('layouts.app')

@section('title', 'Kirim Feedback')

@section('actions')
<a href="{{ route('feedback.index') }}" class="rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 shadow-sm transition hover:border-blue-200 hover:text-blue-700">Kembali</a>
@endsection

@section('content')
<div class="grid gap-6 xl:grid-cols-[0.7fr_1.3fr]">
    <x-dashboard.panel title="Feedback Guide">
        <div class="space-y-3 text-sm leading-6 text-gray-600">
            <p>Pilih kategori yang paling sesuai agar tim CRM dapat menindaklanjuti pengalaman Anda dengan tepat.</p>
            <p>Feedback akan tersimpan sebagai data aftersales dan ditampilkan bersama status penanganannya.</p>
        </div>
    </x-dashboard.panel>

    <x-dashboard.panel title="Form Feedback" description="Rating, kategori, dan detail pengalaman">
        <form method="post" action="{{ route('feedback.store') }}" class="grid gap-4">
            @csrf

            <div class="grid gap-4 md:grid-cols-2">
                <label class="grid gap-2">
                    <span class="text-sm font-semibold text-gray-700">Rating</span>
                    <select name="rating" class="rounded-xl border-gray-200 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        @for ($rating = 5; $rating >= 1; $rating--)
                            <option value="{{ $rating }}" @selected((int) old('rating', 5) === $rating)>{{ $rating }} / 5</option>
                        @endfor
                    </select>
                </label>

                <label class="grid gap-2">
                    <span class="text-sm font-semibold text-gray-700">Category</span>
                    <select name="category" class="rounded-xl border-gray-200 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        @foreach ($categories as $category)
                            <option value="{{ $category }}" @selected(old('category') === $category)>{{ ucfirst($category) }}</option>
                        @endforeach
                    </select>
                </label>
            </div>

            <label class="grid gap-2">
                <span class="text-sm font-semibold text-gray-700">Order</span>
                <select name="order_id" class="rounded-xl border-gray-200 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Tanpa order spesifik</option>
                    @foreach ($orders as $order)
                        <option value="{{ $order->id }}" @selected((string) old('order_id') === (string) $order->id)>
                            {{ $order->invoice_number }} - {{ $order->item?->name ?? $order->description ?? 'Order' }}
                        </option>
                    @endforeach
                </select>
            </label>

            <label class="grid gap-2">
                <span class="text-sm font-semibold text-gray-700">Title</span>
                <input name="title" value="{{ old('title') }}" class="rounded-xl border-gray-200 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500" required maxlength="255">
            </label>

            <label class="grid gap-2">
                <span class="text-sm font-semibold text-gray-700">Feedback</span>
                <textarea name="feedback" rows="6" class="rounded-xl border-gray-200 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500" required>{{ old('feedback') }}</textarea>
            </label>

            <div class="flex flex-wrap gap-2">
                <button class="rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm shadow-blue-200 transition hover:bg-blue-700">Kirim Feedback</button>
                <a href="{{ route('feedback.index') }}" class="rounded-xl border border-gray-200 px-4 py-2.5 text-sm font-semibold text-gray-700 transition hover:border-blue-200 hover:text-blue-700">Cancel</a>
            </div>
        </form>
    </x-dashboard.panel>
</div>
@endsection
