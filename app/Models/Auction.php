<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    use HasFactory;
 
    protected $fillable=[
        'seller_id', 'winner_id', 'title', 'description','category', 
        'condition', 'image', 'starting_bid', 'current_bid','starts_at',
        'ends_at', 'snipe_extension_count', 'status',
    ];
 
    protected $casts = [
        'starts_at'              => 'datetime',
        'ends_at'                => 'datetime',
        'starting_bid'           => 'decimal:2',
        'current_bid'            => 'decimal:2',
        'snipe_extension_count'  => 'integer',
    ];

    // Relationships 
    public function seller(){
        return $this->belongsTo(User::class, 'seller_id');
    }
 
    public function winner(){
        return $this->belongsTo(User::class, 'winner_id');
    }

    // Accessors
    public function getMinNextBidAttribute():float{
        $increment=max(10, $this->current_bid * 0.01);
        return round($this->current_bid + $increment, 2);
    }

    public function getTimeRemainingAttribute():string{
        if ($this->status === 'closed' || $this->status === 'cancelled') {
            return 'Ended';
        }
        if ($this->ends_at->isPast()) {
            return 'Ended';
        }

        $diff = now()->diff($this->ends_at);
        if ($diff->days >= 1) return $diff->days . 'd ' . $diff->h . 'h left';
        if ($diff->h > 0)     return $diff->h . 'h ' . $diff->i . 'm left';
        if ($diff->i > 0)     return $diff->i . 'm ' . $diff->s . 's left';
        return $diff->s . 's left';
    }

        public function getEndsSoonAttribute():bool{
        if ($this->status !== 'active') return false;
        if ($this->ends_at->isPast()) return false; 
        return now()->diffInMinutes($this->ends_at, false) <= 60;
    }

    public function getNotStartedAttribute():bool{
        return $this->starts_at->isFuture();
    }

    public function getCategoryLabelAttribute():string{
        return match ($this->category){
            'art'          => 'Art',
            'watches'      => 'Watches',
            'vehicles'     => 'Vehicles',
            'jewelry'      => 'Jewelry',
            'collectibles' => 'Collectibles',
            'electronics'  => 'Electronics',
            default        => 'Other',
        };
    }

    public function getConditionLabelAttribute():string{
        return match ($this->condition){
            'new'       => 'Brand New',
            'like_new'  => 'Like New',
            'excellent' => 'Excellent',
            'good'      => 'Good',
            'fair'      => 'Fair',
            default     => 'Unknown',
        };
    }

    public function getDurationAttribute():string{
        $hours = $this->starts_at->diffInHours($this->ends_at);
        if ($hours >= 24){
            $days = round($hours /24, 1);
            return $days.' '.($days == 1?'day':'days');
        }
        return $hours.' '.($hours == 1?'hour':'hours');
    }

    // AI bid suggestion based on past bids, competition, and time pressure 

    
}
