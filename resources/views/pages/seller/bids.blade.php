@extends('layouts.app')
@section('title', 'Bid History')
@section('content')

<div class="page-header">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
      <div>
        <h2>Bid History</h2>
        <p>{{ Str::limit($listing->title, 60) }}</p>
      </div>
      <a href="{{ route('seller.dashboard') }}" class="btn btn-ghost-ax px-4">
        <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
      </a>
    </div>
  </div>
</div>

<div class="container py-4">

  {{-- Listing summary  --}}
  <div class="row g-3 mb-4">
    @foreach([
      ['Current Bid',  'Rs. '.number_format($listing->current_bid)],
      ['Total Bids',   $listing->bids_count],
      ['Status',       ucfirst($listing->status)],
      ['Ends',         $listing->ends_at->format('M d, Y')],
    ] as [$label,$val])
    <div class="col-sm-6 col-lg-3">
      <div style="background:#fff;border:1px solid var(--border);border-radius:12px;padding:1rem;display:flex;align-items:center;gap:.8rem">
        <div>
          <div style="font-size:.75rem;color:var(--muted)">{{ $label }}</div>
          <div style="font-weight:800;color:var(--br)">{{ $val }}</div>
        </div>
      </div>
    </div>
    @endforeach
  </div>

  {{-- Bids table  --}}
  <div style="background:#fff;border:1px solid var(--border);border-radius:16px;overflow:hidden">
    <div class="p-3" style="border-bottom:1px solid var(--border)">
      <div class="section-title" style="font-size:1rem">All Bids</div>
    </div>
    @if($bids->isEmpty())
      <div class="text-center py-5" style="color:var(--muted)">
        <i class="bi bi-hammer" style="font-size:2.5rem"></i>
        <div class="mt-2">No bids have been placed yet.</div>
      </div>
    @endif
  </div>

</div>

@endsection