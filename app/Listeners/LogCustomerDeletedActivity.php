<?php

namespace App\Listeners;

use App\Events\CustomerDeleted;
use App\Models\CrmActivity;

class LogCustomerDeletedActivity
{
    public function handle(CustomerDeleted $event): void
    {
        CrmActivity::create([
            'customer_id' => $event->customerId,
            'type' => 'deleted',
            'description' => 'Customer dihapus.',
            'metadata' => [
                'customer_id' => $event->customerId,
                'customer_name' => $event->customerName,
                'reason' => $event->reason,
            ],
            'created_by' => $event->actor->id,
            'created_at' => now(),
        ]);
    }
}
