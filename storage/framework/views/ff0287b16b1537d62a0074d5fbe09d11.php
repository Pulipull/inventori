<?php $__env->startSection('content'); ?>
<div class="grid min-h-screen place-items-center px-4">
    <form method="post" action="<?php echo e(route('login')); ?>" class="w-full max-w-md rounded-lg bg-white p-8 shadow-sm">
        <?php echo csrf_field(); ?>
        <h1 class="mb-6 text-2xl font-bold">Masuk Inventori</h1>
        <label class="mb-4 block text-sm font-medium">Email
            <input name="email" type="email" value="<?php echo e(old('email')); ?>" required autofocus class="mt-1 w-full rounded border-gray-300">
        </label>
        <label class="mb-4 block text-sm font-medium">Password
            <input name="password" type="password" required class="mt-1 w-full rounded border-gray-300">
        </label>
        <label class="mb-6 flex items-center gap-2 text-sm">
            <input type="checkbox" name="remember" class="rounded border-gray-300"> Ingat saya
        </label>
        <button class="w-full rounded bg-moss px-4 py-2 font-semibold text-white">Masuk</button>
        <a href="<?php echo e(route('register')); ?>" class="mt-4 block text-center text-sm text-moss">Daftar akun petugas</a>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/auth/login.blade.php ENDPATH**/ ?>