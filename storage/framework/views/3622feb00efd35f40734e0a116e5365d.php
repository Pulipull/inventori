<?php $__env->startSection('title', 'CRM Feedback'); ?>

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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.panel','data' => ['title' => 'Feedback Management','description' => 'Search, filter, reply, and resolve customer feedback']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dashboard.panel'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Feedback Management','description' => 'Search, filter, reply, and resolve customer feedback']); ?>
    <form class="grid gap-3 rounded-2xl border border-gray-100 bg-gray-50/70 p-3 xl:grid-cols-[minmax(260px,1fr)_160px_160px_130px_auto]">
        <input name="search" value="<?php echo e(request('search')); ?>" placeholder="Search customer, email, invoice, or feedback" class="h-11 rounded-xl border-gray-200 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500">
        <select name="category" class="h-11 rounded-xl border-gray-200 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500">
            <option value="">All categories</option>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($category); ?>" <?php if(request('category') === $category): echo 'selected'; endif; ?>><?php echo e(ucfirst($category)); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <select name="status" class="h-11 rounded-xl border-gray-200 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500">
            <option value="">All status</option>
            <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($status); ?>" <?php if(request('status') === $status): echo 'selected'; endif; ?>><?php echo e(ucfirst($status)); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <select name="rating" class="h-11 rounded-xl border-gray-200 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500">
            <option value="">All rating</option>
            <?php for($rating = 5; $rating >= 1; $rating--): ?>
                <option value="<?php echo e($rating); ?>" <?php if((string) request('rating') === (string) $rating): echo 'selected'; endif; ?>><?php echo e($rating); ?> / 5</option>
            <?php endfor; ?>
        </select>
        <button class="h-11 rounded-xl bg-gray-950 px-4 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">Search</button>
    </form>

    <div class="mt-5 grid gap-4">
        <?php $__empty_1 = true; $__currentLoopData = $feedbacks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feedback): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <article class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm shadow-gray-200/70">
                <div class="flex flex-col gap-4 xl:flex-row xl:items-start xl:justify-between">
                    <div class="min-w-0 flex-1">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="rounded-full px-2.5 py-1 text-xs font-semibold ring-1 <?php echo e($statusStyles[$feedback->status] ?? $statusStyles['pending']); ?>"><?php echo e(ucfirst($feedback->status)); ?></span>
                            <span class="rounded-full px-2.5 py-1 text-xs font-semibold ring-1 <?php echo e($categoryStyles[$feedback->category] ?? $categoryStyles['other']); ?>"><?php echo e(ucfirst($feedback->category)); ?></span>
                            <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-700 ring-1 ring-gray-200">Rating <?php echo e($feedback->rating); ?>/5</span>
                        </div>
                        <h3 class="mt-3 text-base font-semibold text-gray-950"><?php echo e($feedback->title); ?></h3>
                        <p class="mt-2 text-sm leading-6 text-gray-600"><?php echo e($feedback->feedback); ?></p>

                        <div class="mt-4 grid gap-3 text-sm text-gray-600 md:grid-cols-3">
                            <div class="rounded-xl bg-gray-50 p-3">
                                <p class="text-xs font-semibold uppercase tracking-normal text-gray-400">Customer</p>
                                <p class="mt-1 font-semibold text-gray-950"><?php echo e($feedback->customer?->name ?? $feedback->user?->name ?? '-'); ?></p>
                                <p class="mt-0.5 truncate text-xs text-gray-500"><?php echo e($feedback->customer?->email ?? $feedback->user?->email ?? '-'); ?></p>
                            </div>
                            <div class="rounded-xl bg-gray-50 p-3">
                                <p class="text-xs font-semibold uppercase tracking-normal text-gray-400">Order</p>
                                <p class="mt-1 font-semibold text-gray-950"><?php echo e($feedback->order?->invoice_number ?: '-'); ?></p>
                                <p class="mt-0.5 truncate text-xs text-gray-500"><?php echo e($feedback->order?->item?->name ?? $feedback->order?->description ?? 'No linked order'); ?></p>
                            </div>
                            <div class="rounded-xl bg-gray-50 p-3">
                                <p class="text-xs font-semibold uppercase tracking-normal text-gray-400">Submitted</p>
                                <p class="mt-1 font-semibold text-gray-950"><?php echo e($feedback->created_at->format('d M Y')); ?></p>
                                <p class="mt-0.5 text-xs text-gray-500"><?php echo e($feedback->created_at->format('H:i')); ?></p>
                            </div>
                        </div>

                        <?php if($feedback->admin_reply): ?>
                            <div class="mt-4 rounded-2xl border border-blue-100 bg-blue-50 p-4">
                                <p class="text-xs font-semibold uppercase tracking-normal text-blue-700">Current Reply</p>
                                <p class="mt-2 text-sm leading-6 text-blue-950"><?php echo e($feedback->admin_reply); ?></p>
                                <p class="mt-2 text-xs text-blue-700"><?php echo e($feedback->replier?->name ?: 'Admin'); ?><?php echo e($feedback->replied_at ? ' - '.$feedback->replied_at->format('d M Y H:i') : ''); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <form method="post" action="<?php echo e(route('crm.feedback.update', $feedback)); ?>" class="w-full shrink-0 rounded-2xl border border-gray-100 bg-gray-50/80 p-4 xl:w-80">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PATCH'); ?>
                        <div class="grid gap-3">
                            <label class="grid gap-2">
                                <span class="text-xs font-semibold uppercase tracking-normal text-gray-500">Status</span>
                                <select name="status" class="rounded-xl border-gray-200 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($status); ?>" <?php if($feedback->status === $status): echo 'selected'; endif; ?>><?php echo e(ucfirst($status)); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </label>
                            <label class="grid gap-2">
                                <span class="text-xs font-semibold uppercase tracking-normal text-gray-500">Reply</span>
                                <textarea name="admin_reply" rows="5" class="rounded-xl border-gray-200 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500"><?php echo e(old('admin_reply', $feedback->admin_reply)); ?></textarea>
                            </label>
                            <button class="rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm shadow-blue-200 transition hover:bg-blue-700">Save Reply</button>
                        </div>
                    </form>
                </div>

                <?php if($feedback->status !== 'resolved'): ?>
                    <form method="post" action="<?php echo e(route('crm.feedback.resolve', $feedback)); ?>" class="mt-4">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PATCH'); ?>
                        <button class="rounded-xl border border-emerald-200 px-4 py-2.5 text-sm font-semibold text-emerald-700 transition hover:bg-emerald-50">Mark Resolved</button>
                    </form>
                <?php endif; ?>
            </article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="rounded-2xl border border-dashed border-gray-300 bg-gray-50 p-8 text-center text-sm text-gray-500">
                Belum ada feedback customer.
            </div>
        <?php endif; ?>
    </div>

    <div class="mt-5"><?php echo e($feedbacks->links()); ?></div>
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/crm/feedback/index.blade.php ENDPATH**/ ?>