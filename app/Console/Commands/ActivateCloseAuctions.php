<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Auction;
use App\Models\Payment;
use App\Models\Notification;
use App\Events\AuctionStatusChanged;

class ActivateCloseAuctions extends Command
{
    protected $signature='auctions:activate-close';
    protected $description='Active and close all auctions according to their time';

    public function handle(){
        //Activate scheduled auctions whose start time has arrived
        $toActivate=Auction::where('status','scheduled')
            ->where('starts_at', '<=', now())
            ->get();
 
        foreach($toActivate as $auction){
            $auction->update(['status' => 'active']);
            broadcast(new AuctionStatusChanged($auction));

            //notify seller their auction is now live
            Notification::send(
                $auction->seller_id,
                'auction_active',
                'Your auction is now live!',
                '"' . $auction->title . '" has started and is now accepting bids.',
                $auction->id
            );
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

             if($highestBid){
                $fees=Payment::calculateFee((float) $auction->current_bid);
                Payment::firstOrCreate(
                    ['auction_id' => $auction->id],
                    [
                        'buyer_id'      => $highestBid->bidder_id,
                        'seller_id'     => $auction->seller_id,
                        'amount'        => $auction->current_bid,
                        'platform_fee'  => $fees['fee'],
                        'seller_amount' => $fees['sellerAmount'],
                        'status'        => 'pending',
                    ]
                );
            }

            //notify seller auction ended
            Notification::send(
                $auction->seller_id,
                'auction_closed',
                'Your auction has ended',
                '"' . $auction->title . '" has closed.' .
                    ($highestBid ? ' Winning bid: PKR ' . number_format($highestBid->amount) . '.' : ' No bids were placed.'),
                $auction->id
            );
 
            //notify winner
            if($highestBid){
                Notification::send(
                    $highestBid->bidder_id,
                    'auction_won',
                    'You won the auction!',
                    'Congratulations! You won "' . $auction->title . '" with a bid of PKR ' . number_format($highestBid->amount) . '.',
                    $auction->id
                );
            }
        }
 
        $this->info("Activated {$toActivate->count()} auctions, closed {$toClose->count()} expired auctions.");
    }
}
