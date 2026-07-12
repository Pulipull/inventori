<?php

namespace App\Http\Controllers;

use App\Models\CustomerFeedback;
use App\Models\Order;
use App\Services\CRMService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CustomerFeedbackController extends Controller
{
    public function index(Request $request, CRMService $crm): View
    {
        return view('feedback.index', [
            'feedbacks' => $crm->userFeedbacks($request->user()),
        ]);
    }

    public function create(Request $request): View
    {
        return view('feedback.create', [
            'categories' => CustomerFeedback::categories(),
            'orders' => Order::with('item')
                ->where('user_id', $request->user()->id)
                ->latest()
                ->limit(50)
                ->get(),
        ]);
    }

    public function store(Request $request, CRMService $crm): RedirectResponse
    {
        $data = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'title' => ['required', 'string', 'max:255'],
            'feedback' => ['required', 'string'],
            'category' => ['required', Rule::in(CustomerFeedback::categories())],
            'order_id' => [
                'nullable',
                Rule::exists('orders', 'id')->where('user_id', $request->user()->id),
            ],
        ]);

        $crm->createFeedback($request->user(), $data);

        return redirect()->route('feedback.index')->with('success', 'Feedback berhasil dikirim.');
    }
}
