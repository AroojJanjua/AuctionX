@extends('layouts.app')
@section('title', 'Seller Dashboard')
@section('content')

<div class="page-header">
    <div class="container">
      <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
          <h2><i class="bi bi-tag me-2"></i>Seller Dashboard</h2>
          <p>Welcome back, {{ auth()->user()->name }}</p>
        </div>
        <a href="{{ route('seller.create') }}" class="btn btn-brown px-4">
          <i class="bi bi-plus-lg me-2"></i>New Listing
        </a>
      </div>
    </div>
  </div>

  <div class="container py-4">
    {{-- Stats Cards --}}
    <div class="row g-3 mb-4">
      @foreach([
        ['Active Listings', $stats['active']],
        ['Items Sold',      $stats['sold']],
        ['Total Earned',    'Rs. '.number_format($stats['earned'])],
      ] as [$label,$val])
      <div class="col-sm-6 col-lg-3">
        <div style="background:#fff;border:1px solid var(--border);border-radius:14px;padding:1.2rem">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <div style="font-size:0.8rem;color:var(--muted);margin-bottom:4px">{{ $label }}</div>
              <div style="font-size:1.6rem;font-weight:800;color:var(--green)">{{ $val }}</div>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>

    {{-- My Listings Table --}}
    <div style="background:#fff;border:1px solid var(--border);border-radius:16px;overflow:hidden">
      <div class="d-flex justify-content-between align-items-center p-3"
           style="border-bottom:1px solid var(--border)">
        <div class="section-title">My Listings</div>
        {{-- <div class="d-flex gap-2">
          <select class="form-select-ax" style="width:auto;font-size:0.82rem">
            <option>All Status</option>
            <option>Active</option>
            <option>Ended</option>
            <option>Draft</option>
          </select>
        </div> --}}
      </div>

      @if($listings->isEmpty())
        <div class="text-center py-5">
          <i class="bi bi-inbox" style="font-size:3rem;color:var(--muted)"></i>
          <div class="mt-3 fw-bold">No listings yet</div>
          <a href="{{ route('seller.create') }}" class="btn btn-brown mt-3">
            <i class="bi bi-plus-lg me-1"></i>Create Your First Listing
          </a>
        </div>
      @else
        <div class="table-responsive">
          <table class="table mb-0" style="font-size:0.88rem">
            <thead style="background:var(--surface)">
              <tr>
                <th style="font-weight:700;color:var(--muted);border:none;padding:10px 16px">Item</th>
                <th style="font-weight:700;color:var(--muted);border:none;padding:10px 16px">Current Bid</th>
                <th style="font-weight:700;color:var(--muted);border:none;padding:10px 16px">Bids</th>
                <th style="font-weight:700;color:var(--muted);border:none;padding:10px 16px">Ends</th>
                <th style="font-weight:700;color:var(--muted);border:none;padding:10px 16px">Status</th>
                <th style="font-weight:700;color:var(--muted);border:none;padding:10px 16px">Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($listings as $listing)
              <tr style="border-bottom:1px solid var(--border)">
                <td style="padding:12px 16px;vertical-align:middle">
                  <div style="font-weight:700;color:var(--text)">{{ Str::limit($listing->title, 35) }}</div>
                  <div style="font-size:0.75rem;color:var(--muted)">{{ ucfirst($listing->category) }}</div>
                </td>
                <td style="padding:12px 16px;vertical-align:middle;font-weight:700;color:var(--br)">
                  ${{ number_format($listing->current_bid) }}
                </td>
                <td style="padding:12px 16px;vertical-align:middle;color:var(--muted)">
                  {{-- {{ $listing->bids_count }} --}}
                </td>
                <td style="padding:12px 16px;vertical-align:middle;color:var(--muted);font-size:0.82rem">
                  {{ $listing->ends_at->format('M d, Y') }}<br>
                  {{ $listing->ends_at->format('h:i A') }}
                </td>
                <td style="padding:12px 16px;vertical-align:middle">
                  @switch($listing->status)
                    @case('active')
                      <span class="badge rounded-pill badge-buynow">Active</span> @break
                    @case('closed')
                      <span class="badge rounded-pill badge-closed2">Closed</span> @break
                    @case('draft')
                      <span class="badge rounded-pill badge-reserve2">Draft(check badge)</span> @break
                  @endswitch
                </td>
                <td style="padding:12px 16px;vertical-align:middle">
                  <div class="d-flex gap-1">
                    <a href="{{ route('auctions.show', $listing->id) }}"
                       class="btn btn-ghost-ax btn-sm" title="View">
                      <i class="bi bi-eye"></i>
                    </a>
                    <a href="{{ route('seller.edit', $listing->id) }}"
                       class="btn btn-ghost-ax btn-sm" title="Edit">
                      <i class="bi bi-pencil"></i>
                    </a>
                    {{-- <form method="POST"
                          action="{{ route('seller.destroy', $listing->id) }}"
                          onsubmit="return confirm('Are you sure you want to delete this listing?')">
                      @csrf @method('DELETE')
                      <button type="submit" class="btn btn-sm"
                              style="background:var(--red-bg);color:var(--red);border:1px solid var(--red-bd)"
                              title="Delete">
                        <i class="bi bi-trash"></i>
                      </button>
                    </form> --}}
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        {{-- <div class="p-3 d-flex justify-content-center">
          {{ $listings->links('vendor.pagination.bootstrap-5') }}
        </div> --}}
      @endif
    </div>

  </div>
@endsection