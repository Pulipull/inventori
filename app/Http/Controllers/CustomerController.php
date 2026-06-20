<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Services\CRMService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function index(Request $request, CRMService $crm): View
    {
        return view('customers.index', ['customers' => $crm->customers($request)]);
    }

    public function create(CRMService $crm): View
    {
        return view('customers.form', [
            'customer' => new Customer(['source' => 'manual', 'status' => 'active']),
            'users' => $crm->assignableUsers(),
        ]);
    }

    public function store(Request $request, CRMService $crm): RedirectResponse
    {
        $customer = $crm->createCustomer($this->validated($request), $request->user());

        return redirect()->route('customers.show', $customer)->with('success', 'Customer berhasil ditambahkan.');
    }

    public function show(Request $request, Customer $customer, CRMService $crm): View
    {
        $crm->authorizeCustomerAccess($customer, $request->user());

        return view('customers.show', $crm->customerDetails($customer));
    }

    public function edit(Request $request, Customer $customer, CRMService $crm): View
    {
        $crm->authorizeCustomerAccess($customer, $request->user());

        return view('customers.form', [
            'customer' => $customer,
            'users' => $crm->assignableUsers(),
        ]);
    }

    public function update(Request $request, Customer $customer, CRMService $crm): RedirectResponse
    {
        $crm->authorizeCustomerAccess($customer, $request->user());

        $crm->updateCustomer($customer, $this->validated($request), $request->user());

        return redirect()->route('customers.show', $customer)->with('success', 'Customer berhasil diperbarui.');
    }

    public function destroy(Request $request, Customer $customer, CRMService $crm): RedirectResponse
    {
        $crm->authorizeCustomerAccess($customer, $request->user());

        $crm->deleteCustomer($customer, $request->user());

        return redirect()->route('customers.index')->with('success', 'Customer berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'external_customer_id' => ['nullable', 'string', 'max:255'],
            'user_id' => ['nullable', 'exists:users,id'],
            'source' => ['required', 'string', 'max:50'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'company' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
            'notes' => ['nullable', 'string'],
        ]);
    }

}
