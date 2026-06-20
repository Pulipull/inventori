<?php

namespace App\Listeners;

use App\Events\CustomerCreated;
use App\Models\User;
use App\Services\NotificationService;

class SendCustomerCreatedNotification
{
    public function __construct(private readonly NotificationService $notifications)
    {
    }

    public function handle(CustomerCreated $event): void
    {
        User::query()
            ->where('role', 'admin')
            ->each(fn (User $admin) => $this->notifications->create(
                $admin,
                'Customer baru',
                $event->actor->name.' menambahkan customer '.$event->customerName.'.',
                'info',
                'crm',
            ));
    }
}
