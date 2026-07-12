@extends('layouts.app')

@section('title', 'System Center')

@section('content')
@php
    $routeCard = function (string $title, ?string $route, string $description, string $status = 'Available') {
        $routeDefinition = $route ? \Illuminate\Support\Facades\Route::getRoutes()->getByName($route) : null;
        $isNavigable = $routeDefinition && in_array('GET', $routeDefinition->methods(), true);

        return [
            'title' => $title,
            'description' => $description,
            'href' => $isNavigable ? route($route) : null,
            'status' => $isNavigable ? $status : 'Unavailable',
            'disabled' => ! $isNavigable,
        ];
    };

    $cards = [
        $routeCard('User Management', 'admin.users.index', 'Roles, account status, and access controls'),
        $routeCard('Storage', 'storage.files', 'Administrative storage file collection'),
        [
            'title' => 'Integration',
            'description' => 'Integration readiness and configuration',
            'href' => null,
            'status' => $integrationStatus,
            'disabled' => false,
        ],
        [
            'title' => 'Webhook',
            'description' => 'Inbound integration endpoint details',
            'href' => null,
            'status' => 'POST only',
            'disabled' => false,
        ],
        $routeCard('Report Export', 'reports.exports.index', 'Export queue and report artifacts'),
        $routeCard('Settings', 'settings.index', 'System preferences and defaults'),
    ];
@endphp

<div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
    @foreach ($cards as $card)
        @if ($card['href'])
            <a href="{{ $card['href'] }}" class="group rounded-xl border border-gray-200 bg-white p-5 shadow-sm shadow-gray-200/70 transition hover:-translate-y-0.5 hover:border-blue-200 hover:shadow-lg hover:shadow-blue-100/70">
                <div class="flex items-start justify-between gap-4">
                    <div class="min-w-0">
                        <p class="truncate text-base font-semibold text-gray-950 group-hover:text-blue-700">{{ $card['title'] }}</p>
                        <p class="mt-2 text-sm leading-6 text-gray-500">{{ $card['description'] }}</p>
                    </div>
                    <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-emerald-100">{{ $card['status'] }}</span>
                </div>
            </a>
        @else
            <article class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm shadow-gray-200/70 {{ $card['disabled'] ? 'opacity-70' : '' }}">
                <div class="flex items-start justify-between gap-4">
                    <div class="min-w-0">
                        <p class="truncate text-base font-semibold text-gray-950">{{ $card['title'] }}</p>
                        <p class="mt-2 text-sm leading-6 text-gray-500">{{ $card['description'] }}</p>
                    </div>
                    <span class="rounded-full px-2.5 py-1 text-xs font-semibold ring-1 {{ $card['disabled'] ? 'bg-gray-100 text-gray-600 ring-gray-200' : 'bg-blue-50 text-blue-700 ring-blue-100' }}">{{ $card['status'] }}</span>
                </div>
            </article>
        @endif
    @endforeach
</div>

<x-dashboard.panel title="Webhook" description="Inbound integration status" class="mt-6">
    <div class="grid gap-4 lg:grid-cols-2">
        <div class="rounded-xl border border-gray-100 bg-gray-50/70 p-4">
            <p class="text-xs font-semibold uppercase tracking-normal text-gray-400">Webhook Endpoint</p>
            <p class="mt-2 break-all font-mono text-sm font-semibold text-gray-950">{{ $webhookEndpoint }}</p>
        </div>
        <div class="rounded-xl border border-gray-100 bg-gray-50/70 p-4">
            <p class="text-xs font-semibold uppercase tracking-normal text-gray-400">Integration Status</p>
            <p class="mt-2 text-sm font-semibold text-gray-950">{{ $integrationStatus }}</p>
        </div>
        <div class="rounded-xl border border-gray-100 bg-gray-50/70 p-4">
            <p class="text-xs font-semibold uppercase tracking-normal text-gray-400">Webhook Secret</p>
            <p class="mt-2 text-sm font-semibold text-gray-950">{{ $webhookSecretStatus }}</p>
        </div>
        <div class="rounded-xl border border-gray-100 bg-gray-50/70 p-4">
            <p class="text-xs font-semibold uppercase tracking-normal text-gray-400">Last Delivery</p>
            <p class="mt-2 text-sm font-semibold text-gray-950">{{ $lastDelivery }}</p>
        </div>
    </div>
</x-dashboard.panel>
@endsection
