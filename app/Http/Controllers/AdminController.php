<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Bid;
use App\Models\User;
use App\Models\AutoBid;
use App\Models\Notification;
use App\Events\AuctionApproved;
use App\Events\AuctionStatusChanged;
use App\Events\AuctionDeleted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function dashboard(){
        $stats=[
            'total_users'    => User::count(),
            'total_auctions' => Auction::count(),
            'active'         => Auction::where('status', 'active')->count(),
            'closed'         => Auction::where('status', 'closed')->count(),
            'total_bids'     => Bid::count(),
            'total_revenue'  => Auction::where('status', 'closed')->sum('current_bid'),
            'sellers'        => User::where('role', 'seller')->count(),
            'bidders'        => User::where('role', 'bidder')->count(),
        ];

        $recent_auctions=Auction::with('seller')
            ->withCount('bids')->latest()
            ->take(5)->get();
        $recent_users=User::latest()->take(5)->get();
        $recent_bids=Bid::with(['bidder', 'auction'])
            ->latest()->take(5)->get();

        return view('pages.admin.dashboard',compact('stats','recent_auctions','recent_users','recent_bids'));
    }

    // auctions management
    public function auctions(Request $request){
         $query=Auction::with('seller')->withCount('bids');
        if($request->filled('search')){
            $query->where('title','like','%' . $request->search . '%');
        }
        if($request->filled('status')){
            $query->where('status',$request->status);
        }
        $auctions = $query->latest()->paginate(15);
        return view('pages.admin.auctions',compact('auctions'));    
    }

   public function approveAuction($id){
        $auction=Auction::with('seller')->findOrFail($id);
        $status=$auction->starts_at->isFuture()?'scheduled':'active';
        $auction->update(['status' => $status]);
 
        // Tell the seller their auction was approved and update status badge
        broadcast(new AuctionApproved($auction));

        //notify seller
        Notification::send(
            $auction->seller_id,
            'auction_approved',
            'Your auction was approved!',
            $status === 'active'
                ? '"' . $auction->title . '" is now live and accepting bids.'
                : '"' . $auction->title . '" is approved and will go live at its scheduled start time.',
            $auction->id
        );

        $msg=$status === 'active'
            ? 'Auction approved and set to active.'
            : 'Auction approved — will go live automatically at its scheduled start time.';
 
        return back()->with('success', $msg);
    }

    public function closeAuction($id){
        $auction=Auction::with('winner')->withCount('bids')->findOrFail($id);
        $highestBid=Bid::where('auction_id', $auction->id)->orderByDesc('amount')->first();
 
        $auction->update([
            'status'    => 'closed',
            'winner_id' => $highestBid ? $highestBid->bidder_id : null,
        ]);
 
        // Reload so winner relationship is fresh after the update
        $auction->load('winner');
        broadcast(new AuctionStatusChanged($auction));

        //notify seller
        Notification::send(
            $auction->seller_id,
            'auction_closed',
            'Your auction has ended',
            '"' . $auction->title . '" has been closed.' .
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
        return back()->with('success', 'Auction closed.');
    }

    public function destroyAuction($id){
        $auction=Auction::withCount('bids')->findOrFail($id);
        if($auction->bids_count > 0){
            return back()->with('error','Cannot delete an auction that has bids.');
        }

        if($auction->image){
          Storage::disk('public')->delete($auction->image);
        }

        //we capture before delete so we can broadcast after
        $auctionId=$auction->id;
        $sellerId=$auction->seller_id;
        $title=$auction->title;
 
        $auction->delete();
 
        broadcast(new AuctionDeleted($auctionId, $sellerId, $title));

        //notify seller (auction_id=null bcoz record is deleted)
        Notification::send(
            $sellerId,
            'auction_deleted',
            'Your auction was removed',
            '"' . $title . '" has been removed by an admin.',
            null
        );
        
        return redirect()->route('admin.auctions.index')->with('success', 'Auction deleted.');
    }

    //user management
    public function users(Request $request){
        $query=User::withCount(['bids', 'auctions']);
        if($request->filled('search')){
            $query->where('name','like','%' . $request->search . '%')
                  ->orWhere('email','like','%' . $request->search . '%');
        }
        if($request->filled('role')){
            $query->where('role', $request->role);
        }
        $users=$query->latest()->paginate(15);
        return view('pages.admin.users', compact('users'));
    }

    public function showUser($id){
        $user=User::with(['bids.auction','auctions'])
            ->withCount(['bids','auctions'])
            ->findOrFail($id);
        return view('pages.admin.user-detail', compact('user'));
    }

    public function updateRole(Request $request, $id){
        $request->validate([
            'role' => 'required|in:bidder,seller,admin',
        ]);
        $user = User::findOrFail($id);

        //prevent admin from changing their own role
        if($user->id === auth()->id()){
            return back()->with('error','You cannot change your own role');
        }
        $user->update(['role' => $request->role]);
        return back()->with('success',"User role updated to {$request->role}.");
    }

    public function banUser($id){
        $user=User::findOrFail($id);
        if($user->id === auth()->id()){
            return back()->with('error','You cannot ban yourself');
        }
        $newStatus=!$user->is_banned;
        $user->update([
            'is_banned' => $newStatus
        ]);
        return back()->with('success', $newStatus ? 'User banned' : 'User ban lifted');
    }

    public function destroyUser($id){
         $user=User::withCount(['auctions', 'bids'])->findOrFail($id);

        if($user->id === auth()->id()){
            return back()->with('error','You cannot delete your own account.');
        }
        if($user->auctions_count > 0){
            return back()->with('error',
                'This user has '.$user->auctions_count.' auction(s) on record. '.
                'Deleting them will permanently remove those auctions and their bid history. '.
                'Ban the user instead, or delete their auctions individually first.');
            }
        
        $user->auctions->each(function($auction){
        if($auction->image){
            \Illuminate\Support\Facades\Storage::disk('public')->delete($auction->image);
           }
        });

        $user->delete();
        return redirect()->route('admin.users.index')
            ->with('success','User deleted.');
    }

    // bid management
     public function bids(Request $request){
        $query=Bid::with(['bidder', 'auction']);
        if($request->filled('search')){
            $query->whereHas('bidder',function ($q) use ($request){
                $q->where('name','like', '%' . $request->search . '%');
            })->orWhereHas('auction',function ($q) use ($request){
                $q->where('title','like', '%' . $request->search . '%');
            });
        }
        $bids=$query->latest()->paginate(20);
        return view('pages.admin.bids',compact('bids'));
    }

    public function destroyBid($id){
        $bid=Bid::with('auction')->findOrFail($id);
        $auction=$bid->auction;
        $deletedBidderId=$bid->bidder_id;
 
        $bid->delete();
        AutoBid::where('auction_id', $auction->id)
            ->where('bidder_id', $deletedBidderId)
            ->delete();
 
        $newHighest = Bid::where('auction_id', $auction->id)
            ->orderByDesc('amount')
            ->first();
 
        $auction->update([
            'current_bid' => $newHighest ? $newHighest->amount : $auction->starting_bid,
            'winner_id' => $newHighest ? $newHighest->bidder_id : null,
        ]);
        return back()->with('success','Bid removed and auction price recalculated.');
    }

    public function reports(){
        $topSellers=User::where('role','seller')
            ->withCount('auctions')
            ->withSum(['auctions as total_revenue' => function($q){
            $q->where('status', 'closed');}], 'current_bid')
            ->orderByDesc('total_revenue')
            ->take(10)->get();
        $topBidders=User::where('role','bidder')
            ->withCount('bids')
            ->orderByDesc('bids_count')
            ->take(10)->get();
        $categoryStats=Auction::selectRaw('category, COUNT(*) as total, AVG(current_bid) as avg_bid')
            ->groupBy('category')->get();

        return view('pages.admin.reports',compact('topSellers','topBidders','categoryStats'));
    }
}
