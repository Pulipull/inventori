<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PaymentStatusReceived
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(
        public array $payload,
        public ?string $aggregateType = null,
        public ?int $aggregateId = null,
    ) {
        //
    }
}
