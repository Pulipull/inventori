<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\User;
use App\Services\ChatService;
use App\Services\ConversationAccessService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ChatController extends Controller
{
    public function index(Request $request, ChatService $chat): View
    {
        return view('chat.index', [
            'conversations' => $chat->conversationsFor($request->user()),
            'metrics' => $chat->conversationMetrics($request->user()),
            'users' => User::whereIn('role', ['admin', 'petugas'])
                ->where('id', '!=', $request->user()->id)
                ->orderBy('name')
                ->get(),
        ]);
    }

    public function start(Request $request, ChatService $chat): RedirectResponse
    {
        $data = $request->validate([
            'user_id' => ['required', Rule::exists('users', 'id')->whereIn('role', ['admin', 'petugas'])],
        ]);
        $conversation = $chat->startConversation($request->user(), User::findOrFail($data['user_id']));

        return redirect()->route('chat.show', $conversation);
    }

    public function show(
        Request $request,
        Conversation $conversation,
        ConversationAccessService $access,
        ChatService $chat
    ): View
    {
        $access->authorize($request->user(), $conversation);
        $chat->markConversationAsRead($conversation, $request->user());
        $otherUser = $conversation->otherUser($request->user());

        return view('chat.show', [
            'conversation' => $conversation->load(['userOne', 'userTwo', 'messages.user']),
            'otherUser' => $otherUser,
            'otherReadReceipt' => $chat->readReceiptFor($conversation, $otherUser),
        ]);
    }

    public function store(
        Request $request,
        Conversation $conversation,
        ConversationAccessService $access,
        ChatService $chat
    ): RedirectResponse
    {
        $access->authorize($request->user(), $conversation);
        $data = $request->validate(['body' => ['required', 'string', 'max:2000']]);
        $chat->sendMessage($conversation, $request->user(), $data['body']);

        return back();
    }

    public function markRead(Request $request, Conversation $conversation, ChatService $chat): RedirectResponse|JsonResponse
    {
        $chat->markConversationAsRead($conversation, $request->user());

        if ($request->wantsJson()) {
            return response()->json(['unread_count' => $chat->unreadCount($request->user())]);
        }

        return back();
    }

    public function unreadCount(Request $request, ChatService $chat): JsonResponse
    {
        return response()->json(['unread_count' => $chat->unreadCount($request->user())]);
    }
}
