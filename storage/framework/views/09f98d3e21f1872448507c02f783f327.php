

<?php $__env->startSection('title', 'Export Laporan'); ?>

<?php $__env->startSection('content'); ?>
<section class="mb-6 rounded-lg bg-white p-5 shadow-sm">
    <h2 class="mb-4 font-bold">Request Export</h2>
    <form method="post" action="<?php echo e(route('reports.exports.store')); ?>" class="grid gap-3 md:grid-cols-[220px_180px_180px_auto]">
        <?php echo csrf_field(); ?>
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
        <?php $__empty_1 = true; $__currentLoopData = $exports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $export): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr class="border-t">
                <td class="p-4 font-semibold"><?php echo e($export->report_type); ?></td>
                <td class="p-4"><?php echo e($export->user->name); ?></td>
                <td class="p-4"><span class="rounded px-2 py-1 text-xs <?php echo e($export->status === 'completed' ? 'bg-moss/10 text-moss' : ($export->status === 'failed' ? 'bg-coral/10 text-coral' : 'bg-amber/10 text-amber')); ?>"><?php echo e($export->status); ?></span></td>
                <td class="p-4"><?php echo e($export->generated_at?->format('d M Y H:i') ?: '-'); ?></td>
                <td class="p-4 text-right"><a href="<?php echo e(route('reports.exports.show', $export)); ?>" class="text-moss">Detail</a></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="5" class="p-4 text-center text-sm text-gray-500">Belum ada export laporan.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
    <div class="p-4"><?php echo e($exports->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\inventori\resources\views\reports\exports\index.blade.php ENDPATH**/ ?>