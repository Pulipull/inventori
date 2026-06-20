<?php

namespace App\Events;

use App\Models\Conversation;
use App\Models\ConversationReadReceipt;
use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageRead
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(
        public Conversation $conversation,
        public User $reader,
        public ConversationReadReceipt $receipt,
    ) {
    }
}
