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
             class="btn btn-brown px-4 py-2">View Items</a>
            <a href="{{ route('register') }}"
             class="btn btn-brown-outline px-4 py-2">Start Selling</a>
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
                  <span class="auction-price" id="feat-price">PKR {{ number_format($featured->current_bid) }}</span>
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

<section class="py-4">
    <div class="container-fluid px-0">
        <div id="visualSlider" class="carousel slide auction-slider" data-bs-ride="carousel" data-bs-interval="3000">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#visualSlider" data-bs-slide-to="0" 
                class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#visualSlider" data-bs-slide-to="1" 
                aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#visualSlider" data-bs-slide-to="2" 
                aria-label="Slide 3"></button>
                <button type="button" data-bs-target="#visualSlider" data-bs-slide-to="3" 
                aria-label="Slide 4"></button>
                <button type="button" data-bs-target="#visualSlider" data-bs-slide-to="4" 
                aria-label="Slide 5"></button>
                <button type="button" data-bs-target="#visualSlider" data-bs-slide-to="5" 
                aria-label="Slide 6"></button>
            </div>

            <!-- Slides -->
            <div class="carousel-inner">
                <div class="carousel-item active"><img src="{{ asset('image/art.jpeg') }}" class="auction-slide-img"  alt="img"></div>
                <div class="carousel-item"><img src="{{ asset('image/collectible.jpeg') }}" class="auction-slide-img" alt="img"></div>
                <div class="carousel-item"><img src="{{ asset('image/vehicle.jpeg') }}" class="auction-slide-img" alt="img"></div>
                <div class="carousel-item"><img src="{{ asset('image/jewelry.jpeg') }}" class="auction-slide-img" alt="img"></div>
                <div class="carousel-item"><img src="{{ asset('image/watch.jpeg') }}" class="auction-slide-img" alt="img"></div>
                <div class="carousel-item"><img src="{{ asset('image/electronic.jpeg') }}" class="auction-slide-img" alt="img"></div>
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
          View all</a>
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
          <div class="col-sm-6 col-lg-3 auction-item" data-auction-id="{{ $auction->id }}" data-category="{{ $auction->category }}">
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
                    <span class="auction-price" id="home-price-{{ $auction->id }}">PKR {{ number_format($auction->current_bid) }}</span>
                  </div>
                  <div class="text-end">
                    <div style="font-size:.7rem;color:var(--muted)" id="home-bids-{{ $auction->id }}">
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
      ['1', 'bi-person-plus', 'Create Your Account', 'Sign up as a bidder or seller and create your AuctionX account. Verify your email address and complete your profile to begin.'],
      ['2', 'bi-grid', 'Browse Listings', 'Discover auctions in categories such as art, watches, vehicles, jewelry, collectibles, and electronics. Browse listings and use filters to find items you are interested in.'],
      ['3', 'bi-hammer', 'Place Your Bid', 'Choose an auction and enter your bid amount. Your bid must be higher than the current highest bid. You can also use Auto-Bid to automatically place bids for you up to your chosen maximum amount.'],
      ['4', 'bi-trophy', 'Win the Auction', 'Keep an eye on the auction and place higher bids when needed. When the auction ends, the highest bidder becomes the winner and receives a notification.'],
      ['5', 'bi-bag-check', 'Complete Secure Payment', 'After winning, complete your payment through AuctionX escrow. The payment is securely held while the order is processed, helping protect both the buyer and seller throughout the transaction.'],
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
        href="{{ route('register') }}" class="btn btn-brown-outline px-5 py-2">Get Started</a>
      </div>
    </div>
  </section>
@endsection

