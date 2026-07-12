<?php $__env->startSection('title', 'Dashboard Operasional'); ?>

<?php $__env->startSection('actions'); ?>
<div class="flex flex-wrap gap-2">
    <a href="<?php echo e(route('transactions.create', 'in')); ?>" class="rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm shadow-blue-200 transition hover:bg-blue-700">Barang Masuk</a>
    <a href="<?php echo e(route('transactions.create', 'out')); ?>" class="rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 shadow-sm transition hover:border-blue-200 hover:text-blue-700">Barang Keluar</a>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php
    $isSuperAdmin = auth()->user()->role === 'super_admin';

    $stats = [
        ['Total Barang', $itemCount, 'Item aktif di inventori', 'blue'],
        ['Kategori', $categoryCount, 'Klasifikasi barang', 'gray'],
        ['Customer', $customerCount, 'Data CRM tersimpan', 'green'],
        ['Revenue', 'Rp '.number_format($paidRevenueTotal, 0, ',', '.'), 'Total pembayaran lunas', 'blue'],
        ['Order', $paidOrderCount, 'Order selesai', 'green'],
        ['Pending Payment', $pendingOrderCount, 'Menunggu pembayaran', 'amber'],
        ['Unread Notification', $unreadNotificationCount, 'Belum dibaca', 'red'],
        ['Low Stock', $lowStockCount, 'Perlu perhatian', 'amber'],
    ];

    $maxTrend = max(1, (float) $revenueTrend->max('total'));
?>

<div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
    <?php $__currentLoopData = $stats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$label, $value, $hint, $tone]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if (isset($component)) { $__componentOriginal457ade557f73eaa008f851091260abe1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal457ade557f73eaa008f851091260abe1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.stat-card','data' => ['label' => $label,'value' => $value,'hint' => $hint,'tone' => $tone]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dashboard.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($label),'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($value),'hint' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($hint),'tone' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tone)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal457ade557f73eaa008f851091260abe1)): ?>
<?php $attributes = $__attributesOriginal457ade557f73eaa008f851091260abe1; ?>
<?php unset($__attributesOriginal457ade557f73eaa008f851091260abe1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal457ade557f73eaa008f851091260abe1)): ?>
<?php $component = $__componentOriginal457ade557f73eaa008f851091260abe1; ?>
<?php unset($__componentOriginal457ade557f73eaa008f851091260abe1); ?>
<?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<div class="mt-6 grid gap-6 xl:grid-cols-[1.25fr_0.75fr]">
    <?php if (isset($component)) { $__componentOriginalf868fe28be572e81ef311c666230e847 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf868fe28be572e81ef311c666230e847 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.panel','data' => ['title' => 'Revenue Trend','description' => 'Ringkasan pendapatan 7 hari terakhir']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dashboard.panel'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Revenue Trend','description' => 'Ringkasan pendapatan 7 hari terakhir']); ?>
        <div class="flex h-64 items-end gap-3 rounded-xl bg-gray-50 p-4">
            <?php $__currentLoopData = $revenueTrend; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trend): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="flex min-w-0 flex-1 flex-col items-center gap-2">
                    <div class="flex h-44 w-full items-end rounded-full bg-white px-1.5 py-1.5 shadow-inner">
                        <div
                            class="w-full rounded-full bg-blue-600"
                            style="height: <?php echo e(max(8, ((float) $trend['total'] / $maxTrend) * 100)); ?>%"
                        ></div>
                    </div>
                    <div class="w-full text-center">
                        <p class="truncate text-xs font-medium text-gray-500"><?php echo e($trend['date']); ?></p>
                        <p class="truncate text-xs font-semibold text-gray-900">Rp <?php echo e(number_format($trend['total'], 0, ',', '.')); ?></p>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
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

    <?php if (isset($component)) { $__componentOriginalf868fe28be572e81ef311c666230e847 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf868fe28be572e81ef311c666230e847 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.panel','data' => ['title' => 'Recent Orders','description' => 'Status pembayaran terbaru']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dashboard.panel'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Recent Orders','description' => 'Status pembayaran terbaru']); ?>
        <div class="space-y-1">
            <?php if (isset($component)) { $__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.status-row','data' => ['label' => 'Lunas','value' => $paidOrderCount,'tone' => 'green','meta' => 'Order berhasil dibayar']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dashboard.status-row'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Lunas','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($paidOrderCount),'tone' => 'green','meta' => 'Order berhasil dibayar']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf)): ?>
