<?php

namespace App\Http\Controllers;
use App\Models\Auction;
use App\Models\Payment;
use App\Models\User;
use App\Models\Notification;
use App\Models\ContactMessage;
use Illuminate\Support\Str;
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
        $activeListings=Auction::where('status','active')->count();
        $registeredUsers=User::count();
        $totalSold=Payment::whereIn('status',['held', 'shipped', 'received', 'released'])->sum('amount'); 
        $stats=[
            number_format($activeListings) . '+ Active Listings',
            number_format($registeredUsers) . '+ Registered Users',
            'PKR ' . number_format($totalSold, 0) . ' Sold',
            '100% Secure Transactions',
        ];
 
        return view('pages.about',compact('stats'));
    }

    public function contact(){
        return view('pages.contact');
    }

    public function contactSubmit(Request $request){
        $validated = $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|max:255',
            'subject' => 'required|string|max:100',
            'message' => 'required|string|max:2000',
        ]);
 
        $contactMessage = ContactMessage::create([
            'user_id' => auth()->id(),
            'name'    => $validated['name'],
            'email'   => $validated['email'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
        ]);

         User::where('role','admin')->get()->each(function($admin) use ($contactMessage){
            Notification::send(
                $admin->id,
                'contact_message',
                $contactMessage->subject . ': by ' . $contactMessage->email ,
                ' sent: ' . Str::limit($contactMessage->message, 100),
                null
            );
        });
        return back()->with('success', 'Thanks for reaching out! We will get back to you within 24 hours.');
    }

    public function privacy(){
        return view('pages.privacy');
    }
 
    public function terms(){
        return view('pages.terms');
    }
}
