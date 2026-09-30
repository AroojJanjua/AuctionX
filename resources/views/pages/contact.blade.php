@extends('layouts.app')
@section('title', 'Contact')
@section('content')

<div class="page-header">
  <div class="container">
    <h2>Contact Us</h2>
  </div>
</div>
 
<div class="container py-5">
  <div class="row g-4 justify-content-center">
    <div class="col-lg-7">
      <div style="background:#fff;border:1px solid var(--border);border-radius:16px;padding:2rem">
        {{-- contact form --}}
        <div class="section-title mb-4" style="font-size:1rem">Have a Question?</div>
        <form method="POST" action="{{ route('contact.submit') }}">
          @csrf
          <div class="row g-3">
            <div class="col-sm-6">
              <label class="form-label-ax">Full Name</label>
              <input type="text" name="name" class="form-control-ax"
                     placeholder="Your name" value="{{ old('name', auth()->user()->name ?? '') }}" required />
            </div>
            <div class="col-sm-6">
              <label class="form-label-ax">Email Address</label>
              <input type="email" name="email" class="form-control-ax"
                     placeholder="username@gmail.com" value="{{ old('email', auth()->user()->email ?? '') }}" required />
            </div>
            <div class="col-12">
              <label class="form-label-ax">Subject</label>
              <select name="subject" class="form-select-ax">
                @foreach(['General Inquiry','Bid Dispute','Account Issue','Seller Support','Payment Issue','Report a Problem'] as $opt)
                  <option {{ old('subject') === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-12">
              <label class="form-label-ax">Message</label>
              <textarea name="message" rows="5" class="form-control-ax"
                        placeholder="Describe your issue..." required>{{ old('message') }}</textarea>
            </div>
            <div class="col-12">
              <button type="submit" class="btn btn-brown-outline px-5 py-2">Send Message</button>
            </div>
          </div>
        </form>
      </div>
    </div>
 
    {{-- Contact Info --}}
    <div class="col-lg-4">
      <div class="d-flex flex-column gap-2">
        @foreach([
          ['bi-envelope',  'Email Support', 'auctionx01@gmail.com', 'We reply within 24 hours',      'mailto:auctionx01@gmail.com'],
          ['bi-telephone', 'Phone Support', '+92 317 7251685',      '9AM – 12AM PKT',                'tel:+923177251685'],
          ['bi-instagram', 'Instagram',     'auctionx.pk',          'Follow for auction highlights', 'https://www.instagram.com/auctionx__official?igsi=MXJsdHVyazdhb3pxYw=='],
          ['bi-whatsapp',  'WhatsApp',      '+92 317 7251685',      'contact us',               'https://wa.me/923177251685'],
        ] as [$icon, $title, $val, $sub, $link])
        <a href="{{ $link }}" target="_blank" rel="noopener"
           style="background:#fff;border:1px solid var(--border);border-radius:14px;padding:1.2rem;display:flex;gap:1rem;align-items:flex-start;text-decoration:none;transition:border-color .15s"
           onmouseover="this.style.borderColor='var(--br)'" onmouseout="this.style.borderColor='var(--border)'">
          <div style="width:44px;height:44px;background:var(--br-pale);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:1.2rem;color:var(--br);flex-shrink:0">
            <i class="bi {{ $icon }}"></i>
          </div>
          <div>
            <div style="font-weight:700;font-size:.9rem;color:var(--text)">{{ $title }}</div>
            <div style="color:var(--br);font-weight:600;font-size:.88rem">{{ $val }}</div>
            @if($sub)<div style="color:var(--muted);font-size:.78rem">{{ $sub }}</div>@endif
          </div>
        </a>
        @endforeach
      </div>
    </div>
 
  </div>
</div>

@endsection