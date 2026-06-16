<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
     use HasFactory;
 
    protected $fillable = [
        'auction_id',
        'bidder_id',
        'amount',
        'is_auto_bid',
    ];
 
    protected $casts = [
        'amount'       => 'integer',
        'max_auto_bid' => 'integer',
        'is_auto_bid'  => 'boolean',
    ];

    // Relationships
    public function auction(){
        return $this->belongsTo(Auction::class);
    }
 
    public function bidder(){
        return $this->belongsTo(User::class, 'bidder_id');
    }

   
}
