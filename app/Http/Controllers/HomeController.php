<?php

namespace App\Http\Controllers;
use App\Models\Auction;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        // Auto-close expired auctions & activate started ones
        Auction::where('status','active')->where('ends_at','<=', now())->update(['status'=>'closed']);
        Auction::where('status','draft')->where('starts_at','<=', now())->update(['status'=>'active']);
        $featured=Auction::with('seller')
            ->where('status','active')
            ->withCount('bids')
            ->orderByDesc('bids_count')
            ->first();
        $auctions=Auction::with('seller')
            ->where('status','active')
            ->withCount('bids')
            ->orderBy('ends_at')
            ->take(8)
            ->get();
        return view('pages.home',compact('featured', 'auctions'));
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
