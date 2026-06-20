<?php

namespace App\Events;

use App\Models\Item;
use App\Models\StockTransaction;
use Illuminate\Contracts\Events\ShouldDispatchAfterCommit;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LowStockDetected implements ShouldDispatchAfterCommit
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(
        public Item $item,
        public ?StockTransaction $transaction,
        public int $previousStock,
        public int $currentStock,
    ) {
    }
}
