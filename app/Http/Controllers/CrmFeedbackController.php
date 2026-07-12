<?php

namespace App\Http\Controllers;

use App\Models\CustomerFeedback;
use App\Services\CRMService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CrmFeedbackController extends Controller
{
    public function index(Request $request, CRMService $crm): View
    {
        $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
            'category' => ['nullable', Rule::in(CustomerFeedback::categories())],
            'status' => ['nullable', Rule::in(CustomerFeedback::statuses())],
            'rating' => ['nullable', 'integer', 'min:1', 'max:5'],
        ]);

        return view('crm.feedback.index', [
            'feedbacks' => $crm->feedbacks($request),
            'categories' => CustomerFeedback::categories(),
            'statuses' => CustomerFeedback::statuses(),
        ]);
    }

    public function update(Request $request, CustomerFeedback $feedback, CRMService $crm): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(CustomerFeedback::statuses())],
            'admin_reply' => ['nullable', 'string'],
        ]);

        $crm->updateFeedback($feedback, $request->user(), $data);

        return back()->with('success', 'Feedback berhasil diperbarui.');
    }

    public function resolve(Request $request, CustomerFeedback $feedback, CRMService $crm): RedirectResponse
    {
        $crm->resolveFeedback($feedback, $request->user());

        return back()->with('success', 'Feedback ditandai resolved.');
    }
}
