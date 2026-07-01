<?php

namespace App\Events;

use App\Models\Auction;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AuctionSubmitted implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int    $auctionId;
    public string $title;
    public string $category;
    public string $sellerName;
    public int    $startingBid;
    public string $endsAt;
    public string $submittedAgo;

    public function __construct(Auction $auction)
    {
        $this->auctionId    = $auction->id;
        $this->title        = $auction->title;
        $this->category     = ucfirst($auction->category);
        $this->sellerName   = $auction->seller->name;
        $this->startingBid  = (int) $auction->starting_bid;
        $this->endsAt       = $auction->ends_at->format('M d, Y');
        $this->submittedAgo = 'just now';
    }

    public function broadcastOn(): array
    {
        // Private channel, only authenticated admins can subscribe
        return [ new PrivateChannel('admin.feed') ];
    }

    public function broadcastAs(): string
    {
        return 'auction.submitted';
    }
}