@extends('layouts.app')

@section('title', 'Dashboard Operasional')

@section('actions')
<div class="flex flex-wrap gap-2">
    <a href="{{ route('transactions.create', 'in') }}" class="rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm shadow-blue-200 transition hover:bg-blue-700">Barang Masuk</a>
    <a href="{{ route('transactions.create', 'out') }}" class="rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 shadow-sm transition hover:border-blue-200 hover:text-blue-700">Barang Keluar</a>
</div>
@endsection

@section('content')
@php
    $isSuperAdmin = auth()->user()->role === 'super_admin';

    $stats = [
        ['Total Barang', $itemCount, 'Item aktif di inventori', 'blue'],
        ['Kategori', $categoryCount, 'Klasifikasi barang', 'gray'],
        ['Customer', $customerCount, 'Data CRM tersimpan', 'green'],
        ['Revenue', 'Rp '.number_format($paidRevenueTotal, 0, ',', '.'), 'Total pembayaran lunas', 'blue'],
        ['Order', $paidOrderCount, 'Order selesai', 'green'],
        ['Pending Payment', $pendingOrderCount, 'Menunggu pembayaran', 'amber'],
        ['Unread Notification', $unreadNotificationCount, 'Belum dibaca', 'red'],
        ['Low Stock', $lowStockCount, 'Perlu perhatian', 'amber'],
    ];

    $maxTrend = max(1, (float) $revenueTrend->max('total'));
@endphp

<div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
    @foreach ($stats as [$label, $value, $hint, $tone])
        <x-dashboard.stat-card :label="$label" :value="$value" :hint="$hint" :tone="$tone" />
    @endforeach
</div>

