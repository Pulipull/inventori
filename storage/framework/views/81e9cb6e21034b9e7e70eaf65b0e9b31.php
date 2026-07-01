

<?php $__env->startSection('title', $customer->exists ? 'Edit Customer' : 'Tambah Customer'); ?>

<?php $__env->startSection('content'); ?>
<form method="post" action="<?php echo e($customer->exists ? route('customers.update', $customer) : route('customers.store')); ?>" class="max-w-3xl rounded-lg bg-white p-6 shadow-sm">
    <?php echo csrf_field(); ?>
    <?php if($customer->exists): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>

    <div class="grid gap-4 md:grid-cols-2">
        <label class="block text-sm font-medium">Nama
            <input name="name" value="<?php echo e(old('name', $customer->name)); ?>" required class="mt-1 w-full rounded border-gray-300">
        </label>
        <label class="block text-sm font-medium">Email
            <input name="email" type="email" value="<?php echo e(old('email', $customer->email)); ?>" class="mt-1 w-full rounded border-gray-300">
        </label>
        <label class="block text-sm font-medium">Telepon
            <input name="phone" value="<?php echo e(old('phone', $customer->phone)); ?>" class="mt-1 w-full rounded border-gray-300">
        </label>
        <label class="block text-sm font-medium">Perusahaan
            <input name="company" value="<?php echo e(old('company', $customer->company)); ?>" class="mt-1 w-full rounded border-gray-300">
        </label>
        <label class="block text-sm font-medium">Source
            <input name="source" value="<?php echo e(old('source', $customer->source ?? 'manual')); ?>" required class="mt-1 w-full rounded border-gray-300">
        </label>
        <label class="block text-sm font-medium">External Customer ID
            <input name="external_customer_id" value="<?php echo e(old('external_customer_id', $customer->external_customer_id)); ?>" class="mt-1 w-full rounded border-gray-300">
        </label>
        <label class="block text-sm font-medium">User Terkait
            <select name="user_id" class="mt-1 w-full rounded border-gray-300">
                <option value="">Tidak terhubung</option>
                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($user->id); ?>" <?php if(old('user_id', $customer->user_id) == $user->id): echo 'selected'; endif; ?>><?php echo e($user->name); ?> - <?php echo e($user->email); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </label>
        <label class="block text-sm font-medium">Status
            <select name="status" required class="mt-1 w-full rounded border-gray-300">
                <option value="active" <?php if(old('status', $customer->status ?? 'active') === 'active'): echo 'selected'; endif; ?>>Aktif</option>
                <option value="inactive" <?php if(old('status', $customer->status) === 'inactive'): echo 'selected'; endif; ?>>Tidak Aktif</option>
            </select>
        </label>
    </div>

    <label class="mt-4 block text-sm font-medium">Catatan
        <textarea name="notes" rows="4" class="mt-1 w-full rounded border-gray-300"><?php echo e(old('notes', $customer->notes)); ?></textarea>
    </label>

    <div class="mt-6 flex gap-2">
        <button class="rounded bg-moss px-4 py-2 font-semibold text-white">Simpan</button>
        <a href="<?php echo e($customer->exists ? route('customers.show', $customer) : route('customers.index')); ?>" class="rounded bg-gray-100 px-4 py-2 font-semibold text-gray-600">Batal</a>
    </div>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\inventori\resources\views\customers\form.blade.php ENDPATH**/ ?>