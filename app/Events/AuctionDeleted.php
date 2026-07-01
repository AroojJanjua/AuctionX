<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AuctionDeleted implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int    $auctionId;
    public int    $sellerId;
    public string $title;

    public function __construct(int $auctionId, int $sellerId, string $title)
    {
        $this->auctionId = $auctionId;
        $this->sellerId  = $sellerId;
        $this->title     = $title;
    }

    public function broadcastOn(): array
    {
        return [
            // Public, home and index pages can remove the card
            new Channel('auctions.feed'),
            // Private, seller's own dashboard removes the row
            new PrivateChannel('seller.' . $this->sellerId),
        ];
    }

    public function broadcastAs(): string
    {
        return 'auction.deleted';
    }
}