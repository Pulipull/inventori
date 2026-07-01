<!doctype html>
<html lang="id"><head><meta charset="utf-8"><style>body{font-family:DejaVu Sans,sans-serif;font-size:12px}table{width:100%;border-collapse:collapse}th,td{border:1px solid #ddd;padding:8px;text-align:left}th{background:#f1f5f9}.text-right{text-align:right}.summary{margin-bottom:20px;padding:15px;background:#f9fafb;border:1px solid #ddd}.summary-item{margin:8px 0;font-size:14px}.summary-item strong{display:inline-block;min-width:200px}h3{margin-top:25px;margin-bottom:10px}</style></head>
<body>
<h2>Laporan Pendapatan</h2>
@if($dateFrom || $dateTo)
<p>Periode: {{ $dateFrom ? date('d/m/Y', strtotime($dateFrom)) : '-' }} s/d {{ $dateTo ? date('d/m/Y', strtotime($dateTo)) : '-' }}</p>
@endif
<div class="summary">
<div class="summary-item"><strong>Total Pendapatan:</strong> Rp {{ number_format($summary['total_revenue'], 0, ',', '.') }}</div>
<div class="summary-item"><strong>Total Transaksi:</strong> {{ $summary['total_transactions'] }}</div>
<div class="summary-item"><strong>Rata-rata Transaksi:</strong> Rp {{ number_format($summary['average_transaction'], 0, ',', '.') }}</div>
</div>
@if(count($summary['by_item']) > 0)
<h3>Pendapatan Per Item</h3>
<table><thead><tr><th>Item</th><th class="text-right">Jumlah Transaksi</th><th class="text-right">Total Pendapatan</th></tr></thead><tbody>
@foreach ($summary['by_item'] as $item)
<tr><td>{{ $item->item?->name ?? 'N/A' }}</td><td class="text-right">{{ $item->count }}</td><td class="text-right">Rp {{ number_format($item->total, 0, ',', '.') }}</td></tr>
@endforeach
</tbody></table>
@endif
<h3>Daftar Transaksi</h3>
<table><thead><tr><th>Invoice</th><th>Tanggal</th><th>Pelanggan</th><th>Item</th><th class="text-right">Jumlah</th></tr></thead><tbody>
@forelse ($orders as $order)
<tr><td>{{ $order->invoice_number }}</td><td>{{ $order->paid_at?->format('d/m/Y H:i') ?? '-' }}</td><td>{{ $order->user->name }}</td><td>{{ $order->item?->name ?? '-' }}</td><td class="text-right">Rp {{ number_format($order->amount, 0, ',', '.') }}</td></tr>
@empty
<tr><td colspan="5" style="text-align:center">Tidak ada data</td></tr>
@endforelse
</tbody></table>
</body></html>
