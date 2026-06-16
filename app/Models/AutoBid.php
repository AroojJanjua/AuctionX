<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AutoBid extends Model
{
    protected $fillable = ['auction_id', 'bidder_id', 'max_amount'];

    protected $casts = [
        'max_amount' => 'integer',
    ];

    public function bidder(){
        return $this->belongsTo(User::class, 'bidder_id');
    }
    public function auction(){
        return $this->belongsTo(Auction::class);
    }
}
