<?php

namespace App\Listeners;

use App\Events\MessageSent;
use App\Services\NotificationService;

class SendMessageSentNotification
{
    public function __construct(private readonly NotificationService $notifications)
    {
    }

    public function handle(MessageSent $event): void
    {
        $message = $event->message;
        $conversation = $message->conversation;
        $sender = $message->user;
        $recipient = $conversation->otherUser($sender);

        if ($recipient) {
            $this->notifications->create(
                $recipient,
                'Pesan baru dari '.$sender->name,
                substr($message->body, 0, 100).(strlen($message->body) > 100 ? '...' : ''),
                'info',
                'system',
            );
        }
    }
}
