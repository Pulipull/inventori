<!doctype html>
<html lang="id"><head><meta charset="utf-8"><style>body{font-family:DejaVu Sans,sans-serif;font-size:12px}table{width:100%;border-collapse:collapse}th,td{border:1px solid #ddd;padding:8px;text-align:left}th{background:#f1f5f9}.text-right{text-align:right}.summary{margin-bottom:20px;padding:15px;background:#f9fafb;border:1px solid #ddd}.summary-item{margin:8px 0;font-size:14px}.summary-item strong{display:inline-block;min-width:200px}h3{margin-top:25px;margin-bottom:10px}</style></head>
<body>
<h2>Laporan Pendapatan</h2>
<?php if($dateFrom || $dateTo): ?>
<p>Periode: <?php echo e($dateFrom ? date('d/m/Y', strtotime($dateFrom)) : '-'); ?> s/d <?php echo e($dateTo ? date('d/m/Y', strtotime($dateTo)) : '-'); ?></p>
<?php endif; ?>
<div class="summary">
<div class="summary-item"><strong>Total Pendapatan:</strong> Rp <?php echo e(number_format($summary['total_revenue'], 0, ',', '.')); ?></div>
<div class="summary-item"><strong>Total Transaksi:</strong> <?php echo e($summary['total_transactions']); ?></div>
<div class="summary-item"><strong>Rata-rata Transaksi:</strong> Rp <?php echo e(number_format($summary['average_transaction'], 0, ',', '.')); ?></div>
</div>
<?php if(count($summary['by_item']) > 0): ?>
<h3>Pendapatan Per Item</h3>
<table><thead><tr><th>Item</th><th class="text-right">Jumlah Transaksi</th><th class="text-right">Total Pendapatan</th></tr></thead><tbody>
<?php $__currentLoopData = $summary['by_item']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr><td><?php echo e($item->item?->name ?? 'N/A'); ?></td><td class="text-right"><?php echo e($item->count); ?></td><td class="text-right">Rp <?php echo e(number_format($item->total, 0, ',', '.')); ?></td></tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</tbody></table>
<?php endif; ?>
<h3>Daftar Transaksi</h3>
<table><thead><tr><th>Invoice</th><th>Tanggal</th><th>Pelanggan</th><th>Item</th><th class="text-right">Jumlah</th></tr></thead><tbody>
<?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
<tr><td><?php echo e($order->invoice_number); ?></td><td><?php echo e($order->paid_at?->format('d/m/Y H:i') ?? '-'); ?></td><td><?php echo e($order->user->name); ?></td><td><?php echo e($order->item?->name ?? '-'); ?></td><td class="text-right">Rp <?php echo e(number_format($order->amount, 0, ',', '.')); ?></td></tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
<tr><td colspan="5" style="text-align:center">Tidak ada data</td></tr>
<?php endif; ?>
</tbody></table>
</body></html>
<?php /**PATH C:\inventori\resources\views\reports\pdf\revenue.blade.php ENDPATH**/ ?>