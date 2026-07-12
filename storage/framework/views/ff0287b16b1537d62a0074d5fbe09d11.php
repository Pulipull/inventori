<?php $__env->startSection('browser_title', 'Login - NexStock'); ?>

<?php $__env->startSection('content'); ?>
<div class="relative grid min-h-screen place-items-center overflow-hidden bg-[radial-gradient(circle_at_top_left,rgba(37,99,235,0.14),transparent_34%),linear-gradient(135deg,#ffffff_0%,#f8fafc_54%,#eff6ff_100%)] px-4 py-10">
    <div class="pointer-events-none absolute -left-24 top-24 h-72 w-72 rounded-full bg-blue-200/30 blur-3xl"></div>
    <div class="pointer-events-none absolute -right-24 bottom-20 h-80 w-80 rounded-full bg-slate-300/30 blur-3xl"></div>

    <form method="post" action="<?php echo e(route('login')); ?>" class="relative w-full max-w-md rounded-[2rem] bg-white/90 p-8 shadow-2xl shadow-blue-950/10 ring-1 ring-white/80 backdrop-blur">
        <?php echo csrf_field(); ?>
        <div class="text-center">
            <img src="<?php echo e(asset('brand/nexstock-logo.svg')); ?>" alt="NexStock" class="mx-auto h-16 w-16 rounded-2xl object-cover shadow-lg shadow-blue-950/10">
            <h1 class="mt-6 text-3xl font-semibold tracking-normal text-slate-950">Welcome Back</h1>
            <p class="mt-2 text-sm text-slate-500">Continue to NexStock securely.</p>
        </div>

        <?php if(session('success')): ?>
            <div class="mt-6 rounded-2xl bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700 ring-1 ring-emerald-100"><?php echo e(session('success')); ?></div>
        <?php endif; ?>
        <?php if($errors->any()): ?>
            <div class="mt-6 rounded-2xl bg-rose-50 px-4 py-3 text-sm font-medium text-rose-700 ring-1 ring-rose-100"><?php echo e($errors->first()); ?></div>
        <?php endif; ?>

        <div class="mt-6 grid gap-4">
            <label class="block text-sm font-semibold text-slate-700">Email
                <input name="email" type="email" value="<?php echo e(old('email')); ?>" required autofocus class="mt-2 w-full rounded-2xl border-slate-200 bg-white px-4 py-3 text-sm shadow-sm shadow-slate-200/60 focus:border-blue-500 focus:ring-blue-500">
            </label>
            <label class="block text-sm font-semibold text-slate-700">Password
                <input name="password" type="password" required class="mt-2 w-full rounded-2xl border-slate-200 bg-white px-4 py-3 text-sm shadow-sm shadow-slate-200/60 focus:border-blue-500 focus:ring-blue-500">
            </label>
            <label class="flex items-center gap-2 text-sm font-medium text-slate-600">
                <input type="checkbox" name="remember" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500"> Ingat saya
            </label>
        </div>

        <button class="mt-6 w-full rounded-2xl bg-blue-600 px-4 py-3.5 font-semibold text-white shadow-lg shadow-blue-200 transition hover:bg-blue-700">Masuk</button>

        <div class="my-5 flex items-center gap-3 text-xs text-slate-400">
            <span class="h-px flex-1 bg-slate-200"></span>
            <span>atau</span>
            <span class="h-px flex-1 bg-slate-200"></span>
        </div>

        <?php if(config('services.google.client_id') && config('services.google.client_secret')): ?>
            <a href="<?php echo e(route('auth.google.redirect')); ?>" class="flex w-full items-center justify-center gap-3 rounded-2xl bg-slate-950 px-4 py-3.5 text-sm font-semibold text-white shadow-lg shadow-slate-200 transition hover:bg-blue-700">
                <span class="grid h-6 w-6 place-items-center rounded-full bg-white text-sm font-bold text-blue-700">G</span>
                Continue securely with Google
            </a>
        <?php else: ?>
            <div class="rounded-2xl bg-slate-50 px-4 py-3 text-center text-sm text-slate-500 ring-1 ring-slate-100">
                Login Google belum aktif.
            </div>
        <?php endif; ?>

        <div class="mt-5 grid grid-cols-3 gap-2 text-center text-[11px] font-semibold text-slate-500">
            <div class="rounded-2xl bg-slate-50 px-2 py-2">OAuth</div>
            <div class="rounded-2xl bg-slate-50 px-2 py-2">Encrypted</div>
            <div class="rounded-2xl bg-slate-50 px-2 py-2">No password stored</div>
        </div>

        <a href="<?php echo e(route('register')); ?>" class="mt-6 block text-center text-sm font-semibold text-blue-700">Daftar akun user</a>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/auth/login.blade.php ENDPATH**/ ?>