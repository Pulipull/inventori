<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['user']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['user']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $notificationRoute = in_array($user->role, ['admin', 'super_admin'], true)
        ? route('notifications.index')
        : route('notification-preferences.edit');
?>

<header class="sticky top-0 z-20 border-b border-slate-200/70 bg-white/85 backdrop-blur-xl">
    <div class="flex min-h-20 flex-col gap-4 px-4 py-4 sm:px-6 lg:px-8 xl:flex-row xl:items-center xl:justify-between">
        <div class="flex min-w-0 items-center gap-4">
            <img src="<?php echo e(asset('brand/nexstock-logo.svg')); ?>" alt="NexStock" class="h-11 w-11 shrink-0 rounded-2xl object-cover shadow-md shadow-blue-950/10">
            <div class="min-w-0">
                <p class="text-xs font-semibold uppercase tracking-normal text-blue-600">NexStock</p>
                <h1 class="truncate text-2xl font-semibold tracking-normal text-slate-950"><?php echo $__env->yieldContent('title', 'Dashboard'); ?></h1>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <?php echo $__env->yieldContent('actions'); ?>
            <label class="relative hidden min-w-64 sm:block">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 3.473 9.766l2.631 2.63a.75.75 0 1 0 1.061-1.06l-2.63-2.632A5.5 5.5 0 0 0 9 3.5ZM5 9a4 4 0 1 1 8 0 4 4 0 0 1-8 0Z" clip-rule="evenodd" />
                    </svg>
                </span>
                <input type="search" placeholder="Search workspace" class="w-full rounded-2xl border-0 bg-slate-100/80 py-3 pl-9 pr-4 text-sm text-slate-700 shadow-inner shadow-slate-200/60 placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-blue-500">
            </label>
            <a href="<?php echo e($notificationRoute); ?>" class="grid h-11 w-11 place-items-center rounded-2xl bg-white text-slate-600 shadow-sm shadow-slate-200 ring-1 ring-slate-200/70 transition hover:text-blue-700 hover:ring-blue-200" aria-label="Notifications">
                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path d="M10 2a6 6 0 0 0-6 6v2.586l-.707.707A1 1 0 0 0 4 13h12a1 1 0 0 0 .707-1.707L16 10.586V8a6 6 0 0 0-6-6Z" />
                    <path d="M7.5 14a2.5 2.5 0 0 0 5 0h-5Z" />
                </svg>
            </a>
            <div class="flex items-center gap-3 rounded-2xl bg-white px-3 py-2 shadow-sm shadow-slate-200 ring-1 ring-slate-200/70">
                <?php if($user->avatar): ?>
                    <img src="<?php echo e($user->avatar); ?>" alt="<?php echo e($user->name); ?>" class="h-9 w-9 rounded-full object-cover">
                <?php else: ?>
                    <span class="grid h-9 w-9 place-items-center rounded-full bg-blue-600 text-sm font-semibold text-white">
                        <?php echo e(mb_substr($user->name, 0, 1)); ?>

                    </span>
                <?php endif; ?>
                <div class="min-w-0">
                    <p class="max-w-32 truncate text-sm font-semibold text-slate-900"><?php echo e($user->name); ?></p>
                    <p class="mt-0.5 inline-flex rounded-full bg-blue-50 px-2 py-0.5 text-[11px] font-semibold uppercase tracking-normal text-blue-700"><?php echo e($user->role); ?></p>
                </div>
            </div>
        </div>
    </div>
</header>
<?php /**PATH /var/www/html/resources/views/components/dashboard/navbar.blade.php ENDPATH**/ ?>