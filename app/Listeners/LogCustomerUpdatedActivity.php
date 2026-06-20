<?php

namespace App\Listeners;

use App\Events\CustomerUpdated;
use App\Models\CrmActivity;

class LogCustomerUpdatedActivity
{
    public function handle(CustomerUpdated $event): void
    {
        CrmActivity::create([
            'customer_id' => $event->customer->id,
            'type' => 'updated',
            'description' => 'Customer diperbarui.',
            'metadata' => ['changes' => array_keys($event->changes)],
            'created_by' => $event->actor->id,
            'created_at' => now(),
        ]);
    }
}