<?php $attributes = $__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf; ?>
<?php unset($__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf)): ?>
<?php $component = $__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf; ?>
<?php unset($__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.status-row','data' => ['label' => 'Pending','value' => $pendingOrderCount,'tone' => 'amber','meta' => 'Menunggu pembayaran']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dashboard.status-row'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Pending','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pendingOrderCount),'tone' => 'amber','meta' => 'Menunggu pembayaran']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf)): ?>
<?php $attributes = $__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf; ?>
<?php unset($__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf)): ?>
<?php $component = $__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf; ?>
<?php unset($__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.status-row','data' => ['label' => 'Gagal','value' => $failedPaymentCount,'tone' => 'red','meta' => 'Pembayaran gagal']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dashboard.status-row'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Gagal','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($failedPaymentCount),'tone' => 'red','meta' => 'Pembayaran gagal']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf)): ?>
<?php $attributes = $__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf; ?>
<?php unset($__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf)): ?>
<?php $component = $__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf; ?>
<?php unset($__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.status-row','data' => ['label' => 'Expired','value' => $expiredPaymentCount,'tone' => 'gray','meta' => 'Invoice kedaluwarsa']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dashboard.status-row'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Expired','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($expiredPaymentCount),'tone' => 'gray','meta' => 'Invoice kedaluwarsa']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf)): ?>
<?php $attributes = $__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf; ?>
<?php unset($__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf)): ?>
<?php $component = $__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf; ?>
<?php unset($__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf); ?>
<?php endif; ?>
        </div>
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
</div>

