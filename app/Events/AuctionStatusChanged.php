<?php

namespace App\Events;

use App\Models\Auction;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AuctionStatusChanged implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $auctionId;
    public string $status;      
    public ?string $winnerName;

    public function __construct(Auction $auction)
    {
        $this->auctionId  = $auction->id;
        $this->status     = $auction->status;
        $this->winnerName = $auction->winner?->name;
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('auction.' . $this->auctionId),
            new Channel('auctions.feed'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'auction.status-changed';
    }
}