@extends('layouts.app')
@section('title', 'Privacy Policy')
@section('content')

<div class="page-header">
  <div class="container">
    <h2><i class="bi bi-shield-lock me-2"></i>Privacy Policy</h2>
    <p>Last updated: {{ date('F d, Y') }}</p>
  </div>
</div>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">
 
      <div style="background:#fff;border:1px solid var(--border);border-radius:16px;padding:2rem">
 
        <div style="background:var(--br-pale);border:1px solid var(--br-soft);border-radius:10px;padding:1rem;margin-bottom:2rem;font-size:.88rem;color:var(--br)">
          <i class="bi bi-info-circle me-2"></i>
          AuctionX is committed to protecting your personal information and your right to privacy.
        </div>
 
        @foreach([
          [
            'Information We Collect',
            'bi-collection',
            'We collect information you provide when you register — including your name, email address, phone number, and delivery address. We also collect information about your activity on the platform such as bids placed, auctions created, and items purchased.'
          ],
          [
            'How We Use Your Information',
            'bi-gear',
            'We use your information to operate the AuctionX platform, process transactions, send important notifications (such as outbid alerts and auction results), verify seller identities, and improve our services. We never sell your personal data to third parties.'
          ],
          [
            'Payment Information',
            'bi-phone',
            'Payments are processed via JazzCash and EasyPaisa. We store only the transaction ID and sender number that you provide to verify your payment. We do not store full account credentials or passwords for these services.'
          ],
          [
            'Escrow & Transaction Data',
            'bi-shield-check',
            'All escrow transaction records are stored securely and are only accessible to the buyer, seller, and our admin team. Transaction records are retained for a minimum of 2 years for dispute resolution purposes.'
          ],
          [
            'Cookies',
            'bi-cookie',
            'AuctionX uses essential cookies to keep you logged in and maintain your session. We do not use tracking cookies or share cookie data with advertisers.'
          ],
          [
            'Data Security',
            'bi-lock',
            'All passwords are hashed using bcrypt encryption. Sensitive data is transmitted over HTTPS. We regularly review our security practices to protect your information from unauthorized access.'
          ],
          [
            'Your Rights',
            'bi-person-check',
            'You have the right to access, update, or delete your personal information at any time through your Profile settings. To request complete account deletion, please contact our support team.'
          ],
          [
            'Contact Us',
            'bi-envelope',
            'If you have any questions about this Privacy Policy, please contact us at auctionx@gmail.com or visit our Support page.'
          ],
        ] as [$title, $icon, $content])
        <div style="margin-bottom:1.8rem">
          <div style="display:flex;align-items:center;gap:8px;font-weight:700;font-size:1rem;color:var(--br);margin-bottom:.6rem">
            <i class="bi {{ $icon }}" style="font-size:1.1rem"></i>
            {{ $title }}
          </div>
          <p style="font-size:.9rem;color:var(--muted);line-height:1.8;margin:0">{{ $content }}</p>
        </div>
        @endforeach
 
      </div>
 
      <div class="text-center mt-4">
        <a href="{{ route('contact') }}" class="btn btn-brown px-4">
          <i class="bi bi-envelope me-2"></i>Contact Us
        </a>
        <a href="{{ route('home') }}" class="btn btn-ghost-ax px-4 ms-2">
          <i class="bi bi-house me-2"></i>Back to Home
        </a>
      </div>
 
    </div>
  </div>
</div>

@endsection