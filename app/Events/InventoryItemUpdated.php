<?php

namespace App\Events;

use App\Models\Item;
use App\Models\User;
use Illuminate\Contracts\Events\ShouldDispatchAfterCommit;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InventoryItemUpdated implements ShouldDispatchAfterCommit
{
    use Dispatchable;
    use SerializesModels;

    public int $itemId;

    public string $itemCode;

    public string $itemName;

    public function __construct(
        public Item $item,
        public User $actor,
        public array $changes,
    ) {
        $this->itemId = $item->id;
        $this->itemCode = $item->code;
        $this->itemName = $item->name;
    }
}
