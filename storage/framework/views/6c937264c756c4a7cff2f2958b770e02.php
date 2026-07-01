

<?php $__env->startSection('title', $category->exists ? 'Edit Kategori' : 'Tambah Kategori'); ?>

<?php $__env->startSection('content'); ?>
<form method="post" action="<?php echo e($category->exists ? route('categories.update', $category) : route('categories.store')); ?>" class="max-w-2xl rounded-lg bg-white p-6 shadow-sm">
    <?php echo csrf_field(); ?>
    <?php if($category->exists): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>
    <label class="mb-4 block text-sm font-medium">Nama
        <input name="name" value="<?php echo e(old('name', $category->name)); ?>" required class="mt-1 w-full rounded border-gray-300">
    </label>
    <label class="mb-6 block text-sm font-medium">Deskripsi
        <textarea name="description" rows="4" class="mt-1 w-full rounded border-gray-300"><?php echo e(old('description', $category->description)); ?></textarea>
    </label>
    <button class="rounded bg-moss px-4 py-2 font-semibold text-white">Simpan</button>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\inventori\resources\views\categories\form.blade.php ENDPATH**/ ?>