<?php $__env->startSection('title', $item->exists ? 'Edit Barang' : 'Tambah Barang'); ?>

<?php $__env->startSection('content'); ?>
<form method="post" action="<?php echo e($item->exists ? route('items.update', $item) : route('items.store')); ?>" class="max-w-3xl rounded-lg bg-white p-6 shadow-sm">
    <?php echo csrf_field(); ?>
    <?php if($item->exists): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>
    <div class="grid gap-4 md:grid-cols-2">
        <label class="block text-sm font-medium">Kategori
            <select name="category_id" required class="mt-1 w-full rounded border-gray-300">
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($category->id); ?>" <?php if(old('category_id', $item->category_id) == $category->id): echo 'selected'; endif; ?>><?php echo e($category->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </label>
        <label class="block text-sm font-medium">Kode
            <input name="code" value="<?php echo e(old('code', $item->code)); ?>" required class="mt-1 w-full rounded border-gray-300">
        </label>
        <label class="block text-sm font-medium">Nama
            <input name="name" value="<?php echo e(old('name', $item->name)); ?>" required class="mt-1 w-full rounded border-gray-300">
        </label>
        <label class="block text-sm font-medium">Satuan
            <input name="unit" value="<?php echo e(old('unit', $item->unit ?? 'pcs')); ?>" required class="mt-1 w-full rounded border-gray-300">
        </label>
        <label class="block text-sm font-medium">Stok Awal
            <input name="stock" type="number" min="0" value="<?php echo e(old('stock', $item->stock ?? 0)); ?>" required class="mt-1 w-full rounded border-gray-300">
        </label>
        <label class="block text-sm font-medium">Stok Minimum
            <input name="minimum_stock" type="number" min="0" value="<?php echo e(old('minimum_stock', $item->minimum_stock ?? 5)); ?>" required class="mt-1 w-full rounded border-gray-300">
        </label>
    </div>
    <label class="mt-4 block text-sm font-medium">Deskripsi
        <textarea name="description" rows="4" class="mt-1 w-full rounded border-gray-300"><?php echo e(old('description', $item->description)); ?></textarea>
    </label>
    <button class="mt-6 rounded bg-moss px-4 py-2 font-semibold text-white">Simpan</button>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/items/form.blade.php ENDPATH**/ ?>