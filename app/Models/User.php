<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable=[
        'name', 'email', 'phone', 'password',
        'role', 'avatar', 'bio', 'address',
        'city', 'country', 'is_banned', 'email_verified',
    ];

    protected $hidden=[
        'password','remember_token',
    ];

   protected $casts = [
        'email_verified_at' => 'datetime',
        'is_banned'         => 'boolean',
        'email_verified'    => 'boolean',
        'password'          => 'hashed',
    ];

    // Relationships
     public function auctions(){
        return $this->hasMany(Auction::class, 'seller_id');
    }
 
    // Helpers
    public function isAdmin():bool{
        return $this->role === 'admin';
    }
    public function isSeller():bool{
        return $this->role === 'seller';
    }
    public function isBidder():bool{
        return $this->role === 'bidder';
    }
}
