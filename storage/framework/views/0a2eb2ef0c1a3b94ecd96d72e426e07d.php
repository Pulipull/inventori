<!doctype html>
<html lang="id"><head><meta charset="utf-8"><style>body{font-family:DejaVu Sans,sans-serif;font-size:12px}table{width:100%;border-collapse:collapse}th,td{border:1px solid #ddd;padding:8px;text-align:left}th{background:#f1f5f9}.text-right{text-align:right}.summary{margin-bottom:20px;padding:10px;background:#f9fafb;border:1px solid #ddd}.summary-item{margin:5px 0}</style></head>
<body>
<h2>Laporan Pembayaran</h2>
<?php if($dateFrom || $dateTo): ?>
<p>Periode: <?php echo e($dateFrom ? date('d/m/Y', strtotime($dateFrom)) : '-'); ?> s/d <?php echo e($dateTo ? date('d/m/Y', strtotime($dateTo)) : '-'); ?></p>
<?php endif; ?>
<div class="summary">
<div class="summary-item">Total Order: <?php echo e($summary['total_orders']); ?></div>
<div class="summary-item">Lunas: <?php echo e($summary['paid']); ?></div>
<div class="summary-item">Pending: <?php echo e($summary['pending']); ?></div>
<div class="summary-item">Gagal: <?php echo e($summary['failed']); ?></div>
<div class="summary-item">Kadaluarsa: <?php echo e($summary['expired']); ?></div>
<div class="summary-item">Total Nominal: Rp <?php echo e(number_format($summary['total_amount'], 0, ',', '.')); ?></div>
<div class="summary-item">Nominal Lunas: Rp <?php echo e(number_format($summary['paid_amount'], 0, ',', '.')); ?></div>
</div>
<table><thead><tr><th>Invoice</th><th>Tanggal</th><th>Pelanggan</th><th>Item</th><th class="text-right">Jumlah</th><th>Status</th></tr></thead><tbody>
<?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
<tr><td><?php echo e($order->invoice_number); ?></td><td><?php echo e($order->created_at->format('d/m/Y H:i')); ?></td><td><?php echo e($order->user->name); ?></td><td><?php echo e($order->item?->name ?? '-'); ?></td><td class="text-right">Rp <?php echo e(number_format($order->amount, 0, ',', '.')); ?></td><td><?php echo e(strtoupper($order->status)); ?></td></tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
<tr><td colspan="6" style="text-align:center">Tidak ada data</td></tr>
<?php endif; ?>
</tbody></table>
</body></html>
<?php /**PATH C:\inventori\resources\views\reports\pdf\payments.blade.php ENDPATH**/ ?>