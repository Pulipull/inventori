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
    $role = trim((string) $user->role);
    $isBuyer = $role === 'user';
    $isAdmin = $role === 'admin';
    $isSuperAdmin = $role === 'super_admin';
    $canOperate = $isAdmin || $isSuperAdmin;

    $link = fn(string $label, ?string $route = null, array $params = [], ?string $url = null) => [
        'label' => $label,
        'route' => $route,
        'params' => $params,
        'url' => $url,
    ];

    $groups = [
        'Dashboard' => [
            $link('Dashboard', 'dashboard'),
        ],
    ];

    if ($isBuyer) {
        $groups['Buyer'] = [
            $link('Checkout', 'checkout.index'),
            $link('Order History', null, [], route('dashboard').'#order-history'),
            $link('Tracking', 'tracking.index'),
            $link('Profile'),
            $link('Notifications', 'notification-preferences.edit'),
            $link('Feedback', 'feedback.index'),
        ];
    }

    if ($canOperate) {
        $groups['Inventory'] = [
            $link('Inventory', 'items.index'),
            $link('Categories', 'categories.index'),
            $link('Transactions', 'transactions.index'),
        ];

        $groups['CRM'] = [
            $link('CRM', 'customers.index'),
            $link('Feedback Management', 'crm.feedback.index'),
        ];

        $groups['Reporting'] = [
            $link('Stock Report', 'reports.stock'),
            $link('Sales Report', 'reports.sales'),
            $link('Payment Report', 'reports.payments'),
            $link('Revenue Report', 'reports.revenue'),
        ];

        $groups['Communication'] = [
            $link('Notifications', 'notifications.index'),
            $link('Chat', 'chat.index'),
        ];
    }

    if ($isSuperAdmin) {
        $groups['System'] = [
            $link('User Management', 'admin.users.index'),
            $link('Storage', 'storage.files'),
            $link('System Center', 'system.index'),
            $link('Report Export', 'reports.exports.index'),
            $link('Settings', 'settings.index'),
        ];
    }
?>

<aside class="flex flex-col border-b border-gray-200/70 bg-white lg:sticky lg:top-0 lg:h-screen lg:w-72 lg:shrink-0 lg:overflow-hidden lg:border-b-0 lg:border-r">
    <div class="shrink-0 px-5 py-6">
        <a href="<?php echo e(route('dashboard')); ?>" class="flex min-w-0 items-center gap-4">
            <img src="<?php echo e(asset('brand/nexstock-logo.svg')); ?>" alt="NexStock" class="h-14 w-14 shrink-0 rounded-2xl object-cover shadow-lg shadow-blue-950/10">
            <span class="min-w-0">
                <span class="block truncate text-lg font-semibold tracking-normal text-slate-950">NexStock</span>
                <span class="block text-xs font-medium text-slate-500">Enterprise Inventory Platform</span>
            </span>
        </a>
        <span class="mt-4 inline-flex rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold uppercase tracking-normal text-blue-700">
            <?php echo e(str_replace('_', ' ', $role)); ?>

        </span>
    </div>

    <nav class="flex gap-4 overflow-x-auto px-4 pb-4 text-sm lg:min-h-0 lg:flex-1 lg:grid lg:gap-5 lg:overflow-y-auto lg:overflow-x-hidden lg:px-4 lg:pb-6 lg:pr-3">
        <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group => $links): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="min-w-44 lg:min-w-0">
                <p class="mb-2 px-3 text-xs font-semibold uppercase tracking-normal text-slate-400"><?php echo e($group); ?></p>
                <div class="grid gap-1">
                    <?php $__currentLoopData = $links; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $routeDefinition = $item['route'] ? \Illuminate\Support\Facades\Route::getRoutes()->getByName($item['route']) : null;
                            $routeIsNavigable = $routeDefinition && in_array('GET', $routeDefinition->methods(), true);
                            $href = $item['url'] ?? ($routeIsNavigable ? route($item['route'], $item['params']) : null);
                            $active = $routeIsNavigable ? request()->routeIs($item['route'], $item['route'].'.*') : false;
                        ?>

                        <?php if($href): ?>
                            <a
                                href="<?php echo e($href); ?>"
                                class="rounded-2xl px-3 py-2.5 font-medium transition <?php echo e($active ? 'bg-blue-50 text-blue-700 shadow-sm shadow-blue-100/60' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-950'); ?>"
                            >
                                <?php echo e($item['label']); ?>

                            </a>
                        <?php else: ?>
                            <span class="cursor-not-allowed rounded-2xl px-3 py-2.5 font-medium text-slate-400">
                                <?php echo e($item['label']); ?>

                            </span>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </nav>

    <form method="post" action="<?php echo e(route('logout')); ?>" class="shrink-0 border-t border-gray-100 px-5 py-5">
        <?php echo csrf_field(); ?>
        <button type="submit" class="w-full rounded-2xl bg-slate-950 px-4 py-3 text-left text-sm font-semibold text-white shadow-lg shadow-slate-200 transition hover:bg-blue-700">
            Keluar
        </button>
    </form>
</aside>
<?php /**PATH /var/www/html/resources/views/components/dashboard/sidebar.blade.php ENDPATH**/ ?>