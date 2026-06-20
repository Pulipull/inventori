<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Services\CRMService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerTimelineController extends Controller
{
    public function show(Request $request, Customer $customer, CRMService $crm): View
    {
        $crm->authorizeCustomerAccess($customer, $request->user());

        return view('customers.timeline', [
            'customer' => $customer,
            'activities' => $crm->timeline($customer),
        ]);
    }
}
