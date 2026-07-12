<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'label',
    'value',
    'hint' => null,
    'tone' => 'blue',
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
    'hint' => null,
    'tone' => 'blue',
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
        'blue' => 'bg-blue-50 text-blue-700 ring-blue-100',
        'gray' => 'bg-gray-100 text-gray-700 ring-gray-200',
        'green' => 'bg-emerald-50 text-emerald-700 ring-emerald-100',
        'amber' => 'bg-amber-50 text-amber-700 ring-amber-100',
        'red' => 'bg-rose-50 text-rose-700 ring-rose-100',
    ];
?>

<article <?php echo e($attributes->merge(['class' => 'rounded-xl border border-gray-200 bg-white p-5 shadow-sm shadow-gray-200/60'])); ?>>
    <div class="flex items-start justify-between gap-4">
        <div class="min-w-0">
            <p class="text-sm font-medium text-gray-500"><?php echo e($label); ?></p>
            <p class="mt-2 break-words text-2xl font-semibold tracking-normal text-gray-950"><?php echo e($value); ?></p>
        </div>
        <span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl ring-1 <?php echo e($tones[$tone] ?? $tones['blue']); ?>">
            <span class="h-2.5 w-2.5 rounded-full bg-current"></span>
        </span>
    </div>

    <?php if($hint): ?>
        <p class="mt-3 text-xs font-medium text-gray-500"><?php echo e($hint); ?></p>
    <?php endif; ?>
</article>
<?php /**PATH /var/www/html/resources/views/components/dashboard/stat-card.blade.php ENDPATH**/ ?>