

<?php $__env->startSection('title', 'Preferensi Notifikasi'); ?>
<?php $__env->startSection('actions'); ?>
<a href="<?php echo e(route('notifications.index')); ?>" class="rounded bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-600">Kembali</a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<section class="rounded-lg bg-white p-5 shadow-sm">
    <form method="post" action="<?php echo e(route('notification-preferences.update')); ?>" class="grid gap-4 text-sm">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <?php $__currentLoopData = [
            'low_stock_enabled' => 'Stok menipis',
            'crm_enabled' => 'CRM',
            'report_enabled' => 'Laporan',
            'system_enabled' => 'Sistem',
        ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <label class="flex items-center justify-between border-b pb-3 last:border-b-0 last:pb-0">
                <span class="font-semibold"><?php echo e($label); ?></span>
                <input type="hidden" name="<?php echo e($field); ?>" value="0">
                <input type="checkbox" name="<?php echo e($field); ?>" value="1" class="rounded border-gray-300 text-moss" <?php if($preferences->{$field}): echo 'checked'; endif; ?>>
            </label>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <button class="w-fit rounded bg-moss px-4 py-2 font-semibold text-white">Simpan</button>
    </form>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/notifications/preferences.blade.php ENDPATH**/ ?>