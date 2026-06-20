<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerFollowUp;
use App\Services\CRMService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CustomerFollowUpController extends Controller
{
    public function store(Request $request, Customer $customer, CRMService $crm): RedirectResponse
    {
        $crm->authorizeCustomerAccess($customer, $request->user());

        $crm->createFollowUp($customer, $request->user(), $request->validate([
            'assigned_to' => ['required', Rule::exists('users', 'id')->whereIn('role', ['admin', 'petugas'])],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'due_at' => ['nullable', 'date'],
        ]));

        return redirect()->route('customers.show', $customer)->with('success', 'Follow up customer berhasil dibuat.');
    }

    public function update(Request $request, CustomerFollowUp $followUp, CRMService $crm): RedirectResponse
    {
        $crm->authorizeCustomerAccess($followUp->customer, $request->user());

        $crm->updateFollowUp($followUp, $request->validate([
            'assigned_to' => ['required', Rule::exists('users', 'id')->whereIn('role', ['admin', 'petugas'])],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', Rule::in(['open', 'done', 'cancelled'])],
            'due_at' => ['nullable', 'date'],
        ]), $request->user());

        return redirect()->route('customers.show', $followUp->customer)->with('success', 'Follow up customer berhasil diperbarui.');
    }

    public function complete(Request $request, CustomerFollowUp $followUp, CRMService $crm): RedirectResponse
    {
        $crm->authorizeCustomerAccess($followUp->customer, $request->user());

        $crm->completeFollowUp($followUp, $request->user());

        return redirect()->route('customers.show', $followUp->customer)->with('success', 'Follow up customer selesai.');
    }
}
