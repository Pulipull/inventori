<?php

namespace App\Services;

use App\Events\CustomerCreated;
use App\Events\CustomerDeleted;
use App\Events\CustomerFollowUpCompleted;
use App\Events\CustomerFollowUpCreated;
use App\Events\CustomerInteractionLogged;
use App\Events\CustomerUpdated;
use App\Models\CrmActivity;
use App\Models\Customer;
use App\Models\CustomerFollowUp;
use App\Models\CustomerInteraction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CRMService
{
    public function customers(Request $request)
    {
        return Customer::query()
            ->with('user')
            ->when($request->search, fn ($query, $search) => $query->where(fn ($nested) => $nested
                ->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%")
                ->orWhere('company', 'like', "%{$search}%")))
            ->when($request->status, fn ($query, $status) => $query->where('status', $status))
            ->latest()
            ->paginate(12)
            ->withQueryString();
    }

    public function customerDetails(Customer $customer): array
    {
        $customer->load([
            'user',
            'interactions.user',
            'followUps.assignedTo',
            'followUps.creator',
        ]);

        return [
            'customer' => $customer,
            'users' => $this->assignableUsers(),
            'openFollowUps' => $customer->followUps
                ->where('status', CustomerFollowUp::STATUS_OPEN)
                ->sortBy('due_at'),
        ];
    }

    public function assignableUsers()
    {
        return User::whereIn('role', ['admin', 'petugas'])->orderBy('name')->get();
    }

    public function authorizeCustomerAccess(Customer $customer, User $actor): void
    {
        if ($actor->isAdmin()) {
            return;
        }

        if ($customer->user_id && $customer->user_id !== $actor->id) {
            abort(403);
        }
    }

    public function createCustomer(array $data, User $actor): Customer
    {
        $this->ensureEmailIsUnique($data['email'] ?? null);

        $customer = Customer::create($data);

        CustomerCreated::dispatch($customer, $actor);

        return $customer;
    }

    public function updateCustomer(Customer $customer, array $data, User $actor): Customer
    {
        $customer->fill($data);

        if (! $customer->isDirty()) {
            return $customer;
        }

        if ($customer->isDirty('email')) {
            $this->ensureEmailIsUnique($data['email'] ?? null, $customer);
        }

        $customer->save();
        $changes = array_intersect_key($customer->getChanges(), $data);
        $customer->refresh();

        if ($changes !== []) {
            CustomerUpdated::dispatch($customer, $actor, $changes);
        }

        return $customer;
    }

    public function deleteCustomer(Customer $customer, User $actor, ?string $reason = null): void
    {
        CustomerDeleted::dispatch($customer, $actor, $reason);

        $customer->delete();
    }

    public function createFollowUp(Customer $customer, User $actor, array $data): CustomerFollowUp
    {
        $followUp = CustomerFollowUp::create([
            ...$data,
            'customer_id' => $customer->id,
            'created_by' => $actor->id,
            'status' => CustomerFollowUp::STATUS_OPEN,
        ]);

        CustomerFollowUpCreated::dispatch($followUp, $actor);

        return $followUp;
    }

    public function updateFollowUp(CustomerFollowUp $followUp, array $data, ?User $actor = null): CustomerFollowUp
    {
        $wasDone = $followUp->status === CustomerFollowUp::STATUS_DONE;
        $followUp->fill($data);

        if (($data['status'] ?? null) === CustomerFollowUp::STATUS_DONE && ! $followUp->completed_at) {
            $followUp->completed_at = now();
        }

        if (($data['status'] ?? null) !== CustomerFollowUp::STATUS_DONE) {
            $followUp->completed_at = null;
        }

        if ($followUp->isDirty()) {
            $followUp->save();
        }

        if (! $wasDone && $followUp->status === CustomerFollowUp::STATUS_DONE && $actor) {
            CustomerFollowUpCompleted::dispatch($followUp, $actor);
        }

        return $followUp;
    }

    public function completeFollowUp(CustomerFollowUp $followUp, User $actor): CustomerFollowUp
    {
        if ($followUp->status !== CustomerFollowUp::STATUS_DONE) {
            $followUp->forceFill([
                'status' => CustomerFollowUp::STATUS_DONE,
                'completed_at' => now(),
            ])->save();

            CustomerFollowUpCompleted::dispatch($followUp, $actor);
        }

        return $followUp;
    }

    public function logInteraction(Customer $customer, User $actor, array $data): CustomerInteraction
    {
        $interaction = CustomerInteraction::create([
            ...$data,
            'customer_id' => $customer->id,
            'user_id' => $actor->id,
            'occurred_at' => $data['occurred_at'] ?? now(),
        ]);

        CustomerInteractionLogged::dispatch($interaction, $actor);

        return $interaction;
    }

    public function timeline(Customer $customer)
    {
        return $customer->activities()
            ->with('creator')
            ->latest('created_at')
            ->paginate(20);
    }

    public function recentActivities(int $limit = 10)
    {
        return CrmActivity::with(['customer', 'creator'])
            ->latest('created_at')
            ->limit($limit)
            ->get();
    }

    private function ensureEmailIsUnique(?string $email, ?Customer $except = null): void
    {
        if (! $email) {
            return;
        }

        $query = Customer::query()->whereRaw('LOWER(email) = ?', [mb_strtolower($email)]);

        if ($except) {
            $query->whereKeyNot($except->id);
        }

        if ($query->exists()) {
            throw ValidationException::withMessages([
                'email' => 'Email customer sudah terdaftar.',
            ]);
        }
    }
}
