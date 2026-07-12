<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'label',
    'value',
    'tone' => 'gray',
    'meta' => null,
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
    'label',
    'value',
    'tone' => 'gray',
    'meta' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $tones = [
        'blue' => 'bg-blue-50 text-blue-700',
        'green' => 'bg-emerald-50 text-emerald-700',
        'amber' => 'bg-amber-50 text-amber-700',
        'red' => 'bg-rose-50 text-rose-700',
        'gray' => 'bg-gray-100 text-gray-700',
    ];
?>

<div class="flex items-center justify-between gap-4 border-b border-gray-100 py-3 last:border-0">
    <div class="min-w-0">
        <p class="truncate text-sm font-medium text-gray-800"><?php echo e($label); ?></p>
        <?php if($meta): ?>
            <p class="mt-0.5 truncate text-xs text-gray-500"><?php echo e($meta); ?></p>
        <?php endif; ?>
    </div>
    <span class="shrink-0 rounded-full px-2.5 py-1 text-xs font-semibold <?php echo e($tones[$tone] ?? $tones['gray']); ?>">
        <?php echo e($value); ?>

    </span>
</div>
<?php /**PATH /var/www/html/resources/views/components/dashboard/status-row.blade.php ENDPATH**/ ?>