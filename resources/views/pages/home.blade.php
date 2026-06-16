@extends('layouts.app')
@section('title','AuctionX')
@section('content')

{{-- hero section --}}
<section class="hero-section">
  <div class="container">
      <div class="row align-items-center g-4">
          {{-- Left: Headline --}}
        <div class="col-lg-6">
          <div class="hero-tag">
            <span class="dot-live"></span> Timed auctions happening now
          </div>
          <h1>Bid, Win & Own Something Remarkable</h1>
          <p class="lead mt-3" style="color:var(--muted)">
            Browse timed auctions for art, watches, vehicles, 
            jewelry, collectibles and electronics. 
          </p>
          <div class="d-flex flex-wrap gap-2 mt-4">
            <a href="{{ route('auctions.index') }}" 
             class="btn btn-brown px-4 py-2">View Items
            </a>
            <a href="{{ route('register') }}"
             class="btn btn-brown-outline px-4 py-2">Start Selling
            </a>
          </div>
        </div>

          {{-- Right: Featured Live Auction Card --}}
        <div class="col-lg-6">
         @if($featured)
          <div class="auction-card h-100">
          {{-- Card Image --}}
            <div class="auction-card-img {{ $featured->category }}">
              @if($featured->image)
                <img src="{{ asset('storage/' . $featured->image) }}" alt="{{ $featured->title }}"
                    class="w-100 h-100" style="object-fit:cover">
              @else
                <div class="auction-img-icon">
                  @switch($featured->category)
                    @case('art')         <i class="bi bi-palette"   style="color:var(--br)"></i>       @break
                    @case('watches')     <i class="bi bi-watch"     style="color:#1A4A8A"></i>         @break
                    @case('vehicles')    <i class="bi bi-car-front" style="color:var(--green)"></i>    @break
                    @case('jewelry')     <i class="bi bi-gem"       style="color:#E65100"></i>         @break
                    @case('collectibles')<i class="bi bi-box"       style="color:#7B1FA2"></i>         @break
                    @default             <i class="bi bi-laptop"    style="color:#1A4A8A"></i>
                  @endswitch
                </div>
              @endif
              <div class="auction-card-badges">
                <span class="badge rounded-pill badge-timed">
                  <i class="bi bi-clock me-1"></i>Live
                </span>
                @if($featured->ends_soon)
                <span class="badge rounded-pill badge-closed">
                  <i class="bi bi-clock me-1"></i>Ending Soon
                </span>
                @endif
              </div>
            </div>

            {{-- Card Body --}}
            <div class="p-3">
              <div class="auction-title mb-1">{{ Str::limit($featured->title,45) }}</div>
              <div class="auction-sub mb-2">{{ $featured->category_label }} &bull; {{ $featured->seller->name }}</div>

              <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                  <div style="font-size:0.72rem;color:var(--muted);text-transform:uppercase;letter-spacing:.4px">Current Bid</div>
                  <span class="auction-price">PKR {{ number_format($featured->current_bid) }}</span>
                </div>
                <div class="text-end">
                  <div style="font-size:0.72rem;color:var(--muted);margin-bottom:4px">Ends in</div>
                  <div class="d-flex gap-1" id="featTimer" data-ends="{{ $featured->ends_at->timestamp }}">
                    <div class="countdown-unit">
                      <span class="countdown-num" id="feat-d">00</span>
                      <span class="countdown-lbl">days</span>
                    </div>
                    <div class="countdown-unit">
                      <span class="countdown-num" id="feat-h">00</span>
                      <span class="countdown-lbl">hrs</span>
                    </div>
                    <div class="countdown-unit">
                      <span class="countdown-num" id="feat-m">00</span>
                      <span class="countdown-lbl">min</span>
                    </div>
                    <div class="countdown-unit">
                      <span class="countdown-num" id="feat-s">00</span>
                      <span class="countdown-lbl">sec</span>
                    </div>
                  </div>
                </div>
              </div>

              <div class="d-grid gap-2">
                <a href="{{ route('auctions.show', $featured->id) }}" class="btn btn-brown btn-sm">Place Bid</a>
              </div>
            </div>
          </div>
          @endif
        </div>
    </div>
</div>
</section>

