<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class SellerController extends Controller
{
    public function dashboard(){
        $listings=Auction::where('seller_id', auth()->id())
            ->orderByDesc('created_at')
            ->paginate(10);       
        $stats=[
            'active' => Auction::where('seller_id', auth()->id())->where('status', 'active')->count(),
            'sold'   => Auction::where('seller_id', auth()->id())->where('status', 'closed')->count(),
            'earned' => Auction::where('seller_id', auth()->id())->where('status', 'closed')->sum('current_bid'),
        ];
        return view('pages.seller.dashboard', compact('listings', 'stats'));
    }
    public function create(){
        return view('pages.seller.create');
    }

    // Store a new auction listing
    public function store(Request $request){
        $rules = [
        'title'        => 'required|string|max:255',
        'description'  => 'required|string|max:5000',
        'category'     => 'required|in:art,watches,vehicles,jewelry,collectibles,electronics,other',
        'condition'    => 'required|in:new,like_new,excellent,good,fair',
        'starting_bid' => 'required|numeric|min:1',
        'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        'starts_at' => [
            'required',
            'date',
            'after:' . now()->addMinutes(30)->format('Y-m-d H:i:s'),
        ],
        'ends_at' => [
            'required',
            'date',
            'different:starts_at',   // cannot be same as starts_at
            'after:starts_at',       // must be after starts_at 
        ],
    ];

    $validated = $request->validate($rules,[
        'starts_at.required' => 'Please select a start date and time.',
        'starts_at.after'    => 'Auction must start at least 30 minutes from now.',
        'ends_at.required'   => 'Please select an end date and time.',
        'ends_at.different'  => 'Start time and end time cannot be the same.',
        'ends_at.after'      => 'End time must be after start time.',
        'starting_bid.min'   => 'Starting bid must be at least PKR 1.',
    ]);

    $start = \Carbon\Carbon::parse($validated['starts_at']);
    $end   = \Carbon\Carbon::parse($validated['ends_at']);

    if ($end->isAfter($start) && $start->diffInMinutes($end) < 60){
            return back()->withInput()
                ->withErrors(['ends_at' => 'Auction must run for at least 1 hour.']);
        }
        if ($start->diffInDays($end) > 30){
            return back()->withInput()
                ->withErrors(['ends_at' => 'Auction cannot run for more than 30 days.']);
        }
 
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('auctions', 'public');
        }
        Auction::create([
            'seller_id'    => auth()->id(),
            'title'        => $validated['title'],
            'description'  => $validated['description'],
            'category'     => $validated['category'],
            'condition'    => $validated['condition'],
            'starts_at'    => $validated['starts_at'],
            'ends_at'      => $validated['ends_at'],
            'starting_bid' => $validated['starting_bid'],
            'current_bid'  => $validated['starting_bid'],
            'image'        => $imagePath,
            'status'       => 'active', // always draft bcoz needs admin approval
        ]);
        return redirect()->route('seller.dashboard')
            ->with('success', 'Auction submitted for review. Admin will approve it shortly.');
    }
}
