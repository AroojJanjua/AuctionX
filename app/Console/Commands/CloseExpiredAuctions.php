<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Auction;

class CloseExpiredAuctions extends Command
{
    protected $signature = 'auctions:close-expired';
    protected $description = 'Close all auctions past their end time';

    public function handle(){

         // Activate auctions whose start time has arrived
        $activated=Auction::where('status','draft')
            ->where('starts_at', '<=', now())
            ->update(['status' => 'active']);

        // Close auctions whose end time has passed
        $closed =Auction::where('status','active')
            ->where('ends_at', '<=', now())
            ->update(['status' => 'closed']);

        $this->info("Activated {$activated} auctions, closed {$closed} expired auctions.");
    }
}
