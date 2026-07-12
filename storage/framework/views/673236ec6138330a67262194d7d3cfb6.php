<?php $__env->startSection('title', 'Dashboard Pembeli'); ?>

<?php $__env->startSection('actions'); ?>
    <a href="<?php echo e(route('checkout.index')); ?>" class="inline-block rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm shadow-blue-200 transition hover:bg-blue-700">
        Checkout Manual
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="grid gap-4 sm:grid-cols-3">
        <?php if (isset($component)) { $__componentOriginal457ade557f73eaa008f851091260abe1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal457ade557f73eaa008f851091260abe1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.stat-card','data' => ['label' => 'Total Pesanan','value' => (int) ($orderSummary->total ?? 0),'hint' => 'Semua transaksi','tone' => 'blue']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dashboard.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Total Pesanan','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute((int) ($orderSummary->total ?? 0)),'hint' => 'Semua transaksi','tone' => 'blue']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.stat-card','data' => ['label' => 'Berhasil','value' => (int) ($orderSummary->paid ?? 0),'hint' => 'Pembayaran lunas','tone' => 'green']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dashboard.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Berhasil','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute((int) ($orderSummary->paid ?? 0)),'hint' => 'Pembayaran lunas','tone' => 'green']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.stat-card','data' => ['label' => 'Menunggu','value' => (int) ($orderSummary->pending ?? 0),'hint' => 'Pending payment','tone' => 'amber']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dashboard.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Menunggu','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute((int) ($orderSummary->pending ?? 0)),'hint' => 'Pending payment','tone' => 'amber']); ?>
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
    </div>

    <div class="mt-6 grid gap-6 xl:grid-cols-[1fr_0.95fr]">
        <?php if (isset($component)) { $__componentOriginalf868fe28be572e81ef311c666230e847 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf868fe28be572e81ef311c666230e847 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.panel','data' => ['title' => 'Barang Tersedia','description' => 'Katalog pilihan untuk checkout cepat']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dashboard.panel'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Barang Tersedia','description' => 'Katalog pilihan untuk checkout cepat']); ?>
             <?php $__env->slot('actions', null, []); ?> 
                <a href="<?php echo e(route('checkout.index')); ?>" class="text-sm font-semibold text-blue-700 hover:text-blue-800">Pesan manual</a>
             <?php $__env->endSlot(); ?>

            <div class="grid gap-4 sm:grid-cols-2">
                <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <article class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm shadow-gray-200/60">
                        <div class="aspect-[4/3] bg-gray-100">
                            <?php if($item->media_url && $item->media_type !== 'video'): ?>
                                <img src="<?php echo e($item->media_url); ?>" alt="<?php echo e($item->name); ?>" class="h-full w-full object-cover" loading="lazy">
                            <?php else: ?>
                                <div class="grid h-full place-items-center px-3 text-center text-sm font-semibold text-gray-500">
                                    <?php echo e($item->category->name ?? 'Barang'); ?>

                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="p-4">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <h3 class="truncate font-semibold text-gray-950"><?php echo e($item->name); ?></h3>
                                    <p class="mt-1 truncate text-xs text-gray-500"><?php echo e($item->code); ?> &middot; <?php echo e($item->category->name ?? '-'); ?></p>
                                </div>
                                <span class="shrink-0 rounded-full bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-700"><?php echo e($item->stock); ?></span>
                            </div>
                            <p class="mt-3 text-lg font-semibold text-gray-950">Rp <?php echo e(number_format($item->price, 0, ',', '.')); ?></p>
                            <p class="mt-2 line-clamp-2 min-h-10 text-sm leading-5 text-gray-500"><?php echo e($item->description ?: 'Barang siap dipesan.'); ?></p>
                            <a
                                href="<?php echo e(route('checkout.index', ['item_id' => $item->id, 'description' => 'Pesanan '.$item->name])); ?>"
                                class="mt-4 block rounded-xl bg-gray-950 px-3 py-2.5 text-center text-sm font-semibold text-white transition hover:bg-blue-700"
                            >
                                Pesan
                            </a>
                        </div>
                    </article>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="rounded-xl border border-dashed border-gray-300 bg-gray-50 p-8 text-center text-sm text-gray-500 sm:col-span-2">
                        Belum ada barang tersedia untuk dipesan.
                    </div>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.panel','data' => ['id' => 'order-history','title' => 'Recent Orders','description' => 'Riwayat pembayaran dan invoice']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dashboard.panel'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'order-history','title' => 'Recent Orders','description' => 'Riwayat pembayaran dan invoice']); ?>
            <?php if($orders->isEmpty()): ?>
                <div class="rounded-xl bg-gray-50 p-8 text-center">
                    <h3 class="font-semibold text-gray-950">Belum ada pesanan</h3>
                    <p class="mt-1 text-sm text-gray-500">Pilih barang dari katalog untuk membuat pesanan pertama.</p>
                </div>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-gray-100 text-xs font-semibold uppercase tracking-normal text-gray-400">
                                <th class="pb-3">Invoice</th>
                                <th class="pb-3">Barang</th>
                                <th class="pb-3 text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="py-3 pr-3">
                                        <p class="font-mono text-sm font-semibold text-gray-950"><?php echo e($order->invoice_number); ?></p>
                                        <p class="mt-0.5 text-xs text-gray-500"><?php echo e($order->created_at->format('d M Y H:i')); ?></p>
                                    </td>
                                    <td class="py-3 pr-3">
                                        <p class="max-w-48 truncate text-sm font-medium text-gray-800"><?php echo e($order->item?->name ?? $order->description ?? '-'); ?></p>
                                        <p class="mt-0.5 text-xs text-gray-500">Rp <?php echo e(number_format($order->amount, 0, ',', '.')); ?></p>
                                    </td>
                                    <td class="py-3 text-right">
                                        <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold
                                            <?php if($order->status === 'paid'): ?>
                                                bg-emerald-50 text-emerald-700
                                            <?php elseif($order->status === 'pending'): ?>
                                                bg-amber-50 text-amber-700
                                            <?php elseif($order->status === 'failed'): ?>
                                                bg-rose-50 text-rose-700
                                            <?php else: ?>
                                                bg-gray-100 text-gray-700
                                            <?php endif; ?>
                                        ">
                                            <?php echo e(ucfirst($order->status)); ?>

                                        </span>
                                        <?php if($order->status === 'pending' && $order->payment_url): ?>
                                            <a href="<?php echo e($order->payment_url); ?>" class="mt-2 block text-xs font-semibold text-blue-700 hover:text-blue-800">Bayar</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <?php if($orders->hasPages()): ?>
                    <div class="mt-4 border-t border-gray-100 pt-4">
                        <?php echo e($orders->links()); ?>

                    </div>
                <?php endif; ?>
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
    </div>

    <div class="mt-6 grid gap-6 lg:grid-cols-3">
        <?php if (isset($component)) { $__componentOriginalf868fe28be572e81ef311c666230e847 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf868fe28be572e81ef311c666230e847 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.panel','data' => ['title' => 'Feedback','description' => 'Status aftersales terbaru']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dashboard.panel'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Feedback','description' => 'Status aftersales terbaru']); ?>
             <?php $__env->slot('actions', null, []); ?> 
                <a href="<?php echo e(route('feedback.index')); ?>" class="text-sm font-semibold text-blue-700 hover:text-blue-800">Lihat semua</a>
             <?php $__env->endSlot(); ?>

            <div class="space-y-1">
                <?php $__empty_1 = true; $__currentLoopData = $feedbacks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feedback): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php if (isset($component)) { $__componentOriginal8c3b35b2f581c2b6fb12c58398dc69bf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c3b35b2f581c2b6fb12c58398dc69bf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.status-row','data' => ['label' => $feedback->title,'value' => ucfirst($feedback->status),'meta' => 'Rating '.$feedback->rating.'/5 - '.ucfirst($feedback->category),'tone' => $feedback->status === 'resolved' ? 'green' : ($feedback->status === 'reviewed' ? 'blue' : 'amber')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dashboard.status-row'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($feedback->title),'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(ucfirst($feedback->status)),'meta' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Rating '.$feedback->rating.'/5 - '.ucfirst($feedback->category)),'tone' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($feedback->status === 'resolved' ? 'green' : ($feedback->status === 'reviewed' ? 'blue' : 'amber'))]); ?>
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
                    <div class="rounded-xl bg-gray-50 p-5 text-sm text-gray-500">
                        Belum ada feedback. Kirim feedback untuk layanan aftersales.
                    </div>
                <?php endif; ?>
            </div>

            <a href="<?php echo e(route('feedback.create')); ?>" class="mt-4 block rounded-xl bg-gray-950 px-4 py-3 text-center text-sm font-semibold text-white transition hover:bg-blue-700">Kirim Feedback</a>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.panel','data' => ['title' => 'Recent Notifications','description' => 'Informasi akun dan pesanan']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dashboard.panel'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Recent Notifications','description' => 'Informasi akun dan pesanan']); ?>
            <div class="rounded-xl bg-gray-50 p-5 text-sm text-gray-500">
                Notifikasi pembeli akan tampil mengikuti data yang sudah tersedia di aplikasi.
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.panel','data' => ['title' => 'Recent Chat','description' => 'Komunikasi terkait layanan']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dashboard.panel'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Recent Chat','description' => 'Komunikasi terkait layanan']); ?>
            <div class="rounded-xl bg-gray-50 p-5 text-sm text-gray-500">
                Percakapan pembeli mengikuti akses chat yang sudah diatur oleh aplikasi.
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/user/dashboard.blade.php ENDPATH**/ ?>