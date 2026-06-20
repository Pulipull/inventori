<?php

namespace App\Listeners;

use App\Events\InventoryItemUpdated;
use App\Models\User;
use App\Services\NotificationService;

class SendInventoryUpdatedNotification
{
    public function __construct(private readonly NotificationService $notifications)
    {
    }

    public function handle(InventoryItemUpdated $event): void
    {
        User::query()
            ->where('role', 'admin')
            ->each(fn (User $admin) => $this->notifications->inventoryUpdated($admin, $event->item, $event->actor));
    }
}
