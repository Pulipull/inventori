<?php

namespace App\Services;

use App\Events\NotificationCreated;
use App\Models\AppNotification;
use App\Models\Item;
use App\Models\NotificationDeliveryLog;
use App\Models\NotificationPreference;
use App\Models\StockTransaction;
use App\Models\User;
use Illuminate\Support\Arr;

class NotificationService
{
    public function create(
        User|int $recipient,
        string $title,
        string $message,
        string $type = 'info',
        string $preferenceType = 'system'
    ): ?AppNotification {
        return $this->createAndDispatch($recipient, $title, $message, $type, $preferenceType);
    }

    public function createNotification(
        User|int $recipient,
        string $title,
        string $message,
        string $type = 'info',
        string $preferenceType = 'system'
    ): ?AppNotification {
        if (! $this->shouldNotify($recipient, $preferenceType)) {
            return null;
        }

        $userId = $recipient instanceof User ? $recipient->id : $recipient;

        return AppNotification::create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'type' => $type,
        ]);
    }

    public function createAndDispatch(
        User|int $recipient,
        string $title,
        string $message,
        string $type = 'info',
        string $preferenceType = 'system'
    ): ?AppNotification {
        $notification = $this->createNotification($recipient, $title, $message, $type, $preferenceType);

        if ($notification) {
            NotificationCreated::dispatch($notification->id, $notification->user_id, $notification->type);
        }

        return $notification;
    }

    public function shouldNotify(User|int $recipient, string $preferenceType = 'system'): bool
    {
        $userId = $recipient instanceof User ? $recipient->id : $recipient;
        $column = Arr::get([
            'low_stock' => 'low_stock_enabled',
            'crm' => 'crm_enabled',
            'report' => 'report_enabled',
            'system' => 'system_enabled',
        ], $preferenceType, 'system_enabled');

        $preferences = NotificationPreference::firstOrCreate(['user_id' => $userId]);

        return (bool) $preferences->{$column};
    }

    public function logDelivery(
        AppNotification|int $notification,
        string $channel = NotificationDeliveryLog::CHANNEL_DATABASE,
        string $status = NotificationDeliveryLog::STATUS_SENT
    ): NotificationDeliveryLog {
        $notification = $notification instanceof AppNotification
            ? $notification
            : AppNotification::findOrFail($notification);

        return NotificationDeliveryLog::create([
            'notification_id' => $notification->id,
            'user_id' => $notification->user_id,
            'channel' => $channel,
            'status' => $status,
            'sent_at' => $status === NotificationDeliveryLog::STATUS_SENT ? now() : null,
            'created_at' => now(),
        ]);
    }

    public function lowStock(User|int $recipient, Item $item): ?AppNotification
    {
        $type = $item->stock <= 0 ? 'danger' : 'warning';
        $title = $item->stock <= 0 ? 'Stok habis' : 'Stok menipis';

        return $this->create(
            $recipient,
            $title,
            $item->name.' tersisa '.$item->stock.' '.$item->unit.'.',
            $type,
            'low_stock',
        );
    }

    public function stockAdjusted(
        User|int $recipient,
        StockTransaction $transaction,
        int $previousStock,
        int $currentStock
    ): ?AppNotification {
        $transaction->loadMissing('item');
        $direction = $transaction->type === StockTransaction::TYPE_IN ? 'masuk' : 'keluar';

        return $this->create(
            $recipient,
            'Transaksi berhasil',
            'Transaksi barang '.$direction.' untuk '.$transaction->item->name.' berhasil dicatat. Stok '.$previousStock.' menjadi '.$currentStock.'.',
            'success',
            'system',
        );
    }

    public function inventoryUpdated(User|int $recipient, Item $item, User $actor): ?AppNotification
    {
        return $this->create(
            $recipient,
            'Data barang diperbarui',
            $actor->name.' memperbarui data barang '.$item->name.'.',
            'info',
            'system',
        );
    }
}
