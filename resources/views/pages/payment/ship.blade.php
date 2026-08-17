@extends('layouts.app')
@section('title', 'Ship Item')
@section('content')

<div class="page-header">
  <div class="container">
    <h2>Ship Item</h2>
    <p>{{ $payment->auction->title }}</p>
  </div>
</div>

<div class="container py-4" style="max-width:640px">
  {{-- Note --}}
  <div style="background:#E6F1FB;border:1px solid #B3D1F5;border-radius:12px;padding:1rem;margin-bottom:1.5rem;font-size:.85rem;color:#0C447C">
    <i class="bi bi-shield-lock-fill me-2"></i>
    Payment is confirmed and held in escrow. Ship the item to the buyer, then enter the delivery details below.
  </div>


  {{-- Order --}}
  <div style="background:#fff;border:1px solid var(--border);border-radius:16px;padding:1.5rem;margin-bottom:1.5rem">
    <div style="font-weight:700;margin-bottom:1rem">Details</div>
    <div class="d-flex justify-content-between mb-2" style="font-size:.9rem">
      <span style="color:var(--muted)">Buyer</span>
      <span style="font-weight:500">{{ $payment->buyer->name }}</span>
    </div>
    <div class="d-flex justify-content-between mb-2" style="font-size:.9rem">
      <span style="color:var(--muted)">You'll receive</span>
      <span style="font-weight:700;color:var(--text)">PKR {{ number_format($payment->seller_amount) }}</span>
    </div>
    <div class="d-flex justify-content-between" style="font-size:.9rem">
      <span style="color:var(--muted)">Payment confirmed</span>
      <span>{{ $payment->paid_at?->format('M d, Y') }}</span>
    </div>
  </div>

  {{-- Ship form --}}
  <div style="background:#fff;border:1px solid var(--border);border-radius:16px;padding:1.5rem">
    <div style="font-weight:700;margin-bottom:.2rem">Delivery Details</div>
    <div style="font-size:.82rem;color:var(--muted);margin-bottom:1.2rem">
      The buyer will be notified as soon as you submit this
    </div>

    <form method="POST" action="{{ route('payment.ship', $payment->id) }}">
      @csrf
      <div class="mb-3">
        <label class="form-label-ax" for="courier_name">Courier / Shipping Service</label>
        <input type="text" id="courier_name" name="courier_name"
          class="form-control-ax @error('courier_name') is-invalid @enderror"
          placeholder="enter service name like Leopards"
          value="{{ old('courier_name') }}" required autofocus>
        @error('courier_name')
          <div style="font-size:.78rem;color:var(--red);margin-top:4px">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label class="form-label-ax" for="tracking_number">Tracking Number</label>
        <input type="text" id="tracking_number" name="tracking_number"
          class="form-control-ax" placeholder="e.g. TCS1234567"
          value="{{ old('tracking_number') }}">
      </div>

      <div class="mb-4">
        <label class="form-label-ax" for="seller_note">Note to Buyer (optional)</label>
        <textarea id="seller_note" name="seller_note" class="form-control-ax"
          rows="2" style="resize:none"
          placeholder="Any note for buyer…">{{ old('seller_note') }}</textarea>
      </div>

      <div class="d-flex gap-2">
        <button type="submit" class="btn btn-brown w-50">Mark as Shipped
        </button>
        <a href="{{ route('payment.status', $payment->auction_id) }}" class="btn btn-ghost-ax w-50">Cancel</a>
      </div>
    </form>
  </div>

</div>
@endsection