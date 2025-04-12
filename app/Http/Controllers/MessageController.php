<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Events\NewMessageNotification;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class MessageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the chat page with a specific user.
     *
     * @param  int  $userId
     * @return \Illuminate\View\View
     */
    public function show($userId)
    {
        $otherUser = User::findOrFail($userId);
        $currentUser = auth()->user();

        // Create or update conversation to track this chat
        Conversation::updateOrCreate(
            [
                'user_id' => $currentUser->id,
                'other_user_id' => $otherUser->id,
            ],
            [
                'last_message_at' => now(),
            ]
        );

        // Mark all messages from this user as read
        Message::where('sender_id', $userId)
            ->where('receiver_id', $currentUser->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        // Get messages between the two users
        $messages = Message::where(function ($query) use ($currentUser, $userId) {
                $query->where('sender_id', $currentUser->id)
                      ->where('receiver_id', $userId);
            })
            ->orWhere(function ($query) use ($currentUser, $userId) {
                $query->where('sender_id', $userId)
                      ->where('receiver_id', $currentUser->id);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return view('chat.show', compact('otherUser', 'messages'));
    }

    /**
     * Get all conversations for the authenticated user.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $currentUser = auth()->user();

        // Get all conversations for the current user
        $userConversations = Conversation::where('user_id', $currentUser->id)
            ->with('otherUser')
            ->orderBy('last_message_at', 'desc')
            ->get();

        // Map conversations to include last message and unread count
        $conversations = $userConversations->map(function ($conversation) use ($currentUser) {
            $otherUser = $conversation->otherUser;
            
            // Get the last message between the users
            $lastMessage = Message::where(function ($query) use ($currentUser, $otherUser) {
                    $query->where('sender_id', $currentUser->id)
                          ->where('receiver_id', $otherUser->id);
                })
                ->orWhere(function ($query) use ($currentUser, $otherUser) {
                    $query->where('sender_id', $otherUser->id)
                          ->where('receiver_id', $currentUser->id);
                })
                ->latest()
                ->first();

            // Count unread messages
            $unreadCount = Message::where('sender_id', $otherUser->id)
                ->where('receiver_id', $currentUser->id)
                ->where('is_read', false)
                ->count();

            return [
                'user' => $otherUser,
                'last_message' => $lastMessage,
                'unread_count' => $unreadCount
            ];
        })->sortByDesc(function ($conversation) {
            return $conversation['last_message'] ? $conversation['last_message']->created_at : now()->subYear();
        })->values();

        return view('chat.index', compact('conversations'));
    }

    /**
     * Send a new message.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        $sender = auth()->user();
        $receiver = User::find($request->receiver_id);

        // Create the message in the database
        $message = Message::create([
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
            'message' => $request->message,
            'is_read' => false,
        ]);

        // Create or update conversation
        $conversation = Conversation::updateOrCreate(
            [
                'user_id' => $sender->id,
                'other_user_id' => $receiver->id,
            ],
            [
                'last_message_at' => now(),
            ]
        );

        // Create or update the reverse conversation
        Conversation::updateOrCreate(
            [
                'user_id' => $receiver->id,
                'other_user_id' => $sender->id,
            ],
            [
                'last_message_at' => now(),
            ]
        );

        // Broadcast the message to the receiver
        broadcast(new MessageSent($message, $sender))->toOthers();

        // Get unread message count for notification
        $unreadCount = Message::where('sender_id', $sender->id)
            ->where('receiver_id', $receiver->id)
            ->where('is_read', false)
            ->count();

        // Broadcast notification to the receiver
        broadcast(new NewMessageNotification(
            $receiver->id,
            'New message from ' . $sender->name,
            $unreadCount
        ))->toOthers();

        return response()->json([
            'status' => 'success', 
            'message' => $message,
            'sender' => $sender->only(['id', 'name'])
        ]);
    }

    /**
     * Get unread message count for the authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUnreadCount()
    {
        $unreadCount = Message::where('receiver_id', auth()->id())
            ->where('is_read', false)
            ->count();

        return response()->json(['unread_count' => $unreadCount]);
    }

    /**
     * Mark a message as read.
     *
     * @param  int  $messageId
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAsRead($messageId)
    {
        $message = Message::findOrFail($messageId);
        
        // Only the receiver can mark a message as read
        if ($message->receiver_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $message->update(['is_read' => true]);

        return response()->json(['status' => 'success']);
    }
}
