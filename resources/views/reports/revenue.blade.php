@extends('layouts.app')

@section('title', 'Laporan Pendapatan')
@section('actions')
<a href="{{ route('reports.revenue.pdf', request()->only('date_from', 'date_to')) }}" class="rounded bg-coral px-4 py-2 text-sm font-semibold text-white">Export PDF</a>
@endsection

@section('content')
<form class="mb-4 grid gap-2 md:grid-cols-3">
    <input type="date" name="date_from" value="{{ $dateFrom }}" class="rounded border-gray-300">
    <input type="date" name="date_to" value="{{ $dateTo }}" class="rounded border-gray-300">
    <button class="rounded bg-ink px-4 py-2 text-white">Filter Tanggal</button>
</form>

<div class="mb-4 grid gap-4 md:grid-cols-3">
    @foreach ([['Total Pendapatan', 'Rp '.number_format($summary['total_revenue'], 0, ',', '.')], ['Total Transaksi', $summary['total_transactions']], ['Rata-rata Transaksi', 'Rp '.number_format($summary['average_transaction'], 0, ',', '.')]] as [$label, $value])
        <div class="rounded-lg bg-white p-5 shadow-sm">
            <p class="text-sm text-gray-500">{{ $label }}</p>
            <p class="mt-2 text-2xl font-bold">{{ $value }}</p>
        </div>
    @endforeach
</div>

<section class="mb-6 rounded-lg bg-white p-5 shadow-sm">
    <h2 class="mb-4 font-bold">Pendapatan Per Barang</h2>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-gray-50 text-gray-500">
                <tr><th class="p-4">Barang</th><th class="p-4 text-right">Transaksi</th><th class="p-4 text-right">Pendapatan</th></tr>
            </thead>
            <tbody>
            @forelse ($summary['by_item'] as $item)
                <tr class="border-t">
                    <td class="p-4 font-semibold">{{ $item->item?->name ?? 'N/A' }}</td>
                    <td class="p-4 text-right">{{ $item->count }}</td>
                    <td class="p-4 text-right font-semibold">Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr><td colspan="3" class="p-4 text-center text-sm text-gray-500">Tidak ada pendapatan per barang.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</section>

<div class="overflow-hidden rounded-lg bg-white shadow-sm">
    <table class="w-full text-left text-sm">
        <thead class="bg-gray-50 text-gray-500">
            <tr><th class="p-4">Invoice</th><th class="p-4">Tanggal Bayar</th><th class="p-4">Pelanggan</th><th class="p-4">Barang</th><th class="p-4 text-right">Jumlah</th></tr>
        </thead>
        <tbody>
        @forelse ($orders as $order)
            <tr class="border-t">
                <td class="p-4 font-mono text-xs font-semibold">{{ $order->invoice_number }}</td>
                <td class="p-4">{{ $order->paid_at?->format('d M Y H:i') ?: '-' }}</td>
                <td class="p-4">{{ $order->user->name }}</td>
                <td class="p-4">{{ $order->item?->name ?? $order->description ?? '-' }}</td>
                <td class="p-4 text-right font-semibold">Rp {{ number_format($order->amount, 0, ',', '.') }}</td>
            </tr>
        @empty
            <tr><td colspan="5" class="p-4 text-center text-sm text-gray-500">Tidak ada data pendapatan.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
