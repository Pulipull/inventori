<?php

namespace App\Listeners;

use App\Events\CustomerUpdated;
use App\Models\User;
use App\Services\NotificationService;

class SendCustomerUpdatedNotification
{
    public function __construct(private readonly NotificationService $notifications)
    {
    }

    public function handle(CustomerUpdated $event): void
    {
        User::query()
            ->where('role', 'admin')
            ->each(fn (User $admin) => $this->notifications->create(
                $admin,
                'Customer diperbarui',
                $event->actor->name.' memperbarui customer '.$event->customerName.'.',
                'info',
                'crm',
            ));
    }
}
