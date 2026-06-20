@extends('layouts.app')

@section('title', $customer->name)
@section('actions')
<div class="flex gap-2">
    <a href="{{ route('customers.edit', $customer) }}" class="rounded bg-moss px-4 py-2 text-sm font-semibold text-white">Edit Customer</a>
    <a href="{{ route('customers.timeline', $customer) }}" class="rounded bg-ink px-4 py-2 text-sm font-semibold text-white">Timeline</a>
    <a href="{{ route('customers.index') }}" class="rounded bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-600">Kembali</a>
</div>
@endsection

@section('content')
<div class="grid gap-6 lg:grid-cols-[1fr_380px]">
    <div class="space-y-6">
        <section class="rounded-lg bg-white p-5 shadow-sm">
            <div class="grid gap-4 text-sm md:grid-cols-2">
                <div><p class="text-gray-500">Email</p><p class="font-semibold">{{ $customer->email ?: '-' }}</p></div>
                <div><p class="text-gray-500">Telepon</p><p class="font-semibold">{{ $customer->phone ?: '-' }}</p></div>
                <div><p class="text-gray-500">Perusahaan</p><p class="font-semibold">{{ $customer->company ?: '-' }}</p></div>
                <div><p class="text-gray-500">Status</p><p class="font-semibold">{{ $customer->status }}</p></div>
                <div><p class="text-gray-500">Source</p><p class="font-semibold">{{ $customer->source }}</p></div>
                <div><p class="text-gray-500">User Terkait</p><p class="font-semibold">{{ $customer->user?->name ?: '-' }}</p></div>
            </div>
            @if ($customer->notes)
                <div class="mt-4 border-t pt-4 text-sm">
                    <p class="text-gray-500">Catatan</p>
                    <p class="mt-1 whitespace-pre-line">{{ $customer->notes }}</p>
                </div>
            @endif
        </section>

        <section class="rounded-lg bg-white p-5 shadow-sm">
            <h2 class="mb-4 font-bold">Timeline Interaksi</h2>
            <form method="post" action="{{ route('customers.interactions.store', $customer) }}" class="mb-5 grid gap-3">
                @csrf
                <div class="grid gap-3 md:grid-cols-3">
                    <select name="type" required class="rounded border-gray-300">
                        @foreach (['note' => 'Catatan', 'call' => 'Telepon', 'email' => 'Email', 'meeting' => 'Meeting', 'chat' => 'Chat', 'order' => 'Order'] as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    <input name="occurred_at" type="datetime-local" class="rounded border-gray-300">
                    <input name="summary" required placeholder="Ringkasan" class="rounded border-gray-300 md:col-span-1">
                </div>
                <textarea name="description" rows="3" placeholder="Detail interaksi" class="rounded border-gray-300"></textarea>
                <button class="w-fit rounded bg-ink px-4 py-2 text-sm font-semibold text-white">Catat Interaksi</button>
            </form>

            <div class="space-y-3">
                @forelse ($customer->interactions->sortByDesc('occurred_at') as $interaction)
                    <div class="border-t pt-3 text-sm">
                        <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
                            <strong>{{ $interaction->summary }}</strong>
                            <span class="text-xs text-gray-500">{{ $interaction->occurred_at->format('d M Y H:i') }} oleh {{ $interaction->user->name }}</span>
                        </div>
                        <p class="mt-1 text-xs uppercase text-moss">{{ $interaction->type }}</p>
                        @if ($interaction->description)
                            <p class="mt-2 whitespace-pre-line text-gray-600">{{ $interaction->description }}</p>
                        @endif
                    </div>
                @empty
                    <p class="text-sm text-gray-500">Belum ada interaksi.</p>
                @endforelse
            </div>
        </section>
    </div>

    <aside class="space-y-6">
        <section class="rounded-lg bg-white p-5 shadow-sm">
            <h2 class="mb-4 font-bold">Buat Follow Up</h2>
            <form method="post" action="{{ route('customers.follow-ups.store', $customer) }}" class="grid gap-3 text-sm">
                @csrf
                <input name="title" required placeholder="Judul follow up" class="rounded border-gray-300">
                <select name="assigned_to" required class="rounded border-gray-300">
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" @selected($user->id === auth()->id())>{{ $user->name }}</option>
                    @endforeach
                </select>
                <input name="due_at" type="datetime-local" class="rounded border-gray-300">
                <textarea name="description" rows="3" placeholder="Detail follow up" class="rounded border-gray-300"></textarea>
                <button class="rounded bg-moss px-4 py-2 font-semibold text-white">Buat Follow Up</button>
            </form>
        </section>

        <section class="rounded-lg bg-white p-5 shadow-sm">
            <h2 class="mb-4 font-bold">Follow Up</h2>
            <div class="space-y-4">
                @forelse ($customer->followUps->sortByDesc('created_at') as $followUp)
                    <div class="border-t pt-4 text-sm first:border-t-0 first:pt-0">
                        <form method="post" action="{{ route('follow-ups.update', $followUp) }}" class="grid gap-2">
                            @csrf @method('PUT')
                            <input name="title" value="{{ $followUp->title }}" required class="rounded border-gray-300">
                            <select name="assigned_to" required class="rounded border-gray-300">
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" @selected($followUp->assigned_to === $user->id)>{{ $user->name }}</option>
                                @endforeach
                            </select>
                            <select name="status" required class="rounded border-gray-300">
                                <option value="open" @selected($followUp->status === 'open')>Open</option>
                                <option value="done" @selected($followUp->status === 'done')>Done</option>
                                <option value="cancelled" @selected($followUp->status === 'cancelled')>Cancelled</option>
                            </select>
                            <input name="due_at" type="datetime-local" value="{{ $followUp->due_at?->format('Y-m-d\TH:i') }}" class="rounded border-gray-300">
                            <textarea name="description" rows="2" class="rounded border-gray-300">{{ $followUp->description }}</textarea>
                            <div class="flex gap-2">
                                <button class="rounded bg-ink px-3 py-2 text-xs font-semibold text-white">Update</button>
                                @if ($followUp->status !== 'done')
                                    <button form="complete-follow-up-{{ $followUp->id }}" class="rounded bg-moss px-3 py-2 text-xs font-semibold text-white">Selesai</button>
                                @endif
                            </div>
                        </form>
                        @if ($followUp->status !== 'done')
                            <form id="complete-follow-up-{{ $followUp->id }}" method="post" action="{{ route('follow-ups.complete', $followUp) }}" class="hidden">
                                @csrf @method('PATCH')
                            </form>
                        @endif
                    </div>
                @empty
                    <p class="text-sm text-gray-500">Belum ada follow up.</p>
                @endforelse
            </div>
        </section>
    </aside>
</div>
@endsection
