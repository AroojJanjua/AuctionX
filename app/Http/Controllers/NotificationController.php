<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(){
        $notifications=auth()->user()
            ->notifications()
            ->latest()
            ->paginate(20);

        //mark all as read when the user opens full page
        auth()->user()
            ->notifications()
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return view('pages.notifications',compact('notifications'));
    }

    //AJAX returns latest 8 for the bell dropdown with unread count
    public function dropdown(){
        $user=auth()->user();
        $notifications=$user->notifications()
            ->latest()
            ->take(8)
            ->get()
            ->map(fn($n) => [
                'id'        => $n->id,
                'type'      => $n->type,
                'title'     => $n->title,
                'message'   => $n->message,
                'auctionId' => $n->auction_id,
                'isUnread'  => $n->isUnread(),
                'ago'       => $n->created_at->diffForHumans(),
            ]);

        return response()->json([
            'notifications' => $notifications,
            'unreadCount'   => $user->notifications()->whereNull('read_at')->count(),
        ]);
    }

    //AJAX mark one notification as read
    public function markRead(string $id){
        auth()->user()
            ->notifications()
            ->findOrFail($id)->markAsRead();

        return response()->json(['ok' => true]);
    }

    //AJAX mark all read
    public function markAllRead(Request $request){
        auth()->user()
            ->notifications()
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        if ($request->ajax()){
            return response()->json(['ok' => true]);
        }
    }

    //delete a single notification
    public function destroy(string $id){
        auth()->user()->notifications()->findOrFail($id)->delete();
        return back()->with('success','Notification deleted.');
    }
}