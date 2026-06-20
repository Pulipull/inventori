<?php

use App\Services\ConversationAccessService;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('conversation.{conversationId}', function ($user, int $conversationId) {
    return app(ConversationAccessService::class)
        ->participantQuery($user)
        ->whereKey($conversationId)
        ->exists();
});
