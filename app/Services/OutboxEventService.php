<?php

namespace App\Services;

use App\Models\IntegrationOutboxEvent;
use App\Models\IntegrationWebhookLog;

class OutboxEventService
{
    public function create(
        string $eventName,
        array $payload,
        ?string $aggregateType = null,
        ?int $aggregateId = null,
        ?IntegrationWebhookLog $webhookLog = null,
    ): IntegrationOutboxEvent {
        return IntegrationOutboxEvent::create([
            'webhook_log_id' => $webhookLog?->id,
            'event_name' => $eventName,
            'aggregate_type' => $aggregateType,
            'aggregate_id' => $aggregateId,
            'payload' => $payload,
            'status' => IntegrationOutboxEvent::STATUS_PENDING,
        ]);
    }

    public function markProcessed(IntegrationOutboxEvent $event): IntegrationOutboxEvent
    {
        $event->update([
            'status' => IntegrationOutboxEvent::STATUS_PROCESSED,
            'processed_at' => now(),
        ]);

        return $event;
    }

    public function markFailed(IntegrationOutboxEvent $event): IntegrationOutboxEvent
    {
        $event->update([
            'status' => IntegrationOutboxEvent::STATUS_FAILED,
            'processed_at' => null,
        ]);

        return $event;
    }
}
