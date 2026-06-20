<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotificationPreference extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'low_stock_enabled',
        'crm_enabled',
        'report_enabled',
        'system_enabled',
    ];

    protected function casts(): array
    {
        return [
            'low_stock_enabled' => 'boolean',
            'crm_enabled' => 'boolean',
            'report_enabled' => 'boolean',
            'system_enabled' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
