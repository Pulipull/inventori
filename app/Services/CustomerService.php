<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\User;

class CustomerService
{
    public function __construct(private readonly CRMService $crm)
    {
    }

    public function create(array $data, User $actor): Customer
    {
        return $this->crm->createCustomer($data, $actor);
    }

    public function update(Customer $customer, array $data, User $actor): Customer
    {
        return $this->crm->updateCustomer($customer, $data, $actor);
    }

    public function delete(Customer $customer, User $actor, ?string $reason = null): void
    {
        $this->crm->deleteCustomer($customer, $actor, $reason);
    }
}
