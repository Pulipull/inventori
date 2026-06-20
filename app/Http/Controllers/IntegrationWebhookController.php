<?php

namespace App\Http\Controllers;

use App\Models\IntegrationWebhookLog;
use App\Services\IntegrationEventRegistry;
use App\Services\OutboxEventService;
use App\Services\WebhookSignatureService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IntegrationWebhookController extends Controller
{
    public function receive(
        Request $request,
        WebhookSignatureService $signatures,
        IntegrationEventRegistry $events,
        OutboxEventService $outbox,
    ): JsonResponse {
        $data = $request->validate([
            'source' => ['required', 'string', 'max:100'],
            'event_name' => ['required', 'string', 'max:150'],
            'payload' => ['required', 'array'],
            'aggregate_type' => ['nullable', 'string', 'max:150'],
            'aggregate_id' => ['nullable', 'integer'],
        ]);

        $signatureStatus = $signatures->status($request);
        $validSignature = $signatureStatus !== WebhookSignatureService::STATUS_INVALID;
        $validEvent = $events->isAllowed($data['event_name']);

        $log = IntegrationWebhookLog::create([
            'source' => $data['source'],
            'event_name' => $data['event_name'],
            'payload' => $data['payload'],
            'status' => match (true) {
                ! $validSignature => IntegrationWebhookLog::STATUS_INVALID_SIGNATURE,
                ! $validEvent => IntegrationWebhookLog::STATUS_INVALID_EVENT,
                $signatureStatus === WebhookSignatureService::STATUS_NOT_CONFIGURED => IntegrationWebhookLog::STATUS_SIGNATURE_NOT_CONFIGURED,
                default => IntegrationWebhookLog::STATUS_RECEIVED,
            },
            'received_at' => now(),
        ]);

        if (! $validSignature) {
            return response()->json([
                'message' => 'Invalid webhook signature.',
                'log_id' => $log->id,
            ], 403);
        }

        if (! $validEvent) {
            return response()->json([
                'message' => 'Unknown integration event.',
                'log_id' => $log->id,
            ], 422);
        }

        $event = $outbox->create(
            $data['event_name'],
            $data['payload'],
            $data['aggregate_type'] ?? null,
            $data['aggregate_id'] ?? null,
            $log,
        );

        return response()->json([
            'data' => [
                'webhook_log_id' => $log->id,
                'outbox_event_id' => $event->id,
                'status' => $event->status,
            ],
        ], 201);
    }
}
