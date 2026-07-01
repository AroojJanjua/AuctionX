<?php

namespace App\Http\Controllers;
use App\Models\Auction;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $featured=Auction::with('seller')
            ->where('status','active')
            ->withCount('bids')
            ->orderByDesc('bids_count')
            ->first();
        $auctions=Auction::with('seller')
            ->where('status','active')
            ->withCount('bids')
            ->when($featured,function($q) use ($featured){
            $q->where('id','!=',$featured->id);
        })
            ->orderBy('ends_at')
            ->take(8)
            ->get();
        return view('pages.home',compact('featured', 'auctions'));
    }

    public function homeLiveData(){
        $auctions=Auction::with('seller')
            ->where('status','active')
            ->withCount('bids')
            ->orderBy('ends_at')         
            ->take(8)->get()
            ->map(fn($a) => [
                'id'           => $a->id,
                'currentBid'   => (int) $a->current_bid,
                'bidsCount'    => (int) $a->bids_count,
                'timeRemaining'=> $a->time_remaining,
                'endsSoon'     => (bool) $a->ends_soon,
                'endsAt'       => $a->ends_at->timestamp,
                'status'       => $a->status,
            ]);
 
        $featured=Auction::where('status','active')
            ->withCount('bids')
            ->orderByDesc('bids_count')
            ->first();
 
        return response()->json([
            'auctions'   => $auctions,
            'featured'   => $featured ? [
            'id'         => $featured->id,
            'currentBid' => (int) $featured->current_bid,
            'endsAt'     => $featured->ends_at->timestamp,
            'endsSoon'   => (bool) $featured->ends_soon,
            ] : null,
        ]);
    }

    public function howItWorks(){
        return view('pages.how-it-works');
    }

    public function about(){
        return view('pages.about');
    }

    public function contact(){
        return view('pages.contact');
    }
    public function privacy(){
        return view('pages.privacy');
    }
 
    public function terms(){
        return view('pages.terms');
    }
 
    public function support(){
        return view('pages.support');
    }
}
