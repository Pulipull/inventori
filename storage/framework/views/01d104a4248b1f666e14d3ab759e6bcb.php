

<?php $__env->startSection('title', 'CRM Customer'); ?>
<?php $__env->startSection('actions'); ?>
<a href="<?php echo e(route('customers.create')); ?>" class="rounded bg-moss px-4 py-2 text-sm font-semibold text-white">Tambah Customer</a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<form class="mb-4 grid gap-2 md:grid-cols-[1fr_180px_auto]">
    <input name="search" value="<?php echo e(request('search')); ?>" placeholder="Cari nama, email, telepon, atau perusahaan" class="rounded border-gray-300">
    <select name="status" class="rounded border-gray-300">
        <option value="">Semua Status</option>
        <option value="active" <?php if(request('status') === 'active'): echo 'selected'; endif; ?>>Aktif</option>
        <option value="inactive" <?php if(request('status') === 'inactive'): echo 'selected'; endif; ?>>Tidak Aktif</option>
    </select>
    <button class="rounded bg-ink px-4 py-2 text-white">Cari</button>
</form>

<div class="overflow-hidden rounded-lg bg-white shadow-sm">
    <table class="w-full text-left text-sm">
        <thead class="bg-gray-50 text-gray-500">
            <tr><th class="p-4">Nama</th><th class="p-4">Kontak</th><th class="p-4">Perusahaan</th><th class="p-4">Source</th><th class="p-4">Status</th><th class="p-4"></th></tr>
        </thead>
        <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr class="border-t">
                <td class="p-4">
                    <a href="<?php echo e(route('customers.show', $customer)); ?>" class="font-semibold text-moss"><?php echo e($customer->name); ?></a>
                    <?php if($customer->external_customer_id): ?>
                        <p class="text-xs text-gray-400"><?php echo e($customer->external_customer_id); ?></p>
                    <?php endif; ?>
                </td>
                <td class="p-4">
                    <p><?php echo e($customer->email ?: '-'); ?></p>
                    <p class="text-xs text-gray-500"><?php echo e($customer->phone ?: '-'); ?></p>
                </td>
                <td class="p-4"><?php echo e($customer->company ?: '-'); ?></td>
                <td class="p-4"><?php echo e($customer->source); ?></td>
                <td class="p-4"><span class="rounded px-2 py-1 text-xs <?php echo e($customer->status === 'active' ? 'bg-moss/10 text-moss' : 'bg-gray-100 text-gray-500'); ?>"><?php echo e($customer->status); ?></span></td>
                <td class="p-4 text-right">
                    <a href="<?php echo e(route('customers.edit', $customer)); ?>" class="text-moss">Edit</a>
                    <form method="post" action="<?php echo e(route('customers.destroy', $customer)); ?>" class="inline" onsubmit="return confirm('Hapus customer?')">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button class="ml-3 text-coral">Hapus</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="6" class="p-4 text-center text-sm text-gray-500">Belum ada customer.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
    <div class="p-4"><?php echo e($customers->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\inventori\resources\views\customers\index.blade.php ENDPATH**/ ?>