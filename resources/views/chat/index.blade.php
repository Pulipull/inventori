@extends('layouts.app')

@section('title', 'Chat Internal')

@section('content')
<div class="mb-4 grid gap-4 sm:grid-cols-2">
    <div class="rounded-lg bg-white p-4 shadow-sm">
        <p class="text-sm text-gray-500">Percakapan Aktif</p>
        <p class="mt-2 text-2xl font-bold">{{ $metrics['active_conversations'] }}</p>
    </div>
    <div class="rounded-lg bg-white p-4 shadow-sm">
        <p class="text-sm text-gray-500">Percakapan Belum Dibaca</p>
        <p class="mt-2 text-2xl font-bold">{{ $metrics['unread_conversations'] }}</p>
    </div>
</div>
<form method="post" action="{{ route('chat.start') }}" class="mb-6 flex gap-2 rounded-lg bg-white p-4 shadow-sm">
    @csrf
    <select name="user_id" class="w-full rounded border-gray-300">
        @foreach ($users as $user)
            <option value="{{ $user->id }}">{{ $user->name }} - {{ $user->role }}</option>
        @endforeach
    </select>
    <button class="rounded bg-moss px-4 py-2 font-semibold text-white">Mulai</button>
</form>
<div class="grid gap-3">
    @forelse ($conversations as $conversation)
        <a href="{{ route('chat.show', $conversation) }}" class="rounded-lg bg-white p-4 shadow-sm hover:ring-2 hover:ring-moss/20">
            <div class="flex items-start justify-between gap-3">
                <strong>{{ $conversation->otherUser(auth()->user())->name }}</strong>
                @if ($conversation->unread_messages_count > 0)
                    <span class="rounded bg-coral px-2 py-1 text-xs font-semibold text-white">{{ $conversation->unread_messages_count }}</span>
                @endif
            </div>
            <p class="mt-1 text-sm text-gray-500">{{ $conversation->latestMessage?->body ?? 'Belum ada pesan.' }}</p>
        </a>
    @empty
        <p class="rounded-lg bg-white p-5 text-sm text-gray-500 shadow-sm">Belum ada percakapan.</p>
    @endforelse
</div>
@endsection
