@extends('layouts.app')
@section('title', 'My Bids')
@section('content')
 
<div class="page-header">
  <div class="container">
    <h2>My Bids</h2>
    <p>All bids you have placed on AuctionX</p>
  </div>
</div>

<div class="container py-4">
  @if($bids->isEmpty())
    <div class="text-center py-5">
      <i class="bi bi-hammer" style="font-size:3.5rem;color:var(--muted)"></i>
      <div class="mt-3 fw-bold" style="font-size:1.1rem">No bids yet</div>
      <p style="color:var(--muted);font-size:.9rem">Start bidding on auctions to see your history here.</p>
      <a href="{{ route('auctions.index') }}" class="btn btn-brown">Browse Auctions</a>
    </div>
  @else
  <div style="background:#fff;border:1px solid var(--border);border-radius:16px;overflow:hidden">
    <table class="table mb-0" style="font-size:.88rem">
        <thead style="background:var(--surface)">
          <tr>
            <th style="font-weight:700;color:var(--muted);border:none;padding:12px 16px">Auction</th>
            <th style="font-weight:700;color:var(--muted);border:none;padding:12px 16px">Your Bid</th>
            <th style="font-weight:700;color:var(--muted);border:none;padding:12px 16px">Current Bid</th>
            <th style="font-weight:700;color:var(--muted);border:none;padding:12px 16px">Status</th>
            <th style="font-weight:700;color:var(--muted);border:none;padding:12px 16px">Placed</th>
            <th style="font-weight:700;color:var(--muted);border:none;padding:12px 16px">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($bids as $bid)
          <tr style="border-bottom:1px solid var(--border)">
            <td style="padding:12px 16px;vertical-align:middle">
              <div style="font-weight:700;color:var(--text)">{{ Str::limit($bid->auction->title,40) }}</div>
              <div style="font-size:.75rem;color:var(--muted)">{{ ucfirst($bid->auction->category) }}</div>
            </td>
            <td style="padding:12px 16px;vertical-align:middle;font-weight:800;color:var(--br)">
              PKR {{ number_format($bid->amount) }}</td>
            <td style="padding:12px 16px;vertical-align:middle;font-weight:700">
              PKR {{ number_format($bid->auction->current_bid) }}</td>
            <td style="padding:12px 16px;vertical-align:middle">
              @if($bid->auction->status === 'closed' && $bid->auction->winner_id === auth()->id())
                <span class="badge rounded-pill badge-buynow"><i class="bi bi-trophy me-1"></i>Won</span>
              @elseif($bid->amount == $bid->auction->current_bid && $bid->auction->status === 'active')
                <span class="badge rounded-pill badge-timed"><i class="bi bi-arrow-up me-1"></i>Leading</span>
              @elseif($bid->auction->status === 'closed')
                <span class="badge rounded-pill badge-closed2">Ended</span>
              @else
                <span class="badge rounded-pill" style="background:var(--red-bg);color:var(--red)"><i class="bi bi-arrow-down me-1"></i>Outbid</span>
              @endif
            </td>
            <td style="padding:12px 16px;vertical-align:middle;color:var(--muted);font-size:.8rem">
              {{ $bid->created_at->format('M d, Y') }}<br>
              {{ $bid->created_at->format('h:i A') }}
            </td>
            <td style="padding:12px 16px;vertical-align:middle">
              <a href="{{ route('auctions.show', $bid->auction->id) }}"
                 class="btn btn-ghost-ax btn-sm">
                <i class="bi bi-eye me-1"></i>View
              </a>
            </td>
          </tr>
          @endforeach
        </tbody>
    </table>
  </div>
  @endif   
</div>
@endsection