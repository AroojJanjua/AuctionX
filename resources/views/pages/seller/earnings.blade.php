@extends('layouts.app')
@section('title', 'My Earnings — AuctionX')
@section('content')

<div class="page-header">
  <div class="container">
    <h2>My Earnings</h2>
    <p>Track payments and escrow status for your auctions</p>
  </div>
</div>

<div class="container py-4">
  @unless(auth()->user()->hasPayoutDetails())
  <div style="background:#FFF8E1;border:1px solid #F0D48A;border-radius:12px;padding:1rem 1.25rem;margin-bottom:1.2rem;font-size:.85rem;color:#8A5A00;display:flex;align-items:center;justify-content:space-between">
    <div><i class="bi bi-exclamation-triangle-fill me-2"></i>Add your JazzCash/EasyPaisa details so admin knows where to send your earnings.</div>
    <a href="{{ route('profile.edit') }}" class="btn btn-sm" style="background:#8A5A00;color:#fff">Add Payout Details</a>
  </div>
  @endunless

  {{-- Stats --}}
  <div class="row g-3 mb-4">
    <div class="col-sm-4">
      <div style="background:#fff;border:1px solid var(--border);border-radius:14px;padding:1.1rem">
        <div style="font-size:.78rem;color:var(--muted);margin-bottom:3px">Total Earned</div>
        <div style="font-size:1.5rem;font-weight:800;color:var(--green)">PKR {{ number_format($stats['total_earned']) }}</div>
        <div style="font-size:.72rem;color:var(--muted)">after 5% platform fee</div>
      </div>
    </div>
    <div class="col-sm-4">
      <div style="background:#fff;border:1px solid var(--border);border-radius:14px;padding:1.1rem">
        <div style="font-size:.78rem;color:var(--muted);margin-bottom:3px">Held in Escrow</div>
        <div style="font-size:1.5rem;font-weight:800;color:#0C447C">PKR {{ number_format($stats['held']) }}</div>
        <div style="font-size:.72rem;color:var(--muted)">pending release</div>
      </div>
    </div>
    <div class="col-sm-4">
      <div style="background:#fff;border:1px solid var(--border);border-radius:14px;padding:1.1rem">
        <div style="font-size:.78rem;color:var(--muted);margin-bottom:3px">Refunded Orders</div>
        <div style="font-size:1.5rem;font-weight:800;color:var(--red)">{{ $stats['refunded'] }}</div>
      </div>
    </div>
  </div>

  {{-- Payments table --}}
  <div style="background:#fff;border:1px solid var(--border);border-radius:16px;overflow:hidden">
    <div class="px-4 py-3" style="border-bottom:1px solid var(--border);font-weight:700">Payment History</div>

    @if($payments->isEmpty())
      <div class="text-center py-5" style="color:var(--muted)">
        <i class="bi bi-cash-coin" style="font-size:2rem;display:block;margin-bottom:.5rem"></i>
        No payments yet. They appear here once your auction closes and the buyer pays.
      </div>
    @else
    <div class="table-responsive">
      <table class="table mb-0" style="font-size:.85rem">
        <thead>
          <tr style="border-bottom:1px solid var(--border);background:var(--surface-1)">
            <th style="padding:10px 16px;font-weight:600">Auction</th>
            <th style="padding:10px 16px;font-weight:600">Buyer</th>
            <th style="padding:10px 16px;font-weight:600">You Receive</th>
            <th style="padding:10px 16px;font-weight:600">Status</th>
            <th style="padding:10px 16px;font-weight:600">Date</th>
            <th style="padding:10px 16px;font-weight:600">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($payments as $payment)
          @php
            $badges=[
              'pending'   => ['class'=>'badge-drafted','label'=>'Pending'],
              'submitted' => ['class'=>'badge-drafted','label'=>'Proof Submitted'],
              'held'      => ['class'=>'badge-drafted','label'=>'In Escrow'],
              'shipped'   => ['class'=>'badge-timed',  'label'=>'Shipped'],
              'received'  => ['class'=>'badge-timed',  'label'=>'Received'],
              'released'  => ['class'=>'badge-timed',  'label'=>'Released'],
              'refunded'  => ['class'=>'badge-closed', 'label'=>'Refunded'],
              'disputed'  => ['class'=>'badge-closed', 'label'=>'Disputed'],
            ];
            $b = $badges[$payment->status] ?? $badges['pending'];
          @endphp
          <tr style="border-bottom:1px solid var(--border)">
            <td style="padding:12px 16px;vertical-align:middle">
              <div style="font-weight:700">{{ Str::limit($payment->auction->title, 32) }}</div>
              <div style="font-size:.75rem;color:var(--muted)">PKR {{ number_format($payment->amount) }}</div>
            </td>
            <td style="padding:12px 16px;vertical-align:middle">{{ $payment->buyer->name }}</td>
            <td style="padding:12px 16px;vertical-align:middle;font-weight:800;color:var(--text)">
              PKR {{ number_format($payment->seller_amount) }}
            </td>
            <td style="padding:12px 16px;vertical-align:middle">
              <span class="badge rounded-pill {{ $b['class'] }}">{{ $b['label'] }}</span>
            </td>
            <td style="padding:12px 16px;vertical-align:middle;font-size:.8rem;color:var(--muted)">
              {{ ($payment->submitted_at ?? $payment->created_at)->format('M d, Y') }}
            </td>
            <td style="padding:12px 16px;vertical-align:middle">
              <div class="d-flex gap-2 align-items-center">
                <a href="{{ route('payment.status', $payment->auction_id) }}"
                   class="btn btn-ghost-ax btn-sm" title="View">
                  <i class="bi bi-eye"></i>
                </a>
                @if($payment->isHeld())
                  <a href="{{ route('payment.ship.form', $payment->id) }}"
                     class="btn btn-sm btn-green" style="font-size:.75rem;padding:5px 7px">Ship Now</a>
                @endif
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    @if($payments->hasPages())
    <div class="p-3 d-flex justify-content-center">
      {{ $payments->links('vendor.pagination.bootstrap-5') }}
    </div>
    @endif
    @endif
  </div>

</div>
@endsection