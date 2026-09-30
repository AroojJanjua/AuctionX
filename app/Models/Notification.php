<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Notification extends Model
{
    use HasFactory;
 
    protected $keyType = 'string';
    public $incrementing = false;
 
    protected $fillable = [
        'id', 'user_id', 'auction_id',
        'type', 'title', 'message', 'read_at',
    ];
 
    protected $casts = [
        'read_at' => 'datetime',
    ];
 
    //Helpers
    public function isUnread():bool{
        return is_null($this->read_at);
    }
 
    public function markAsRead():void{
        $this->update(['read_at' => now()]);
    }

    public static function send(
        int    $userId,
        string $type,
        string $title,
        string $message,
        ?int   $auctionId = null
    ): self {
        $notification = self::create([
            'id'         => (string) Str::uuid(),
            'user_id'    => $userId,
            'auction_id' => $auctionId,
            'type'       => $type,
            'title'      => $title,
            'message'    => $message,
        ]);
 
        // Broadcast to the user private channel so their bell updates immediately
        broadcast(new \App\Events\NotificationSent($notification));
        return $notification;
    }
}
