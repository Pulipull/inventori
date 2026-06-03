<?php $__env->startSection('title', 'Riwayat Transaksi'); ?>
<?php $__env->startSection('actions'); ?>
<div class="flex gap-2"><a href="<?php echo e(route('transactions.create', 'in')); ?>" class="rounded bg-moss px-4 py-2 text-sm text-white">Masuk</a><a href="<?php echo e(route('transactions.create', 'out')); ?>" class="rounded bg-coral px-4 py-2 text-sm text-white">Keluar</a></div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<form class="mb-4 grid gap-2 md:grid-cols-4">
    <select name="type" class="rounded border-gray-300"><option value="">Semua</option><option value="in" <?php if(request('type')==='in'): echo 'selected'; endif; ?>>Masuk</option><option value="out" <?php if(request('type')==='out'): echo 'selected'; endif; ?>>Keluar</option></select>
    <input type="date" name="date_from" value="<?php echo e(request('date_from')); ?>" class="rounded border-gray-300">
    <input type="date" name="date_to" value="<?php echo e(request('date_to')); ?>" class="rounded border-gray-300">
    <button class="rounded bg-ink px-4 py-2 text-white">Filter</button>
</form>
<div class="overflow-hidden rounded-lg bg-white shadow-sm">
    <table class="w-full text-left text-sm">
        <thead class="bg-gray-50 text-gray-500"><tr><th class="p-4">Tanggal</th><th class="p-4">Barang</th><th class="p-4">Jenis</th><th class="p-4">Jumlah</th><th class="p-4">Petugas</th><th class="p-4">Catatan</th></tr></thead>
        <tbody>
        <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr class="border-t"><td class="p-4"><?php echo e($transaction->transaction_date->format('d M Y')); ?></td><td class="p-4"><?php echo e($transaction->item->name); ?></td><td class="p-4"><?php echo e($transaction->type === 'in' ? 'Masuk' : 'Keluar'); ?></td><td class="p-4"><?php echo e($transaction->quantity); ?></td><td class="p-4"><?php echo e($transaction->user->name); ?></td><td class="p-4"><?php echo e($transaction->notes); ?></td></tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <div class="p-4"><?php echo e($transactions->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/transactions/index.blade.php ENDPATH**/ ?>