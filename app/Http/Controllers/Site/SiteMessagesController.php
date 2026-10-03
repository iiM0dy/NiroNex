<?php

namespace App\Http\Controllers\Site;

use App\Enums\MessageType;
use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Mail\NewMessageNotification;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Mail;

class SiteMessagesController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $admin = User::where('type', UserType::Admin)->first();

        $messages = Message::where('type', MessageType::single)->where(function ($q) use ($user, $admin) {
            $q->where(function ($sq) use ($user, $admin) {
                $sq->where('sender_id', $user->id)->where('receiver_id', $admin->id);
            })->orWhere(function ($sq) use ($user, $admin) {
                $sq->where('sender_id', $admin->id)->where('receiver_id', $user->id);
            });
        })->orderByDesc('id')->limit(200)->get()->sortBy('created_at')->values();

        $user->receivedMessages()
            ->where('sender_id', $admin->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('site.messages.chat', compact('user', 'messages'));
    }

    public function recommendations()
    {
        $userId = auth()->id();
        $user = auth()->user();

        $messagesQuery = Message::where('type', MessageType::multi)
            ->whereJsonContains('target_user_ids', $userId)
            ->orderByDesc('id');

        $messagesQuery->clone()->update(['is_read' => true]);

        $messages = $messagesQuery->get();
        return view('site.messages.recommendations', compact('user', 'messages'));
    }

    public function fetch(Request $request)
    {
        $user = auth()->user();
        $admin = User::where('type', UserType::Admin)->first();
        $afterId = $request->input('after_id');

        $query = Message::where('type', MessageType::single)->where(function ($q) use ($user, $admin) {
            $q->where(function ($sq) use ($user, $admin) {
                $sq->where('sender_id', $user->id)->where('receiver_id', $admin->id);
            })->orWhere(function ($sq) use ($user, $admin) {
                $sq->where('sender_id', $admin->id)->where('receiver_id', $user->id);
            });
        });

        if ($afterId) {
            $query->where('id', '>', $afterId);
        } else {
            $query->orderByDesc('id')->limit(200);
        }

        $messages = $messages = $query->get()->sortBy('created_at');

        return response()->json([
            'messages' => $messages->map(function ($msg) {
                return [
                    'id' => $msg->id,
                    'sender_id' => $msg->sender_id,
                    'title' => $msg->title,
                    'body' => $msg->body,
                    'time_formatted' => formatDate($msg->created_at),
                ];
            }),
        ]);
    }

    public function send(Request $request)
    {
        $request->validate(['body' => 'required|string|max:3000']);

        $admin = User::where('type', UserType::Admin)->first();

        $message = Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $admin->id,
            'title' => null,
            'body' => $request->body,
            'is_read' => false,
        ]);

        $sender = auth()->user();
        $messageData = [
            'sender_name' => $sender->full_name,
            'body' => $request->body,
            'time' => now()->format('Y-m-d H:i'),
        ];

        Mail::to(env('CHAT_EMAIL'))->queue(new NewMessageNotification($messageData));

        return response()->json([
            'success' => true,
            'message' => [
                'id' => $message->id,
                'sender_id' => $message->sender_id,
                'title' => $message->title,
                'body' => $message->body,
                'time_formatted' => formatDate($message->created_at),
            ]
        ]);
    }

}
