

<?php $__env->startSection('title', 'Chat dengan '.$otherUser->name); ?>

<?php $__env->startSection('content'); ?>
<div class="rounded-lg bg-white p-4 shadow-sm">
    <div id="messages" class="mb-4 grid max-h-[60vh] gap-3 overflow-y-auto">
        <?php $__currentLoopData = $conversation->messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="rounded p-3 <?php echo e($message->user_id === auth()->id() ? 'ml-auto bg-moss text-white' : 'mr-auto bg-gray-100'); ?>">
                <p class="text-sm"><?php echo e($message->body); ?></p>
                <small class="opacity-75"><?php echo e($message->user->name); ?> - <?php echo e($message->created_at->format('d M Y H:i')); ?></small>
                <?php if($message->user_id === auth()->id() && $otherReadReceipt?->message_id >= $message->id): ?>
                    <small class="mt-1 block opacity-75">Dibaca</small>
                <?php endif; ?>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <form method="post" action="<?php echo e(route('chat.store', $conversation)); ?>" class="flex gap-2">
        <?php echo csrf_field(); ?>
        <input name="body" autocomplete="off" required placeholder="Tulis pesan" class="w-full rounded border-gray-300">
        <button class="rounded bg-moss px-4 py-2 font-semibold text-white">Kirim</button>
    </form>
</div>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const box = document.getElementById('messages');
    box.scrollTop = box.scrollHeight;
    if (window.Echo) {
        window.Echo.private('conversation.<?php echo e($conversation->id); ?>')
            .listen('MessageSent', (event) => {
                const mine = event.user.id === <?php echo e(auth()->id()); ?>;
                const bubble = document.createElement('div');
                bubble.className = 'rounded p-3 ' + (mine ? 'ml-auto bg-moss text-white' : 'mr-auto bg-gray-100');
                bubble.innerHTML = `<p class="text-sm">${event.body}</p><small class="opacity-75">${event.user.name} - ${event.created_at}</small>`;
                box.appendChild(bubble);
                box.scrollTop = box.scrollHeight;
            });
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\inventori\resources\views\chat\show.blade.php ENDPATH**/ ?>