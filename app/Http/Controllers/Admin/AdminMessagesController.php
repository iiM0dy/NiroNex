<?php

namespace App\Http\Controllers\Admin;

use App\Enums\MessageType;
use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;

class AdminMessagesController extends Controller
{
    public function index()
    {
        $adminId = auth()->id();

        $users = User::realUsers()
            ->where(function ($query) use ($adminId) {
                $query->whereHas('sentMessages', function ($q) use ($adminId) {
                    $q->where('receiver_id', $adminId);
                })->orWhereHas('receivedMessages', function ($q) use ($adminId) {
                    $q->where('sender_id', $adminId);
                });
            })
            ->withCount([
                    'sentMessages as unread_count' => function ($q) use ($adminId) {
                        $q->where('receiver_id', $adminId)->where('is_read', false);
                    }
                ])->orderByDesc('unread_count')->paginate(20);

        return view('admin.messages.index', compact('users'));
    }

    public function userChat(User $user)
    {
        abort_if($user->isDemoAccount() || $user->type !== \App\Enums\UserType::User, 404);

        $messages = Message::where(function ($q) use ($user) {
            $q->where('sender_id', $user->id)
                ->where('receiver_id', auth()->id());
        })->orWhere(function ($q) use ($user) {
            $q->where('sender_id', auth()->id())
                ->where('receiver_id', $user->id);
        })->orderByDesc('id')->limit(500)->get()->sortBy('created_at')->values();

        Message::where('sender_id', $user->id)
            ->where('receiver_id', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('admin.messages.chat', compact('user', 'messages'));
    }
    public function fetch(Request $request)
    {
        $admin = auth()->user();
        $afterId = $request->input('after_id');
        $userId = $request->user_id;

        User::realUsers()->findOrFail($userId);

        $query = Message::where(function ($q) use ($admin, $userId) {
            $q->where(function ($sub) use ($admin, $userId) {
                $sub->where('sender_id', $userId)
                    ->where('receiver_id', $admin->id);
            })->orWhere(function ($sub) use ($admin, $userId) {
                $sub->where('sender_id', $admin->id)
                    ->where('receiver_id', $userId);
            });
        });

        if ($afterId) {
            $query->where('id', '>', $afterId)
                ->orderBy('id', 'asc');
        } else {
            $query->orderBy('id', 'desc')->limit(1000);
        }

        $messages = $query->get();

        $messages = $messages->sortBy('created_at')->values();

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

        User::realUsers()->findOrFail($request->user_id);

        $message = Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->user_id,
            'title' => null,
            'body' => $request->body,
            'is_read' => false,
        ]);

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

    public function recommendationsShow()
    {
        $messages = Message::where('type', MessageType::multi)->whereNotNull('target_user_ids')
            ->orderByDesc('id')
            ->limit(2000)
            ->get();
        return view('admin.messages.recommendations', compact('messages'));
    }

    public function sendRecommendations(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'body' => 'required|string|max:4000',
        ]);
        $data = $request->all();

        $planIds = Plan::where('recommendation', 1)
            ->orWhere('privet_manger', 1)
            ->pluck('id')
            ->toArray();

        $userIds = User::realUsers()
            ->whereIn('plan_id', $planIds)
            ->where('status', UserStatus::Active)
            ->pluck('id')
            ->toArray();

        Message::create([
            'type' => MessageType::multi,
            'title' => $data['title'],
            'body' => $data['body'],
            'target_user_ids' => json_encode($userIds),
            'is_read' => false,
        ]);

        return back()->with('success', 'تم إرسال التوصية بنجاح لجميع المشتركين.');
    }

}
