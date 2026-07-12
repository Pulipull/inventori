@extends('layouts.app')

@section('title', 'View User')

@section('actions')
<div class="flex flex-wrap gap-2">
    <a href="{{ route('admin.users.index') }}" class="rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 shadow-sm transition hover:border-blue-200 hover:text-blue-700">Back</a>
    <a href="{{ route('admin.users.edit', $managedUser) }}" class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">Edit Role</a>
</div>
@endsection

@section('content')
<div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
    <x-dashboard.stat-card label="Role" :value="str_replace('_', ' ', $managedUser->role)" hint="Current access level" tone="blue" />
    <x-dashboard.stat-card label="Status" :value="$managedUser->is_active ? 'active' : 'inactive'" hint="Administrative status" :tone="$managedUser->is_active ? 'green' : 'gray'" />
    <x-dashboard.stat-card label="Login" :value="$managedUser->google_id ? 'Google' : 'Email'" hint="Registration source" tone="amber" />
    <x-dashboard.stat-card label="Joined" :value="$managedUser->created_at->format('d M Y')" hint="Account created" tone="gray" />
</div>

<div class="mt-6 grid gap-6 xl:grid-cols-[0.8fr_1.2fr]">
    <x-dashboard.panel title="Profile">
        <div class="flex items-center gap-4">
            @if ($managedUser->avatar)
                <img src="{{ $managedUser->avatar }}" alt="{{ $managedUser->name }}" class="h-16 w-16 rounded-full object-cover">
            @else
                <span class="grid h-16 w-16 place-items-center rounded-full bg-blue-600 text-xl font-semibold text-white">
                    {{ mb_substr($managedUser->name, 0, 1) }}
                </span>
            @endif
            <div class="min-w-0">
                <p class="truncate text-lg font-semibold text-gray-950">{{ $managedUser->name }}</p>
                <p class="truncate text-sm text-gray-500">{{ $managedUser->email }}</p>
            </div>
        </div>
    </x-dashboard.panel>

    <x-dashboard.panel title="Account Detail">
        <div class="space-y-1">
            <x-dashboard.status-row label="Email Verified" :value="$managedUser->email_verified_at ? $managedUser->email_verified_at->format('d M Y') : '-'" :tone="$managedUser->email_verified_at ? 'green' : 'gray'" />
            <x-dashboard.status-row label="Google OAuth" :value="$managedUser->google_id ? 'connected' : 'not connected'" :tone="$managedUser->google_id ? 'green' : 'gray'" />
            <x-dashboard.status-row label="Last Updated" :value="$managedUser->updated_at->format('d M Y')" tone="blue" />
        </div>
    </x-dashboard.panel>
</div>

<x-dashboard.panel title="Actions" description="Status dan penghapusan user" class="mt-6">
    <div class="flex flex-wrap gap-2">
        @if ($managedUser->is_active)
            <form method="post" action="{{ route('admin.users.deactivate', $managedUser) }}">
                @csrf
                @method('PATCH')
                <button class="rounded-lg border border-amber-200 px-4 py-2.5 text-sm font-semibold text-amber-700 transition hover:bg-amber-50">Deactivate</button>
            </form>
        @else
            <form method="post" action="{{ route('admin.users.activate', $managedUser) }}">
                @csrf
                @method('PATCH')
                <button class="rounded-lg border border-emerald-200 px-4 py-2.5 text-sm font-semibold text-emerald-700 transition hover:bg-emerald-50">Activate</button>
            </form>
        @endif
        <form method="post" action="{{ route('admin.users.destroy', $managedUser) }}" onsubmit="return confirm('Delete this user?')">
            @csrf
            @method('DELETE')
            <button class="rounded-lg border border-rose-200 px-4 py-2.5 text-sm font-semibold text-rose-700 transition hover:bg-rose-50">Delete</button>
        </form>
    </div>
</x-dashboard.panel>
@endsection
