<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use Illuminate\Http\Request;

class AuctionController extends Controller
{
    public function index(Request $request){
        $query=Auction::with('seller')
            // ->withCount('bids')
            ->where('status', 'active');

        // Search 
        if($request->filled('search')){
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title'       ,'like','%'.$search.'%')
                ->orWhere('description' ,'like','%'.$search.'%');
            });
        }

        //  Category filter 
        if($request->filled('category') && $request->category !== 'all'){
            $query->where('category',$request->category);
        }

        // Price range filter 
        if($request->filled('min_price') && is_numeric($request->min_price)){
            $query->where('current_bid','>=', $request->min_price);
        }
        if($request->filled('max_price') && is_numeric($request->max_price)){
            $query->where('current_bid','<=', $request->max_price);
        }

        // Sorting 
            switch($request->get('sort','ending_soon')){
            case 'newest':
                $query->orderByDesc('created_at');
                break;
            case 'price_asc':
                $query->orderBy('current_bid');
                break;
            case 'price_desc':
                $query->orderByDesc('current_bid');
                break;
            case 'most_bids':
                $query->orderByDesc('bids_count');
                break;
            case 'ending_soon':
            default:
                $query->orderBy('ends_at');
                break;
        }
 
        $total    = $query->count();
        $auctions = $query->paginate(12)->withQueryString();
 
        return view('pages.auctions.index',compact('auctions','total'));
    }

    public function show($id){
        return view('pages.auctions.show');      
    }

    public static function timeRules():array{
       return[
            'starts_at' => [
                'required',
                'date',
                'after:' .now()->addMinutes(30)->format('Y-m-d H:i:s'),
            ],
            'ends_at' => [
                'required',
                'date',
                'different:starts_at',   
                'after:starts_at',      
                ],];
    }
}
