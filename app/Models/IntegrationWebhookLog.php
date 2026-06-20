<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class IntegrationWebhookLog extends Model
{
    use HasFactory;

    public const STATUS_RECEIVED = 'received';
    public const STATUS_SIGNATURE_NOT_CONFIGURED = 'signature_not_configured';
    public const STATUS_INVALID_SIGNATURE = 'invalid_signature';
    public const STATUS_INVALID_EVENT = 'invalid_event';

    protected $fillable = [
        'source',
        'event_name',
        'payload',
        'status',
        'received_at',
    ];

    protected function casts(): array
    {
        return [
            'payload' => 'array',
            'received_at' => 'datetime',
        ];
    }

    public function outboxEvents(): HasMany
    {
        return $this->hasMany(IntegrationOutboxEvent::class, 'webhook_log_id');
    }
}
