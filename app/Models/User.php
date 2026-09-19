<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use App\Notifications\VerifyEmailOtp;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable=[
        'name', 'email', 'phone', 'password', 'role', 'bio', 
        'address', 'city', 'country', 'is_banned', 'email_verified',
        'payout_method', 'payout_account_number', 'payout_account_name',
    ];

    protected $hidden=[
        'password','remember_token','email_verification_code',
    ];

   protected $casts = [
        'email_verified_at'             => 'datetime',
        'email_verification_expires_at' => 'datetime',
        'is_banned'                     => 'boolean',
        'email_verified'                => 'boolean',
        'password'                      => 'hashed',
    ];

    // Relationships
     public function auctions(){
        return $this->hasMany(Auction::class, 'seller_id');
    }
    public function bids(){
        return $this->hasMany(Bid::class, 'bidder_id');
    }
    public function notifications(){
        return $this->hasMany(Notification::class);
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
    public function hasPayoutDetails():bool{
        return !empty($this->payout_method) && !empty($this->payout_account_number);
    }

    public function sendEmailVerificationNotification(): void{
        $code=(string) random_int(1000, 9999);

        $this->forceFill([
            'email_verification_code' => Hash::make($code),
            'email_verification_expires_at' => now()->addMinutes(10),
        ])->save();
        $this->notify(new VerifyEmailOtp($code));
    }

    public function checkEmailVerificationCode(string $code): bool{
        if(! $this->email_verification_code || ! $this->email_verification_expires_at){
            return false;
        }
 
        if(now()->greaterThan($this->email_verification_expires_at)){
            return false;
        }
        return Hash::check($code, $this->email_verification_code);
    }
 
    public function markEmailAsVerified(): bool{
        $result=$this->forceFill([
            'email_verified_at' => $this->freshTimestamp(),
            'email_verified' => true,
            'email_verification_code' => null,
            'email_verification_expires_at' => null,
        ])->save();
 
        if($result){
            event(new \Illuminate\Auth\Events\Verified($this));
        }
        return $result;
    }
}