@push('styles')
<style>
.auction-slider .carousel-inner{
    overflow: hidden;
}
.auction-slider .carousel-item img.auction-slide-img{
    display: block;
    width: 100%;
    height: 500px;
    object-fit: cover;
    object-position: center;
}
.auction-slider .carousel-indicators [data-bs-target]{
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background-color: rgba(255, 255, 255, .5);
}
.auction-slider .carousel-indicators [data-bs-target].active{
    background-color: var(--br);
    opacity: 1;
}
@media (max-width: 992px){
    .auction-slider .carousel-item img.auction-slide-img{
        height: 400px;
    }
}
@media (max-width: 576px){
    .auction-slider .carousel-item img.auction-slide-img{
        height: 220px;
    }
}
</style>
@endpush

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
  const noResults=document.getElementById('noResults');

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

  //Pusher for real-time updates
  if(typeof AuctionXSocket === 'undefined') return;

  //Track the current featured auction id and its bid count
  var featuredId={{ $featured ? $featured->id : 'null' }};
  var featuredBids={{ $featured ? $featured->bids_count : 0 }};

  // Subscribe to every grid card's channel
  document.querySelectorAll('#auctionGrid .auction-item').forEach(function(col){
    var id=col.dataset.auctionId;
    var ch=AuctionXSocket.subscribe('auction.' + id);

    ch.bind('bid.placed',function(data){
      var auctionId=parseInt(id,10);
      var newBids=data.bidsCount;
      var newPrice=data.currentBid;

      //Update grid card price
      var priceEl=document.getElementById('home-price-' + id);
      if(priceEl){
        priceEl.textContent='PKR ' + Number(newPrice).toLocaleString();
        priceEl.style.transition='color .2s';
        priceEl.style.color='var(--br)';
        setTimeout(function(){ priceEl.style.color = ''; }, 800);
      }

      //Update grid card bid count
      var bidsEl=document.getElementById('home-bids-' + id);
      if(bidsEl){
        bidsEl.textContent=newBids + ' ' + (newBids === 1 ? 'bid' : 'bids');
        bidsEl.dataset.bidsCount=newBids;
      }
      //Also keep the col data attribute in sync for swap logic
      col.dataset.bidsCount=newBids;

      //Check if a different card now has more bids then swap
      if(newBids > featuredBids){
        fetch('{{ route("home.live-data") }}')
          .then(function(res){ return res.json(); })
          .then(function(d){
            if(!d.featured) return;
            // Only swap if server agree that this id is now the top bidded
            if(d.featured.id === auctionId){
              featuredId=d.featured.id;
              featuredBids=d.featured.bidsCount || newBids;
              location.reload();
            }
          })
          .catch(function(err){
                console.error('Failed to check featured auction:', err);
          });
      }
       });
      //when an auction closes, grey out its card instantly
      ch.bind('auction.status-changed',function(data){
      if(data.status !== 'closed') return;

      // If this was the featured card then reload so the next best takes over
      if(parseInt(id,10) === featuredId){
        location.reload();
        return;
      }

      // Otherwise just dim the grid card in place
      var card=col.querySelector('.auction-card');
      if(card){
        card.style.opacity='0.5';
        card.style.pointerEvents='none';
      }
      var timerEl=col.querySelector('.auction-timer');
      if(timerEl){
        timerEl.textContent='Ended';
        timerEl.classList.remove('ending');
        timerEl.style.color='var(--muted)';
      }
      var badges=col.querySelector('.auction-card-badges');
      if(badges){
        var ended=document.createElement('span');
        ended.className='badge rounded-pill badge-closed';
        ended.textContent='Ended';
        badges.innerHTML='';
        badges.appendChild(ended);
      }
    });
  });

  if(featuredId){
    var featCh=AuctionXSocket.subscribe('auction.' + featuredId);
    featCh.bind('bid.placed', function(data){
      var featPrice=document.getElementById('feat-price');
      if(featPrice){
        featPrice.textContent='PKR ' + Number(data.currentBid).toLocaleString();
        featPrice.style.transition='color .2s';
        featPrice.style.color='var(--br)';
        setTimeout(function(){ featPrice.style.color = ''; }, 800);
      }
      featuredBids=data.bidsCount;
    });

    
    // Featured card closed then reload 
    featCh.bind('auction.status-changed',function(data){
      if(data.status === 'closed') 
        location.reload();
      });
  }

  var feedCh=AuctionXSocket.subscribe('auctions.feed');
  feedCh.bind('auction.deleted',function(data){
    var col=document.querySelector('#auctionGrid [data-auction-id="' + data.auctionId + '"]');
    if(col){
        col.remove(); 
      }

    // If the deleted auction was the featured card then reload
    if(parseInt(data.auctionId) === featuredId){
      location.reload();
    }
  });

  // scheduled auction to appears it live in the grid
  feedCh.bind('auction.status-changed',function(data){
    if(data.status !== 'active') return;
    var alreadyOnPage=document.querySelector('#auctionGrid [data-auction-id="' + data.auctionId + '"]');
    if(!alreadyOnPage){
      location.reload();
    }
  });
  
});
</script>
@endpush