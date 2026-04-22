@extends('layouts.app')
@section('title', 'About')
@section('content')

<div class="page-header">
  <div class="container">
    <h2><i class="bi bi-building me-2"></i>About AuctionX</h2>
    <p>The trusted online auction platform for buyers and sellers</p>
  </div>
</div>

<div class="container py-5">
    <div class="row g-5 align-items-center mb-5">
        {{-- Our Mission  --}}
        <div class="col-lg-6">
      <h3 style="font-size:1.5rem;font-weight:800;color:var(--br)">Our Mission</h3>
      <p style="color:var(--muted);line-height:1.8">
        AuctionX connects buyers and sellers in a simple, safe, and fair way. 
        Users can find and bid on special items like art, watches, vehicles, 
        jewelry, and collectibles all in one place..
      </p>
      <div class="row g-3 mt-2">
        @foreach(['50+ Active Listings','50+ Registered Users','$0.1M+ Sold This Week','100% Secure Transactions'] as $stat)
        <div class="col-6">
          <div style="background:var(--br-pale);border:1px solid var(--br-soft);border-radius:10px;padding:.9rem;text-align:center">
            <div style="font-weight:800;font-size:1rem;color:var(--br)">{{ $stat }}</div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
    {{-- Right Img --}}
    <div class="col-lg-6">
      <div style="background:var(--br-soft);border-radius:16px;height:280px;display:flex;align-items:center;justify-content:center">
        <img src="{{ asset('images/about.jpeg') }}" style="border-radius:16px;width:445px;height:280px;">
      </div>
    </div>

    {{-- Values --}}
  <div class="row g-3">
    @foreach([
      ['bi-shield-check',  'Buyer Protection',  'Every purchase is protected. Verified sellers, secure payments and dispute resolution.'],
      ['bi-eye',           'Transparency',      'All bids are visible in real-time. No hidden fees, no surprise charges after winning.'],
      ['bi-lock',          'Secure Platform',   'SSL encryption, verified accounts and fraud detection keep your data and money safe.'],
      ['bi-headset',       '24/7 Support',      'Our support team is available around the clock to help buyers and sellers with any issue.'],
    ] as [$icon, $title, $desc])
    <div class="col-sm-6 col-lg-3">
      <div class="step-card text-center">
        <div style="font-size:2rem;color:var(--br);margin-bottom:.8rem"><i class="bi {{ $icon }}"></i></div>
        <div class="step-title mb-1">{{ $title }}</div>
        <div class="step-desc">{{ $desc }}</div>
      </div>
    </div>
    @endforeach
  </div>
  
    </div>
</div>

@endsection