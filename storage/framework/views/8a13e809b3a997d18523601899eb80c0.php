<?php $__env->startSection('title', 'Feedback'); ?>

<?php $__env->startSection('actions'); ?>
<a href="<?php echo e(route('feedback.create')); ?>" class="rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm shadow-blue-200 transition hover:bg-blue-700">Kirim Feedback</a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php
    $statusStyles = [
        'pending' => 'bg-amber-50 text-amber-700 ring-amber-100',
        'reviewed' => 'bg-blue-50 text-blue-700 ring-blue-100',
        'resolved' => 'bg-emerald-50 text-emerald-700 ring-emerald-100',
    ];

    $categoryStyles = [
        'product' => 'bg-sky-50 text-sky-700 ring-sky-100',
        'delivery' => 'bg-violet-50 text-violet-700 ring-violet-100',
        'service' => 'bg-emerald-50 text-emerald-700 ring-emerald-100',
        'payment' => 'bg-amber-50 text-amber-700 ring-amber-100',
        'other' => 'bg-gray-100 text-gray-700 ring-gray-200',
    ];
?>

<?php if (isset($component)) { $__componentOriginalf868fe28be572e81ef311c666230e847 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf868fe28be572e81ef311c666230e847 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.panel','data' => ['title' => 'Submitted Feedback','description' => 'Status feedback dan balasan dari tim CRM']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dashboard.panel'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Submitted Feedback','description' => 'Status feedback dan balasan dari tim CRM']); ?>
    <?php if($feedbacks->isEmpty()): ?>
        <div class="rounded-2xl border border-dashed border-gray-300 bg-gray-50 p-8 text-center">
            <h3 class="font-semibold text-gray-950">Belum ada feedback</h3>
            <p class="mt-1 text-sm text-gray-500">Bagikan pengalaman produk, pengiriman, service, atau pembayaran.</p>
            <a href="<?php echo e(route('feedback.create')); ?>" class="mt-4 inline-flex rounded-xl bg-gray-950 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700">Kirim Feedback</a>
        </div>
    <?php else: ?>
        <div class="grid gap-4">
            <?php $__currentLoopData = $feedbacks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feedback): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <article class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm shadow-gray-200/70">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="rounded-full px-2.5 py-1 text-xs font-semibold ring-1 <?php echo e($statusStyles[$feedback->status] ?? $statusStyles['pending']); ?>"><?php echo e(ucfirst($feedback->status)); ?></span>
                                <span class="rounded-full px-2.5 py-1 text-xs font-semibold ring-1 <?php echo e($categoryStyles[$feedback->category] ?? $categoryStyles['other']); ?>"><?php echo e(ucfirst($feedback->category)); ?></span>
                                <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-700 ring-1 ring-gray-200">Rating <?php echo e($feedback->rating); ?>/5</span>
                            </div>
                            <h3 class="mt-3 text-base font-semibold text-gray-950"><?php echo e($feedback->title); ?></h3>
                            <p class="mt-2 text-sm leading-6 text-gray-600"><?php echo e($feedback->feedback); ?></p>
                        </div>
                        <div class="shrink-0 text-left text-xs text-gray-500 sm:text-right">
                            <p><?php echo e($feedback->created_at->format('d M Y H:i')); ?></p>
                            <p class="mt-1"><?php echo e($feedback->order?->invoice_number ?: 'Tanpa order'); ?></p>
                        </div>
                    </div>

                    <?php if($feedback->admin_reply): ?>
                        <div class="mt-4 rounded-2xl border border-blue-100 bg-blue-50 p-4">
                            <p class="text-xs font-semibold uppercase tracking-normal text-blue-700">Admin Reply</p>
                            <p class="mt-2 text-sm leading-6 text-blue-950"><?php echo e($feedback->admin_reply); ?></p>
                            <?php if($feedback->replier): ?>
                                <p class="mt-2 text-xs text-blue-700">Oleh <?php echo e($feedback->replier->name); ?><?php echo e($feedback->replied_at ? ' pada '.$feedback->replied_at->format('d M Y H:i') : ''); ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="mt-5"><?php echo e($feedbacks->links()); ?></div>
    <?php endif; ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf868fe28be572e81ef311c666230e847)): ?>
<?php $attributes = $__attributesOriginalf868fe28be572e81ef311c666230e847; ?>
<?php unset($__attributesOriginalf868fe28be572e81ef311c666230e847); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf868fe28be572e81ef311c666230e847)): ?>
<?php $component = $__componentOriginalf868fe28be572e81ef311c666230e847; ?>
<?php unset($__componentOriginalf868fe28be572e81ef311c666230e847); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/feedback/index.blade.php ENDPATH**/ ?>