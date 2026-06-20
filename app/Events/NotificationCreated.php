<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationCreated
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(
        public int $notification_id,
        public int $user_id,
        public string $type,
    ) {
    }
}
