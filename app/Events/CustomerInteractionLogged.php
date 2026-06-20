<?php

namespace App\Events;

use App\Models\CustomerInteraction;
use App\Models\User;
use Illuminate\Contracts\Events\ShouldDispatchAfterCommit;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CustomerInteractionLogged implements ShouldDispatchAfterCommit
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(
        public CustomerInteraction $interaction,
        public User $actor,
    ) {
        $this->interaction->loadMissing('customer');
    }
}
