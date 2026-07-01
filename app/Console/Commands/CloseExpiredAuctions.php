<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Auction;
use App\Events\AuctionStatusChanged;

class CloseExpiredAuctions extends Command
{
    protected $signature='auctions:close-expired';
    protected $description='Close all auctions past their end time';

    public function handle(){
        //Activate scheduled auctions whose start time has arrived
        $toActivate=Auction::where('status','scheduled')
            ->where('starts_at', '<=', now())
            ->get();
 
        foreach($toActivate as $auction){
            $auction->update(['status' => 'active']);
            broadcast(new AuctionStatusChanged($auction));
        }

        $toClose=Auction::with('winner')
            ->where('status','active')
            ->where('ends_at', '<=', now())
            ->get();
 
        foreach($toClose as $auction){
            $highestBid=$auction->bids()->orderByDesc('amount')->first();
            $auction->update([
                'status'    => 'closed',
                'winner_id' => $highestBid?->bidder_id,  //null-safe operator 
            ]);
            $auction->load('winner');
            broadcast(new AuctionStatusChanged($auction));
        }
 
        $this->info("Activated {$toActivate->count()} auctions, closed {$toClose->count()} expired auctions.");
    }
}
