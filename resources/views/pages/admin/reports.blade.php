@extends('layouts.app')
@section('title', 'Reports')
@section('content')
 
<div class="page-header">
  <div class="container">
    <h2>Platform Reports</h2>
    <p>Sales, users and auction analytics</p>
  </div>
</div>

<div class="container py-4">
  <div class="row g-4">
  
    {{-- Top Sellers --}}
    <div class="col-lg-6">
      <div style="background:#fff;border:1px solid var(--border);border-radius:16px;overflow:hidden">
        <div class="p-3" style="border-bottom:1px solid var(--border)">
          <div class="section-title" style="font-size:1rem">Top Sellers by Revenue</div>
        </div>
        @forelse($topSellers as $i => $seller)
        <div class="d-flex align-items-center gap-2 p-3" style="border-bottom:1px solid var(--border)">
          <div style="width:28px;height:28px;border-radius:50%;background:var(--br-pale);display:flex;align-items:center;justify-content:center;font-size:.75rem;font-weight:800;color:var(--br);flex-shrink:0">
            {{ $i + 1 }}
          </div>
          <div class="flex-grow-1">
            <div style="font-weight:700;font-size:.88rem">{{ $seller->name }}</div>
            <div style="font-size:.75rem;color:var(--muted)">{{ $seller->auctions_count }} listings</div>
          </div>
          <div style="font-weight:800;color:var(--br)">${{ number_format($seller->total_revenue ?? 0) }}</div>
        </div>
        @empty
        <div class="text-center py-4" style="color:var(--muted);font-size:.88rem">No data available.</div>
        @endforelse
      </div>
    </div>
 
    {{-- Top Bidders --}}
    <div class="col-lg-6">
      <div style="background:#fff;border:1px solid var(--border);border-radius:16px;overflow:hidden">
        <div class="p-3" style="border-bottom:1px solid var(--border)">
          <div class="section-title" style="font-size:1rem">Top Bidders by Activity</div>
        </div>
        @forelse($topBidders as $i => $bidder)
        <div class="d-flex align-items-center gap-2 p-3" style="border-bottom:1px solid var(--border)">
          <div style="width:28px;height:28px;border-radius:50%;background:#EAF0FA;display:flex;align-items:center;justify-content:center;font-size:.75rem;font-weight:800;color:#1A4A8A;flex-shrink:0">
            {{ $i + 1 }}
          </div>
          <div class="flex-grow-1">
            <div style="font-weight:700;font-size:.88rem">{{ $bidder->name }}</div>
            <div style="font-size:.75rem;color:var(--muted)">{{ $bidder->email }}</div>
          </div>
          <div style="font-weight:800;color:#1A4A8A">{{ $bidder->bids_count }} bids</div>
        </div>
        @empty
        <div class="text-center py-4" style="color:var(--muted);font-size:.88rem">No data available.</div>
        @endforelse
      </div>
    </div>

    {{-- Category Stats --}}
    <div class="col-12">
      <div style="background:#fff;border:1px solid var(--border);border-radius:16px;overflow:hidden">
        <div class="p-3" style="border-bottom:1px solid var(--border)">
          <div class="section-title" style="font-size:1rem">Auctions by Category</div>
        </div>
        <div class="table-responsive">
          <table class="table mb-0" style="font-size:.88rem">
            <thead style="background:var(--surface)">
              <tr>
                <th style="font-weight:700;color:var(--muted);border:none;padding:10px 16px">Category</th>
                <th style="font-weight:700;color:var(--muted);border:none;padding:10px 16px">Total Auctions</th>
                <th style="font-weight:700;color:var(--muted);border:none;padding:10px 16px">Average Bid</th>
                <th style="font-weight:700;color:var(--muted);border:none;padding:10px 16px">Share</th>
              </tr>
            </thead>
            <tbody>
              @php $grandTotal=$categoryStats->sum('total'); @endphp
              @forelse($categoryStats as $cat)
              <tr style="border-bottom:1px solid var(--border)">
                <td style="padding:10px 16px;vertical-align:middle;font-weight:700">{{ ucfirst($cat->category) }}</td>
                <td style="padding:10px 16px;vertical-align:middle;color:var(--muted)">{{ $cat->total }}</td>
                <td style="padding:10px 16px;vertical-align:middle;font-weight:700;color:var(--br)">PKR {{ number_format($cat->avg_bid, 0) }}</td>
                <td style="padding:10px 16px;vertical-align:middle">
                  @php $percentage = $grandTotal > 0 ? round(($cat->total / $grandTotal) * 100) : 0; @endphp
                  <div class="d-flex align-items-center gap-2">
                    <div style="flex:1;height:8px;background:var(--surface);border-radius:4px;overflow:hidden">
                      <div style="width:{{ $percentage }}%;height:100%;background:var(--br);border-radius:4px"></div>
                    </div>
                    <span style="font-size:.78rem;color:var(--muted);min-width:32px">{{ $percentage }}%</span>
                  </div>
                </td>
              </tr>
              @empty
              <tr><td colspan="4" class="text-center py-4" style="color:var(--muted)">No data yet</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

    </div>
</div>
@endsection