{{-- featured auctions --}}
<section class="py-5">
    <div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="section-title">Featured Auctions</div>
        <a href="{{ route('auctions.index') }}" class="see-all-btn">
          View all <i class="bi bi-arrow-right"></i></a>
      </div>

    {{-- Category Filters --}}
      <div class="d-flex flex-wrap gap-2 mb-4" id="filterBar">
        <button class="filter-btn active" data-filter="all">All</button>
        <button class="filter-btn" data-filter="art">Art</button>
        <button class="filter-btn" data-filter="watches">Watches</button>
        <button class="filter-btn" data-filter="vehicles">Vehicles</button>
        <button class="filter-btn" data-filter="jewelry">Jewelry</button>
        <button class="filter-btn" data-filter="collectibles">Collectibles</button>
        <button class="filter-btn" data-filter="electronics">Electronics</button>
      </div>

      @if($auctions->isEmpty())
        <div class="text-center py-5" style="color:var(--muted)">
          <i class="bi bi-hourglass-split" style="font-size:2rem;display:block;margin-bottom:.5rem"></i>
          No active auctions right now. Check back soon!
        </div>

      @else
      <div class="row g-3" id="auctionGrid">
          @foreach($auctions as $auction)
          <div class="col-sm-6 col-lg-3 auction-item" data-category="{{ $auction->category }}">
            <div class="auction-card h-100">
            {{-- card image --}}
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

                <div class="auction-card-badges">
                  <span class="badge rounded-pill badge-timed">
                    <i class="bi bi-clock me-1"></i>Live
                  </span>
                  @if($auction->ends_soon)
                    <span class="badge rounded-pill badge-closed">
                      <i class="bi bi-clock me-1"></i>Ending Soon
                    </span>
                  @endif
                </div>
              </div>

              {{-- Card body --}}
              <div class="p-3">
                <div class="auction-title mb-1">
                  {{ Str::limit($auction->title, 45) }}
                </div>
                <div class="auction-sub mb-2">
                  {{ $auction->category_label }} &bull; {{ $auction->seller->name }}
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                  <div>
                    <div style="font-size:.7rem;color:var(--muted);text-transform:uppercase;letter-spacing:.4px">
                      Current Bid
                    </div>
                    <span class="auction-price">PKR {{ number_format($auction->current_bid) }}</span>
                  </div>
                  <div class="text-end">
                    <div style="font-size:.7rem;color:var(--muted)">
                      {{ $auction->bids_count }} {{ Str::plural('bid', $auction->bids_count) }}
                    </div>
                    <span class="auction-timer {{ $auction->ends_soon ? 'ending' : '' }}">
                      <i class="bi bi-clock me-1"></i>{{ $auction->time_remaining }}
                    </span>
                  </div>
                </div>

                <div class="d-grid gap-2">
                  <a href="{{ route('auctions.show', $auction->id) }}"
                     class="btn btn-brown btn-sm">
                    Place Bid
                  </a>
                </div>
              </div>

            </div>
          </div>
          @endforeach
      </div>
      @endif

      <div id="noResults" class="text-center py-5" style="color:var(--muted);display:none">
        <i class="bi bi-search" style="font-size:2rem;display:block;margin-bottom:.5rem"></i>
        No auctions found in this category.
      </div>
</div>   
</section>

{{-- HOW IT WORKS --}}
  <section class="how-section py-5">
    <div class="container">
      <div class="text-center mb-4">
        <div class="section-title">How AuctionX Works</div>
        <p style="color:var(--muted);font-size:0.9rem;margin-top:0.4rem">
          Five simple steps from sign-up to winning your item
        </p>
      </div>
      <div class="row g-4 mb-5">
     @foreach([
      ['1','bi-person-plus','Create Your Account','Register as a bidder or seller in minutes. Verify your email and complete your profile to get started.'],
      ['2','bi-grid',       'Browse Listings',    'Explore thousands of auctions across art, watches, vehicles, jewelry, collectibles and more. Use filters to find exactly what you want.'],
      ['3','bi-hammer',     'Place Your Bid',     'Enter your bid amount that must be above the current bid. Use auto-bid to let the system bid on your behalf up to your maximum.'],
      ['4','bi-trophy',     'Win the Auction',    'When the timer ends, the highest bidder wins. You\'ll receive an instant notification with payment instructions.'],
      ['5','bi-bag-check',  'Secure Checkout',    'Complete your purchase securely using escrow. AuctionX provides buyer protection for every transaction to ensure safety and trust.'],
    ] as [$n, $icon, $title, $desc])
    <div class="col-md-6 col-lg-4">
      <div class="step-card">
        <div class="step-num">{{ $n }}</div>
        <div class="mb-2" style="font-size:1.6rem;color:var(--br)"><i class="bi {{ $icon }}"></i></div>
        <div class="step-title mb-2">{{ $title }}</div>
        <div class="step-desc">{{ $desc }}</div>
      </div>
    </div>
    @endforeach
  </div>
      <div class="text-center mt-4">
        <a 
        href="{{ route('register') }}" class="btn btn-brown px-5 py-2">Get Started Free</a>
      </div>
    </div>
  </section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded',function(){
  // Live countdown for featured auction card
  const featTimer=document.getElementById('featTimer');
  if (featTimer){
    const endsAt=parseInt(featTimer.dataset.ends, 10) * 1000;
    const dEl=document.getElementById('feat-d');
    const hEl=document.getElementById('feat-h');
    const mEl=document.getElementById('feat-m');
    const sEl=document.getElementById('feat-s');

    function tickFeatured(){
      const diff=Math.max(0, Math.floor((endsAt - Date.now()) / 1000));
      const d=Math.floor(diff / 86400);
      const h=Math.floor((diff % 86400) / 3600);
      const m=Math.floor((diff % 3600) / 60);
      const s=diff % 60;

      dEl.textContent=String(d).padStart(2,'0');
      hEl.textContent=String(h).padStart(2,'0');
      mEl.textContent=String(m).padStart(2,'0');
      sEl.textContent=String(s).padStart(2,'0');

      if(diff > 0) 
         setTimeout(tickFeatured,1000);
    }
    tickFeatured();
  }

  const filterBtns=document.querySelectorAll('#filterBar .filter-btn');
  const items=document.querySelectorAll('#auctionGrid .auction-item');
  const noResults =document.getElementById('noResults');

  filterBtns.forEach(btn=>{
    btn.addEventListener('click', function(){
      filterBtns.forEach(b=>b.classList.remove('active'));
      this.classList.add('active');

      const filter=this.dataset.filter;
      let visibleCount=0;

      items.forEach(item=>{
        const match = (filter === 'all' || item.dataset.category === filter);
        item.style.display = match ? '' : 'none';
        if(match) 
          visibleCount++;
      });

      if(noResults){
        noResults.style.display = visibleCount === 0 ? '' : 'none';
      }
    });
  });
});
</script>
@endpush