

<?php $__env->startSection('title', $type === 'in' ? 'Barang Masuk' : 'Barang Keluar'); ?>

<?php $__env->startSection('content'); ?>
<form method="post" action="<?php echo e(route('transactions.store')); ?>" class="max-w-2xl rounded-lg bg-white p-6 shadow-sm">
    <?php echo csrf_field(); ?>
    <input type="hidden" name="type" value="<?php echo e($type); ?>">
    <label class="mb-4 block text-sm font-medium">Barang
        <select name="item_id" required class="mt-1 w-full rounded border-gray-300">
            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($item->id); ?>"><?php echo e($item->code); ?> - <?php echo e($item->name); ?> (stok <?php echo e($item->stock); ?>)</option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </label>
    <label class="mb-4 block text-sm font-medium">Jumlah
        <input name="quantity" type="number" min="1" required class="mt-1 w-full rounded border-gray-300">
    </label>
    <label class="mb-4 block text-sm font-medium">Tanggal
        <input name="transaction_date" type="date" value="<?php echo e(date('Y-m-d')); ?>" required class="mt-1 w-full rounded border-gray-300">
    </label>
    <label class="mb-6 block text-sm font-medium">Catatan
        <textarea name="notes" rows="3" class="mt-1 w-full rounded border-gray-300"></textarea>
    </label>
    <button class="rounded <?php echo e($type === 'in' ? 'bg-moss' : 'bg-coral'); ?> px-4 py-2 font-semibold text-white">Simpan Transaksi</button>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\inventori\resources\views\transactions\form.blade.php ENDPATH**/ ?>