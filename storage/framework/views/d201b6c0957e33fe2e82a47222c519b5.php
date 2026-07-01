

<?php $__env->startSection('title', 'Detail Export Laporan'); ?>
<?php $__env->startSection('actions'); ?>
<a href="<?php echo e(route('reports.exports.index')); ?>" class="rounded bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-600">Kembali</a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="rounded-lg bg-white p-5 shadow-sm">
    <div class="grid gap-4 text-sm md:grid-cols-2">
        <div><p class="text-gray-500">Jenis Laporan</p><p class="font-semibold"><?php echo e($export->report_type); ?></p></div>
        <div><p class="text-gray-500">Status</p><p class="font-semibold"><?php echo e($export->status); ?></p></div>
        <div><p class="text-gray-500">Pemohon</p><p class="font-semibold"><?php echo e($export->user->name); ?></p></div>
        <div><p class="text-gray-500">Generated At</p><p class="font-semibold"><?php echo e($export->generated_at?->format('d M Y H:i') ?: '-'); ?></p></div>
    </div>

    <div class="mt-5 border-t pt-5">
        <p class="mb-2 text-sm text-gray-500">Filter</p>
        <pre class="overflow-auto rounded bg-gray-50 p-3 text-xs"><?php echo e(json_encode($metadata['filters'], JSON_PRETTY_PRINT)); ?></pre>
    </div>

    <?php if($export->file_path): ?>
        <div class="mt-5 border-t pt-5">
            <p class="mb-2 text-sm text-gray-500">File Reference</p>
            <a href="<?php echo e($export->file_path); ?>" class="text-moss"><?php echo e($export->file_path); ?></a>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\inventori\resources\views\reports\exports\show.blade.php ENDPATH**/ ?>