<div class="mt-6 grid gap-6 <?php echo e($isSuperAdmin ? 'xl:grid-cols-4' : 'xl:grid-cols-2'); ?>">
    <?php if (isset($component)) { $__componentOriginalf868fe28be572e81ef311c666230e847 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf868fe28be572e81ef311c666230e847 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.panel','data' => ['title' => 'Recent Notifications','description' => 'Kondisi komunikasi sistem']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dashboard.panel'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Recent Notifications','description' => 'Kondisi komunikasi sistem']); ?>
        <div class="grid gap-3">
            <div class="rounded-xl bg-blue-50 p-4">
                <p class="text-sm font-medium text-blue-700">Notifikasi belum dibaca</p>
                <p class="mt-2 text-3xl font-semibold text-blue-950"><?php echo e($unreadNotificationCount); ?></p>
            </div>
            <a href="<?php echo e(route('notifications.index')); ?>" class="rounded-xl border border-gray-200 px-4 py-3 text-sm font-semibold text-gray-700 transition hover:border-blue-200 hover:text-blue-700">Buka notifikasi</a>
        </div>
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

    <?php if (isset($component)) { $__componentOriginalf868fe28be572e81ef311c666230e847 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf868fe28be572e81ef311c666230e847 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.panel','data' => ['title' => 'Recent Chat','description' => 'Aktivitas percakapan internal']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dashboard.panel'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Recent Chat','description' => 'Aktivitas percakapan internal']); ?>
        <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-1">
            <?php if (isset($component)) { $__componentOriginal457ade557f73eaa008f851091260abe1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal457ade557f73eaa008f851091260abe1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.stat-card','data' => ['label' => 'Percakapan Aktif','value' => $activeConversationCount,'tone' => 'blue']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dashboard.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Percakapan Aktif','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($activeConversationCount),'tone' => 'blue']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal457ade557f73eaa008f851091260abe1)): ?>
<?php $attributes = $__attributesOriginal457ade557f73eaa008f851091260abe1; ?>
<?php unset($__attributesOriginal457ade557f73eaa008f851091260abe1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal457ade557f73eaa008f851091260abe1)): ?>
<?php $component = $__componentOriginal457ade557f73eaa008f851091260abe1; ?>
<?php unset($__componentOriginal457ade557f73eaa008f851091260abe1); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal457ade557f73eaa008f851091260abe1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal457ade557f73eaa008f851091260abe1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.stat-card','data' => ['label' => 'Belum Dibaca','value' => $unreadConversationCount,'tone' => 'amber']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dashboard.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Belum Dibaca','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($unreadConversationCount),'tone' => 'amber']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal457ade557f73eaa008f851091260abe1)): ?>
<?php $attributes = $__attributesOriginal457ade557f73eaa008f851091260abe1; ?>
<?php unset($__attributesOriginal457ade557f73eaa008f851091260abe1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal457ade557f73eaa008f851091260abe1)): ?>
<?php $component = $__componentOriginal457ade557f73eaa008f851091260abe1; ?>
<?php unset($__componentOriginal457ade557f73eaa008f851091260abe1); ?>
<?php endif; ?>
            <a href="<?php echo e(route('chat.index')); ?>" class="rounded-xl bg-gray-950 px-4 py-3 text-center text-sm font-semibold text-white transition hover:bg-blue-700">Buka chat</a>
        </div>
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

    <?php if($isSuperAdmin): ?>
        <?php if (isset($component)) { $__componentOriginalf868fe28be572e81ef311c666230e847 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf868fe28be572e81ef311c666230e847 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.panel','data' => ['title' => 'System Health','description' => 'Storage dan integration']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dashboard.panel'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'System Health','description' => 'Storage dan integration']); ?>
            <div class="space-y-1">
                <?php if (isset($component)) { $__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.status-row','data' => ['label' => 'Total File Upload','value' => $storageFileCount,'tone' => 'blue']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dashboard.status-row'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Total File Upload','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($storageFileCount),'tone' => 'blue']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf)): ?>
<?php $attributes = $__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf; ?>
<?php unset($__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf)): ?>
<?php $component = $__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf; ?>
<?php unset($__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.status-row','data' => ['label' => 'Integration Pending','value' => $pendingIntegrationEventCount,'tone' => 'amber']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dashboard.status-row'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Integration Pending','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pendingIntegrationEventCount),'tone' => 'amber']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf)): ?>
<?php $attributes = $__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf; ?>
<?php unset($__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf)): ?>
<?php $component = $__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf; ?>
<?php unset($__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.status-row','data' => ['label' => 'Integration Processed','value' => $processedIntegrationEventCount,'tone' => 'green']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dashboard.status-row'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Integration Processed','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($processedIntegrationEventCount),'tone' => 'green']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf)): ?>
<?php $attributes = $__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf; ?>
<?php unset($__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf)): ?>
<?php $component = $__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf; ?>
<?php unset($__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.status-row','data' => ['label' => 'Total Export','value' => $reportExportCount,'tone' => 'gray']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dashboard.status-row'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Total Export','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($reportExportCount),'tone' => 'gray']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf)): ?>
<?php $attributes = $__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf; ?>
<?php unset($__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf)): ?>
<?php $component = $__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf; ?>
<?php unset($__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf); ?>
<?php endif; ?>
            </div>
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

        <?php if (isset($component)) { $__componentOriginalf868fe28be572e81ef311c666230e847 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf868fe28be572e81ef311c666230e847 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.panel','data' => ['title' => 'Feedback Statistics','description' => 'Aftersales customer signal']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dashboard.panel'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Feedback Statistics','description' => 'Aftersales customer signal']); ?>
            <div class="space-y-1">
                <?php if (isset($component)) { $__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.status-row','data' => ['label' => 'Pending','value' => $feedbackStats['pending'],'tone' => 'amber']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dashboard.status-row'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Pending','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($feedbackStats['pending']),'tone' => 'amber']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf)): ?>
