@extends('layouts.app')
@section('title', 'Manage Bids By Admin')
@section('content')
 
<div class="page-header">
  <div class="container">
    <h2>Manage Bids</h2>
    <p>{{ $bids->total() }} total bids on the platform</p>
  </div>
</div>

<div class="container py-4">
<form method="GET" action="{{ route('admin.bids.index') }}" class="d-flex gap-2 flex-wrap mb-4">
    <input type="text" name="search" class="form-control-ax" style="max-width:320px"
           placeholder="Search by bidder name or auction..." value="{{ request('search') }}" />
    <button type="submit" class="btn btn-brown px-3"><i class="bi bi-search me-1"></i></button>
    @if(request('search'))
      <a href="{{ route('admin.bids.index') }}" class="btn btn-ghost-ax px-3">Clear</a>
    @endif
  </form>

  <div style="background:#fff;border:1px solid var(--border);border-radius:16px;overflow:hidden">
    <div class="table-responsive">
      <table class="table mb-0" style="font-size:.87rem">
        <thead style="background:var(--surface)">
          <tr>
            <th style="font-weight:700;color:var(--muted);border:none;padding:11px 16px">Bidder</th>
            <th style="font-weight:700;color:var(--muted);border:none;padding:11px 16px">Auction</th>
            <th style="font-weight:700;color:var(--muted);border:none;padding:11px 16px">Amount</th>
            <th style="font-weight:700;color:var(--muted);border:none;padding:11px 16px">Type</th>
            <th style="font-weight:700;color:var(--muted);border:none;padding:11px 16px">Placed At</th>
            <th style="font-weight:700;color:var(--muted);border:none;padding:11px 16px">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($bids as $bid)
          <tr style="border-bottom:1px solid var(--border)">
            <td style="padding:11px 16px;vertical-align:middle">
              <div style="font-weight:700">{{ $bid->bidder->name }}</div>
              <div style="font-size:.75rem;color:var(--muted)">{{ $bid->bidder->email }}</div>
            </td>
            <td style="padding:11px 16px;vertical-align:middle">
              <div style="font-weight:600">{{ Str::limit($bid->auction->title, 35) }}</div>
            </td>
            <td style="padding:11px 16px;vertical-align:middle;font-weight:800;color:var(--br)">PKR {{ number_format($bid->amount) }}</td>
            <td style="padding:12px 16px;vertical-align:middle">
               @if($bid->is_auto_bid)
                  <span style="background:#EEEDFE;color:#534AB7;font-size:.65rem;padding:2px 7px;border-radius:10px;font-weight:600">Auto</span>
                @else
                  <span style="background:var(--br-pale);color:var(--br);font-size:.65rem;padding:2px 7px;border-radius:10px;font-weight:600">Manual</span>
                @endif
            </td>
            <td style="padding:11px 16px;vertical-align:middle;color:var(--muted);font-size:.8rem">
              {{ $bid->created_at->format('M d, Y · h:i A') }}
            </td>
            <td style="padding:11px 16px;vertical-align:middle">
              <form method="POST" action="{{ route('admin.bids.destroy', $bid->id) }}"
                    onsubmit="return confirm('Remove this bid? The auction price will be recalculated.')">
                @csrf @method('DELETE')
                <button class="btn btn-sm" style="background:var(--red-bg);color:var(--red);border:1px solid var(--red-bd)">
                  <i class="bi bi-trash"></i>
                </button>
              </form>
            </td>
          </tr>
          @empty
          <tr><td colspan="6" class="text-center py-4" style="color:var(--muted)">No bids found</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="p-3 d-flex justify-content-center">
      {{ $bids->withQueryString()->links('vendor.pagination.bootstrap-5') }}
    </div>
  </div>

</div>
@endsection