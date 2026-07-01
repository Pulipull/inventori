<!doctype html>
<html lang="id"><head><meta charset="utf-8"><style>body{font-family:DejaVu Sans,sans-serif;font-size:12px}table{width:100%;border-collapse:collapse}th,td{border:1px solid #ddd;padding:8px;text-align:left}th{background:#f1f5f9}.text-right{text-align:right}.summary{margin-top:20px;font-weight:bold}</style></head>
<body>
<h2>Laporan Penjualan</h2>
<?php if($dateFrom || $dateTo): ?>
<p>Periode: <?php echo e($dateFrom ? date('d/m/Y', strtotime($dateFrom)) : '-'); ?> s/d <?php echo e($dateTo ? date('d/m/Y', strtotime($dateTo)) : '-'); ?></p>
<?php endif; ?>
<table><thead><tr><th>Invoice</th><th>Tanggal</th><th>Pelanggan</th><th>Item</th><th class="text-right">Jumlah</th><th>Metode</th></tr></thead><tbody>
<?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
<tr><td><?php echo e($order->invoice_number); ?></td><td><?php echo e($order->paid_at->format('d/m/Y H:i')); ?></td><td><?php echo e($order->user->name); ?></td><td><?php echo e($order->item?->name ?? '-'); ?></td><td class="text-right">Rp <?php echo e(number_format($order->amount, 0, ',', '.')); ?></td><td><?php echo e(strtoupper($order->payment_method)); ?></td></tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
<tr><td colspan="6" style="text-align:center">Tidak ada data</td></tr>
<?php endif; ?>
</tbody></table>
<div class="summary">Total Penjualan: Rp <?php echo e(number_format($total, 0, ',', '.')); ?></div>
</body></html>
<?php /**PATH C:\inventori\resources\views\reports\pdf\sales.blade.php ENDPATH**/ ?>