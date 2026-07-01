<!doctype html>
<html lang="id"><head><meta charset="utf-8"><style>body{font-family:DejaVu Sans,sans-serif;font-size:12px}table{width:100%;border-collapse:collapse}th,td{border:1px solid #ddd;padding:8px;text-align:left}th{background:#f1f5f9}</style></head>
<body>
<h2><?php echo e($type === 'in' ? 'Laporan Barang Masuk' : 'Laporan Barang Keluar'); ?></h2>
<p>Periode: <?php echo e($dateFrom ?: '-'); ?> sampai <?php echo e($dateTo ?: '-'); ?></p>
<table><thead><tr><th>Tanggal</th><th>Barang</th><th>Kategori</th><th>Jumlah</th><th>Petugas</th><th>Catatan</th></tr></thead><tbody>
<?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr><td><?php echo e($transaction->transaction_date->format('d M Y')); ?></td><td><?php echo e($transaction->item->name); ?></td><td><?php echo e($transaction->item->category->name); ?></td><td><?php echo e($transaction->quantity); ?></td><td><?php echo e($transaction->user->name); ?></td><td><?php echo e($transaction->notes); ?></td></tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</tbody></table>
</body></html>
<?php /**PATH C:\inventori\resources\views\reports\pdf\transactions.blade.php ENDPATH**/ ?>