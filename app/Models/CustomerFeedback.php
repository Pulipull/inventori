<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerFeedback extends Model
{
    use HasFactory;

    public const CATEGORY_PRODUCT = 'product';
    public const CATEGORY_DELIVERY = 'delivery';
    public const CATEGORY_SERVICE = 'service';
    public const CATEGORY_PAYMENT = 'payment';
    public const CATEGORY_OTHER = 'other';

    public const STATUS_PENDING = 'pending';
    public const STATUS_REVIEWED = 'reviewed';
    public const STATUS_RESOLVED = 'resolved';

    protected $table = 'customer_feedback';

    protected $fillable = [
        'customer_id',
        'user_id',
        'order_id',
        'rating',
        'title',
        'feedback',
        'category',
        'status',
        'admin_reply',
        'replied_by',
        'replied_at',
        'resolved_at',
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'integer',
            'replied_at' => 'datetime',
            'resolved_at' => 'datetime',
        ];
    }

    public static function categories(): array
    {
        return [
            self::CATEGORY_PRODUCT,
            self::CATEGORY_DELIVERY,
            self::CATEGORY_SERVICE,
            self::CATEGORY_PAYMENT,
            self::CATEGORY_OTHER,
        ];
    }

    public static function statuses(): array
    {
        return [
            self::STATUS_PENDING,
            self::STATUS_REVIEWED,
            self::STATUS_RESOLVED,
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function replier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'replied_by');
    }
}
