@extends('layouts.app')

@section('title', 'Export Laporan')

@section('content')
<section class="mb-6 rounded-lg bg-white p-5 shadow-sm">
    <h2 class="mb-4 font-bold">Request Export</h2>
    <form method="post" action="{{ route('reports.exports.store') }}" class="grid gap-3 md:grid-cols-[220px_180px_180px_auto]">
        @csrf
        <select name="report_type" required class="rounded border-gray-300">
            <option value="stock">Laporan Stok</option>
            <option value="transactions_in">Laporan Barang Masuk</option>
            <option value="transactions_out">Laporan Barang Keluar</option>
            <option value="sales">Laporan Penjualan</option>
            <option value="payments">Laporan Pembayaran</option>
            <option value="revenue">Laporan Pendapatan</option>
        </select>
        <input name="date_from" type="date" class="rounded border-gray-300">
        <input name="date_to" type="date" class="rounded border-gray-300">
        <button class="rounded bg-moss px-4 py-2 font-semibold text-white">Buat Export</button>
    </form>
</section>

<div class="overflow-hidden rounded-lg bg-white shadow-sm">
    <table class="w-full text-left text-sm">
        <thead class="bg-gray-50 text-gray-500">
            <tr><th class="p-4">Jenis</th><th class="p-4">Pemohon</th><th class="p-4">Status</th><th class="p-4">Generated</th><th class="p-4"></th></tr>
        </thead>
        <tbody>
        @forelse ($exports as $export)
            <tr class="border-t">
                <td class="p-4 font-semibold">{{ $export->report_type }}</td>
                <td class="p-4">{{ $export->user->name }}</td>
                <td class="p-4"><span class="rounded px-2 py-1 text-xs {{ $export->status === 'completed' ? 'bg-moss/10 text-moss' : ($export->status === 'failed' ? 'bg-coral/10 text-coral' : 'bg-amber/10 text-amber') }}">{{ $export->status }}</span></td>
                <td class="p-4">{{ $export->generated_at?->format('d M Y H:i') ?: '-' }}</td>
                <td class="p-4 text-right"><a href="{{ route('reports.exports.show', $export) }}" class="text-moss">Detail</a></td>
            </tr>
        @empty
            <tr><td colspan="5" class="p-4 text-center text-sm text-gray-500">Belum ada export laporan.</td></tr>
        @endforelse
        </tbody>
    </table>
    <div class="p-4">{{ $exports->links() }}</div>
</div>
@endsection