<?php $attributes = $__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf; ?>
<?php unset($__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf)): ?>
<?php $component = $__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf; ?>
<?php unset($__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.status-row','data' => ['label' => 'Reviewed','value' => $feedbackStats['reviewed'],'tone' => 'blue']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dashboard.status-row'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Reviewed','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($feedbackStats['reviewed']),'tone' => 'blue']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf)): ?>
<?php $attributes = $__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf; ?>
<?php unset($__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf)): ?>
<?php $component = $__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf; ?>
<?php unset($__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.status-row','data' => ['label' => 'Resolved','value' => $feedbackStats['resolved'],'tone' => 'green']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dashboard.status-row'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Resolved','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($feedbackStats['resolved']),'tone' => 'green']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf)): ?>
<?php $attributes = $__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf; ?>
<?php unset($__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf)): ?>
<?php $component = $__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf; ?>
<?php unset($__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.status-row','data' => ['label' => 'Average Rating','value' => number_format($feedbackStats['average_rating'], 1).'/5','tone' => 'gray']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dashboard.status-row'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Average Rating','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(number_format($feedbackStats['average_rating'], 1).'/5'),'tone' => 'gray']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf)): ?>
<?php $attributes = $__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf; ?>
<?php unset($__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf)): ?>
<?php $component = $__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf; ?>
<?php unset($__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf); ?>
<?php endif; ?>
            </div>
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
    <?php endif; ?>
</div>

