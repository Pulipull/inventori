<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\CustomerInteraction;
use App\Models\User;

class CustomerInteractionService
{
    public function __construct(private readonly CRMService $crm)
    {
    }

    public function create(Customer $customer, User $actor, array $data): CustomerInteraction
    {
        return $this->crm->logInteraction($customer, $actor, $data);
    }
}
