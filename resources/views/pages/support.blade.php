@extends('layouts.app')
@section('title', 'Support')
@section('content')

<div class="page-header">
  <div class="container">
    <h2><i class="bi bi-person-raised-hand me-2"></i>Support Center</h2>
    <p>We are here to help — find answers or contact our team</p>
  </div>
</div>

<div class="container py-5">
 
  {{-- Quick help cards --}}
  <div class="row g-3 mb-5">
    @foreach([
      ['bi-hammer',        'Bidding Help',      'Learn how to place bids, auto-bid, and win auctions.', 'how-it-works'],
      ['bi-tag',           'Selling Help',       'How to list items, set prices, and manage your orders.', 'how-it-works'],
      ['bi-shield-lock',   'Escrow & Payments',  'Understand how escrow works and how to pay safely.', 'how-it-works'],
      ['bi-person-circle', 'Account Issues',     'Login problems, profile settings, and account security.', 'contact'],
    ] as [$icon, $title, $desc, $route])
    <div class="col-sm-6 col-lg-3">
      <a href="{{ route($route) }}" style="text-decoration:none">
        <div style="background:#fff;border:1px solid var(--border);border-radius:14px;padding:1.3rem;text-align:center;transition:all .15s;height:100%"
             onmouseover="this.style.borderColor='var(--br)'" onmouseout="this.style.borderColor='var(--border)'">
          <i class="bi {{ $icon }}" style="font-size:2rem;color:var(--br);display:block;margin-bottom:.8rem"></i>
          <div style="font-weight:700;font-size:.93rem;color:var(--text);margin-bottom:.4rem">{{ $title }}</div>
          <div style="font-size:.8rem;color:var(--muted);line-height:1.6">{{ $desc }}</div>
        </div>
      </a>
    </div>
    @endforeach
  </div>
 
  <div class="row g-4">
 
    {{-- FAQ --}}
    <div class="col-lg-7">
      <div style="font-size:1.1rem;font-weight:800;color:var(--br);margin-bottom:1.2rem">
        <i class="bi bi-patch-question me-2"></i>Frequently Asked Questions
      </div>
 
      <div class="accordion" id="supportFAQ">
        @foreach([
          ['Is it free to register?',            
          'Yes, creating an account on AuctionX is completely free for both bidders and sellers.'],
          ['How do I place a bid?',
           'Go to any active auction page and enter your bid amount in the "Place Bid" field. Your bid must be higher than the current bid. Click "Place Bid" to confirm. You will receive a notification if you are outbid.'],
          ['How do I know a bid is valid?',      
          'All bids are recorded instantly and each bidder is notified if they are outbid. The system automatically validates that each bid exceeds the minimum increment.'],
          ['How do I become a seller?',
           'During registration, select "Sell items (Seller)" as your role. Once registered, you can access your Seller Dashboard from the navigation menu and create your first listing.'],
          ['Can I cancel a bid after placing it?',
           'No — bids on AuctionX are binding and cannot be cancelled once placed. Please make sure you intend to purchase the item before bidding.'],
          ['How do I change my account role from bidder to seller?',
           'Contact our support team via the contact form below. An admin will update your role within 24 hours.'],
          ['How does the reserve price work?',   
          'If the auction has a reserve price, the item will only sell if bidding reaches that amount. You can see on the listing whether the reserve has been met.'],
        ] as $i => [$q, $a])
        <div class="accordion-item" style="border:1px solid var(--border);border-radius:10px!important;margin-bottom:8px;overflow:hidden">
          <h2 class="accordion-header">
            <button class="accordion-button {{ $i > 0 ? 'collapsed' : '' }}"
                    type="button" data-bs-toggle="collapse"
                    data-bs-target="#faq{{ $i }}"
                    style="font-weight:700;font-size:.88rem;color:var(--text);background:#fff">
              {{ $q }}
            </button>
          </h2>
          <div id="faq{{ $i }}" class="accordion-collapse collapse {{ $i === 0 ? 'show' : '' }}"
               data-bs-parent="#supportFAQ">
            <div class="accordion-body" style="font-size:.85rem;color:var(--muted);line-height:1.75">{{ $a }}</div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
 
    {{-- Contact --}}
    <div class="col-lg-5">
      <div style="font-size:1.1rem;font-weight:800;color:var(--br);margin-bottom:1.2rem">
        <i class="bi bi-chat-dots me-2"></i>Contact Support
      </div>
 
      <div style="background:#fff;border:1px solid var(--border);border-radius:16px;padding:1.5rem;margin-bottom:1rem">
 
        @if(session('success'))
          <div style="background:var(--green-bg);border:1px solid var(--green-bd);border-radius:10px;padding:.85rem;margin-bottom:1.2rem;font-size:.85rem;font-weight:700;color:var(--green)">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
          </div>
        @endif
 
        <form method="POST" action="{{ route('contact') }}">
          @csrf
          <div class="mb-3">
            <label class="form-label-ax">Your Name</label>
            <input type="text" name="name" class="form-control-ax"
                   value="{{ auth()->user()->name ?? old('name') }}"
                   placeholder="Full name" required />
          </div>
          <div class="mb-3">
            <label class="form-label-ax">Email Address</label>
            <input type="email" name="email" class="form-control-ax"
                   value="{{ auth()->user()->email ?? old('email') }}"
                   placeholder="username@email.com" required />
          </div>
          <div class="mb-3">
            <label class="form-label-ax">Issue Type</label>
            <select name="subject" class="form-select-ax">
              <option>Bidding Issue</option>
              <option>Payment / Escrow Problem</option>
              <option>Account Access</option>
              <option>Seller Support</option>
              <option>Dispute Assistance</option>
              <option>Report a User</option>
              <option>Other</option>
            </select>
          </div>
          <div class="mb-4">
            <label class="form-label-ax">Message</label>
            <textarea name="message" rows="4" class="form-control-ax"
                      placeholder="Describe your issue in detail..." required></textarea>
          </div>
          <button type="submit" class="btn btn-brown w-100 py-2">
            <i class="bi bi-send me-2"></i>Send Message
          </button>
        </form>
      </div>
    </div>
      {{-- Contact Info --}}
      <div style="background:#fff;border:1px solid var(--border);border-radius:14px;padding:1.2rem">
        <div style="font-weight:700;font-size:.88rem;color:var(--br);margin-bottom:.8rem">Other ways to reach us</div>
        @foreach([
          ['bi-envelope',  'Email',          'auctionx@gmail.com.com', 'Reply within 24 hours'],
          ['bi-telephone', 'Phone',          '+92 317 7251685',        'Mon–Fri, 9am–6pm PKT'],
          ['bi-instagram', 'Instagram',      'auctionX',               ''],
          ['bi-twitter-x', 'Twitter',        'auctionX',               ''],
          ['bi-clock',     'Response Time',  'Under 24 hours',         ''],
        ] as [$icon, $label, $val, $sub])
        <div class="d-flex align-items-center gap-2 mb-2" style="font-size:.83rem">
          <i class="bi {{ $icon }}" style="color:var(--br);width:16px;font-size:16px"></i>
          <div>
            <span style="color:var(--muted)">{{ $label }}: </span>
            <strong style="color:var(--text)">{{ $val }}</strong>
            <div style="font-size:.75rem;color:var(--muted)">{{ $sub }}</div>
          </div>
        </div>
        @endforeach
      </div>
    
 
  </div>
</div>

@endsection