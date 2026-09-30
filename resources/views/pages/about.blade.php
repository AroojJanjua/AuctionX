@extends('layouts.app')
@section('title', 'About')
@section('content')

<div class="page-header">
  <div class="container">
    <h2>About AuctionX</h2>
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
        jewelry, collectibles, and electronics all in one place..
      </p>
      <div class="row g-3 mt-2">
         @foreach($stats as $stat)
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
        <img src="{{ asset('image/about.jpeg') }}" style="border-radius:16px;width:445px;height:280px;">
      </div>
    </div>

     {{-- Values --}}
  <div class="row g-3">
    @foreach([
      ['bi-shield-check',  'Escrow Protection',   'Payments are held in escrow until you confirm receipt of your item, then released to the seller. Sellers can\'t be paid before delivery.'],
      ['bi-broadcast',     'Real-Time Bidding',    'Experience live auctions with instant bid updates, dynamic pricing, and synchronized countdowns.'],
      ['bi-lock',          'Secure Payments',      'Transparent payments through JazzCash or EasyPaisa with payment verification, clear pricing and a simple payment process.'],
      ['bi-headset',       'Dispute Resolution',   'Shop with confidence. If an issue arises after delivery, our support team carefully reviews the case and works with both buyers and sellers to reach a fair resolution.'],
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