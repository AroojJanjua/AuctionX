@extends('layouts.app')
@section('title','Admin Dashboard')
@section('content')

<div class="page-header">
  <div class="container">
    <h2>Admin Dashboard</h2>
    <p>Overview — {{ now()->format('l, M d Y') }}</p>
  </div>
</div>

<div class="container py-4">

{{-- Stats --}}
<div class="row g-3 mb-4">
    @foreach([
      ['Total Revenue',   'Rs. '.number_format($stats['total_revenue']), 'var(--br-pale)','var(--br)'],
      ['All Auctions',    $stats['total_auctions'],     'var(--br-pale)','var(--br)'],
      ['Total Bids',      $stats['total_bids'],         'var(--br-pale)','var(--br)'],
      ['Active Auctions', $stats['active'],             'var(--green-bg)','var(--green)'],
      ['Total Users',     $stats['total_users'],       '#EAF0FA','#1A4A8A'],
      ['Sellers',         $stats['sellers'],            '#EAF0FA','#1A4A8A'],
      ['Bidders',         $stats['bidders'],            '#EAF0FA','#1A4A8A'],
      ['Closed Auctions', $stats['closed'],             'var(--red-bg)','var(--red)'],
      
    ] as [$label,$val,$bg,$color])
    <div class="col-sm-6 col-lg-3">
      <div style="background:#fff;border:1px solid var(--border);border-radius:14px;padding:1.1rem">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <div style="font-size:.78rem;color:var(--muted);margin-bottom:3px">{{ $label }}</div>
            <div style="font-size:1.5rem;font-weight:800;color:{{ $color }}">{{ $val }}</div>
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>

  <div class="row g-4 justify-content-center">

  {{-- Recent auctions --}}
  <div class="col-lg-6">
      <div style="background:#fff;border:1px solid var(--border);border-radius:16px;overflow:hidden">
      <div class="d-flex justify-content-between align-items-center p-3" style="border-bottom:1px solid var(--border)">
          <div class="section-title" style="font-size:1rem">Recent Auctions</div>
          <a href="{{ route('admin.auctions.index') }}" class="see-all-btn">View all</a>
        </div>

        <table class="table mb-0" style="font-size:.85rem">
          <tbody>
            @foreach($recent_auctions as $auction)
            <tr style="border-bottom:1px solid var(--border)">
             <td style="padding:16px 16px;vertical-align:middle">
                <div style="font-weight:700">{{ Str::limit($auction->title,35) }}</div>
                <div style="font-size:.75rem;color:var(--muted)">{{ ucfirst($auction->category) }} · {{ $auction->bids_count }} bids</div>
              </td>
              <td style="padding:10px 16px;vertical-align:middle;font-weight:800;color:var(--br)">PKR {{ number_format($auction->current_bid) }}</td>
              <td style="padding:10px 0;vertical-align:middle">
                @if($auction->status === 'active')
                  <span class="badge rounded-pill badge-timed">Active</span>
                @elseif($auction->status === 'closed')
                  <span class="badge rounded-pill badge-closed">Closed</span>
                @elseif($auction->status === 'draft')
                  <span class="badge rounded-pill badge-drafted">Draft</span>
                @else
                  <span class="badge rounded-pill badge-drafted">{{ ucfirst($auction->status) }}</span>
                @endif
              </td>
            </tr>
             @endforeach
          </tbody>
        </table>

      </div>
    </div>

  {{-- Recent users --}}
  <div class="col-lg-6">
      <div style="background:#fff;border:1px solid var(--border);border-radius:16px;overflow:hidden">
      <div class="d-flex justify-content-between align-items-center p-3" style="border-bottom:1px solid var(--border)">
          <div class="section-title" style="font-size:1rem">Recent Users</div>
          <a href="{{ route('admin.users.index') }}" class="see-all-btn">View all</a>
        </div>

        @foreach($recent_users as $user)
        <div class="d-flex align-items-center gap-2 p-3" style="border-bottom:1px solid var(--border)">
          <div style="width:36px;height:36px;border-radius:50%;background:var(--br-pale);display:flex;align-items:center;justify-content:center;font-size:.75rem;font-weight:800;color:var(--br);flex-shrink:0">
            {{ strtoupper(substr($user->name, 0, 2)) }}
          </div>
          <div class="flex-grow-1">
            <div style="font-weight:700;font-size:.88rem">{{ $user->name }}</div>
            <div style="font-size:.75rem;color:var(--muted)">{{ $user->email }}</div>
          </div>
          <span class="badge rounded-pill {{ $user->role === 'admin' ? 'badge-admin' : ($user->role === 'seller' ? 'badge-seller' : 'badge-bidder') }}">
            {{ ucfirst($user->role) }}
          </span>
        </div>
         @endforeach
      </div>
    </div>

    {{-- Recent Bids --}}
    <div class="col-lg-10">
      <div style="background:#fff;border:1px solid var(--border);border-radius:16px;overflow:hidden">
        <div class="d-flex justify-content-between align-items-center p-3" style="border-bottom:1px solid var(--border)">
          <div class="section-title" style="font-size:1rem"><i class="bi bi-hammer me-1"></i>Recent Bids</div>
          <a href="{{ route('admin.bids.index') }}" class="see-all-btn">View all</a>
        </div>
        <table class="table mb-0" style="font-size:.85rem">
          <tbody>
            @foreach($recent_bids as $bid)
            <tr style="border-bottom:1px solid var(--border)">
              <td style="vertical-align:middle">
                <div class="d-flex align-items-center gap-2 p-2" >
          <div style="width:36px;height:36px;border-radius:50%;background:var(--br-pale);display:flex;align-items:center;justify-content:center;font-size:.75rem;font-weight:800;color:var(--br);flex-shrink:0">
            {{ strtoupper(substr($bid->bidder->name, 0, 2)) }}
          </div>
          <div class="flex-grow-1">
            <div style="font-weight:700;font-size:.88rem">{{ $bid->bidder->name }}</div>
            <div style="font-size:.75rem;color:var(--muted)">{{ $bid->bidder->email }}</div>
          </div></div>
              </td>
              <td style="padding:10px 16px;vertical-align:middle">
                <div style="font-weight:600">{{ Str::limit($bid->auction->title, 35) }}</div>
                <div style="font-size:.75rem;color:var(--muted)">{{ ucfirst($bid->auction->category) }}</div>
              </td>
              <td style="padding:10px 16px;vertical-align:middle;font-weight:800;color:var(--br)">
                PKR {{ number_format($bid->amount) }}
              </td>
              <td style="padding:10px 16px;vertical-align:middle">
                @if($bid->is_auto_bid)
                  <span style="background:#EEEDFE;color:#534AB7;font-size:.65rem;padding:2px 7px;border-radius:10px;font-weight:600">Auto</span>
                @else
                  <span style="background:var(--br-pale);color:var(--br);font-size:.65rem;padding:2px 7px;border-radius:10px;font-weight:600">Manual</span>
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>


  </div>
</div>
@endsection