@extends('layouts.app')
@section('title', 'Browse Auctions')
@section('content')

{{-- Page Header --}}
<div class="page-header">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
      <div>
        <h2><i class="bi bi-grid me-2"></i>Browse Auctions</h2>
      </div>
      @auth
        @if(auth()->user()->role === 'seller')
          <a href="{{ route('seller.create') }}" class="btn btn-brown px-4">
            <i class="bi bi-plus-circle me-2"></i>New Listing
          </a>
        @endif
      @endauth
    </div>
  </div>
</div>

<div class="container py-4">
    <div class="row g-4">
        {{-- Sidebar Filters --}}
      <div class="col-lg-3">
      <form method="GET" action="{{ route('auctions.index') }}" id="filterForm">
        @if(request('search'))
           <input type="hidden" name="search" value="{{ request('search') }}">
        @endif
        {{-- Category --}}
        <div style="background:#fff;border:1px solid var(--border);border-radius:14px;padding:1.1rem;margin-bottom:1rem">
          <div style="font-weight:700;font-size:.85rem;color:var(--br);margin-bottom:.8rem">
            <i class="bi bi-collection me-1"></i>Category
          </div>
          @foreach([
            ['all',          'All Categories'],
            ['art',          'Art'],
            ['watches',      'Watches'],
            ['vehicles',     'Vehicles'],
            ['jewelry',      'Jewelry'],
            ['collectibles', 'Collectibles'],
            ['electronics',  'Electronics'],
          ] as [$val, $label])
          <div class="form-check mb-1">
            <input class="form-check-input" type="radio" name="category"
                   id="cat_{{ $val }}" value="{{ $val }}"
                   {{ request('category', 'all') === $val ? 'checked' : '' }}
                   onchange="document.getElementById('filterForm').submit()">
            <label class="form-check-label" for="cat_{{ $val }}"
                   style="font-size:.85rem;color:var(--text)">
              {{ $label }}
            </label>
          </div>
          @endforeach
        </div>

        {{-- Price Range --}}
        <div style="background:#fff;border:1px solid var(--border);border-radius:14px;padding:1.1rem;margin-bottom:1rem">
          <div style="font-weight:700;font-size:.85rem;color:var(--br);margin-bottom:.8rem">
            <i class="bi bi-currency-rupee"></i>Price Range
          </div>
          <div class="d-flex gap-1 align-items-center">
            <input type="number" name="min_price" class="form-control-ax"
                   placeholder="Min " value="{{ request('min_price') }}"
                   min="0" style="width:80px" />
            <span style="color:var(--muted);font-size:.8rem">to</span>
            <input type="number" name="max_price" class="form-control-ax"
                   placeholder="Max " value="{{ request('max_price') }}"
                   min="0" style="width:80px" />
          </div>
          <button type="submit" class="btn btn-brown w-100 btn-sm mt-2">Apply</button>
        </div>

        {{-- Sort --}}
        <div style="background:#fff;border:1px solid var(--border);border-radius:14px;padding:1.1rem;margin-bottom:1rem">
          <div style="font-weight:700;font-size:.85rem;color:var(--br);margin-bottom:.8rem">
            <i class="bi bi-sort-down me-1"></i>Sort By
          </div>
          <select name="sort" class="form-select-ax"
                  onchange="document.getElementById('filterForm').submit()">
            @foreach([
              ['ending_soon', 'Ending Soonest'],
              ['newest',      'Newest First'],
              ['price_asc',   'Price: Low to High'],
              ['price_desc',  'Price: High to Low'],
              ['most_bids',   'Most Bids'],
            ] as [$val, $label])
            <option value="{{ $val }}" {{ request('sort','ending_soon') === $val ? 'selected' : '' }}>
              {{ $label }}
            </option>
            @endforeach
          </select>
        </div>

        {{-- Clear Filters --}}
        @if(request()->hasAny(['category','min_price','max_price','sort']))
          <a href="{{ route('auctions.index') }}" class="btn btn-ghost-ax w-100 btn-sm">
            <i class="bi bi-x me-1"></i>Clear Filters
          </a>
        @endif
      </form>
      </div>

        {{-- Auction Grid --}}
      <div class="col-lg-9">

      @if($auctions->isEmpty())
        <div style="background:#fff;border:1px solid var(--border);border-radius:16px;
                    padding:4rem 2rem;text-align:center">
          <i class="bi bi-search" style="font-size:3rem;color:var(--muted);display:block;margin-bottom:1rem"></i>
          <div style="font-size:1.1rem;font-weight:800;color:var(--br);margin-bottom:.5rem">
            No auctions found
          </div>
          <p style="color:var(--muted);font-size:.9rem;margin-bottom:1.2rem">
            Try different keywords or clear the filters to see all auctions.
          </p>
          <a href="{{ route('auctions.index') }}" class="btn btn-brown px-4">
            <i class="bi bi-grid me-2"></i>View All Auctions
          </a>
        </div>

      @else
      <div class="row g-3">
          @foreach($auctions as $auction)
          <div class="col-sm-4  col-xl-4">
            <div class="auction-card h-100">
            {{-- Image --}}
            <div class="auction-card-img {{ $auction->category }}">
                @if($auction->image)
                  <img src="{{ asset('storage/' . $auction->image) }}"
                       class="w-100 h-100" style="object-fit:cover"
                       alt="{{ $auction->title }}">
                @else
                  <div class="auction-img-icon">
                    @switch($auction->category)
                      @case('art')         <i class="bi bi-palette"   style="color:var(--br)"></i>       @break
                      @case('watches')     <i class="bi bi-watch"     style="color:#1A4A8A"></i>       @break
                      @case('vehicles')    <i class="bi bi-car-front" style="color:var(--green)"></i>    @break
                      @case('jewelry')     <i class="bi bi-gem"       style="color:#E65100"></i>       @break
                      @case('collectibles')<i class="bi bi-box"       style="color:#7B1FA2"></i>       @break
                      @default             <i class="bi bi-laptop"    style="color:#1A4A8A"></i>
                    @endswitch
                  </div>
                @endif

            {{-- Badges --}}
                <div class="auction-card-badges">
                      <span class="badge rounded-pill badge-timed">
                      <i class="bi bi-clock me-1"></i>Live
                    </span>
  
                  @if($auction->ends_soon)
                    <span class="badge rounded-pill"
                          style="background:var(--red);color:#fff;font-size:.7rem">
                      Ending Soon
                    </span>
                  @endif
                </div>
            </div>

            {{-- Body  --}}
            <div class="p-3">
              <div class="auction-title mb-1">
                  {{ Str::limit($auction->title, 45) }}
                </div>
                <div class="auction-sub mb-2">
                  {{ $auction->category_label }} &bull; {{ $auction->seller->name }}
                </div>

              {{-- Bid + Timer row --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <div>
                    <div style="font-size:.7rem;color:var(--muted);text-transform:uppercase;letter-spacing:.4px">
                      Current Bid
                    </div>
                    <span class="auction-price">${{ number_format($auction->current_bid) }}</span>
                  </div>
                  <div class="text-end">
                    <div style="font-size:.7rem;color:var(--muted)"> added later
                      {{-- {{ $auction->bids_count }} {{ Str::plural('bid', $auction->bids_count) }} --}}
                    </div>
                    <span class="auction-timer {{ $auction->ends_soon ? 'ending' : '' }}">
                      <i class="bi bi-clock me-1"></i>{{ $auction->time_remaining }}
                    </span>
                  </div>
                </div>

                {{-- Actions  --}}
                <div class="d-flex gap-2">
                <a href="{{ route('auctions.show', $auction->id) }}"
                       class="btn btn-brown btn-sm flex-grow-1">
                      <i class="bi bi-hammer me-1"></i>Place Bid
                    </a>
                @auth
                    <form method="POST"
                          {{-- action="{{ route('favorites.store', $auction->id) }}" --}}
                          style="margin:0">
                      @csrf
                      <button type="submit" class="btn btn-ghost-ax btn-sm"
                              title="Save to Favorites">
                        <i class="bi bi-heart"></i>
                      </button>
                    </form>
                  @else
                    <a href="{{ route('login') }}"
                       class="btn btn-ghost-ax btn-sm" title="Login to save">
                      <i class="bi bi-heart"></i>
                    </a>
                  @endauth
                </div>

            </div>
          </div>
          </div>
          @endforeach
        </div>
              {{-- Pagination --}}
              <div class="mt-4 d-flex justify-content-center">
          {{ $auctions->links('vendor.pagination.bootstrap-5') }}
        </div>
      @endif
      </div>
    </div>
  </div>
@endsection