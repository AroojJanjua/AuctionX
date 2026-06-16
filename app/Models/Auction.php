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
        'starting_bid'           => 'integer',
        'current_bid'            => 'integer',
        'snipe_extension_count'  => 'integer',
    ];

    // Relationships 
    public function seller(){
        return $this->belongsTo(User::class, 'seller_id');
    }
 
    public function winner(){
        return $this->belongsTo(User::class, 'winner_id');
    }

    public function bids(){
        return $this->hasMany(Bid::class);
    }
    public function autoBids(){
        return $this->hasMany(AutoBid::class);
    }

    // Accessors
    public function getMinNextBidAttribute():int{
        $increment=max(10, $this->current_bid * 0.01);
        return (int) round($this->current_bid + $increment);
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
        $hours=$this->starts_at->diffInHours($this->ends_at);
        if($hours >= 24){
            $days = round($hours /24, 1);
            return $days.' '.($days == 1?'day':'days');
        }
        return $hours.' '.($hours == 1?'hour':'hours');
    }

    // AI bid suggestion based on past bids, competition, and time pressure 
    public function getAiBidSuggestionAttribute():array{
        $bids = $this->bids()->orderBy('amount')->pluck('amount')->toArray();

        // 1: Average increment from past bids
        $avgIncrement=10;
        if(count($bids) >= 2){
            $increments=[];
            for ($i = 1; $i < count($bids); $i++) {
                $increments[] = $bids[$i] - $bids[$i - 1];
            }
            $avgIncrement = array_sum($increments) / count($increments);
        }

         // 2: Competition multiplier
        $bidderCount=$this->bids()->distinct('bidder_id')->count('bidder_id');
        $multiplier =match(true){
            $bidderCount >= 10 => 2.5,
            $bidderCount >= 5  => 1.8,
            $bidderCount >= 2  => 1.3,
            default            => 1.0,
        };

        // 3: Time pressure bonus
        $hoursLeft=now()->diffInHours($this->ends_at, false);
        $bonus     = match(true){
            $hoursLeft <= 1  => $avgIncrement * 2.0,
            $hoursLeft <= 6  => $avgIncrement * 1.5,
            $hoursLeft <= 24 => $avgIncrement * 1.2,
            default          => 0,
        };

        $suggested =round($this->current_bid + ($avgIncrement * $multiplier) + $bonus);
        $confidence=match(true){
            count($bids) >= 10 => 'High',
            count($bids) >= 5  => 'Medium',
            default            => 'Low',
        };
 
        return [
            'amount'        => $suggested,
            'confidence'    => $confidence,
            'bids_analyzed' => count($bids),
        ];
    }
    
}
