<?php

namespace App\Console\Commands;

use App\Models\Auction;
use Illuminate\Console\Command;
use App\Events\AuctionStatusChanged;

class ActivateScheduledAuctions extends Command
{
    protected $signature='auctions:activate';
    protected $description='Activate approved auctions whose start time has arrived';

    public function handle(){
        $toActivate=Auction::where('status','scheduled')
            ->where('starts_at','<=', now())
            ->get();
 
        foreach($toActivate as $auction){
            $auction->update(['status' => 'active']);
            broadcast(new AuctionStatusChanged($auction));
        }

        $this->info("Activated {$toActivate->count()} auctions.");
    }
}
