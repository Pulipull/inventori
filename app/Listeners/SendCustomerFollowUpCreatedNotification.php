<?php

namespace App\Listeners;

use App\Events\CustomerFollowUpCreated;
use App\Services\NotificationService;

class SendCustomerFollowUpCreatedNotification
{
    public function __construct(private readonly NotificationService $notifications)
    {
    }

    public function handle(CustomerFollowUpCreated $event): void
    {
        $this->notifications->create(
            $event->followUp->assignedTo,
            'Follow up customer',
            $event->actor->name.' menugaskan follow up '.$event->followUp->title.' untuk '.$event->followUp->customer->name.'.',
            'warning',
            'crm',
        );
    }
}
