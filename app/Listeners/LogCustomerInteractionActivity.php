<?php

namespace App\Listeners;

use App\Events\CustomerInteractionLogged;
use App\Models\CrmActivity;

class LogCustomerInteractionActivity
{
    public function handle(CustomerInteractionLogged $event): void
    {
        CrmActivity::create([
            'customer_id' => $event->interaction->customer_id,
            'type' => 'interaction',
            'description' => $event->interaction->summary,
            'metadata' => [
                'interaction_id' => $event->interaction->id,
                'interaction_type' => $event->interaction->type,
            ],
            'created_by' => $event->actor->id,
            'created_at' => now(),
        ]);
    }
}
