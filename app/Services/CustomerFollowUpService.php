<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\CustomerFollowUp;
use App\Models\User;

class CustomerFollowUpService
{
    public function __construct(private readonly CRMService $crm)
    {
    }

    public function create(Customer $customer, User $actor, array $data): CustomerFollowUp
    {
        return $this->crm->createFollowUp($customer, $actor, $data);
    }

    public function update(CustomerFollowUp $followUp, array $data, ?User $actor = null): CustomerFollowUp
    {
        return $this->crm->updateFollowUp($followUp, $data, $actor);
    }

    public function complete(CustomerFollowUp $followUp, User $actor): CustomerFollowUp
    {
        return $this->crm->completeFollowUp($followUp, $actor);
    }
}
