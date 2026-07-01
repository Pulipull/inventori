<?php $__env->startSection('title', 'Laporan Pembayaran'); ?>
<?php $__env->startSection('actions'); ?>
<a href="<?php echo e(route('reports.payments.pdf', request()->only('date_from', 'date_to'))); ?>" class="rounded bg-coral px-4 py-2 text-sm font-semibold text-white">Export PDF</a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<form class="mb-4 grid gap-2 md:grid-cols-3">
    <input type="date" name="date_from" value="<?php echo e($dateFrom); ?>" class="rounded border-gray-300">
    <input type="date" name="date_to" value="<?php echo e($dateTo); ?>" class="rounded border-gray-300">
    <button class="rounded bg-ink px-4 py-2 text-white">Filter Tanggal</button>
</form>

<div class="mb-4 grid gap-4 md:grid-cols-4">
    <?php $__currentLoopData = [['Total Order', $summary['total_orders']], ['Lunas', $summary['paid']], ['Pending', $summary['pending']], ['Gagal', $summary['failed']], ['Kadaluarsa', $summary['expired']], ['Total Nominal', 'Rp '.number_format($summary['total_amount'], 0, ',', '.')], ['Nominal Lunas', 'Rp '.number_format($summary['paid_amount'], 0, ',', '.')]]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$label, $value]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="rounded-lg bg-white p-5 shadow-sm">
            <p class="text-sm text-gray-500"><?php echo e($label); ?></p>
            <p class="mt-2 text-2xl font-bold"><?php echo e($value); ?></p>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<div class="overflow-hidden rounded-lg bg-white shadow-sm">
    <table class="w-full text-left text-sm">
        <thead class="bg-gray-50 text-gray-500">
            <tr><th class="p-4">Invoice</th><th class="p-4">Tanggal</th><th class="p-4">Pelanggan</th><th class="p-4">Barang</th><th class="p-4">Status</th><th class="p-4 text-right">Jumlah</th></tr>
        </thead>
        <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr class="border-t">
                <td class="p-4 font-mono text-xs font-semibold"><?php echo e($order->invoice_number); ?></td>
                <td class="p-4"><?php echo e($order->created_at->format('d M Y H:i')); ?></td>
                <td class="p-4"><?php echo e($order->user->name); ?></td>
                <td class="p-4"><?php echo e($order->item?->name ?? $order->description ?? '-'); ?></td>
                <td class="p-4"><span class="rounded px-2 py-1 text-xs <?php echo e($order->status === 'paid' ? 'bg-moss/10 text-moss' : ($order->status === 'failed' ? 'bg-coral/10 text-coral' : 'bg-amber/10 text-amber')); ?>"><?php echo e($order->status); ?></span></td>
                <td class="p-4 text-right font-semibold">Rp <?php echo e(number_format($order->amount, 0, ',', '.')); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="6" class="p-4 text-center text-sm text-gray-500">Tidak ada data pembayaran.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\inventori\resources\views\reports\payments.blade.php ENDPATH**/ ?>