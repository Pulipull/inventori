<?php

namespace App\Listeners;

use App\Events\InventoryStockAdjusted;
use App\Services\NotificationService;

class SendStockAdjustedNotification
{
    public function __construct(private readonly NotificationService $notifications)
    {
    }

    public function handle(InventoryStockAdjusted $event): void
    {
        $this->notifications->stockAdjusted(
            $event->actor,
            $event->transaction,
            $event->previousStock,
            $event->currentStock,
        );
    }
}
