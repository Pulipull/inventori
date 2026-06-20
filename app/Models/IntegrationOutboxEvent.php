<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IntegrationOutboxEvent extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';
    public const STATUS_PROCESSED = 'processed';
    public const STATUS_FAILED = 'failed';

    protected $fillable = [
        'webhook_log_id',
        'event_name',
        'aggregate_type',
        'aggregate_id',
        'payload',
        'status',
        'processed_at',
    ];

    protected function casts(): array
    {
        return [
            'payload' => 'array',
            'processed_at' => 'datetime',
        ];
    }

    public function webhookLog(): BelongsTo
    {
        return $this->belongsTo(IntegrationWebhookLog::class, 'webhook_log_id');
    }
}
