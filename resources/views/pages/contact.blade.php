@extends('layouts.app')
@section('title', 'Cotact')
@section('content')

<div class="page-header">
  <div class="container">
    <h2><i class="bi bi-envelope me-2"></i>Contact Us</h2>
    <p>We are here to help — reach out any time</p>
  </div>
</div>
 
<div class="container py-5">
  <div class="row g-4 justify-content-center">
 
    {{-- Contact Form --}}
    <div class="col-lg-7">
      <div style="background:#fff;border:1px solid var(--border);border-radius:16px;padding:2rem">
        <div class="section-title mb-4" style="font-size:1rem">
          <i class="bi bi-chat-dots me-1"></i>Send us a message
        </div>
 
        @if(session('success'))
          <div style="background:var(--green-bg);border:1px solid var(--green-bd);border-radius:10px;padding:.9rem 1rem;margin-bottom:1.2rem;font-size:.88rem;color:var(--green);font-weight:700">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
          </div>
        @endif
 
        <form method="POST" action="#">
          @csrf
          <div class="row g-3">
            <div class="col-sm-6">
              <label class="form-label-ax">Full Name</label>
              <input type="text" name="name" class="form-control-ax" placeholder="Your name" required />
            </div>
            <div class="col-sm-6">
              <label class="form-label-ax">Email Address</label>
              <input type="email" name="email" class="form-control-ax" placeholder="username@gmail.com" required />
            </div>
            <div class="col-12">
              <label class="form-label-ax">Subject</label>
              <select name="subject" class="form-select-ax">
                <option>General Inquiry</option>
                <option>Bid Dispute</option>
                <option>Account Issue</option>
                <option>Seller Support</option>
                <option>Payment Issue</option>
                <option>Report a Problem</option>
              </select>
            </div>
            <div class="col-12">
              <label class="form-label-ax">Message</label>
              <textarea name="message" rows="5" class="form-control-ax"
                        placeholder="Describe your issue or question..." required></textarea>
            </div>
            <div class="col-12">
              <button type="submit" class="btn btn-brown px-5 py-2">
                <i class="bi bi-send me-2"></i>Send Message
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
 
    {{-- Contact Info --}}
    <div class="col-lg-4">
      <div class="d-flex flex-column gap-2">
        @foreach([
          ['bi-envelope',   'Email Support',   'auctionx@gmail.com',  'We reply within 24 hours'],
          ['bi-telephone',  'Phone Support',   '+92 317 7251685',        'Mon–Fri, 9am–6pm PKT'],
          ['bi-geo-alt',    'Head Office',     'Gujranwala, Punjab, Pakistan','Visit us by appointment'],
          ['bi-instagram', 'Instagram',      'auctionX',               ''],
          ['bi-twitter-x', 'Twitter',        'auctionX',               ''],
        ] as [$icon, $title, $val, $sub])
        <div style="background:#fff;border:1px solid var(--border);border-radius:14px;padding:1.2rem;display:flex;gap:1rem;align-items:flex-start">
          <div style="width:44px;height:44px;background:var(--br-pale);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:1.2rem;color:var(--br);flex-shrink:0">
            <i class="bi {{ $icon }}"></i>
          </div>
          <div>
            <div style="font-weight:700;font-size:.9rem">{{ $title }}</div>
            <div style="color:var(--br);font-weight:600;font-size:.88rem">{{ $val }}</div>
            <div style="color:var(--muted);font-size:.78rem">{{ $sub }}</div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
 
  </div>
</div>

@endsection