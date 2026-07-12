<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title',
    'description' => null,
]));

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

foreach (array_filter(([
    'title',
    'description' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<section <?php echo e($attributes->merge(['class' => 'rounded-xl border border-gray-200 bg-white shadow-sm shadow-gray-200/60'])); ?>>
    <div class="flex flex-col gap-1 border-b border-gray-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-base font-semibold text-gray-950"><?php echo e($title); ?></h2>
            <?php if($description): ?>
                <p class="mt-1 text-sm text-gray-500"><?php echo e($description); ?></p>
            <?php endif; ?>
        </div>
        <?php if(isset($actions)): ?>
            <div class="shrink-0">
                <?php echo e($actions); ?>

            </div>
        <?php endif; ?>
    </div>
    <div class="p-5">
        <?php echo e($slot); ?>

    </div>
</section>
<?php /**PATH /var/www/html/resources/views/components/dashboard/panel.blade.php ENDPATH**/ ?>