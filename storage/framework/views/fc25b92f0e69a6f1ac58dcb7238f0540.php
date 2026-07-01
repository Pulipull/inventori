

<?php $__env->startSection('title', 'Timeline '.$customer->name); ?>
<?php $__env->startSection('actions'); ?>
<a href="<?php echo e(route('customers.show', $customer)); ?>" class="rounded bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-600">Kembali</a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-3">
    <?php $__empty_1 = true; $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="rounded-lg bg-white p-4 text-sm shadow-sm">
            <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
                <strong><?php echo e($activity->type); ?></strong>
                <span class="text-xs text-gray-500"><?php echo e($activity->created_at?->format('d M Y H:i')); ?> oleh <?php echo e($activity->creator?->name ?: '-'); ?></span>
            </div>
            <?php if($activity->description): ?>
                <p class="mt-2 text-gray-600"><?php echo e($activity->description); ?></p>
            <?php endif; ?>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <p class="rounded-lg bg-white p-5 text-sm text-gray-500 shadow-sm">Belum ada aktivitas CRM.</p>
    <?php endif; ?>
    <?php echo e($activities->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\inventori\resources\views\customers\timeline.blade.php ENDPATH**/ ?>