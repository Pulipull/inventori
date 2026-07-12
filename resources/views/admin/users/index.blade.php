@extends('layouts.app')

@section('title', 'User Management')

@section('content')
@php
    $roleStyles = [
        'guest' => 'bg-gray-100 text-gray-700 ring-gray-200',
        'user' => 'bg-sky-50 text-sky-700 ring-sky-100',
        'admin' => 'bg-violet-50 text-violet-700 ring-violet-100',
        'super_admin' => 'bg-amber-50 text-amber-800 ring-amber-100',
    ];
@endphp

<div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
    <x-dashboard.stat-card label="Total User" :value="$stats['total']" hint="User aktif dan inactive" tone="blue" />
    <x-dashboard.stat-card label="Active" :value="$stats['active']" hint="Akun aktif" tone="green" />
    <x-dashboard.stat-card label="Inactive" :value="$stats['inactive']" hint="Akun dinonaktifkan" tone="gray" />
    <x-dashboard.stat-card label="Super Admin" :value="$stats['super_admin']" hint="Akses sistem penuh" tone="amber" />
</div>

<x-dashboard.panel title="User List" description="Search, filter, and manage account access" class="mt-6 rounded-2xl shadow-md shadow-gray-200/70">
    <form class="grid gap-3 rounded-2xl border border-gray-100 bg-gray-50/70 p-3 lg:grid-cols-[minmax(260px,1fr)_180px_180px_auto]">
        <label class="relative block">
            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 3.473 9.766l2.631 2.63a.75.75 0 1 0 1.061-1.06l-2.63-2.632A5.5 5.5 0 0 0 9 3.5ZM5 9a4 4 0 1 1 8 0 4 4 0 0 1-8 0Z" clip-rule="evenodd" />
                </svg>
            </span>
            <input
                name="search"
                value="{{ request('search') }}"
                placeholder="Search name or email"
                class="h-11 w-full rounded-xl border-gray-200 bg-white pl-9 text-sm shadow-sm shadow-gray-200/60 focus:border-blue-500 focus:ring-blue-500"
            >
        </label>
        <select name="role" class="h-11 rounded-xl border-gray-200 bg-white text-sm shadow-sm shadow-gray-200/60 focus:border-blue-500 focus:ring-blue-500">
            <option value="">All roles</option>
            @foreach ($roles as $role)
                <option value="{{ $role }}" @selected(request('role') === $role)>{{ str_replace('_', ' ', $role) }}</option>
            @endforeach
        </select>
        <select name="status" class="h-11 rounded-xl border-gray-200 bg-white text-sm shadow-sm shadow-gray-200/60 focus:border-blue-500 focus:ring-blue-500">
            <option value="">All status</option>
            <option value="active" @selected(request('status') === 'active')>active</option>
            <option value="inactive" @selected(request('status') === 'inactive')>inactive</option>
        </select>
        <button class="h-11 rounded-xl bg-gray-950 px-4 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">Search</button>
    </form>

    <div class="mt-5 overflow-x-auto rounded-2xl border border-gray-100 shadow-sm shadow-gray-200/60">
        <table class="w-full min-w-[920px] text-left text-sm">
            <thead class="bg-gray-50/90">
                <tr class="text-xs font-semibold uppercase tracking-normal text-gray-500">
                    <th class="px-4 py-3">User</th>
                    <th class="px-4 py-3">Role</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Login</th>
                    <th class="px-4 py-3">Joined</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                @forelse ($users as $managedUser)
                    <tr class="transition hover:bg-blue-50/50">
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-3">
                                @if ($managedUser->avatar)
                                    <img src="{{ $managedUser->avatar }}" alt="{{ $managedUser->name }}" class="h-11 w-11 rounded-full object-cover ring-2 ring-white shadow-md shadow-gray-200/80">
                                @else
                                    <span class="grid h-11 w-11 place-items-center rounded-full bg-gradient-to-br from-blue-600 to-slate-900 text-sm font-semibold text-white shadow-md shadow-blue-200/80">
                                        {{ mb_substr($managedUser->name, 0, 1) }}
                                    </span>
                                @endif
                                <div class="min-w-0">
                                    <a href="{{ route('admin.users.show', $managedUser) }}" class="block truncate font-semibold text-gray-950 hover:text-blue-700">{{ $managedUser->name }}</a>
                                    <p class="truncate text-xs text-gray-500">{{ $managedUser->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold ring-1 {{ $roleStyles[$managedUser->role] ?? $roleStyles['guest'] }}">
                                {{ str_replace('_', ' ', $managedUser->role) }}
                            </span>
                        </td>
                        <td class="px-4 py-4">
                            <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold ring-1 {{ $managedUser->is_active ? 'bg-emerald-50 text-emerald-700 ring-emerald-100' : 'bg-gray-100 text-gray-600 ring-gray-200' }}">
                                <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
                                {{ $managedUser->is_active ? 'active' : 'inactive' }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-gray-600">{{ $managedUser->google_id ? 'Google OAuth' : 'Email' }}</td>
                        <td class="px-4 py-4 text-gray-500">{{ $managedUser->created_at->format('d M Y') }}</td>
                        <td class="px-4 py-4 text-right">
                            <details class="relative inline-block text-left">
                                <summary class="list-none rounded-xl border border-gray-200 bg-white px-3 py-2 text-xs font-semibold text-gray-700 shadow-sm transition hover:border-blue-200 hover:text-blue-700 [&::-webkit-details-marker]:hidden">
                                    Actions
                                </summary>
                                <div class="absolute right-0 z-30 mt-2 w-44 overflow-hidden rounded-xl border border-gray-200 bg-white py-1 text-left shadow-lg shadow-gray-200/80">
                                    <a href="{{ route('admin.users.show', $managedUser) }}" class="block px-3 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50">View User</a>
                                    <a href="{{ route('admin.users.edit', $managedUser) }}" class="block px-3 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50">Edit Role</a>
                                    @if ($managedUser->is_active)
                                        <form method="post" action="{{ route('admin.users.deactivate', $managedUser) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button class="block w-full px-3 py-2 text-left text-xs font-semibold text-amber-700 hover:bg-amber-50">Deactivate</button>
                                        </form>
                                    @else
                                        <form method="post" action="{{ route('admin.users.activate', $managedUser) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button class="block w-full px-3 py-2 text-left text-xs font-semibold text-emerald-700 hover:bg-emerald-50">Activate</button>
                                        </form>
                                    @endif
                                    <form method="post" action="{{ route('admin.users.destroy', $managedUser) }}" onsubmit="return confirm('Delete this user?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="block w-full px-3 py-2 text-left text-xs font-semibold text-rose-700 hover:bg-rose-50">Delete</button>
                                    </form>
                                </div>
                            </details>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-10 text-center text-sm text-gray-500">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-5">{{ $users->links() }}</div>
</x-dashboard.panel>
@endsection
