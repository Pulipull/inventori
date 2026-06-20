<?php

namespace App\Listeners;

use App\Events\CustomerFollowUpCompleted;
use App\Events\CustomerFollowUpCreated;
use App\Models\CrmActivity;

class LogCustomerFollowUpActivity
{
    public function handle(CustomerFollowUpCreated|CustomerFollowUpCompleted $event): void
    {
        $isCompleted = $event instanceof CustomerFollowUpCompleted;

        CrmActivity::create([
            'customer_id' => $event->followUp->customer_id,
            'type' => $isCompleted ? 'completed' : 'follow_up',
            'description' => $isCompleted ? 'Follow up diselesaikan.' : 'Follow up dibuat.',
            'metadata' => [
                'follow_up_id' => $event->followUp->id,
                'title' => $event->followUp->title,
                'status' => $event->followUp->status,
            ],
            'created_by' => $event->actor->id,
            'created_at' => now(),
        ]);
    }
}
