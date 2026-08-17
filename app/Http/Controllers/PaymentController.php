<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Payment;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    //Buyer:checkout page
    public function checkout(Auction $auction){
        if(auth()->id() !== $auction->winner_id) 
            abort(403);

        if($auction->status !== 'closed'){
            return redirect()->route('auctions.show', $auction->id)->with('error','This auction is not closed yet.');
        }

        $fees=Payment::calculateFee((int) $auction->current_bid);
        $payment=Payment::firstOrCreate(
            ['auction_id' => $auction->id],
            [
                'buyer_id'      => auth()->id(),
                'seller_id'     => $auction->seller_id,
                'amount'        => $auction->current_bid,
                'platform_fee'  => $fees['fee'],
                'seller_amount' => $fees['sellerAmount'],
                'status'        => 'pending',
            ]
        );

        if(!$payment->isPending()){
            return redirect()->route('payment.status', $auction->id);
        }

        $jazzcash=config('services.jazzcash');
        $easypaisa=config('services.easypaisa');

        return view('pages.payment.checkout', compact('auction', 'payment', 'jazzcash', 'easypaisa'));
    }

    //Buyer:submit payment proof
    public function submit(Request $request, Auction $auction){
        if(auth()->id() !== $auction->winner_id) 
            abort(403);

        $request->validate([
            'payment_method' => 'required|in:jazzcash,easypaisa',
            'transaction_id' => 'required|string|max:100',
            'proof_image'    => 'required|image|mimes:jpg,jpeg,png|max:5120',
            'buyer_note'     => 'nullable|string|max:500',
        ]);

        $payment=$auction->payment;

       $payment->update([
            'payment_method' => $request->payment_method,
            'transaction_id' => $request->transaction_id,
            'proof_image'    => $request->file('proof_image')->store('payment-proofs','public'),
            'buyer_note'     => $request->buyer_note,
            'status'         => 'submitted',
            'submitted_at'   => now(),
        ]);

        $payment->load('buyer');
        $admin=User::where('role','admin')->first();
        if($admin){
            Notification::send(
                $admin->id,
                'payment_held',
                'Payment proof submitted',
                $payment->buyer->name . ' submitted ' . $payment->methodLabel() . ' proof for "' . $auction->title . '". Transaction ID: ' . $request->transaction_id,
                $auction->id
            );
        }

        return redirect()->route('payment.status', $auction->id)
            ->with('success','Payment proof submitted! Admin will confirm within 24 hours.');
    }

    //Buyer,Seller:payment status page
    public function status(Auction $auction){
        $payment=$auction->load(['payment.buyer','payment.seller'])->payment;
        $userId=auth()->id();
        if($userId !== $auction->winner_id && $userId !== $auction->seller_id && auth()->user()->role !== 'admin'){
            abort(403);
        }
        return view('pages.payment.status', compact('auction', 'payment'));
    }

    //Seller:ship form page
    public function shipForm(Payment $payment){
        if(auth()->id() !== $payment->seller_id) 
            abort(403);

        $payment->load('auction','buyer');
        return view('pages.payment.ship',compact('payment'));
    }

    //Seller:mark as shipped
    public function ship(Request $request, Payment $payment){
        if(auth()->id() !== $payment->seller_id) 
            abort(403);

        $request->validate([
            'courier_name'    => 'required|string|max:100',
            'tracking_number' => 'nullable|string|max:100',
            'seller_note'     => 'nullable|string|max:500',
        ]);

        $updated=Payment::where('id', $payment->id)
            ->where('status','held')
            ->update([
                'status'          => 'shipped',
                'courier_name'    => $request->courier_name,
                'tracking_number' => $request->tracking_number,
                'seller_note'     => $request->seller_note,
                'shipped_at'      => now(),
            ]);
 
        if(!$updated){
            return back()->with('error','This item has already been marked as shipped.');
        }
 
        $payment->refresh();

        Notification::send(
            $payment->buyer_id,
            'payment_held',
            'Your item has been shipped!',
            'The seller shipped your "' . $payment->auction->title . '" via ' . $request->courier_name .
                ($request->tracking_number ? '. Tracking: ' . $request->tracking_number : '') .
                '. Confirm receipt once it arrives.',
            $payment->auction_id
        );

        $admin=User::where('role','admin')->first();
        if($admin){
            Notification::send(
                $admin->id,
                'payment_held',
                'Item shipped',
                $payment->seller->name . ' marked "' . $payment->auction->title . '" as shipped via ' . $request->courier_name . '.',
                $payment->auction_id
            );
        }

        return back()->with('success', 'Item marked as shipped. Buyer has been notified.');
    }

    // ── Buyer: confirm receipt → auto-release ─────────────────

    public function confirmReceipt(Payment $payment)
    {
        if (auth()->id() !== $payment->buyer_id) abort(403);

        if (!$payment->isShipped()) {
            return back()->with('error', 'Cannot confirm receipt before seller marks item as shipped.');
        }

        $payment->update([
            'status'      => 'released',
            'received_at' => now(),
            'released_at' => now(),
            'admin_note'  => 'Auto-released after buyer confirmed receipt.',
        ]);

        Notification::send(
            $payment->seller_id,
            'payment_released',
            'Payment released to you! 🎉',
            'The buyer confirmed receipt of "' . $payment->auction->title . '". PKR ' . number_format($payment->seller_amount) . ' will be transferred to your account.',
            $payment->auction_id
        );

        $admin = User::where('role', 'admin')->first();
        if ($admin) {
            Notification::send(
                $admin->id,
                'payment_released',
                'Payment auto-released',
                'Buyer confirmed receipt of "' . $payment->auction->title . '". Transfer PKR ' . number_format($payment->seller_amount) . ' to ' . $payment->seller->name . '.',
                $payment->auction_id
            );
        }

        return redirect()->route('payment.status', $payment->auction_id)
            ->with('success', 'Receipt confirmed! Payment has been released to the seller.');
    }

    //Buyer/Seller:raise dispute
    public function dispute(Request $request,Payment $payment){
        $request->validate([
            'statement' => 'required|string|max:500',
            'evidence'  => 'nullable|image|max:5120',
        ]);
 
        $userId=auth()->id();
        $role=$payment->roleOf($userId);
        if(!$role) 
            abort(403);
 
        // if(!in_array($payment->status,['held', 'submitted', 'shipped', 'disputed'])) {
        //     return back()->with('error','This payment can no longer be disputed.');
        // }
 
        $evidencePath=$request->hasFile('evidence')?$request->file('evidence')->store('disputes', 'public'):null;
 
        // Each party writes only to their own dedicated slot — a buyer can never
        // end up in the seller_statement column or vice versa, by construction.
        $updates=$role==='buyer'?
            [
                'buyer_statement'          => $request->statement,
                'buyer_statement_evidence' => $evidencePath,
                'buyer_statement_at'       => now(),
            ]:[
                'seller_statement'          => $request->statement,
                'seller_statement_evidence' => $evidencePath,
                'seller_statement_at'       => now(),
            ];
 
        $isFirstStatement=!$payment->isDisputed();
        if($isFirstStatement){
            $updates['status']='disputed';
            $updates['dispute_raised_by']=$userId;
            $updates['dispute_raised_at']=now();
        }
 
        $payment->update($updates);
 
        $otherPartyId=$role ==='buyer'?$payment->seller_id:$payment->buyer_id;
        $admin=User::where('role', 'admin')->first();

        if($admin){
            Notification::send(
                $admin->id,
                'payment_disputed',
                $isFirstStatement?'Payment dispute raised':'Dispute statement updated',
                auth()->user()->name . '(' . $role . ') submitted a statement for "' . $payment->auction->title . '.',
                $payment->auction_id
            );
        }
 
        Notification::send(
            $otherPartyId,
            'payment_disputed',
            $isFirstStatement?'A dispute was raised on your order':'The other party updated their dispute statement',
            $isFirstStatement
                ? auth()->user()->name . ' raised a dispute for "' . $payment->auction->title . '". Please share your side before admin makes a decision.'
                : 'An updated statement was submitted for "' . $payment->auction->title . '".',
            $payment->auction_id
        );
 
        return back()->with('success', 'Your statement has been recorded and sent to admin.');
    }

    //Admin:all payments list
    public function index(){
        $payments=Payment::with(['auction','buyer','seller'])->latest()->paginate(20);
        $stats=[
            'total_held'     => Payment::where('status','held')->sum('amount'),
            'total_released' => Payment::where('status','released')->sum('seller_amount'),
            'total_refunded' => Payment::where('status','refunded')->sum('amount'),
            'total_fees'     => Payment::where('status','released')->sum('platform_fee'),
            'pending_review' => Payment::where('status','submitted')->count(),
            'dispute_count'  => Payment::where('status','disputed')->count(),
        ];

        return view('pages.admin.payments',compact('payments', 'stats'));
    }

    //Admin:confirm
    public function confirm(Request $request,Payment $payment){
        if(!$payment->isSubmitted()){
            return back()->with('error','Only submitted payments can be confirmed.');
        }

        $payment->update([
            'status'     => 'held',
            'admin_note' => $request->input('note'),
            'paid_at'    => now(),
        ]);

        Notification::send(
            $payment->buyer_id,
            'payment_held',
            'Payment confirmed, funds in escrow',
            'Your ' . $payment->methodLabel() . ' payment for "' . $payment->auction->title . '" has been confirmed and is held securely in escrow.',
            $payment->auction_id
        );

        Notification::send(
            $payment->seller_id,
            'payment_held',
            'Buyer payment confirmed, ship the item',
            'PKR ' . number_format($payment->seller_amount) . ' for "' . $payment->auction->title . '" is confirmed and held in escrow. Please ship the item to the buyer now.',
            $payment->auction_id
        );

        return back()->with('success','Payment confirmed and moved to escrow.');
    }

    //Admin:release to seller
    public function release(Request $request, Payment $payment){
        $releasable=['held', 'shipped', 'received', 'disputed'];

        if(!in_array($payment->status,$releasable)){
            return back()->with('error', 'Payment cannot be released in its current state.');
        }

        $payment->update([
            'status'      => 'released',
            'admin_note'  => $request->input('note'),
            'released_at' => now(),
        ]);

        Notification::send(
            $payment->seller_id,
            'payment_released',
            'Payment released to you!',
            'PKR ' . number_format($payment->seller_amount) . ' for "' . $payment->auction->title . '" has been released. Admin will transfer to your account.',
            $payment->auction_id
        );

        Notification::send(
            $payment->buyer_id,
            'payment_released',
            'Payment released to seller',
            'Your payment for "' . $payment->auction->title . '" has been released to the seller.',
            $payment->auction_id
        );

        return back()->with('success','PKR ' . number_format($payment->seller_amount) . ' released to seller.');
    }

    //Admin:refund to buyer
    public function refund(Request $request, Payment $payment){
        $request->validate(['note' => 'required|string|max:500']);

        $refundable=['submitted', 'held', 'shipped', 'received', 'disputed'];
        if(!in_array($payment->status, $refundable)){
            return back()->with('error','Payment cannot be refunded in its current state.');
        }

        $payment->update([
            'status'      => 'refunded',
            'admin_note'  => $request->input('note'),
            'refunded_at' => now(),
        ]);

        Notification::send(
            $payment->buyer_id,
            'payment_refunded',
            'Payment refunded',
            'Your payment of PKR ' . number_format($payment->amount) . ' for "' . $payment->auction->title . '" has been marked as refunded. Admin will transfer you back.',
            $payment->auction_id
        );

        Notification::send(
            $payment->seller_id,
            'payment_refunded',
            'Payment refunded to buyer',
            'The payment for "' . $payment->auction->title . '" was refunded to the buyer. Reason: ' . $request->input('note'),
            $payment->auction_id
        );

        return back()->with('success','Payment marked as refunded.');
    }
}