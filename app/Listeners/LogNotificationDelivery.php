<?php

namespace App\Listeners;

use App\Events\NotificationCreated;
use App\Services\NotificationService;

class LogNotificationDelivery
{
    public function __construct(private readonly NotificationService $notifications)
    {
    }

    public function handle(NotificationCreated $event): void
    {
        $this->notifications->logDelivery($event->notification_id);
    }
}
