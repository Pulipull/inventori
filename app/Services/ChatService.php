<?php

namespace App\Services;

use App\Events\ConversationStarted;
use App\Events\MessageRead;
use App\Events\MessageSent;
use App\Models\Conversation;
use App\Models\ConversationReadReceipt;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Collection;

class ChatService
{
    public function __construct(private readonly ConversationAccessService $access)
    {
    }

    public function conversationsFor(User $user): Collection
    {
        $conversations = $this->access->participantQuery($user)
            ->with(['userOne', 'userTwo', 'latestMessage'])
            ->latest()
            ->get();

        $unreadCounts = $this->unreadCountsByConversation($user);

        return $conversations->each(fn (Conversation $conversation) => $conversation
            ->setAttribute('unread_messages_count', (int) ($unreadCounts[$conversation->id] ?? 0)));
    }

    public function startConversation(User $actor, User $participant): Conversation
    {
        abort_if($actor->id === $participant->id, 422);

        $ids = [$actor->id, $participant->id];
        sort($ids);

        $conversation = Conversation::firstOrCreate([
            'user_one_id' => $ids[0],
            'user_two_id' => $ids[1],
        ]);

        if ($conversation->wasRecentlyCreated) {
            ConversationStarted::dispatch($conversation, $actor, $participant);
        }

        return $conversation;
    }

    public function sendMessage(Conversation $conversation, User $sender, string $body): Message
    {
        $this->access->authorize($sender, $conversation);

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'user_id' => $sender->id,
            'body' => $body,
        ]);

        $this->markConversationAsRead($conversation, $sender);
        
        MessageSent::dispatch($message);

        return $message;
    }

    public function markConversationAsRead(Conversation $conversation, User $user): ConversationReadReceipt
    {
        $this->access->authorize($user, $conversation);

        $latestMessage = $conversation->messages()->latest('id')->first();
        $receipt = ConversationReadReceipt::firstOrNew([
            'conversation_id' => $conversation->id,
            'user_id' => $user->id,
        ]);

        $previousMessageId = $receipt->message_id;
        $receipt->forceFill([
            'message_id' => $latestMessage?->id,
            'read_at' => now(),
        ])->save();

        if ($previousMessageId !== $receipt->message_id) {
            MessageRead::dispatch($conversation, $user, $receipt);
        }

        return $receipt;
    }

    public function unreadCount(User $user): int
    {
        return $this->unreadCountsByConversation($user)->sum();
    }

    public function conversationMetrics(User $user): array
    {
        return [
            'active_conversations' => $this->access->participantQuery($user)->has('messages')->count(),
            'unread_conversations' => $this->unreadCountsByConversation($user)->filter(fn (int $count) => $count > 0)->count(),
        ];
    }

    public function readReceiptFor(Conversation $conversation, User $user): ?ConversationReadReceipt
    {
        return ConversationReadReceipt::where('conversation_id', $conversation->id)
            ->where('user_id', $user->id)
            ->first();
    }

    private function unreadCountsByConversation(User $user): Collection
    {
        return Message::query()
            ->selectRaw('messages.conversation_id, count(*) as total')
            ->join('conversations', 'conversations.id', '=', 'messages.conversation_id')
            ->leftJoin('conversation_read_receipts as receipts', function ($join) use ($user) {
                $join->on('receipts.conversation_id', '=', 'messages.conversation_id')
                    ->where('receipts.user_id', '=', $user->id);
            })
            ->where(fn ($query) => $query
                ->where('conversations.user_one_id', $user->id)
                ->orWhere('conversations.user_two_id', $user->id))
            ->where('messages.user_id', '!=', $user->id)
            ->whereRaw('messages.id > COALESCE(receipts.message_id, 0)')
            ->groupBy('messages.conversation_id')
            ->pluck('total', 'messages.conversation_id');
    }
}
