<?php

namespace App\Events;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Contracts\Events\ShouldDispatchAfterCommit;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ConversationStarted implements ShouldDispatchAfterCommit
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(
        public Conversation $conversation,
        public User $actor,
        public User $participant,
    ) {
    }
}