<div class="mt-6 grid gap-6 xl:grid-cols-[1.25fr_0.75fr]">
    <x-dashboard.panel title="Revenue Trend" description="Ringkasan pendapatan 7 hari terakhir">
        <div class="flex h-64 items-end gap-3 rounded-xl bg-gray-50 p-4">
            @foreach ($revenueTrend as $trend)
                <div class="flex min-w-0 flex-1 flex-col items-center gap-2">
                    <div class="flex h-44 w-full items-end rounded-full bg-white px-1.5 py-1.5 shadow-inner">
                        <div
                            class="w-full rounded-full bg-blue-600"
                            style="height: {{ max(8, ((float) $trend['total'] / $maxTrend) * 100) }}%"
                        ></div>
                    </div>
                    <div class="w-full text-center">
                        <p class="truncate text-xs font-medium text-gray-500">{{ $trend['date'] }}</p>
                        <p class="truncate text-xs font-semibold text-gray-900">Rp {{ number_format($trend['total'], 0, ',', '.') }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </x-dashboard.panel>

    <x-dashboard.panel title="Recent Orders" description="Status pembayaran terbaru">
        <div class="space-y-1">
            <x-dashboard.status-row label="Lunas" :value="$paidOrderCount" tone="green" meta="Order berhasil dibayar" />
            <x-dashboard.status-row label="Pending" :value="$pendingOrderCount" tone="amber" meta="Menunggu pembayaran" />
            <x-dashboard.status-row label="Gagal" :value="$failedPaymentCount" tone="red" meta="Pembayaran gagal" />
            <x-dashboard.status-row label="Expired" :value="$expiredPaymentCount" tone="gray" meta="Invoice kedaluwarsa" />
        </div>
    </x-dashboard.panel>
</div>

<div class="mt-6 grid gap-6 {{ $isSuperAdmin ? 'xl:grid-cols-4' : 'xl:grid-cols-2' }}">
    <x-dashboard.panel title="Recent Notifications" description="Kondisi komunikasi sistem">
        <div class="grid gap-3">
            <div class="rounded-xl bg-blue-50 p-4">
                <p class="text-sm font-medium text-blue-700">Notifikasi belum dibaca</p>
                <p class="mt-2 text-3xl font-semibold text-blue-950">{{ $unreadNotificationCount }}</p>
            </div>
            <a href="{{ route('notifications.index') }}" class="rounded-xl border border-gray-200 px-4 py-3 text-sm font-semibold text-gray-700 transition hover:border-blue-200 hover:text-blue-700">Buka notifikasi</a>
        </div>
    </x-dashboard.panel>

    <x-dashboard.panel title="Recent Chat" description="Aktivitas percakapan internal">
        <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-1">
            <x-dashboard.stat-card label="Percakapan Aktif" :value="$activeConversationCount" tone="blue" />
            <x-dashboard.stat-card label="Belum Dibaca" :value="$unreadConversationCount" tone="amber" />
            <a href="{{ route('chat.index') }}" class="rounded-xl bg-gray-950 px-4 py-3 text-center text-sm font-semibold text-white transition hover:bg-blue-700">Buka chat</a>
        </div>
    </x-dashboard.panel>

    @if ($isSuperAdmin)
        <x-dashboard.panel title="System Health" description="Storage dan integration">
            <div class="space-y-1">
                <x-dashboard.status-row label="Total File Upload" :value="$storageFileCount" tone="blue" />
                <x-dashboard.status-row label="Integration Pending" :value="$pendingIntegrationEventCount" tone="amber" />
                <x-dashboard.status-row label="Integration Processed" :value="$processedIntegrationEventCount" tone="green" />
                <x-dashboard.status-row label="Total Export" :value="$reportExportCount" tone="gray" />
            </div>
        </x-dashboard.panel>

        <x-dashboard.panel title="Feedback Statistics" description="Aftersales customer signal">
            <div class="space-y-1">
                <x-dashboard.status-row label="Pending" :value="$feedbackStats['pending']" tone="amber" />
                <x-dashboard.status-row label="Reviewed" :value="$feedbackStats['reviewed']" tone="blue" />
                <x-dashboard.status-row label="Resolved" :value="$feedbackStats['resolved']" tone="green" />
                <x-dashboard.status-row label="Average Rating" :value="number_format($feedbackStats['average_rating'], 1).'/5'" tone="gray" />
            </div>
        </x-dashboard.panel>
    @endif
</div>

<div class="mt-6 grid gap-6 xl:grid-cols-2">
    <x-dashboard.panel title="Transaksi Terbaru" description="Pergerakan barang terakhir">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-gray-100 text-xs font-semibold uppercase tracking-normal text-gray-400">
                        <th class="pb-3">Barang</th>
                        <th class="pb-3">User</th>
                        <th class="pb-3 text-right">Qty</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($recentTransactions as $transaction)
                        <tr>
                            <td class="py-3 pr-3 text-sm font-medium text-gray-900">{{ $transaction->item->name }}</td>
                            <td class="py-3 pr-3 text-sm text-gray-500">{{ $transaction->user->name }}</td>
                            <td class="py-3 text-right text-sm font-semibold {{ $transaction->type === 'in' ? 'text-emerald-700' : 'text-rose-700' }}">
                                {{ $transaction->type === 'in' ? '+' : '-' }}{{ $transaction->quantity }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-6 text-center text-sm text-gray-500">Belum ada transaksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-dashboard.panel>

    <x-dashboard.panel title="Stok Perlu Perhatian" description="Barang di bawah minimum atau habis">
        <div class="space-y-1">
            @forelse ($lowItems as $item)
                <x-dashboard.status-row
                    :label="$item->name"
                    :value="$item->stock.' '.$item->unit"
                    :meta="$item->category->name ?? 'Tanpa kategori'"
                    :tone="$item->stock <= 0 ? 'red' : 'amber'"
                />
            @empty
                <p class="rounded-xl bg-gray-50 px-4 py-6 text-center text-sm text-gray-500">Semua stok aman.</p>
            @endforelse
        </div>
    </x-dashboard.panel>
</div>

<div class="mt-6 grid gap-6 {{ $isSuperAdmin ? 'xl:grid-cols-3' : 'xl:grid-cols-1' }}">
    @if ($isSuperAdmin)
        <x-dashboard.panel title="Export Laporan Terbaru">
            <div class="space-y-1">
                @forelse ($recentReportExports as $export)
                    <x-dashboard.status-row
                        :label="$export->report_type"
                        :value="$export->status"
                        :meta="'oleh '.$export->user->name"
                        :tone="$export->status === 'completed' ? 'green' : ($export->status === 'failed' ? 'red' : 'amber')"
                    />
                @empty
                    <p class="rounded-xl bg-gray-50 px-4 py-6 text-center text-sm text-gray-500">Belum ada export laporan.</p>
                @endforelse
            </div>
        </x-dashboard.panel>

        <x-dashboard.panel title="Webhook Integration Terbaru">
            <div class="space-y-1">
                @forelse ($recentWebhookLogs as $log)
                    <x-dashboard.status-row
                        :label="$log->source"
                        :value="$log->status"
                        :meta="$log->event_name"
                        :tone="$log->status === 'received' ? 'green' : 'red'"
                    />
                @empty
                    <p class="rounded-xl bg-gray-50 px-4 py-6 text-center text-sm text-gray-500">Belum ada webhook integration.</p>
                @endforelse
            </div>
        </x-dashboard.panel>
    @endif

    <x-dashboard.panel title="Aktivitas CRM Terbaru">
        <div class="space-y-1">
            @forelse ($recentCrmActivities as $activity)
                <x-dashboard.status-row
                    :label="$activity->customer?->name ?: '-'"
                    :value="$activity->type"
                    :meta="$activity->description ?: $activity->type"
                    tone="blue"
                />
            @empty
                <p class="rounded-xl bg-gray-50 px-4 py-6 text-center text-sm text-gray-500">Belum ada aktivitas CRM.</p>
            @endforelse
        </div>
    </x-dashboard.panel>
</div>
@endsection
