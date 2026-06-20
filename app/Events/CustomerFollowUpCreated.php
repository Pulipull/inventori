<?php

namespace App\Events;

use App\Models\CustomerFollowUp;
use App\Models\User;
use Illuminate\Contracts\Events\ShouldDispatchAfterCommit;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CustomerFollowUpCreated implements ShouldDispatchAfterCommit
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(
        public CustomerFollowUp $followUp,
        public User $actor,
    ) {
        $this->followUp->loadMissing(['customer', 'assignedTo']);
    }
}
