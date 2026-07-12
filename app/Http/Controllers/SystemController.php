<?php

namespace App\Http\Controllers;

use App\Models\IntegrationWebhookLog;
use Illuminate\View\View;

class SystemController extends Controller
{
    public function __invoke(): View
    {
        $lastWebhookLog = IntegrationWebhookLog::latest('received_at')->first();
        $webhookSecretConfigured = filled(config('services.integration.webhook_secret'));

        return view('admin.system.index', [
            'webhookEndpoint' => 'POST /integration/webhook',
            'integrationStatus' => $webhookSecretConfigured ? 'Configured' : 'Setup required',
            'webhookSecretStatus' => $webhookSecretConfigured ? 'Configured' : 'Not configured',
            'lastDelivery' => $lastWebhookLog?->received_at?->format('d M Y H:i') ?? 'Unavailable',
        ]);
    }
}
