<?php

namespace App\Events;

use App\Models\Auction;
use App\Models\Bid;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BidPlaced implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $auctionId;
    public int $currentBid;
    public string $bidderName;
    public bool $isAutoBid;
    public int $bidsCount;
    public string $endsAt;      
    public bool $sniped;
    public int $minNextBid;
    public array $aiSuggestion;

    public function __construct(Auction $auction, bool $sniped = false)
    {
        $latestBid=Bid::with('bidder')
            ->where('auction_id', $auction->id)
            ->orderByDesc('amount')
            ->orderByDesc('created_at')
            ->first();

        $this->auctionId    = $auction->id;
        $this->currentBid   = $auction->current_bid;
        $this->bidderName   = $latestBid?->bidder?->name ?? 'Unknown';
        $this->isAutoBid    = $latestBid?->is_auto_bid ?? false;
        $this->bidsCount    = $auction->bids()->count();
        $this->endsAt       = $auction->ends_at->toIso8601String();
        $this->sniped       = $sniped;
        $this->minNextBid   = (int) $auction->min_next_bid;
        $this->aiSuggestion = $auction->ai_bid_suggestion;
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
        return 'bid.placed';
    }
}