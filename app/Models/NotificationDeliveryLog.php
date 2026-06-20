<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotificationDeliveryLog extends Model
{
    use HasFactory;

    public const CHANNEL_DATABASE = 'database';
    public const STATUS_SENT = 'sent';
    public const STATUS_FAILED = 'failed';

    public const UPDATED_AT = null;

    protected $fillable = [
        'notification_id',
        'user_id',
        'channel',
        'status',
        'sent_at',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'sent_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function notification(): BelongsTo
    {
        return $this->belongsTo(AppNotification::class, 'notification_id');
    }
}
