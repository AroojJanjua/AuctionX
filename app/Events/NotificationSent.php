<?php

namespace App\Events;

use App\Models\Notification;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int    $userId;
    public string $id;
    public string $type;
    public string $title;
    public string $message;
    public ?int   $auctionId;
    public string $createdAt;

    public function __construct(Notification $notification)
    {
        $this->userId    = $notification->user_id;
        $this->id        = $notification->id;
        $this->type      = $notification->type;
        $this->title     = $notification->title;
        $this->message   = $notification->message;
        $this->auctionId = $notification->auction_id;
        $this->createdAt = $notification->created_at->diffForHumans();
    }

    public function broadcastOn(): array
    {
        //private per-user channel, only specific user receives their own notifications
        return [ new PrivateChannel('user.' . $this->userId) ];
    }

    public function broadcastAs(): string
    {
        return 'notification.sent';
    }
}