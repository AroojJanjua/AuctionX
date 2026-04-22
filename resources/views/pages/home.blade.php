@extends('layouts.app')
@section('title','AuctionX')
@section('content')

{{-- HERO SECTION --}}
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
            jewelry, and collectibles with reserve price protection 
            and Buy Now options.
          </p>
          <div class="d-flex flex-wrap gap-2 mt-4">
            <a 
             class="btn btn-brown px-4 py-2">
              <i class="bi bi-grid me-2"></i>View Items
            </a>
            <a 
             class="btn btn-brown-outline px-4 py-2">
              <i class="bi bi-tag me-2"></i>Start Selling
            </a>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="feat-card">
            <div class="feat-card-img">
                     <img src="{{ asset('images\Car1.jpeg') }}"  alt="Car"
                     class="w-100 h-100" style="object-fit:cover">
                <span class="badge-status-abs">
                  <i class="bi bi-check-circle me-1"></i>Reserve Met
                </span>
            </div>
            <div class="p-3">
              <div class="fw-bold fs-6">
                Hyundai Grand i10 Nios</div>
              <div class="auction-sub mb-3">
                Arooj Janjua     
                &bull;
                 10 bids placed
              </div>

              <div class="d-flex justify-content-between align-items-end mb-3">
                <div>
                  <div style="font-size:0.72rem;text-transform:uppercase;letter-spacing:.4px;color:var(--muted)">
                    Current bid
                  </div>
                  <div class="bid-amount">
                    $14,999
                </div>
                </div>
                <div class="text-end">
                  <div style="font-size:0.72rem;color:var(--muted);margin-bottom:4px">Ends in</div>
                  <div class="d-flex gap-1">
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

              <div class="d-grid gap-2 d-sm-flex">
                <a 
                   class="btn btn-brown flex-grow-1 py-2">
                  <i class="bi bi-hammer me-1"></i> Place Bid
                </a>
                <button class="btn btn-ghost-ax px-3 py-2"
                        title="Add to Favorites">
                  <i class="bi bi-heart"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
</div>
</section>

