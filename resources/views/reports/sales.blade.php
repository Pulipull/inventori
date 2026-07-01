@extends('layouts.app')

@section('title', 'Laporan Penjualan')
@section('actions')
<a href="{{ route('reports.sales.pdf', request()->only('date_from', 'date_to')) }}" class="rounded bg-coral px-4 py-2 text-sm font-semibold text-white">Export PDF</a>
@endsection

@section('content')
<form class="mb-4 grid gap-2 md:grid-cols-3">
    <input type="date" name="date_from" value="{{ $dateFrom }}" class="rounded border-gray-300">
    <input type="date" name="date_to" value="{{ $dateTo }}" class="rounded border-gray-300">
    <button class="rounded bg-ink px-4 py-2 text-white">Filter Tanggal</button>
</form>

<div class="mb-4 rounded-lg bg-white p-5 shadow-sm">
    <p class="text-sm text-gray-500">Total Penjualan</p>
    <p class="mt-2 text-3xl font-bold">Rp {{ number_format($orders->sum('amount'), 0, ',', '.') }}</p>
</div>

<div class="overflow-hidden rounded-lg bg-white shadow-sm">
    <table class="w-full text-left text-sm">
        <thead class="bg-gray-50 text-gray-500">
            <tr><th class="p-4">Invoice</th><th class="p-4">Tanggal Bayar</th><th class="p-4">Pelanggan</th><th class="p-4">Barang</th><th class="p-4">Metode</th><th class="p-4 text-right">Jumlah</th></tr>
        </thead>
        <tbody>
        @forelse ($orders as $order)
            <tr class="border-t">
                <td class="p-4 font-mono text-xs font-semibold">{{ $order->invoice_number }}</td>
                <td class="p-4">{{ $order->paid_at?->format('d M Y H:i') ?: '-' }}</td>
                <td class="p-4">{{ $order->user->name }}</td>
                <td class="p-4">{{ $order->item?->name ?? $order->description ?? '-' }}</td>
                <td class="p-4">{{ strtoupper($order->payment_method ?? '-') }}</td>
                <td class="p-4 text-right font-semibold">Rp {{ number_format($order->amount, 0, ',', '.') }}</td>
            </tr>
        @empty
            <tr><td colspan="6" class="p-4 text-center text-sm text-gray-500">Tidak ada data penjualan.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
