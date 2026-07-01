<?php $__env->startSection('title', 'Laporan Pendapatan'); ?>
<?php $__env->startSection('actions'); ?>
<a href="<?php echo e(route('reports.revenue.pdf', request()->only('date_from', 'date_to'))); ?>" class="rounded bg-coral px-4 py-2 text-sm font-semibold text-white">Export PDF</a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<form class="mb-4 grid gap-2 md:grid-cols-3">
    <input type="date" name="date_from" value="<?php echo e($dateFrom); ?>" class="rounded border-gray-300">
    <input type="date" name="date_to" value="<?php echo e($dateTo); ?>" class="rounded border-gray-300">
    <button class="rounded bg-ink px-4 py-2 text-white">Filter Tanggal</button>
</form>

<div class="mb-4 grid gap-4 md:grid-cols-3">
    <?php $__currentLoopData = [['Total Pendapatan', 'Rp '.number_format($summary['total_revenue'], 0, ',', '.')], ['Total Transaksi', $summary['total_transactions']], ['Rata-rata Transaksi', 'Rp '.number_format($summary['average_transaction'], 0, ',', '.')]]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$label, $value]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="rounded-lg bg-white p-5 shadow-sm">
            <p class="text-sm text-gray-500"><?php echo e($label); ?></p>
            <p class="mt-2 text-2xl font-bold"><?php echo e($value); ?></p>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<section class="mb-6 rounded-lg bg-white p-5 shadow-sm">
    <h2 class="mb-4 font-bold">Pendapatan Per Barang</h2>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-gray-50 text-gray-500">
                <tr><th class="p-4">Barang</th><th class="p-4 text-right">Transaksi</th><th class="p-4 text-right">Pendapatan</th></tr>
            </thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $summary['by_item']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="border-t">
                    <td class="p-4 font-semibold"><?php echo e($item->item?->name ?? 'N/A'); ?></td>
                    <td class="p-4 text-right"><?php echo e($item->count); ?></td>
                    <td class="p-4 text-right font-semibold">Rp <?php echo e(number_format($item->total, 0, ',', '.')); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="3" class="p-4 text-center text-sm text-gray-500">Tidak ada pendapatan per barang.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<div class="overflow-hidden rounded-lg bg-white shadow-sm">
    <table class="w-full text-left text-sm">
        <thead class="bg-gray-50 text-gray-500">
            <tr><th class="p-4">Invoice</th><th class="p-4">Tanggal Bayar</th><th class="p-4">Pelanggan</th><th class="p-4">Barang</th><th class="p-4 text-right">Jumlah</th></tr>
        </thead>
        <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr class="border-t">
                <td class="p-4 font-mono text-xs font-semibold"><?php echo e($order->invoice_number); ?></td>
                <td class="p-4"><?php echo e($order->paid_at?->format('d M Y H:i') ?: '-'); ?></td>
                <td class="p-4"><?php echo e($order->user->name); ?></td>
                <td class="p-4"><?php echo e($order->item?->name ?? $order->description ?? '-'); ?></td>
                <td class="p-4 text-right font-semibold">Rp <?php echo e(number_format($order->amount, 0, ',', '.')); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="5" class="p-4 text-center text-sm text-gray-500">Tidak ada data pendapatan.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\inventori\resources\views\reports\revenue.blade.php ENDPATH**/ ?>