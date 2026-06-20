<?php

namespace App\Events;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Contracts\Events\ShouldDispatchAfterCommit;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CustomerUpdated implements ShouldDispatchAfterCommit
{
    use Dispatchable;
    use SerializesModels;

    public int $customerId;

    public string $customerName;

    public function __construct(
        public Customer $customer,
        public User $actor,
        public array $changes,
    ) {
        $this->customerId = $customer->id;
        $this->customerName = $customer->name;
    }
}
