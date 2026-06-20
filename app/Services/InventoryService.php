<?php

namespace App\Services;

use App\Events\InventoryStockAdjusted;
use App\Events\LowStockDetected;
use App\Models\Item;
use App\Models\StockTransaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class InventoryService
{
    public function record(Item $item, User $user, string $type, int $quantity, string $date, ?string $notes): StockTransaction
    {
        if ($quantity < 1) {
            throw new InvalidArgumentException('Jumlah transaksi harus lebih dari nol.');
        }

        return DB::transaction(function () use ($item, $user, $type, $quantity, $date, $notes) {
            $item = Item::query()->whereKey($item->id)->lockForUpdate()->firstOrFail();
            $previousStock = $item->stock;

            if ($type === StockTransaction::TYPE_OUT && $item->stock < $quantity) {
                throw new InvalidArgumentException('Stok barang tidak mencukupi.');
            }

            $item->stock += $type === StockTransaction::TYPE_IN ? $quantity : -$quantity;
            $item->save();

            $transaction = StockTransaction::create([
                'item_id' => $item->id,
                'user_id' => $user->id,
                'type' => $type,
                'quantity' => $quantity,
                'transaction_date' => $date,
                'notes' => $notes,
            ]);

            InventoryStockAdjusted::dispatch($transaction, $item, $user, $previousStock, $item->stock);

            if ($previousStock > $item->minimum_stock && $item->stock <= $item->minimum_stock) {
                LowStockDetected::dispatch($item, $transaction, $previousStock, $item->stock);
            }

            return $transaction;
        });
    }
}
