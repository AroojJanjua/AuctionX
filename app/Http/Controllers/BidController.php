<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\AutoBid;
use App\Models\Bid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Events\BidPlaced;

class BidController extends Controller
{
    public function myBids(){
        $bids=Bid::with('auction','auction.seller')
            ->where('bidder_id', auth()->id())
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('pages.my-bids',compact('bids'));
    }

    public function store(Request $request, $auctionId){
        $auction = Auction::findOrFail($auctionId);

        // checking 
        if($auction->status !== 'active'){
            return back()->with('error','This auction is not active.');
        }
        if($auction->starts_at->isFuture()){
            return back()->with('error','This auction has not started yet.');
        }
        if($auction->ends_at->isPast()){
            return back()->with('error','This auction has already ended.');
        }
        if($auction->seller_id === auth()->id()){
            return back()->with('error','You cannot bid on your own listing.');
        }

        // Validation
         $request->validate([
            'bid_amount'=>[
                'required', 
                'numeric',
                'min:' . $auction->min_next_bid,
            ],
            'max_auto_bid'=>[
                'nullable',
                'numeric',
                'min:' . $auction->min_next_bid,
            ],
        ], [
            'bid_amount.required'  => 'Please enter a bid amount.',
            'bid_amount.min'       => 'Your bid must be at least PKR ' . number_format((int)$auction->min_next_bid) . '.',
            'max_auto_bid.numeric' => 'Auto-bid limit must be a valid number.',
            'max_auto_bid.min'     => 'Auto-bid limit must also be at least PKR ' . number_format((int)$auction->min_next_bid) . '.',
        ]);

        // If auto-bid limit is set, it must be >= bid amount
        $bidAmount=(int)$request->bid_amount;
         $maxAutoBid=$request->filled('max_auto_bid')? (int)$request->max_auto_bid : null;
 
        if($maxAutoBid !== null && $maxAutoBid < $bidAmount){
            return back()->withInput()->with(['error' => 'Auto-bid limit must be greater than or equal to your bid amount.']);
        }

        // Place bid inside a transaction
        $sniped=false;
        DB::transaction(function() use ($bidAmount, $maxAutoBid, $auction, &$sniped){

        // Save or update auto-bid limit in its own table
        if($maxAutoBid !== null){
            AutoBid::updateOrCreate(
                [
                    'auction_id' => $auction->id,
                    'bidder_id'  => auth()->id(),
                ],
                ['max_amount' => $maxAutoBid]
            );
        }

         // Save the manual bid
            Bid::create([
                'auction_id'   => $auction->id,
                'bidder_id'    => auth()->id(),
                'amount'       => $bidAmount,
                'is_auto_bid'  => false,
            ]);

        // Update auction current bid
            $auction->update(['current_bid' => $bidAmount]);

        //Anti sniping
            $minutesLeft=now()->diffInMinutes($auction->ends_at, false);
            if($minutesLeft >= 0 && $minutesLeft <= 1 && $auction->snipe_extension_count < 5){
                $auction->update([
                    'ends_at'                => $auction->ends_at->addMinutes(2),
                    'snipe_extension_count'  => $auction->snipe_extension_count + 1,
                ]);
                 $sniped=true;               
            }
        // auto bid: check if another bidder can counter
        $this->processAutoBids($auction, auth()->id(),$bidAmount);
        });
        
        if($sniped){
        session()->flash('info','Anti-sniping protection activated — auction timer extended by 2 minutes!');
        }

        // Re-fetch to get fresh current_bid 
        $auction->refresh();

        broadcast(new BidPlaced($auction,$sniped));
 
        $isLeading=$auction->bids()
            ->orderByDesc('amount')
            ->value('bidder_id') === auth()->id();
 
        if($isLeading){
            return back()->with('success',
                'Bid placed successfully! You are the highest bidder.' .
                ($maxAutoBid ? 'Auto-bid is active up to PKR ' . number_format((int) $maxAutoBid) . '.' : ''));
        }
 
        return back()->with('info',
            'Your bid was placed but you were immediately outbid by another bidder\'s auto-bid. Raise your bid to take the lead!');
    }

    // Auto bod engine: Runs after every manual bid to finds the best competing auto-bidder and fires a counter-bid if they can still outbid the new bid
    private function processAutoBids(Auction $auction, int $justBiddedBy, int $currentBid, int $depth=0):void{
    
    if($depth > 20) return;
    // Find competitor from auto_bids table — clean and accurate
    $competitor=AutoBid::where('auction_id', $auction->id)
        ->where('bidder_id', '!=', $justBiddedBy)
        ->where('max_amount', '>', $currentBid)
        ->orderByDesc('max_amount')
        ->orderBy('created_at')     //older limit wins
        ->first();

    if(!$competitor) return;

    $increment=max(10,(int)($currentBid * 0.01));
    $counterBid=min((int)round($currentBid + $increment),(int)$competitor->max_amount);

     if($counterBid <= $currentBid) return;

    Bid::create([
        'auction_id'  => $auction->id,
        'bidder_id'   => $competitor->bidder_id,
        'amount'      => $counterBid,
        'is_auto_bid' => true,
    ]);

    $auction->update(['current_bid' => $counterBid]);
    $this->processAutoBids($auction,$competitor->bidder_id,$counterBid,$depth + 1);
    } 

}