<div class="mt-6 grid gap-6 xl:grid-cols-2">
    <?php if (isset($component)) { $__componentOriginalf868fe28be572e81ef311c666230e847 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf868fe28be572e81ef311c666230e847 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.panel','data' => ['title' => 'Transaksi Terbaru','description' => 'Pergerakan barang terakhir']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dashboard.panel'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Transaksi Terbaru','description' => 'Pergerakan barang terakhir']); ?>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-gray-100 text-xs font-semibold uppercase tracking-normal text-gray-400">
                        <th class="pb-3">Barang</th>
                        <th class="pb-3">User</th>
                        <th class="pb-3 text-right">Qty</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php $__empty_1 = true; $__currentLoopData = $recentTransactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="py-3 pr-3 text-sm font-medium text-gray-900"><?php echo e($transaction->item->name); ?></td>
                            <td class="py-3 pr-3 text-sm text-gray-500"><?php echo e($transaction->user->name); ?></td>
                            <td class="py-3 text-right text-sm font-semibold <?php echo e($transaction->type === 'in' ? 'text-emerald-700' : 'text-rose-700'); ?>">
                                <?php echo e($transaction->type === 'in' ? '+' : '-'); ?><?php echo e($transaction->quantity); ?>

                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="3" class="py-6 text-center text-sm text-gray-500">Belum ada transaksi.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
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

    <?php if (isset($component)) { $__componentOriginalf868fe28be572e81ef311c666230e847 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf868fe28be572e81ef311c666230e847 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.panel','data' => ['title' => 'Stok Perlu Perhatian','description' => 'Barang di bawah minimum atau habis']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dashboard.panel'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Stok Perlu Perhatian','description' => 'Barang di bawah minimum atau habis']); ?>
        <div class="space-y-1">
            <?php $__empty_1 = true; $__currentLoopData = $lowItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php if (isset($component)) { $__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.status-row','data' => ['label' => $item->name,'value' => $item->stock.' '.$item->unit,'meta' => $item->category->name ?? 'Tanpa kategori','tone' => $item->stock <= 0 ? 'red' : 'amber']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dashboard.status-row'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item->name),'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item->stock.' '.$item->unit),'meta' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item->category->name ?? 'Tanpa kategori'),'tone' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item->stock <= 0 ? 'red' : 'amber')]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf)): ?>
<?php $attributes = $__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf; ?>
<?php unset($__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf)): ?>
<?php $component = $__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf; ?>
<?php unset($__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf); ?>
<?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="rounded-xl bg-gray-50 px-4 py-6 text-center text-sm text-gray-500">Semua stok aman.</p>
            <?php endif; ?>
        </div>
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
</div>

<div class="mt-6 grid gap-6 <?php echo e($isSuperAdmin ? 'xl:grid-cols-3' : 'xl:grid-cols-1'); ?>">
    <?php if($isSuperAdmin): ?>
        <?php if (isset($component)) { $__componentOriginalf868fe28be572e81ef311c666230e847 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf868fe28be572e81ef311c666230e847 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.panel','data' => ['title' => 'Export Laporan Terbaru']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dashboard.panel'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Export Laporan Terbaru']); ?>
            <div class="space-y-1">
                <?php $__empty_1 = true; $__currentLoopData = $recentReportExports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $export): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php if (isset($component)) { $__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.status-row','data' => ['label' => $export->report_type,'value' => $export->status,'meta' => 'oleh '.$export->user->name,'tone' => $export->status === 'completed' ? 'green' : ($export->status === 'failed' ? 'red' : 'amber')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dashboard.status-row'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($export->report_type),'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($export->status),'meta' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('oleh '.$export->user->name),'tone' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($export->status === 'completed' ? 'green' : ($export->status === 'failed' ? 'red' : 'amber'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf)): ?>
<?php $attributes = $__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf; ?>
<?php unset($__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf)): ?>
<?php $component = $__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf; ?>
<?php unset($__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf); ?>
<?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="rounded-xl bg-gray-50 px-4 py-6 text-center text-sm text-gray-500">Belum ada export laporan.</p>
                <?php endif; ?>
            </div>
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

        <?php if (isset($component)) { $__componentOriginalf868fe28be572e81ef311c666230e847 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf868fe28be572e81ef311c666230e847 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.panel','data' => ['title' => 'Webhook Integration Terbaru']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dashboard.panel'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Webhook Integration Terbaru']); ?>
            <div class="space-y-1">
                <?php $__empty_1 = true; $__currentLoopData = $recentWebhookLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php if (isset($component)) { $__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.status-row','data' => ['label' => $log->source,'value' => $log->status,'meta' => $log->event_name,'tone' => $log->status === 'received' ? 'green' : 'red']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dashboard.status-row'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($log->source),'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($log->status),'meta' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($log->event_name),'tone' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($log->status === 'received' ? 'green' : 'red')]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf)): ?>
<?php $attributes = $__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf; ?>
<?php unset($__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf)): ?>
<?php $component = $__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf; ?>
<?php unset($__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf); ?>
<?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="rounded-xl bg-gray-50 px-4 py-6 text-center text-sm text-gray-500">Belum ada webhook integration.</p>
                <?php endif; ?>
            </div>
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
    <?php endif; ?>

    <?php if (isset($component)) { $__componentOriginalf868fe28be572e81ef311c666230e847 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf868fe28be572e81ef311c666230e847 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.panel','data' => ['title' => 'Aktivitas CRM Terbaru']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dashboard.panel'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Aktivitas CRM Terbaru']); ?>
        <div class="space-y-1">
            <?php $__empty_1 = true; $__currentLoopData = $recentCrmActivities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php if (isset($component)) { $__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.status-row','data' => ['label' => $activity->customer?->name ?: '-','value' => $activity->type,'meta' => $activity->description ?: $activity->type,'tone' => 'blue']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dashboard.status-row'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($activity->customer?->name ?: '-'),'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($activity->type),'meta' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($activity->description ?: $activity->type),'tone' => 'blue']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf)): ?>
<?php $attributes = $__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf; ?>
<?php unset($__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf)): ?>
<?php $component = $__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf; ?>
<?php unset($__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf); ?>
<?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="rounded-xl bg-gray-50 px-4 py-6 text-center text-sm text-gray-500">Belum ada aktivitas CRM.</p>
            <?php endif; ?>
        </div>
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
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/dashboard.blade.php ENDPATH**/ ?>