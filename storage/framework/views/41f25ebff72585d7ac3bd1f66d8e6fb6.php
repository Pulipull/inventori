<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>NexStock - Enterprise Inventory Platform</title>
    <link rel="icon" type="image/svg+xml" href="<?php echo e(asset('brand/nexstock-logo.svg')); ?>">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="min-h-screen bg-gray-50 font-sans text-slate-950 antialiased">
    <main class="relative min-h-screen overflow-hidden bg-[radial-gradient(circle_at_top_left,rgba(37,99,235,0.12),transparent_32%),linear-gradient(135deg,#ffffff_0%,#f8fafc_46%,#eff6ff_100%)]">
        <div class="pointer-events-none absolute -left-24 top-24 h-72 w-72 rounded-full bg-blue-200/30 blur-3xl"></div>
        <div class="pointer-events-none absolute -right-24 bottom-20 h-80 w-80 rounded-full bg-slate-300/30 blur-3xl"></div>
        <div class="pointer-events-none absolute inset-0 opacity-[0.035] [background-image:linear-gradient(#0f172a_1px,transparent_1px),linear-gradient(90deg,#0f172a_1px,transparent_1px)] [background-size:48px_48px]"></div>

        <section class="relative mx-auto grid min-h-screen max-w-7xl gap-12 px-5 py-8 sm:px-8 lg:grid-cols-[65fr_35fr] lg:items-center lg:px-10 lg:py-12">
            <div class="flex min-h-[680px] flex-col justify-between">
                <header class="flex items-center justify-between gap-4">
                    <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-4">
                        <img src="<?php echo e(asset('brand/nexstock-logo.svg')); ?>" alt="NexStock" class="h-14 w-14 rounded-2xl object-cover shadow-xl shadow-blue-950/10">
                        <span>
                            <span class="block text-xl font-semibold tracking-normal text-slate-950">NexStock</span>
                            <span class="block text-xs font-semibold uppercase tracking-normal text-blue-600">Enterprise Inventory Platform</span>
                        </span>
                    </a>

                    <?php if(auth()->guard()->check()): ?>
                        <a href="<?php echo e(route('dashboard')); ?>" class="rounded-2xl bg-slate-950 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-slate-200 transition hover:bg-blue-700">Dashboard</a>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>" class="rounded-2xl bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm shadow-slate-200 ring-1 ring-slate-200/70 transition hover:text-blue-700 hover:ring-blue-200">Masuk</a>
                    <?php endif; ?>
                </header>

                <div class="py-12 lg:py-16">
                    <img src="<?php echo e(asset('brand/nexstock-logo.svg')); ?>" alt="NexStock" class="h-24 w-24 rounded-[1.75rem] object-cover shadow-2xl shadow-blue-950/10">
                    <p class="mt-8 text-sm font-semibold uppercase tracking-normal text-blue-600">Inventory • CRM • Reporting • AI Assistant</p>
                    <h1 class="mt-4 max-w-4xl text-5xl font-semibold leading-tight tracking-normal text-slate-950 sm:text-6xl lg:text-7xl">
                        NexStock
                    </h1>
                    <p class="mt-5 text-2xl font-semibold text-slate-700">
                        Enterprise Inventory Platform
                    </p>
                    <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-600">
                        Manage inventory, CRM, reporting, payments and operations from one intelligent workspace.
                    </p>

                    <div class="mt-10 grid max-w-4xl gap-4 sm:grid-cols-2 xl:grid-cols-4">
                        <?php $__currentLoopData = [
                            ['Inventory', 'Stock control and item visibility'],
                            ['CRM', 'Customer records and follow-up flow'],
                            ['Reporting', 'Operational and revenue summaries'],
                            ['Payment DOKU', 'Checkout and payment status'],
                            ['Internal Chat', 'Team conversation workspace'],
                            ['Notifications', 'Business alerts and read states'],
                            ['Google OAuth', 'Secure account access'],
                            ['AI Assistant', 'Coming Soon'],
                        ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$title, $description]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <article class="rounded-2xl bg-white/85 p-5 shadow-sm shadow-slate-200/70 ring-1 ring-white/70 backdrop-blur transition hover:-translate-y-0.5 hover:shadow-xl hover:shadow-blue-950/5">
                                <div class="mb-4 h-10 w-10 rounded-2xl bg-blue-50 ring-1 ring-blue-100">
                                    <div class="m-auto h-full w-2 rounded-full bg-blue-600"></div>
                                </div>
                                <h2 class="text-sm font-semibold text-slate-950"><?php echo e($title); ?></h2>
                                <p class="mt-2 min-h-10 text-sm leading-5 text-slate-500"><?php echo e($description); ?></p>
                            </article>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <footer class="text-sm text-slate-500">
                    <span class="font-semibold text-slate-700">NexStock</span>
                    <span class="mx-2 text-slate-300">/</span>
                    Enterprise Inventory Platform
                </footer>
            </div>

            <aside class="flex items-center justify-center lg:justify-end">
                <div class="w-full max-w-md rounded-[2rem] bg-white/70 p-3 shadow-2xl shadow-blue-950/10 ring-1 ring-white/80 backdrop-blur-2xl">
                    <div class="rounded-[1.5rem] bg-white/90 p-8 shadow-inner shadow-white ring-1 ring-slate-100">
                        <img src="<?php echo e(asset('brand/nexstock-logo.svg')); ?>" alt="NexStock" class="mx-auto h-16 w-16 rounded-2xl object-cover shadow-lg shadow-blue-950/10">

                        <div class="mt-8 text-center">
                            <h2 class="text-3xl font-semibold tracking-normal text-slate-950">Welcome Back</h2>
                            <p class="mt-3 text-sm leading-6 text-slate-500">Continue securely with Google</p>
                        </div>

                        <div class="mt-8">
                            <?php if(auth()->guard()->check()): ?>
                                <a href="<?php echo e(route('dashboard')); ?>" class="flex w-full items-center justify-center rounded-2xl bg-blue-600 px-5 py-4 text-base font-semibold text-white shadow-lg shadow-blue-200 transition hover:bg-blue-700">
                                    Continue to Dashboard
                                </a>
                            <?php else: ?>
                                <a href="<?php echo e(route('auth.google.redirect')); ?>" class="flex w-full items-center justify-center gap-3 rounded-2xl bg-blue-600 px-5 py-4 text-base font-semibold text-white shadow-lg shadow-blue-200 transition hover:bg-blue-700">
                                    <span class="grid h-7 w-7 place-items-center rounded-full bg-white text-sm font-bold text-blue-700">G</span>
                                    Continue with Google
                                </a>
                            <?php endif; ?>
                        </div>

                        <div class="mt-6 grid grid-cols-3 gap-3 text-center text-xs font-semibold text-slate-500">
                            <div class="rounded-2xl bg-slate-50 px-3 py-3">OAuth</div>
                            <div class="rounded-2xl bg-slate-50 px-3 py-3">Encrypted</div>
                            <div class="rounded-2xl bg-slate-50 px-3 py-3">No password stored</div>
                        </div>

                        <div class="mt-8 border-t border-slate-100 pt-5 text-center text-xs leading-5 text-slate-400">
                            Protected access for authorized NexStock users.
                        </div>
                    </div>
                </div>
            </aside>
        </section>
    </main>
</body>
</html>
<?php /**PATH /var/www/html/resources/views/home.blade.php ENDPATH**/ ?>