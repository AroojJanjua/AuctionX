@extends('layouts.app')
@section('title', 'How It Works')
@section('content')

<div class="page-header">
  <div class="container">
    <h2><i class="bi bi-info-circle me-2"></i>How AuctionX Works</h2>
    <p>Simple, secure and transparent — from registration to winning your item</p>
  </div>
</div>

<div class="container py-5">
    {{-- Steps --}}
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
  {{-- Auction Types --}}
  <div class="mb-5">
    <h3 style="font-size:1.2rem;font-weight:800;color:var(--br);margin-bottom:1.5rem">
      <i class="bi bi-clock me-2"></i>Selling Types
    </h3>
    <div class="row g-3">
      @foreach([
        ['Timed Auction',   'bi-clock',     'badge-timed',  'Bidding opens and closes at set times. Place your bid anytime before the timer runs out. The highest bid when time expires wins.'],
        ['Buy Now',         'bi-bag-check', 'badge-buynow', 'Skip the bidding and purchase instantly at the fixed Buy Now price. Available on select listings alongside regular bidding.'],
      ] as [$type, $icon, $badge, $desc])
      <div class="col-md-6">
        <div style="background:#fff;border:1px solid var(--border);border-radius:14px;padding:1.2rem">
          <div class="d-flex align-items-center gap-2 mb-2">
            <i class="bi {{ $icon }}" style="font-size:1.2rem;color:var(--br)"></i>
            <span class="fw-bold">{{ $type }}</span>
            <span class="badge rounded-pill {{ $badge }} ms-auto">{{ $type }}</span>
          </div>
          <p style="font-size:0.88rem;color:var(--muted);margin:0">{{ $desc }}</p>
        </div>
      </div>
      @endforeach
    </div>
  </div>
  
  {{-- FAQ --}}
  <div class="mb-5">
    <h3 style="font-size:1.2rem;font-weight:800;color:var(--br);margin-bottom:1.5rem">
      <i class="bi bi-patch-question me-2"></i>Frequently Asked Questions
    </h3>
    <div class="accordion" id="faqAccordion">
      @foreach([
          ['Is it free to register?',            
          'Yes, creating an account on AuctionX is completely free for both bidders and sellers.'],
          ['How do I place a bid?',
           'Go to any active auction page and enter your bid amount in the "Place Bid" field. Your bid must be higher than the current bid. Click "Place Bid" to confirm. You will receive a notification if you are outbid.'],
          ['How do I know a bid is valid?',      
          'All bids are recorded instantly and each bidder is notified if they are outbid. The system automatically validates that each bid exceeds the minimum increment.'],
          ['What happens when I win an auction?',
           'When the auction ends and you are the highest bidder, you will see a "Proceed to Checkout" button on the auction page. Complete the checkout form, choose JazzCash or EasyPaisa, and follow the payment instructions.'],
          ['How does the escrow payment work?',
           'After winning, you send payment to AuctionX\'s JazzCash/EasyPaisa number and submit your Transaction ID. Our admin verifies the payment and holds the funds safely. Once the seller ships and you confirm delivery, the payment is automatically released to the seller.'],
          ['What if my item does not arrive?',
           'If your item has not arrived within the expected delivery period, do NOT confirm delivery. Instead raise a dispute from your Order Status page. Our admin team will investigate and either arrange a refund or resolve the issue with the seller.'],
          ['How do I become a seller?',
           'During registration, select "Sell items (Seller)" as your role. Once registered, you can access your Seller Dashboard from the navigation menu and create your first listing.'],
          ['How do I list an item for sale?',    
          'Register as a seller, go to your Seller Dashboard and click "New Listing". Fill in your item details, set your pricing and schedule, then publish.'],
          ['Can I cancel a bid after placing it?',
           'No — bids on AuctionX are binding and cannot be cancelled once placed. Please make sure you intend to purchase the item before bidding.'],
          ['How do I change my account role from bidder to seller?',
           'Contact our support team via the contact form below. An admin will update your role within 24 hours.'],
          ['What is a reserve price?',
           'A reserve price is a secret minimum price set by the seller. If bidding does not reach this amount, the auction ends without a winner. You can see on each listing whether the reserve price has been "Met" or "Not Met".'],
          ['How does the reserve price work?',   
          'If the auction has a reserve price, the item will only sell if bidding reaches that amount. You can see on the listing whether the reserve has been met.'],
        ] as $i => [$q, $a])
      <div class="accordion-item" 
      style="border:1px solid var(--border);border-radius:10px!important;margin-bottom:8px;overflow:hidden">
        <h2 class="accordion-header">
          <button class="accordion-button {{ $i > 0 ? 'collapsed' : '' }}"
                  type="button" data-bs-toggle="collapse"
                  data-bs-target="#faq{{ $i }}"
                  style="font-weight:700;font-size:0.9rem;color:var(--text);background:#fff">
            {{ $q }}
          </button>
        </h2>
        <div id="faq{{ $i }}" class="accordion-collapse collapse {{ $i === 0 ? 'show' : '' }}"
             data-bs-parent="#faqAccordion">
          <div class="accordion-body" style="font-size:0.88rem;color:var(--muted)">{{ $a }}</div>
        </div>
      </div>
      @endforeach
    </div>
  </div>

  {{-- CTA --}}
  <div class="text-center py-4" style="background:var(--br-pale);border-radius:16px;border:1px solid var(--br-soft)">
    <h3 style="font-size:1.3rem;font-weight:800;color:var(--br)">Ready to start bidding?</h3>
    <p style="color:var(--muted);font-size:0.9rem">Join thousands of bidders and sellers on AuctionX today.</p>
    <div class="d-flex justify-content-center gap-3 flex-wrap">
      <a href="{{ route('register') }}" class="btn btn-brown px-5 py-2">Create Free Account</a>
      <a class="btn btn-brown-outline px-5 py-2">Browse Auctions</a>
    </div>
  </div>

</div>

@endsection