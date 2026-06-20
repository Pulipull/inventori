<?php

namespace App\Services;

use InvalidArgumentException;

class IntegrationEventRegistry
{
    private const EVENTS = [
        'InventoryUpdated' => [
            'description' => 'Inventory state changed for integration consumers.',
            'aggregate_type' => 'inventory',
        ],
        'CustomerSynced' => [
            'description' => 'Customer synchronization state was received.',
            'aggregate_type' => 'customer',
        ],
        'ShipmentTrackingUpdated' => [
            'description' => 'Shipment tracking state was received.',
            'aggregate_type' => 'shipment',
        ],
        'PaymentStatusReceived' => [
            'description' => 'Payment status update was received.',
            'aggregate_type' => 'payment',
        ],
    ];

    public function isAllowed(string $eventName): bool
    {
        return array_key_exists($eventName, self::EVENTS);
    }

    public function validate(string $eventName): void
    {
        if (! $this->isAllowed($eventName)) {
            throw new InvalidArgumentException('Unknown integration event.');
        }
    }

    public function metadata(string $eventName): array
    {
        $this->validate($eventName);

        return self::EVENTS[$eventName];
    }

    public function allowedEvents(): array
    {
        return array_keys(self::EVENTS);
    }
}
