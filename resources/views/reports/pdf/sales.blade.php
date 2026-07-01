<!doctype html>
<html lang="id"><head><meta charset="utf-8"><style>body{font-family:DejaVu Sans,sans-serif;font-size:12px}table{width:100%;border-collapse:collapse}th,td{border:1px solid #ddd;padding:8px;text-align:left}th{background:#f1f5f9}.text-right{text-align:right}.summary{margin-top:20px;font-weight:bold}</style></head>
<body>
<h2>Laporan Penjualan</h2>
@if($dateFrom || $dateTo)
<p>Periode: {{ $dateFrom ? date('d/m/Y', strtotime($dateFrom)) : '-' }} s/d {{ $dateTo ? date('d/m/Y', strtotime($dateTo)) : '-' }}</p>
@endif
<table><thead><tr><th>Invoice</th><th>Tanggal</th><th>Pelanggan</th><th>Item</th><th class="text-right">Jumlah</th><th>Metode</th></tr></thead><tbody>
@forelse ($orders as $order)
<tr><td>{{ $order->invoice_number }}</td><td>{{ $order->paid_at->format('d/m/Y H:i') }}</td><td>{{ $order->user->name }}</td><td>{{ $order->item?->name ?? '-' }}</td><td class="text-right">Rp {{ number_format($order->amount, 0, ',', '.') }}</td><td>{{ strtoupper($order->payment_method) }}</td></tr>
@empty
<tr><td colspan="6" style="text-align:center">Tidak ada data</td></tr>
@endforelse
</tbody></table>
<div class="summary">Total Penjualan: Rp {{ number_format($total, 0, ',', '.') }}</div>
</body></html>
