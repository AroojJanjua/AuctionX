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
        @foreach([
           ['Information We Collect','bi-collection',
            'When you create an AuctionX account, we collect information such as your name, email address, 
            phone number, password, biography, and address. Sellers may also be required to provide payout 
            information, including their preferred payout method and relevant account details, to enable us 
            to process and disburse funds owed to them following a completed sale.
            As you use AuctionX, we may also collect information related to your activity on the platform, 
            including auctions you create, bids you place, orders you complete, and, where applicable, 
            statements, or evidence you submit in connection with a dispute.',
          ],['How We Use Your Information','bi-gear',
            'We use the information we collect to operate and maintain your account, manage bids and auctions, 
            process orders and payments, hold funds in escrow, and release or refund payments once an order is 
            confirmed or a dispute is resolved. We also use this information to send transactional communications,
            including outbid notifications, order updates, and dispute-related correspondence, and to verify sellers
            before processing payouts. When a dispute arises between a buyer and seller, we review the statements and
            evidence provided by both parties to investigate the matter and reach a fair resolution.'          
          ],['Payments and Escrow','bi-phone',
            'Payments on AuctionX are processed through JazzCash or EasyPaisa. We retain only the transaction ID, 
            sender number, and any proof of payment you provide for transaction verification. We never request or 
            store your mobile wallet password or PIN. Once a payment is received, the funds are held in escrow 
            and are not immediately released to the seller. The funds are released after the buyer confirms 
            receipt of the item, at which time AuctionX deducts a 5% platform fee from the sale amount. If a 
            dispute is raised before the payment is released, any statements and evidence submitted by either 
            party are accessible only to the buyer, the seller, and authorized members of the AuctionX 
            administration team responsible for reviewing the dispute.',
          ],['How We Share Information','bi-people',
           'We do not sell your personal information or share it beyond what is necessary to facilitate a 
           transaction. Buyers and sellers are provided only with the information required to complete and manage 
           an order. To support real-time bidding, AuctionX uses Pusher, a third-party service that receives 
           auction and bid-related data but not your personal information. We may also disclose information when 
           required by law or when reasonably necessary to protect the rights, property, security, or safety of 
           AuctionX, and our users.',          
           ],['Account Security','bi-lock',
           'We take reasonable measures to protect your account and personal information. Your password is never 
           stored in plain text and is securely hashed using bcrypt before being stored in our database. You are 
           also responsible for keeping your login credentials confidential and should notify us promptly if you 
           become aware of any unauthorized activity on your account.',          
           ],['Cookies','bi-cookie',
            'AuctionX uses cookies only to keep you signed in and to maintain your session. We do not use cookies 
            for advertising, and we do not share cookie data with third-party trackers.',
           ],['Your Rights','bi-person-check',
            'You can view and update most of your personal information at any time through your Profile settings. 
            If you would like to access a copy of your personal data or request the deletion of your account and 
            personal information, please contact our support team. We will review and process your request in 
            accordance with applicable requirements.',
           ],['Contact Us','bi-envelope',
             'If anything in this Policy is unclear, or you have questions about how your data is handled, you 
             may reach us through our Support page.',
           ],
        ] as [$title, $icon, $content])
        <div style="margin-bottom:1.5rem">
          <div style="display:flex;align-items:center;gap:8px;font-weight:700;font-size:.98rem;color:var(--br);margin-bottom:.5rem">
            <i class="bi {{ $icon }}" style="font-size:1.05rem"></i>
            {{ $title }}
          </div>
          <p style="font-size:.88rem;color:var(--muted);line-height:1.75;margin:0">{{ $content }}</p>
        </div>
        @endforeach

      </div>

      <div class="text-center mt-4">
        <a href="{{ route('contact') }}" class="btn btn-brown px-4">Contact Us</a>
        <a href="{{ route('home') }}" class="btn btn-brown-outline px-4 ms-2">Back to Home</a>
      </div>

    </div>
  </div>
</div>

@endsection