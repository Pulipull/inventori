<?php $__env->startSection('title', 'Kategori'); ?>
<?php $__env->startSection('actions'); ?>
<a href="<?php echo e(route('categories.create')); ?>" class="rounded bg-moss px-4 py-2 text-sm font-semibold text-white">Tambah Kategori</a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="overflow-hidden rounded-lg bg-white shadow-sm">
    <table class="w-full text-left text-sm">
        <thead class="bg-gray-50 text-gray-500"><tr><th class="p-4">Nama</th><th class="p-4">Deskripsi</th><th class="p-4">Barang</th><th class="p-4"></th></tr></thead>
        <tbody>
        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr class="border-t">
                <td class="p-4 font-semibold"><?php echo e($category->name); ?></td>
                <td class="p-4"><?php echo e($category->description); ?></td>
                <td class="p-4"><?php echo e($category->items_count); ?></td>
                <td class="p-4 text-right">
                    <a href="<?php echo e(route('categories.edit', $category)); ?>" class="text-moss">Edit</a>
                    <form method="post" action="<?php echo e(route('categories.destroy', $category)); ?>" class="inline" onsubmit="return confirm('Hapus kategori?')">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button class="ml-3 text-coral">Hapus</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <div class="p-4"><?php echo e($categories->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/categories/index.blade.php ENDPATH**/ ?>