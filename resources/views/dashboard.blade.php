@extends('layouts.app')

@section('title', 'Dashboard')
@section('actions')
<div class="flex gap-2">
    <a href="{{ route('transactions.create', 'in') }}" class="rounded bg-moss px-4 py-2 text-sm font-semibold text-white">Barang Masuk</a>
    <a href="{{ route('transactions.create', 'out') }}" class="rounded bg-coral px-4 py-2 text-sm font-semibold text-white">Barang Keluar</a>
</div>
@endsection

@section('content')
<div class="grid gap-4 md:grid-cols-4">
    @foreach ([['Barang', $itemCount], ['Kategori', $categoryCount], ['Customer', $customerCount], ['Follow Up Open', $openFollowUpCount], ['Follow Up Selesai', $completedFollowUpCount], ['Total Export', $reportExportCount], ['Penjualan Hari Ini', $todaySalesCount], ['Pendapatan Hari Ini', 'Rp '.number_format($todayRevenueTotal, 0, ',', '.')], ['Pendapatan Bulan Ini', 'Rp '.number_format($monthlyRevenueTotal, 0, ',', '.')], ['Order Selesai', $paidOrderCount], ['Pembayaran Pending', $pendingOrderCount], ['Pembayaran Gagal', $failedPaymentCount], ['Total Pendapatan', 'Rp '.number_format($paidRevenueTotal, 0, ',', '.')], ['Total File Upload', $storageFileCount], ['Integration Pending', $pendingIntegrationEventCount], ['Integration Processed', $processedIntegrationEventCount], ['Notifikasi Belum Dibaca', $unreadNotificationCount], ['Percakapan Aktif', $activeConversationCount], ['Percakapan Belum Dibaca', $unreadConversationCount], ['Stok Menipis', $lowStockCount], ['Stok Habis', $emptyStockCount]] as [$label, $value])
        <div class="rounded-lg bg-white p-5 shadow-sm">
            <p class="text-sm text-gray-500">{{ $label }}</p>
            <p class="mt-2 text-3xl font-bold">{{ $value }}</p>
        </div>
    @endforeach
</div>
<div class="mt-6 grid gap-6 lg:grid-cols-2">
    <section class="rounded-lg bg-white p-5 shadow-sm">
        <h2 class="mb-4 font-bold">Ringkasan Status Pembayaran</h2>
        <div class="space-y-3">
            @foreach ([['Lunas', $paidOrderCount, 'text-moss'], ['Pending', $pendingOrderCount, 'text-amber'], ['Gagal', $failedPaymentCount, 'text-coral'], ['Expired', $expiredPaymentCount, 'text-gray-500']] as [$label, $value, $color])
                <div class="flex justify-between border-b pb-3 text-sm">
                    <span>{{ $label }}</span>
                    <strong class="{{ $color }}">{{ $value }}</strong>
                </div>
            @endforeach
        </div>
    </section>
    <section class="rounded-lg bg-white p-5 shadow-sm">
        <h2 class="mb-4 font-bold">Tren Pendapatan 7 Hari</h2>
        <div class="space-y-3">
            @foreach ($revenueTrend as $trend)
                <div class="flex justify-between border-b pb-3 text-sm">
                    <span>{{ $trend['date'] }}</span>
                    <strong class="text-moss">Rp {{ number_format($trend['total'], 0, ',', '.') }}</strong>
                </div>
            @endforeach
        </div>
    </section>
</div>
<section class="mt-6 rounded-lg bg-white p-5 shadow-sm">
    <h2 class="mb-4 font-bold">Export Laporan Terbaru</h2>
    <div class="space-y-3">
        @forelse ($recentReportExports as $export)
            <div class="flex justify-between border-b pb-3 text-sm">
                <span>{{ $export->report_type }} oleh {{ $export->user->name }}</span>
                <strong class="{{ $export->status === 'completed' ? 'text-moss' : ($export->status === 'failed' ? 'text-coral' : 'text-amber') }}">{{ $export->status }}</strong>
            </div>
        @empty
            <p class="text-sm text-gray-500">Belum ada export laporan.</p>
        @endforelse
    </div>
</section>
<section class="mt-6 rounded-lg bg-white p-5 shadow-sm">
    <h2 class="mb-4 font-bold">Webhook Integration Terbaru</h2>
    <div class="space-y-3">
        @forelse ($recentWebhookLogs as $log)
            <div class="flex justify-between border-b pb-3 text-sm">
                <span>{{ $log->source }} - {{ $log->event_name }}</span>
                <strong class="{{ $log->status === 'received' ? 'text-moss' : 'text-coral' }}">{{ $log->status }}</strong>
            </div>
        @empty
            <p class="text-sm text-gray-500">Belum ada webhook integration.</p>
        @endforelse
    </div>
</section>
<section class="mt-6 rounded-lg bg-white p-5 shadow-sm">
    <h2 class="mb-4 font-bold">Upload File Terbaru</h2>
    <div class="space-y-3">
        @forelse ($recentStorageFiles as $file)
            <div class="flex justify-between border-b pb-3 text-sm">
                <span>{{ $file->filename }} oleh {{ $file->user?->name ?: '-' }}</span>
                <strong class="text-moss">{{ number_format($file->size / 1024, 1) }} KB</strong>
            </div>
        @empty
            <p class="text-sm text-gray-500">Belum ada file upload.</p>
        @endforelse
    </div>
</section>
<section class="mt-6 rounded-lg bg-white p-5 shadow-sm">
    <h2 class="mb-4 font-bold">Aktivitas CRM Terbaru</h2>
    <div class="space-y-3">
        @forelse ($recentCrmActivities as $activity)
            <div class="flex justify-between border-b pb-3 text-sm">
                <span>{{ $activity->customer?->name ?: '-' }} - {{ $activity->description ?: $activity->type }}</span>
                <strong class="text-moss">{{ $activity->type }}</strong>
            </div>
        @empty
            <p class="text-sm text-gray-500">Belum ada aktivitas CRM.</p>
        @endforelse
    </div>
</section>
<div class="mt-6 grid gap-6 lg:grid-cols-2">
    <section class="rounded-lg bg-white p-5 shadow-sm">
        <h2 class="mb-4 font-bold">Transaksi Terbaru</h2>
        <div class="space-y-3">
            @forelse ($recentTransactions as $transaction)
                <div class="flex justify-between border-b pb-3 text-sm">
                    <span>{{ $transaction->item->name }} oleh {{ $transaction->user->name }}</span>
                    <strong class="{{ $transaction->type === 'in' ? 'text-moss' : 'text-coral' }}">{{ $transaction->type === 'in' ? '+' : '-' }}{{ $transaction->quantity }}</strong>
                </div>
            @empty
                <p class="text-sm text-gray-500">Belum ada transaksi.</p>
            @endforelse
        </div>
    </section>
    <section class="rounded-lg bg-white p-5 shadow-sm">
        <h2 class="mb-4 font-bold">Stok Perlu Perhatian</h2>
        <div class="space-y-3">
            @forelse ($lowItems as $item)
                <div class="flex justify-between border-b pb-3 text-sm">
                    <span>{{ $item->name }} <small class="text-gray-500">({{ $item->category->name }})</small></span>
                    <strong class="{{ $item->stock <= 0 ? 'text-coral' : 'text-amber' }}">{{ $item->stock }} {{ $item->unit }}</strong>
                </div>
            @empty
                <p class="text-sm text-gray-500">Semua stok aman.</p>
            @endforelse
        </div>
    </section>
</div>
@endsection
