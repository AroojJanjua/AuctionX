@extends('layouts.app')
@section('title', 'Terms of Service')
@section('content')

<div class="page-header">
  <div class="container">
    <h2>Terms of Service</h2>
    <p>Last updated: {{ date('F d, Y') }}</p>
  </div>
</div>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">
 
      <div style="background:#fff;border:1px solid var(--border);border-radius:16px;padding:2rem"> 
        @foreach([
          ['1. Acceptance of Terms',
          'By creating an account on AuctionX, you confirm that you are at least 18 years old and that all information you provide is accurate, complete, and up to date. By accessing or using the platform, you agree to be bound by these Terms. AuctionX reserves the right to modify or update these Terms from time to time.'          
          ],['2. User Accounts',
          'You are responsible for maintaining the confidentiality of your account credentials and for all activity that occurs under your account. AuctionX is not liable for any loss arising from your failure to protect your login information, and you must notify us immediately if you suspect unauthorized access to your account.'
          ],[
          '3. Bidding Rules',
          'All bids placed on AuctionX are binding and cannot be cancelled, withdrawn, or modified once submitted. The highest valid bid at the time the auction ends will be considered the winning bid. To discourage last-second bidding, any qualifying bid placed during the final minute of an auction will automatically extend the auction by two minutes, subject to a maximum of three extensions per auction. AuctionX may also offer an automatic bidding feature, allowing you to set a maximum bid amount. The system will place incremental bids on your behalf, up to your specified maximum, as other users place competing bids.'
          ],[
            '4. Seller Obligations',
            'Sellers must accurately describe every item listed, including its condition, and the item received by the buyer must match its listing. Once payment is confirmed, sellers are expected to ship the item promptly and provide tracking information where available. Repeated failure to fulfill orders may result in account suspension.'
          ],[
            '5. Buyer Obligations',
            'Winning bidders are expected to complete payment promptly after an auction ends. Non-payment may result in the order being cancelled and repeated non-payment may result in account suspension.'
          ], [
            '6. Prohibited Items',
            'The following may not be listed on AuctionX: counterfeit or stolen goods, weapons and ammunition, illegal substances, adult content, and any item that violates applicable Pakistani law. Listing a prohibited item may result in immediate removal of the listing and termination of the seller\'s account.'
          ], [
            '7. Escrow & Platform Fee',
            'All payments on AuctionX pass through escrow: buyers pay AuctionX directly, funds are held until the buyer confirms receipt of the item, and are then released to the seller. AuctionX deducts a 5% platform fee from the sale amount before releasing funds to the seller; this fee is disclosed to both parties before checkout.'
          ],[
            '8. Dispute Resolution',
            'If a buyer or seller believes an order was not fulfilled as agreed, either party may raise a dispute and submit supporting evidence. Our admin team reviews the statements and evidence from both sides before deciding whether to release the escrowed funds to the seller or refund the buyer. This decision is made in good faith and is final.'
          ],] as [$title, $content])
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
        <a href="{{ route('register') }}" class="btn btn-brown px-4">Create Account</a>
        <a href="{{ route('home') }}" class="btn btn-brown-outline px-4 ms-2">Back to Home</a>
      </div>
 
    </div>
  </div>
</div>

@endsection