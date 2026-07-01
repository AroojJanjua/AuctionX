<?php

namespace App\Events;

use App\Models\Auction;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AuctionApproved implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int    $auctionId;
    public int    $sellerId;
    public string $title;
    public string $newStatus;
    public string $message;

    public function __construct(Auction $auction)
    {
        $this->auctionId = $auction->id;
        $this->sellerId  = $auction->seller_id;
        $this->title     = $auction->title;
        $this->newStatus = $auction->status;
       $this->message    = match($auction->status){
            'active'    => 'Your auction is now live and accepting bids!',
            'scheduled' => 'Your auction is approved and scheduled — it will go live automatically at its start time.',
            default     => 'Your auction status has been updated.',
        };
    }

    public function broadcastOn(): array
    {
        // Private channel, only this seller receives their own approval
        return [ new PrivateChannel('seller.' . $this->sellerId) ];
    }

    public function broadcastAs(): string
    {
        return 'auction.approved';
    }
}