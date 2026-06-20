<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Services\CRMService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CustomerInteractionController extends Controller
{
    public function store(Request $request, Customer $customer, CRMService $crm): RedirectResponse
    {
        $crm->authorizeCustomerAccess($customer, $request->user());

        $crm->logInteraction($customer, $request->user(), $request->validate([
            'type' => ['required', Rule::in(['note', 'call', 'email', 'meeting', 'chat', 'order'])],
            'summary' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'occurred_at' => ['nullable', 'date'],
        ]));

        return redirect()->route('customers.show', $customer)->with('success', 'Interaksi customer berhasil dicatat.');
    }
}
