<?php

namespace App\Services;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class ConversationAccessService
{
    public function authorize(User $user, Conversation $conversation): void
    {
        abort_unless($this->isParticipant($user, $conversation), 403);
    }

    public function isParticipant(User $user, Conversation $conversation): bool
    {
        return in_array($user->id, [$conversation->user_one_id, $conversation->user_two_id], true);
    }

    public function participantQuery(User $user): Builder
    {
        return Conversation::query()
            ->where(fn (Builder $query) => $query
                ->where('user_one_id', $user->id)
                ->orWhere('user_two_id', $user->id));
    }
}