{{-- FEATURED AUCTIONS --}}
<section class="py-5">
    <div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="section-title">Featured Auctions</div>
        <a 
        class="see-all-btn">
          View all <i class="bi bi-arrow-right"></i>
        </a>
      </div>

      {{-- Category Filters --}}
      <div class="d-flex flex-wrap gap-2 mb-4" id="filterBar">
        <button class="filter-btn active" data-filter="all">All</button>
        <button class="filter-btn" data-filter="art">Art</button>
        <button class="filter-btn" data-filter="watches">Watches</button>
        <button class="filter-btn" data-filter="vehicles">Vehicles</button>
        <button class="filter-btn" data-filter="jewelry">Jewelry</button>
        <button class="filter-btn" data-filter="collectibles">Collectibles</button>
      </div>
        <div class="row g-3" id="auctionGrid">
          {{-- 1 --}}       
        <div class="col-sm-6 col-lg-3 auction-item">
      <div class="auction-card">
    {{-- Card Image --}}
    <div class="auction-card-img">
      <img src="{{ asset('images/Rolex Watch.jpeg') }}" alt="Watch"
           class="w-100 h-100" style="object-fit:cover">
           <div class="auction-card-badges">
      <span class="badge rounded-pill badge-timed">Timed</span>
           </div>
    </div>
    {{-- Card Body --}}
    <div class="p-3">
      <div class="auction-title mb-1">Rolex Watch</div>
      <div class="auction-sub mb-2">Watches &bull; Ahmad</div>

      <div class="d-flex justify-content-between align-items-center mb-3">
        <span class="auction-price">$5,999</span>
        <span class="auction-timer">
          <i class="bi bi-clock me-1"></i>00:00:00
        </span>
      </div>

      <div class="d-grid gap-2">
        <a class="btn btn-brown btn-sm">Place Bid</a>

        <div class="d-flex gap-2">
          <a class="btn btn-green btn-sm flex-grow-1">Buy $11,999</a>
          
        </div>
      </div>
    </div>
  </div>
        </div>
        {{-- 2 --}}       
        <div class="col-sm-6 col-lg-3 auction-item">
      <div class="auction-card">
    {{-- Card Image --}}
    <div class="auction-card-img">
      <img src="{{ asset('images/Royal Jewelry.jpeg') }}" alt="Jewelry"
           class="w-100 h-100" style="object-fit:cover">
           <div class="auction-card-badges">
      <span class="badge rounded-pill badge-timed">Timed</span>
           </div>
    </div>
    {{-- Card Body --}}
    <div class="p-3">
      <div class="auction-title mb-1">Royal Jewelry</div>
      <div class="auction-sub mb-2">Jewelry &bull; Arooj</div>

      <div class="d-flex justify-content-between align-items-center mb-3">
        <span class="auction-price">$5,499</span>
        <span class="auction-timer">
          <i class="bi bi-clock me-1"></i>00:00:00
        </span>
      </div>

      <div class="d-grid gap-2">
        <a class="btn btn-brown btn-sm">Place Bid</a>

        <div class="d-flex gap-2">
          <a class="btn btn-green btn-sm flex-grow-1">Buy $11,499</a>

        </div>
      </div>
    </div>
  </div>
        </div>
        {{-- 3 --}}       
        <div class="col-sm-6 col-lg-3 auction-item">
      <div class="auction-card">
    {{-- Card Image --}}
    <div class="auction-card-img">
      <img src="{{ asset('images/iphone.jpeg') }}" alt="Iphone"
           class="w-100 h-100" style="object-fit:cover">
           <div class="auction-card-badges">
      <span class="badge rounded-pill badge-timed">Timed</span>
           </div>
    </div>
    {{-- Card Body --}}
    <div class="p-3">
      <div class="auction-title mb-1">Iphone</div>
      <div class="auction-sub mb-2">Collectibles &bull; Bismah</div>

      <div class="d-flex justify-content-between align-items-center mb-3">
        <span class="auction-price">$4,999</span>
        <span class="auction-timer">
          <i class="bi bi-clock me-1"></i>00:00:00
        </span>
      </div>

      <div class="d-grid gap-2">
        <a class="btn btn-brown btn-sm">Place Bid</a>

        <div class="d-flex gap-2">
          <a class="btn btn-green btn-sm flex-grow-1">Buy $9,990</a>
        </div>
      </div>
    </div>
  </div>
        </div>
  {{-- 4 --}}      
        <div class="col-sm-6 col-lg-3 auction-item">
      <div class="auction-card">
    {{-- Card Image --}}
    <div class="auction-card-img">
      <img src="{{ asset('images/Girly Watch.jpeg') }}" alt="Blashon"
           class="w-100 h-100" style="object-fit:cover">
           <div class="auction-card-badges">
      <span class="badge rounded-pill badge-timed">Timed</span>
           </div>
    </div>
    {{-- Card Body --}}
    <div class="p-3">
      <div class="auction-title mb-1">Girly Watch</div>
      <div class="auction-sub mb-2">Watches &bull; Laiba</div>

      <div class="d-flex justify-content-between align-items-center mb-3">
        <span class="auction-price">$4,799</span>
        <span class="auction-timer">
          <i class="bi bi-clock me-1"></i>00:00:00
        </span>
      </div>

      <div class="d-grid gap-2">
        <a class="btn btn-brown btn-sm">Place Bid</a>

        <div class="d-flex gap-2">
          <a class="btn btn-green btn-sm flex-grow-1">Buy $7,599</a>
        </div>
      </div>
    </div>
  </div>
        </div>
      {{-- 5 --}}     
        <div class="col-sm-6 col-lg-3 auction-item">
      <div class="auction-card">
    {{-- Card Image --}}
    <div class="auction-card-img">
      <img src="{{ asset('images/earbuds.jpeg') }}" alt="Blashon"
           class="w-100 h-100" style="object-fit:cover">
           <div class="auction-card-badges">
      <span class="badge rounded-pill badge-timed">Timed</span>
           </div>
    </div>
    {{-- Card Body --}}
    <div class="p-3">
      <div class="auction-title mb-1">Ear Buds</div>
      <div class="auction-sub mb-2">Collectibles &bull; Jasim</div>

      <div class="d-flex justify-content-between align-items-center mb-3">
        <span class="auction-price">$1,999</span>
        <span class="auction-timer">
          <i class="bi bi-clock me-1"></i>00:00:00
        </span>
      </div>

      <div class="d-grid gap-2">
        <a class="btn btn-brown btn-sm">Place Bid</a>

        <div class="d-flex gap-2">
          <a class="btn btn-green btn-sm flex-grow-1">Buy $2,999</a>
        </div>
      </div>
    </div>
  </div>
        </div>
        {{-- 6 --}}    
        <div class="col-sm-6 col-lg-3 auction-item">
      <div class="auction-card">
    {{-- Card Image --}}
    <div class="auction-card-img">
      <img src="{{ asset('images/pendant.jpeg') }}" alt="Blashon"
           class="w-100 h-100" style="object-fit:cover">
           <div class="auction-card-badges">
      <span class="badge rounded-pill badge-timed">Timed</span>
           </div>
    </div>
    {{-- Card Body --}}
    <div class="p-3">
      <div class="auction-title mb-1">Antique Pendant</div>
      <div class="auction-sub mb-2">Jewelry &bull; Habeeb</div>

      <div class="d-flex justify-content-between align-items-center mb-3">
        <span class="auction-price">$1,699</span>
        <span class="auction-timer">
          <i class="bi bi-clock me-1"></i>00:00:00
        </span>
      </div>

      <div class="d-grid gap-2">
        <a class="btn btn-brown btn-sm">Place Bid</a>

        <div class="d-flex gap-2">
          <a class="btn btn-green btn-sm flex-grow-1">Buy $1,999</a>

        </div>
      </div>
    </div>
  </div>
        </div>
         {{-- 7    --}}
        <div class="col-sm-6 col-lg-3 auction-item">
      <div class="auction-card">
    {{-- Card Image --}}
    <div class="auction-card-img">
      <img src="{{ asset('images/headphones.jpeg') }}" alt="Blashon"
           class="w-100 h-100" style="object-fit:cover">
           <div class="auction-card-badges">
      <span class="badge rounded-pill badge-timed">Timed</span>
           </div>
    </div>
    {{-- Card Body --}}
    <div class="p-3">
      <div class="auction-title mb-1">Headphone</div>
      <div class="auction-sub mb-2">Collectibles &bull; Faiza</div>

      <div class="d-flex justify-content-between align-items-center mb-3">
        <span class="auction-price">$999</span>
        <span class="auction-timer">
          <i class="bi bi-clock me-1"></i>00:00:00
        </span>
      </div>

      <div class="d-grid gap-2">
        <a class="btn btn-brown btn-sm">Place Bid</a>

        <div class="d-flex gap-2">
          <a class="btn btn-green btn-sm flex-grow-1">Buy $1,999</a>
        </div>
      </div>
    </div>
  </div>
        </div>
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
      ['1','bi-person-plus',   'Create Your Account',  'Register as a bidder or seller in minutes. Verify your email and complete your profile to get started.'],
      ['2','bi-grid',          'Browse Listings',       'Explore thousands of auctions across art, watches, vehicles, jewelry, collectibles and more. Use filters to find exactly what you want.'],
      ['3','bi-hammer',        'Place Your Bid',        'Enter your bid amount — must be above the current bid. Use auto-bid to let the system bid on your behalf up to your maximum.'],
      ['4','bi-trophy',        'Win the Auction',       'When the timer ends, the highest bidder wins. You\'ll receive an instant notification with payment instructions.'],
      ['5','bi-bag-check',     'Secure Checkout',       'Complete your purchase securely using escrow. AuctionX provides buyer protection for every transaction to ensure safety and trust.'],
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
        {{-- href="{{ route('register') }}" --}}
         class="btn btn-brown px-5 py-2">
          Get Started Free
        </a>
      </div>
    </div>
  </section>
@endsection