@extends('layouts.app')

@section('title', 'Edit Role')

@section('actions')
<a href="{{ route('admin.users.show', $managedUser) }}" class="rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 shadow-sm transition hover:border-blue-200 hover:text-blue-700">Back</a>
@endsection

@section('content')
<div class="grid gap-6 xl:grid-cols-[0.8fr_1.2fr]">
    <x-dashboard.panel title="User">
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
        <div class="mt-5 space-y-1">
            <x-dashboard.status-row label="Current Role" :value="str_replace('_', ' ', $managedUser->role)" tone="blue" />
            <x-dashboard.status-row label="Status" :value="$managedUser->is_active ? 'active' : 'inactive'" :tone="$managedUser->is_active ? 'green' : 'gray'" />
        </div>
    </x-dashboard.panel>

    <x-dashboard.panel title="Role Selector" description="Pilih akses baru untuk user">
        <form method="post" action="{{ route('admin.users.update', $managedUser) }}" class="grid gap-4">
            @csrf
            @method('PUT')

            <label class="grid gap-2">
                <span class="text-sm font-semibold text-gray-700">Role</span>
                <select name="role" class="rounded-lg border-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500">
                    @foreach ($roles as $role)
                        <option value="{{ $role }}" @selected(old('role', $managedUser->role) === $role)>{{ str_replace('_', ' ', $role) }}</option>
                    @endforeach
                </select>
            </label>

            <div class="flex flex-wrap gap-2">
                <button class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">Save Role</button>
                <a href="{{ route('admin.users.show', $managedUser) }}" class="rounded-lg border border-gray-200 px-4 py-2.5 text-sm font-semibold text-gray-700 transition hover:border-blue-200 hover:text-blue-700">Cancel</a>
            </div>
        </form>
    </x-dashboard.panel>
</div>
@endsection
