@extends('layouts.app')
@section('title','Manage Auctions By Admin')
@section('content')

<div class="page-header">
  <div class="container">
    <h2>Manage Auctions</h2>
    <p>{{ $auctions->total() }} total auctions</p>
  </div>
</div>

<div class="container py-4">
    {{-- filter --}}
    <form method="GET" action="{{ route('admin.auctions.index') }}" class="d-flex gap-2 flex-wrap mb-4">
    <input type="text" name="search" class="form-control-ax" style="max-width:280px"
           placeholder="Search auction title..." value="{{ request('search') }}" />
    <select name="status" class="form-select-ax" style="width:auto" onchange="this.form.submit()">
      <option value="">All Status</option>
      <option value="active"    {{ request('status')==='active'    ?'selected':'' }}>Active</option>
      <option value="closed"    {{ request('status')==='closed'    ?'selected':'' }}>Closed</option>
      <option value="draft"     {{ request('status')==='draft'     ?'selected':'' }}>Draft</option>
      <option value="cancelled" {{ request('status')==='cancelled' ?'selected':'' }}>Cancelled</option>
    </select>
        <button type="submit" class="btn btn-brown px-3"><i class="bi bi-search me-1"></i></button>
    @if(request()->anyFilled(['search','status']))
      <a href="{{ route('admin.auctions.index') }}" class="btn btn-ghost-ax px-3">Clear</a>
    @endif
  </form>

  <div style="background:#fff;border:1px solid var(--border);border-radius:16px;overflow:hidden">
    <div class="table-responsive">
    <table class="table mb-0" style="font-size:.87rem">
        <thead style="background:var(--surface)">
          <tr>
            <th style="font-weight:700;color:var(--muted);border:none;padding:11px 16px">Auction</th>
            <th style="font-weight:700;color:var(--muted);border:none;padding:11px 16px">Seller</th>
            <th style="font-weight:700;color:var(--muted);border:none;padding:11px 16px">Current Bid</th>
            <th style="font-weight:700;color:var(--muted);border:none;padding:11px 16px">Bids</th>
            <th style="font-weight:700;color:var(--muted);border:none;padding:11px 16px">Ends</th>
            <th style="font-weight:700;color:var(--muted);border:none;padding:11px 16px">Status</th>
            <th style="font-weight:700;color:var(--muted);border:none;padding:11px 16px">Actions</th>
          </tr>
        </thead>
        <tbody>
         @forelse($auctions as $auction)
          <tr style="border-bottom:1px solid var(--border)">
          <td style="padding:11px 16px;vertical-align:middle">
              <div style="font-weight:700">{{ Str::limit($auction->title, 35) }}</div>
              <div style="font-size:.75rem;color:var(--muted)">{{ ucfirst($auction->category) }}</div>
            </td>
          <td style="padding:11px 16px;vertical-align:middle;color:var(--muted);font-size:.82rem">{{ $auction->seller->name }}</td>
            <td style="padding:11px 16px;vertical-align:middle;font-weight:800;color:var(--br)">PKR {{ number_format($auction->current_bid) }}</td>
            <td style="padding:11px 16px;vertical-align:middle;color:var(--muted)">{{ $auction->bids_count }}</td>
            <td style="padding:11px 16px;vertical-align:middle;color:var(--muted);font-size:.8rem">{{ $auction->ends_at->format('M d, Y') }}</td>
            <td style="padding:11px 16px;vertical-align:middle">
              @switch($auction->status)
                @case('active')<span class="badge rounded-pill badge-timed">Active</span>@break
                @case('closed')<span class="badge rounded-pill badge-closed">Closed</span>@break
                @case('draft')<span class="badge rounded-pill badge-drafted">Draft</span>@break
                @default<span class="badge rounded-pill badge-drafted">{{ ucfirst($auction->status) }}</span>
              @endswitch
            </td>
             <td style="padding:11px 16px;vertical-align:middle">
             <div class="d-flex gap-1 flex-wrap">
             <a href="{{ route('auctions.show', $auction->id) }}" class="btn btn-ghost-ax btn-sm" title="View"><i class="bi bi-eye"></i></a>
             @if($auction->status === 'draft')
                <form method="POST" action="{{ route('admin.auctions.approve', $auction->id) }}">
                  @csrf @method('PUT')
                  <button class="btn btn-sm btn-green" title="Approve"><i class="bi bi-check2"></i></button>
                </form>
                @endif
                @if($auction->status === 'active')
                <form method="POST" action="{{ route('admin.auctions.close', $auction->id) }}">
                  @csrf @method('PUT')
                  <button class="btn btn-sm" style="background:var(--red-bg);color:var(--red);border:1px solid var(--red-bd)" title="Close">
                    <i class="bi bi-x-circle"></i></button>
                </form>
                @endif
                @if($auction->bids_count === 0)
                <form method="POST" action="{{ route('admin.auctions.destroy', $auction->id) }}"
                      onsubmit="return confirm('Delete this auction?')">
                  @csrf @method('DELETE') 
                  <button class="btn btn-sm" style="background:var(--red-bg);color:var(--red);border:1px solid var(--red-bd)" title="Delete">
                  <i class="bi bi-trash"></i></button>
                </form>
                @endif
             </div>
            </td>
          </tr>
          @empty
          <tr><td colspan="8" class="text-center py-4" style="color:var(--muted)">No auctions found</td></tr>
          @endforelse
        </tbody>
    </table>
    </div>
     <div class="p-3 d-flex justify-content-center">
      {{ $auctions->withQueryString()->links('vendor.pagination.bootstrap-5') }}
    </div>
  </div>

</div>
@endsection