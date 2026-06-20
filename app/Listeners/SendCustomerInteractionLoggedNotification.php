<?php

namespace App\Listeners;

use App\Events\CustomerInteractionLogged;
use App\Models\User;
use App\Services\NotificationService;

class SendCustomerInteractionLoggedNotification
{
    public function __construct(private readonly NotificationService $notifications)
    {
    }

    public function handle(CustomerInteractionLogged $event): void
    {
        User::query()
            ->where('role', 'admin')
            ->each(fn (User $admin) => $this->notifications->create(
                $admin,
                'Interaksi customer dicatat',
                $event->actor->name.' mencatat interaksi '.$event->interaction->type.' untuk '.$event->interaction->customer->name.'.',
                'info',
                'crm',
            ));
    }
}
