<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->latest()
            ->paginate(20);

        return view('site.notifications', compact('notifications'));
    }

    public function markRead($id)
    {
        $notification = Notification::where('user_id', Auth::id())->findOrFail($id);
        $notification->update(['is_read' => true]);

        return back()->with('success', 'تم تعليم الإشعار كمقروء.');
    }

    /**
     * JSON endpoint for polling unread notifications.
     * Designed so the frontend only depends on this JSON shape —
     * easy to swap to WebSocket/Pusher later by broadcasting
     * the same payload structure.
     */
    public function fetchUnread()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->unread()
            ->latest()
            ->take(10)
            ->get()
            ->map(fn($n) => [
                'id' => $n->id,
                'type' => $n->type,
                'title' => $n->title,
                'body' => $n->body,
                'icon' => $n->icon,
                'tone' => $n->tone,
                'time' => $n->created_at->diffForHumans(),
            ]);

        return response()->json([
            'count' => Notification::where('user_id', Auth::id())->unread()->count(),
            'items' => $notifications,
        ]);
    }
}
