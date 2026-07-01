<!doctype html>
<html lang="id"><head><meta charset="utf-8"><style>body{font-family:DejaVu Sans,sans-serif;font-size:12px}table{width:100%;border-collapse:collapse}th,td{border:1px solid #ddd;padding:8px;text-align:left}th{background:#f1f5f9}.text-right{text-align:right}.summary{margin-bottom:20px;padding:10px;background:#f9fafb;border:1px solid #ddd}.summary-item{margin:5px 0}</style></head>
<body>
<h2>Laporan Pembayaran</h2>
@if($dateFrom || $dateTo)
<p>Periode: {{ $dateFrom ? date('d/m/Y', strtotime($dateFrom)) : '-' }} s/d {{ $dateTo ? date('d/m/Y', strtotime($dateTo)) : '-' }}</p>
@endif
<div class="summary">
<div class="summary-item">Total Order: {{ $summary['total_orders'] }}</div>
<div class="summary-item">Lunas: {{ $summary['paid'] }}</div>
<div class="summary-item">Pending: {{ $summary['pending'] }}</div>
<div class="summary-item">Gagal: {{ $summary['failed'] }}</div>
<div class="summary-item">Kadaluarsa: {{ $summary['expired'] }}</div>
<div class="summary-item">Total Nominal: Rp {{ number_format($summary['total_amount'], 0, ',', '.') }}</div>
<div class="summary-item">Nominal Lunas: Rp {{ number_format($summary['paid_amount'], 0, ',', '.') }}</div>
</div>
<table><thead><tr><th>Invoice</th><th>Tanggal</th><th>Pelanggan</th><th>Item</th><th class="text-right">Jumlah</th><th>Status</th></tr></thead><tbody>
@forelse ($orders as $order)
<tr><td>{{ $order->invoice_number }}</td><td>{{ $order->created_at->format('d/m/Y H:i') }}</td><td>{{ $order->user->name }}</td><td>{{ $order->item?->name ?? '-' }}</td><td class="text-right">Rp {{ number_format($order->amount, 0, ',', '.') }}</td><td>{{ strtoupper($order->status) }}</td></tr>
@empty
<tr><td colspan="6" style="text-align:center">Tidak ada data</td></tr>
@endforelse
</tbody></table>
</body></html>
