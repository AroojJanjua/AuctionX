<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Payment extends Model
{
    protected $fillable=[
        'auction_id', 'buyer_id', 'seller_id',
        'amount', 'platform_fee', 'seller_amount',
        'payment_method', 'transaction_id', 'proof_image',
        'status', 'courier_name', 'tracking_number',
        'buyer_note', 'seller_note', 'admin_note',
        'dispute_raised_by', 'dispute_raised_at',
        'buyer_statement', 'buyer_statement_evidence', 'buyer_statement_at',
        'seller_statement', 'seller_statement_evidence', 'seller_statement_at',
        'submitted_at', 'paid_at', 'shipped_at',
        'received_at', 'released_at', 'refunded_at',
    ];
 
    protected $casts=[
        'amount'        => 'decimal:2',
        'platform_fee'  => 'decimal:2',
        'seller_amount' => 'decimal:2',
        'submitted_at'  => 'datetime',
        'paid_at'       => 'datetime',
        'shipped_at'    => 'datetime',
        'received_at'   => 'datetime',
        'released_at'   => 'datetime',
        'refunded_at'   => 'datetime',
        'dispute_raised_at'   => 'datetime',
        'buyer_statement_at'  => 'datetime',
        'seller_statement_at' => 'datetime',
    ];
 
    //Relationships
    public function auction(){ 
        return $this->belongsTo(Auction::class); 
    }
    public function buyer(){ 
        return $this->belongsTo(User::class, 'buyer_id'); 
    }
    public function disputeRaisedBy(){ 
        return $this->belongsTo(User::class, 'dispute_raised_by'); 
    }
    public function seller(){ 
        return $this->belongsTo(User::class, 'seller_id'); 
    }
 
    //Status helpers
    public function isPending():bool{ 
        return $this->status === 'pending';
    }
    public function isSubmitted():bool{ 
        return $this->status === 'submitted'; 
    }
    public function isHeld():bool{ 
        return $this->status === 'held'; 
    }
    public function isShipped():bool{ 
        return $this->status === 'shipped'; 
    }
    public function isReceived():bool{ 
        return $this->status === 'received'; 
    }
    public function isReleased():bool{ 
        return $this->status === 'released'; 
    }
    public function isRefunded():bool{ 
        return $this->status === 'refunded'; 
    }
    public function isDisputed():bool{ 
        return $this->status === 'disputed'; 
    }
 
    public function roleOf(int $userId):?string{
        if($userId === $this->buyer_id)  
            return 'buyer';
        if($userId === $this->seller_id) 
            return 'seller';
        return null;
    }

    //Payment method label
    public function methodLabel(): string{
        return match($this->payment_method){
            'jazzcash'  => 'JazzCash',
            'easypaisa' => 'EasyPaisa',
            default     => ucfirst($this->payment_method ?? ''),
        };
    }

    //Calculate 5% platform fee
    public static function calculateFee(int $amount): array{
        $fee=round($amount * 0.05, 2);
        $sellerAmount=round($amount - $fee, 2);
        return compact('fee','sellerAmount');
    }
}