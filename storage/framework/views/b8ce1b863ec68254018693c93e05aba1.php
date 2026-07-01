

<?php $__env->startSection('title', $customer->name); ?>
<?php $__env->startSection('actions'); ?>
<div class="flex gap-2">
    <a href="<?php echo e(route('customers.edit', $customer)); ?>" class="rounded bg-moss px-4 py-2 text-sm font-semibold text-white">Edit Customer</a>
    <a href="<?php echo e(route('customers.timeline', $customer)); ?>" class="rounded bg-ink px-4 py-2 text-sm font-semibold text-white">Timeline</a>
    <a href="<?php echo e(route('customers.index')); ?>" class="rounded bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-600">Kembali</a>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="grid gap-6 lg:grid-cols-[1fr_380px]">
    <div class="space-y-6">
        <section class="rounded-lg bg-white p-5 shadow-sm">
            <div class="grid gap-4 text-sm md:grid-cols-2">
                <div><p class="text-gray-500">Email</p><p class="font-semibold"><?php echo e($customer->email ?: '-'); ?></p></div>
                <div><p class="text-gray-500">Telepon</p><p class="font-semibold"><?php echo e($customer->phone ?: '-'); ?></p></div>
                <div><p class="text-gray-500">Perusahaan</p><p class="font-semibold"><?php echo e($customer->company ?: '-'); ?></p></div>
                <div><p class="text-gray-500">Status</p><p class="font-semibold"><?php echo e($customer->status); ?></p></div>
                <div><p class="text-gray-500">Source</p><p class="font-semibold"><?php echo e($customer->source); ?></p></div>
                <div><p class="text-gray-500">User Terkait</p><p class="font-semibold"><?php echo e($customer->user?->name ?: '-'); ?></p></div>
            </div>
            <?php if($customer->notes): ?>
                <div class="mt-4 border-t pt-4 text-sm">
                    <p class="text-gray-500">Catatan</p>
                    <p class="mt-1 whitespace-pre-line"><?php echo e($customer->notes); ?></p>
                </div>
            <?php endif; ?>
        </section>

        <section class="rounded-lg bg-white p-5 shadow-sm">
            <h2 class="mb-4 font-bold">Timeline Interaksi</h2>
            <form method="post" action="<?php echo e(route('customers.interactions.store', $customer)); ?>" class="mb-5 grid gap-3">
                <?php echo csrf_field(); ?>
                <div class="grid gap-3 md:grid-cols-3">
                    <select name="type" required class="rounded border-gray-300">
                        <?php $__currentLoopData = ['note' => 'Catatan', 'call' => 'Telepon', 'email' => 'Email', 'meeting' => 'Meeting', 'chat' => 'Chat', 'order' => 'Order']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($value); ?>"><?php echo e($label); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <input name="occurred_at" type="datetime-local" class="rounded border-gray-300">
                    <input name="summary" required placeholder="Ringkasan" class="rounded border-gray-300 md:col-span-1">
                </div>
                <textarea name="description" rows="3" placeholder="Detail interaksi" class="rounded border-gray-300"></textarea>
                <button class="w-fit rounded bg-ink px-4 py-2 text-sm font-semibold text-white">Catat Interaksi</button>
            </form>

            <div class="space-y-3">
                <?php $__empty_1 = true; $__currentLoopData = $customer->interactions->sortByDesc('occurred_at'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $interaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="border-t pt-3 text-sm">
                        <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
                            <strong><?php echo e($interaction->summary); ?></strong>
                            <span class="text-xs text-gray-500"><?php echo e($interaction->occurred_at->format('d M Y H:i')); ?> oleh <?php echo e($interaction->user->name); ?></span>
                        </div>
                        <p class="mt-1 text-xs uppercase text-moss"><?php echo e($interaction->type); ?></p>
                        <?php if($interaction->description): ?>
                            <p class="mt-2 whitespace-pre-line text-gray-600"><?php echo e($interaction->description); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-sm text-gray-500">Belum ada interaksi.</p>
                <?php endif; ?>
            </div>
        </section>
    </div>

    <aside class="space-y-6">
        <section class="rounded-lg bg-white p-5 shadow-sm">
            <h2 class="mb-4 font-bold">Buat Follow Up</h2>
            <form method="post" action="<?php echo e(route('customers.follow-ups.store', $customer)); ?>" class="grid gap-3 text-sm">
                <?php echo csrf_field(); ?>
                <input name="title" required placeholder="Judul follow up" class="rounded border-gray-300">
                <select name="assigned_to" required class="rounded border-gray-300">
                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($user->id); ?>" <?php if($user->id === auth()->id()): echo 'selected'; endif; ?>><?php echo e($user->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <input name="due_at" type="datetime-local" class="rounded border-gray-300">
                <textarea name="description" rows="3" placeholder="Detail follow up" class="rounded border-gray-300"></textarea>
                <button class="rounded bg-moss px-4 py-2 font-semibold text-white">Buat Follow Up</button>
            </form>
        </section>

        <section class="rounded-lg bg-white p-5 shadow-sm">
            <h2 class="mb-4 font-bold">Follow Up</h2>
            <div class="space-y-4">
                <?php $__empty_1 = true; $__currentLoopData = $customer->followUps->sortByDesc('created_at'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $followUp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="border-t pt-4 text-sm first:border-t-0 first:pt-0">
                        <form method="post" action="<?php echo e(route('follow-ups.update', $followUp)); ?>" class="grid gap-2">
                            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                            <input name="title" value="<?php echo e($followUp->title); ?>" required class="rounded border-gray-300">
                            <select name="assigned_to" required class="rounded border-gray-300">
                                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($user->id); ?>" <?php if($followUp->assigned_to === $user->id): echo 'selected'; endif; ?>><?php echo e($user->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <select name="status" required class="rounded border-gray-300">
                                <option value="open" <?php if($followUp->status === 'open'): echo 'selected'; endif; ?>>Open</option>
                                <option value="done" <?php if($followUp->status === 'done'): echo 'selected'; endif; ?>>Done</option>
                                <option value="cancelled" <?php if($followUp->status === 'cancelled'): echo 'selected'; endif; ?>>Cancelled</option>
                            </select>
                            <input name="due_at" type="datetime-local" value="<?php echo e($followUp->due_at?->format('Y-m-d\TH:i')); ?>" class="rounded border-gray-300">
                            <textarea name="description" rows="2" class="rounded border-gray-300"><?php echo e($followUp->description); ?></textarea>
                            <div class="flex gap-2">
                                <button class="rounded bg-ink px-3 py-2 text-xs font-semibold text-white">Update</button>
                                <?php if($followUp->status !== 'done'): ?>
                                    <button form="complete-follow-up-<?php echo e($followUp->id); ?>" class="rounded bg-moss px-3 py-2 text-xs font-semibold text-white">Selesai</button>
                                <?php endif; ?>
                            </div>
                        </form>
                        <?php if($followUp->status !== 'done'): ?>
                            <form id="complete-follow-up-<?php echo e($followUp->id); ?>" method="post" action="<?php echo e(route('follow-ups.complete', $followUp)); ?>" class="hidden">
                                <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                            </form>
                        <?php endif; ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-sm text-gray-500">Belum ada follow up.</p>
                <?php endif; ?>
            </div>
        </section>
    </aside>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\inventori\resources\views\customers\show.blade.php ENDPATH**/ ?>