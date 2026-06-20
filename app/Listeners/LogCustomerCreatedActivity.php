<?php

namespace App\Listeners;

use App\Events\CustomerCreated;
use App\Models\CrmActivity;

class LogCustomerCreatedActivity
{
    public function handle(CustomerCreated $event): void
    {
        CrmActivity::create([
            'customer_id' => $event->customer->id,
            'type' => 'created',
            'description' => 'Customer dibuat.',
            'metadata' => ['customer_name' => $event->customerName],
            'created_by' => $event->actor->id,
            'created_at' => now(),
        ]);
    }
}
