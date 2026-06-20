<?php

namespace App\Listeners;

use App\Events\ConversationStarted;
use App\Services\NotificationService;

class SendConversationStartedNotification
{
    public function __construct(private readonly NotificationService $notifications)
    {
    }

    public function handle(ConversationStarted $event): void
    {
        $this->notifications->create(
            $event->participant,
            'Percakapan baru',
            $event->actor->name.' memulai percakapan internal dengan Anda.',
            'info',
            'system',
        );
    }
}
