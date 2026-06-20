<?php

namespace App\Events;

use App\Models\Item;
use App\Models\StockTransaction;
use App\Models\User;
use Illuminate\Contracts\Events\ShouldDispatchAfterCommit;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InventoryStockAdjusted implements ShouldDispatchAfterCommit
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(
        public StockTransaction $transaction,
        public Item $item,
        public User $actor,
        public int $previousStock,
        public int $currentStock,
    ) {
    }
}
