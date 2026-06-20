

<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('actions'); ?>
<div class="flex gap-2">
    <a href="<?php echo e(route('transactions.create', 'in')); ?>" class="rounded bg-moss px-4 py-2 text-sm font-semibold text-white">Barang Masuk</a>
    <a href="<?php echo e(route('transactions.create', 'out')); ?>" class="rounded bg-coral px-4 py-2 text-sm font-semibold text-white">Barang Keluar</a>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="grid gap-4 md:grid-cols-4">
    <?php $__currentLoopData = [['Barang', $itemCount], ['Kategori', $categoryCount], ['Customer', $customerCount], ['Follow Up Open', $openFollowUpCount], ['Follow Up Selesai', $completedFollowUpCount], ['Total Export', $reportExportCount], ['Total File Upload', $storageFileCount], ['Integration Pending', $pendingIntegrationEventCount], ['Integration Processed', $processedIntegrationEventCount], ['Notifikasi Belum Dibaca', $unreadNotificationCount], ['Percakapan Aktif', $activeConversationCount], ['Percakapan Belum Dibaca', $unreadConversationCount], ['Stok Menipis', $lowStockCount], ['Stok Habis', $emptyStockCount]]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$label, $value]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="rounded-lg bg-white p-5 shadow-sm">
            <p class="text-sm text-gray-500"><?php echo e($label); ?></p>
            <p class="mt-2 text-3xl font-bold"><?php echo e($value); ?></p>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<section class="mt-6 rounded-lg bg-white p-5 shadow-sm">
    <h2 class="mb-4 font-bold">Export Laporan Terbaru</h2>
    <div class="space-y-3">
        <?php $__empty_1 = true; $__currentLoopData = $recentReportExports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $export): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="flex justify-between border-b pb-3 text-sm">
                <span><?php echo e($export->report_type); ?> oleh <?php echo e($export->user->name); ?></span>
                <strong class="<?php echo e($export->status === 'completed' ? 'text-moss' : ($export->status === 'failed' ? 'text-coral' : 'text-amber')); ?>"><?php echo e($export->status); ?></strong>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-sm text-gray-500">Belum ada export laporan.</p>
        <?php endif; ?>
    </div>
</section>
<section class="mt-6 rounded-lg bg-white p-5 shadow-sm">
    <h2 class="mb-4 font-bold">Webhook Integration Terbaru</h2>
    <div class="space-y-3">
        <?php $__empty_1 = true; $__currentLoopData = $recentWebhookLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="flex justify-between border-b pb-3 text-sm">
                <span><?php echo e($log->source); ?> - <?php echo e($log->event_name); ?></span>
                <strong class="<?php echo e($log->status === 'received' ? 'text-moss' : 'text-coral'); ?>"><?php echo e($log->status); ?></strong>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-sm text-gray-500">Belum ada webhook integration.</p>
        <?php endif; ?>
    </div>
</section>
<section class="mt-6 rounded-lg bg-white p-5 shadow-sm">
    <h2 class="mb-4 font-bold">Upload File Terbaru</h2>
    <div class="space-y-3">
        <?php $__empty_1 = true; $__currentLoopData = $recentStorageFiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="flex justify-between border-b pb-3 text-sm">
                <span><?php echo e($file->filename); ?> oleh <?php echo e($file->user?->name ?: '-'); ?></span>
                <strong class="text-moss"><?php echo e(number_format($file->size / 1024, 1)); ?> KB</strong>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-sm text-gray-500">Belum ada file upload.</p>
        <?php endif; ?>
    </div>
</section>
<section class="mt-6 rounded-lg bg-white p-5 shadow-sm">
    <h2 class="mb-4 font-bold">Aktivitas CRM Terbaru</h2>
    <div class="space-y-3">
        <?php $__empty_1 = true; $__currentLoopData = $recentCrmActivities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="flex justify-between border-b pb-3 text-sm">
                <span><?php echo e($activity->customer?->name ?: '-'); ?> - <?php echo e($activity->description ?: $activity->type); ?></span>
                <strong class="text-moss"><?php echo e($activity->type); ?></strong>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-sm text-gray-500">Belum ada aktivitas CRM.</p>
        <?php endif; ?>
    </div>
</section>
<div class="mt-6 grid gap-6 lg:grid-cols-2">
    <section class="rounded-lg bg-white p-5 shadow-sm">
        <h2 class="mb-4 font-bold">Transaksi Terbaru</h2>
        <div class="space-y-3">
            <?php $__empty_1 = true; $__currentLoopData = $recentTransactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="flex justify-between border-b pb-3 text-sm">
                    <span><?php echo e($transaction->item->name); ?> oleh <?php echo e($transaction->user->name); ?></span>
                    <strong class="<?php echo e($transaction->type === 'in' ? 'text-moss' : 'text-coral'); ?>"><?php echo e($transaction->type === 'in' ? '+' : '-'); ?><?php echo e($transaction->quantity); ?></strong>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-sm text-gray-500">Belum ada transaksi.</p>
            <?php endif; ?>
        </div>
    </section>
    <section class="rounded-lg bg-white p-5 shadow-sm">
        <h2 class="mb-4 font-bold">Stok Perlu Perhatian</h2>
        <div class="space-y-3">
            <?php $__empty_1 = true; $__currentLoopData = $lowItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="flex justify-between border-b pb-3 text-sm">
                    <span><?php echo e($item->name); ?> <small class="text-gray-500">(<?php echo e($item->category->name); ?>)</small></span>
                    <strong class="<?php echo e($item->stock <= 0 ? 'text-coral' : 'text-amber'); ?>"><?php echo e($item->stock); ?> <?php echo e($item->unit); ?></strong>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-sm text-gray-500">Semua stok aman.</p>
            <?php endif; ?>
        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/dashboard.blade.php ENDPATH**/ ?>