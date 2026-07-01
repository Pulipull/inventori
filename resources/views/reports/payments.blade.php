@extends('layouts.app')

@section('title', 'Laporan Pembayaran')
@section('actions')
<a href="{{ route('reports.payments.pdf', request()->only('date_from', 'date_to')) }}" class="rounded bg-coral px-4 py-2 text-sm font-semibold text-white">Export PDF</a>
@endsection

@section('content')
<form class="mb-4 grid gap-2 md:grid-cols-3">
    <input type="date" name="date_from" value="{{ $dateFrom }}" class="rounded border-gray-300">
    <input type="date" name="date_to" value="{{ $dateTo }}" class="rounded border-gray-300">
    <button class="rounded bg-ink px-4 py-2 text-white">Filter Tanggal</button>
</form>

<div class="mb-4 grid gap-4 md:grid-cols-4">
    @foreach ([['Total Order', $summary['total_orders']], ['Lunas', $summary['paid']], ['Pending', $summary['pending']], ['Gagal', $summary['failed']], ['Kadaluarsa', $summary['expired']], ['Total Nominal', 'Rp '.number_format($summary['total_amount'], 0, ',', '.')], ['Nominal Lunas', 'Rp '.number_format($summary['paid_amount'], 0, ',', '.')]] as [$label, $value])
        <div class="rounded-lg bg-white p-5 shadow-sm">
            <p class="text-sm text-gray-500">{{ $label }}</p>
            <p class="mt-2 text-2xl font-bold">{{ $value }}</p>
        </div>
    @endforeach
</div>

<div class="overflow-hidden rounded-lg bg-white shadow-sm">
    <table class="w-full text-left text-sm">
        <thead class="bg-gray-50 text-gray-500">
            <tr><th class="p-4">Invoice</th><th class="p-4">Tanggal</th><th class="p-4">Pelanggan</th><th class="p-4">Barang</th><th class="p-4">Status</th><th class="p-4 text-right">Jumlah</th></tr>
        </thead>
        <tbody>
        @forelse ($orders as $order)
            <tr class="border-t">
                <td class="p-4 font-mono text-xs font-semibold">{{ $order->invoice_number }}</td>
                <td class="p-4">{{ $order->created_at->format('d M Y H:i') }}</td>
                <td class="p-4">{{ $order->user->name }}</td>
                <td class="p-4">{{ $order->item?->name ?? $order->description ?? '-' }}</td>
                <td class="p-4"><span class="rounded px-2 py-1 text-xs {{ $order->status === 'paid' ? 'bg-moss/10 text-moss' : ($order->status === 'failed' ? 'bg-coral/10 text-coral' : 'bg-amber/10 text-amber') }}">{{ $order->status }}</span></td>
                <td class="p-4 text-right font-semibold">Rp {{ number_format($order->amount, 0, ',', '.') }}</td>
            </tr>
        @empty
            <tr><td colspan="6" class="p-4 text-center text-sm text-gray-500">Tidak ada data pembayaran.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
