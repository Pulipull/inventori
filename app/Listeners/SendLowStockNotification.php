<?php

namespace App\Listeners;

use App\Events\LowStockDetected;
use App\Models\User;
use App\Services\NotificationService;

class SendLowStockNotification
{
    public function __construct(private readonly NotificationService $notifications)
    {
    }

    public function handle(LowStockDetected $event): void
    {
        User::query()
            ->where('role', 'admin')
            ->each(fn (User $admin) => $this->notifications->lowStock($admin, $event->item));
    }
}
