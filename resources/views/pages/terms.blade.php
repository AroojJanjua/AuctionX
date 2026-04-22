@extends('layouts.app')
@section('title', 'Terms of Service')
@section('content')

<div class="page-header">
  <div class="container">
    <h2><i class="bi bi-file-text me-2"></i>Terms of Service</h2>
    <p>Last updated: {{ date('F d, Y') }}</p>
  </div>
</div>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">
 
      <div style="background:#fff;border:1px solid var(--border);border-radius:16px;padding:2rem">
 
        <div style="background:var(--br-pale);border:1px solid var(--br-soft);border-radius:10px;padding:1rem;margin-bottom:2rem;font-size:.88rem;color:var(--br)">
          <i class="bi bi-info-circle me-2"></i>
          By registering and using AuctionX, you agree to these Terms of Service. Please read them carefully.
        </div>
 
        @foreach([
          [
            '1. Acceptance of Terms',
            'By creating an account on AuctionX, you confirm that you are at least 18 years old, that all information you provide is accurate and truthful, and that you agree to comply with these terms. AuctionX reserves the right to update these terms at any time.'
          ],
          [
            '2. User Accounts',
            'You are responsible for maintaining the security of your account and password. AuctionX is not liable for any loss or damage arising from your failure to protect your account. You must notify us immediately if you suspect unauthorized use of your account.'
          ],
          [
            '3. Bidding Rules',
            'All bids placed on AuctionX are binding. Once a bid is placed, it cannot be cancelled or retracted. The highest bid at the end of the auction timer wins the item. Bid sniping (placing bids in the final seconds) is allowed but may trigger automatic time extensions on certain auctions.'
          ],
          [
            '4. Seller Obligations',
            'Sellers must accurately describe all items listed for auction. Items must match their description, photos, and stated condition. Sellers must ship won items within 5 business days of receiving confirmed payment. Failure to fulfill orders may result in account suspension.'
          ],
          [
            '5. Buyer Obligations',
            'Winning bidders are obligated to complete payment within 48 hours of winning an auction. Failure to pay will result in the bid being cancelled and the item relisted. Repeated non-payment will result in account suspension.'
          ],
          [
            '6. Prohibited Items',
            'The following are strictly prohibited on AuctionX: counterfeit or stolen goods, weapons and ammunition, illegal substances, adult content, and any item that violates Pakistani law. Violation will result in immediate account termination.'
          ],
          [
            '7. Escrow & Payments',
            'AuctionX uses an escrow system for all transactions. Buyers send payment to AuctionX, funds are held until delivery is confirmed, then released to the seller. Disputes must be raised within 7 days of the item being marked as shipped. AuctionX charges no transaction fees during the current beta period.'
          ],
          [
            '8. Dispute Resolution',
            'In case of a dispute between buyer and seller, both parties must submit evidence to the AuctionX admin team within 7 days. The admin team will make a final decision within 5 business days. AuctionX\'s decision is final and binding.'
          ],
          [
            '9. Account Termination',
            'AuctionX reserves the right to suspend or permanently ban any account that violates these terms, engages in fraudulent activity, or receives multiple verified complaints. Banned users may not create new accounts.'
          ],
          [
            '10. Limitation of Liability',
            'AuctionX acts as a platform connecting buyers and sellers. We are not responsible for the quality, safety, or legality of items listed. Our liability is limited to the escrow amount held at the time of any dispute.'
          ],
        ] as [$title, $content])
        <div style="margin-bottom:1.8rem;padding-bottom:1.8rem;">
          <div style="font-weight:700;font-size:.95rem;color:var(--br);margin-bottom:.5rem">{{ $title }}</div>
          <p style="font-size:.88rem;color:var(--muted);line-height:1.8;margin:0">{{ $content }}</p>
        </div>
        @endforeach
 
        <div style="font-size:.82rem;color:var(--muted);text-align:center;margin-top:1rem">
          By using AuctionX you confirm you have read and agreed to these Terms of Service.<br>
          For questions: <a href="{{ route('contact') }}" style="color:var(--br)">contact our support team</a>.
        </div>
 
      </div>
 
      <div class="text-center mt-4">
        <a href="{{ route('register') }}" class="btn btn-brown px-4">
          <i class="bi bi-person-plus me-2"></i>Create Account
        </a>
        <a href="{{ route('home') }}" class="btn btn-ghost-ax px-4 ms-2">
          <i class="bi bi-house me-2"></i>Back to Home
        </a>
      </div>
 
    </div>
  </div>
</div>

@endsection