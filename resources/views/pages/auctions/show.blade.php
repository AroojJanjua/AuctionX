@extends('layouts.app')
@section('title', $auction->title)
@section('content')

<div class="container py-4">
  <div class="row g-4">

  {{-- left side: item info + bid history --}}
  <div class="col-lg-7">

   {{-- Image --}}
    <div style="border-radius:16px;overflow:hidden;margin-bottom:1.2rem;background:var(--br-pale);
                  height:380px;display:flex;align-items:center;justify-content:center;position:relative">
    @if($auction->image)
          <img src="{{ asset('storage/'.$auction->image) }}"
               style="width:100%;height:100%;object-fit:cover" alt="{{ $auction->title }}">
    @else
          <div style="text-align:center">
            @switch($auction->category)
              @case('art')         <i class="bi bi-palette"   style="font-size:5rem;color:var(--br)"></i>    @break
              @case('watches')     <i class="bi bi-watch"     style="font-size:5rem;color:#1A4A8A"></i>    @break
              @case('vehicles')    <i class="bi bi-car-front" style="font-size:5rem;color:var(--green)"></i> @break
              @case('jewelry')     <i class="bi bi-gem"       style="font-size:5rem;color:#E65100"></i>    @break
              @case('collectibles')<i class="bi bi-box"       style="font-size:5rem;color:#7B1FA2"></i>    @break
              @case('electronics')<i class="bi bi-laptop"       style="font-size:5rem;color:#7B1FA2"></i>    @break
              @default             <i class="bi bi-box2-heart"    style="font-size:5rem;color:#1A4A8A"></i>    

            @endswitch
            <div style="font-size:.85rem;color:var(--muted);margin-top:.5rem">No image uploaded</div>
          </div>
    @endif
    {{-- badge --}}
    <div style="position:absolute;top:14px;left:14px">
          <span class="badge rounded-pill badge-timed"><i class="bi bi-clock me-1"></i>Timed</span>
        </div>
    </div>

    {{-- Title --}}
    <h1 style="font-size:1.5rem;font-weight:800;color:var(--br);margin-bottom:.5rem">
        {{ $auction->title }}
      </h1>

    {{-- Detail badges --}}
    <div class="d-flex flex-wrap gap-2 mb-3">
        <span style="background:var(--br-pale);border:1px solid var(--br-soft);border-radius:8px;
                     padding:3px 10px;font-size:.78rem;color:var(--br);font-weight:600">
            <i class="bi bi-collection me-1"></i>{{ $auction->category_label }}
        </span>
        <span style="background:var(--br-pale);border:1px solid var(--br-soft);border-radius:8px;
                     padding:3px 10px;font-size:.78rem;color:var(--br);font-weight:600">
              <i class="bi bi-star me-1"></i>{{ $auction->condition_label }}
        </span>
        <span style="background:var(--br-pale);border:1px solid var(--br-soft);border-radius:8px;
                     padding:3px 10px;font-size:.78rem;color:var(--br);font-weight:600">
              <i class="bi bi-person me-1"></i>{{ $auction->seller->name }}
        </span>
        <span style="background:var(--br-pale);border:1px solid var(--br-soft);border-radius:8px;
                     padding:3px 10px;font-size:.78rem;color:var(--br);font-weight:600">
              <i class="bi bi-clock-history me-1"></i>{{ $auction->duration }}
        </span>
    </div>

    {{-- Description --}}
    <div style="background:#fff;border:1px solid var(--border);border-radius:12px;padding:1.2rem;margin-bottom:1.2rem">
        <div style="font-weight:700;font-size:.88rem;color:var(--br);margin-bottom:.6rem">
          <i class="bi bi-card-text me-1"></i>Description
        </div>
        <p style="font-size:.9rem;color:var(--muted);line-height:1.8;margin:0">{{ $auction->description }}</p>
      </div>
      
    {{-- Schedule --}}
    <div style="background:var(--br-pale);border:1px solid var(--br-soft);
                border-radius:12px;padding:1.1rem;margin-bottom:1.2rem">

        <div style="font-weight:700;font-size:.88rem;color:var(--br);margin-bottom:.8rem">
          <i class="bi bi-calendar-event me-1"></i>Auction Schedule</div>
        
        <div class="row g-2">
          <div class="col-sm-4 text-center">
            <div style="font-size:.88rem;color:var(--muted);text-transform:uppercase;letter-spacing:.4px">Started</div>
            <div style="font-size:.85rem;font-weight:700;color:var(--text)">{{ $auction->starts_at->format('d M Y') }}</div>
            <div style="font-size:.75rem;color:var(--muted)">{{ $auction->starts_at->format('h:i A') }}</div>
          </div>
          <div class="col-sm-4 text-center" style="border-left:1px solid var(--br-soft);border-right:1px solid var(--br-soft)">
            <div style="font-size:.88rem;color:var(--muted);text-transform:uppercase;letter-spacing:.4px">Duration</div>
            <div style="font-size:.85rem;font-weight:700;color:var(--br)">{{ $auction->duration }}</div>
            <div style="font-size:.75rem;color:var(--muted)">{{ $auction->type_label }}</div>
          </div>
          <div class="col-sm-4 text-center">
            <div style="font-size:.88rem;color:var(--muted);text-transform:uppercase;letter-spacing:.4px">Ends</div>
            <div style="font-size:.85rem;font-weight:700;color:var(--text)">{{ $auction->ends_at->format('d M Y') }}</div>
            <div style="font-size:.75rem;color:var(--muted)">{{ $auction->ends_at->format('h:i A') }}</div>
          </div>
        </div>

        @if($auction->snipe_extension_count > 0)
          <div style="margin-top:.7rem;font-size:.78rem;color:var(--red);font-weight:700;text-align:center">
            <i class="bi bi-shield-exclamation me-1"></i>
            Anti-sniping active — timer extended {{ $auction->snipe_extension_count }} {{ Str::plural('time',$auction->snipe_extension_count) }}
          </div>
        @endif
    </div>

    {{-- Bid history table --}}
    <div style="background:#fff;border:1px solid var(--border);border-radius:12px;padding:1.2rem">
    <div style="font-weight:700;font-size:.88rem;color:var(--br);margin-bottom:.8rem">
          <i class="bi bi-list-ol me-1"></i>Bid History
      </div>

    @if($bids->isEmpty())
          <div style="text-align:center;padding:1.5rem;color:var(--muted);font-size:.88rem">
            <i class="bi bi-coin" style="font-size:1.5rem;display:block;margin-bottom:.4rem"></i>
            No bids yet
          </div>
    
    @else
          <div style="overflow-x:auto">
          <table style="width:100%;font-size:.83rem;border-collapse:collapse">
              <thead>
                <tr style="border-bottom:2px solid var(--border)">
                  <th style="padding:6px 8px;text-align:left;color:var(--muted);font-weight:600">#</th>
                  <th style="padding:6px 8px;text-align:left;color:var(--muted);font-weight:600">Bidder</th>
                  <th style="padding:6px 8px;text-align:left;color:var(--muted);font-weight:600">Type</th>
                  <th style="padding:6px 8px;text-align:right;color:var(--muted);font-weight:600">Amount</th>
                  <th style="padding:6px 8px;text-align:right;color:var(--muted);font-weight:600">Time</th>
                </tr>
              </thead>
              <tbody id="bid-history-body">
                @foreach($bids as $i => $bid)
                <tr style="border-bottom:1px solid var(--border);{{ $i===0 ? 'background:var(--br-pale)' : '' }}">
                  <td style="padding:7px 8px;color:var(--muted)">{{ $i+1 }}</td>
                  <td style="padding:7px 8px;font-weight:{{ $i===0?'700':'400' }};color:var(--text)">
                    {{ $bid->bidder->name }}
                    @if($i===0)
                    <span data-leading-badge style="background:var(--green);color:#fff;font-size:.65rem;padding:2px 6px;border-radius:10px;margin-left:4px">Leading</span>
                    @endif</td>
                  <td style="padding:7px 8px">
                    @if($bid->is_auto_bid)
                    <span style="background:#EEEDFE;color:#534AB7;font-size:.65rem;padding:2px 7px;border-radius:10px;font-weight:600">Auto</span>
                    @else
                    <span style="background:var(--br-pale);color:var(--br);font-size:.65rem;padding:2px 7px;border-radius:10px;font-weight:600">Manual</span>
                    @endif</td>
                  <td style="padding:7px 8px;text-align:right;font-weight:700;color:var(--br)">PKR {{ number_format($bid->amount) }}</td>
                  <td style="padding:7px 8px;text-align:right;color:var(--muted)">{{ $bid->created_at->diffForHumans() }}</td>
                  </tr>
                @endforeach
              </tbody>           
          </table>
          </div>

    @endif
    </div>
  </div>

  {{-- right side: bid panel --}}
  <div class="col-lg-5">
      <div style="position:sticky;top:80px">
      
        {{-- Seller Information --}}
      <div style="background:#fff;border:1px solid var(--border);border-radius:14px;padding:1rem;margin-top:.8rem" class="mb-3">
      <div style="font-weight:700;font-size:.83rem;color:var(--br);margin-bottom:.7rem">
        <i class="bi bi-person-badge me-1"></i>Seller</div>
        <div class="d-flex align-items-center gap-2">
          <div style="width:38px;height:38px;border-radius:50%;background:var(--br-pale);
                        border:1px solid var(--br-soft);display:flex;align-items:center;
                        justify-content:center;font-weight:800;color:var(--br);font-size:.95rem">
              {{ strtoupper(substr($auction->seller->name,0,2)) }}
            </div>
            <div>
            <div style="font-weight:700;font-size:.88rem;color:var(--text)">{{ $auction->seller->name }}</div>
            <div style="font-size:.75rem;color:var(--muted)">Member since {{ $auction->seller->created_at->format('M Y') }}</div>
            </div>
        </div>
      </div>

        {{-- Current bid + timer card --}}
        <div style="background:#fff;border:1px solid var(--border);border-radius:16px;padding:1.4rem"
          class="d-flex justify-content-between align-items-start mb-3">
          <div>
              <div style="font-size:.72rem;color:var(--muted);text-transform:uppercase;letter-spacing:.4px">Current Bid</div>
              <div class="bid-amount" id="current-bid">PKR {{ number_format($auction->current_bid) }}</div>
              <div style="font-size:.78rem;color:var(--muted);margin-top:3px">Starting bid: PKR {{ number_format($auction->starting_bid) }}</div>
            </div>

          <div class="text-end">
              @if($auction->starts_at->isFuture())
              <div style="font-size:.72rem;color:var(--muted);margin-bottom:4px">Starts in</div>
              @else
              <div style="font-size:.72rem;color:var(--muted);margin-bottom:4px">Ends in</div>
              @endif              <div class="d-flex gap-1">
                <div class="countdown-unit">
                  <span class="countdown-num" id="show-h">00</span>
                  <span class="countdown-lbl">hrs</span>
                </div>
                <div class="countdown-unit">
                  <span class="countdown-num" id="show-m">00</span>
                  <span class="countdown-lbl">min</span>
                </div>
                <div class="countdown-unit">
                  <span class="countdown-num" id="show-s">00</span>
                  <span class="countdown-lbl">sec</span>
                </div>
              </div>
            </div>
        </div>

        {{-- Smart bid suggestion card  --}}
        @if($auction->status === 'active' && $auction->ends_at->isFuture())
        @php 
          $suggestion=$auction->ai_bid_suggestion; 
        @endphp
        <div style="background:var(--br-pale);border:1.5px solid var(--br-soft);border-radius:14px;
        padding:1.1rem;margin-bottom:1rem">
        {{-- Header --}}
        <div style="margin-bottom:.8rem">
        <div style="font-weight:800; font-size:.9rem; color:var(--br); margin-bottom: 4px;">
        Smart Bid Suggestion</div>

            <div style="display:flex; align-items:center; justify-content:space-between; width:100%">
              <div style="font-size:.72rem; color:var(--muted)" id="suggestion-bids-analyzed">
                    Based on {{ $suggestion['bids_analyzed'] }} {{ Str::plural('bid',$suggestion['bids_analyzed']) }}
              </div>
              <div style="font-size:.72rem; color:var(--muted)">Confidence: 
                  <span id="suggestion-confidence" style="font-weight:700; color:{{ $suggestion['confidence']==='High' ? 'var(--green)' : ($suggestion['confidence']==='Medium' ? '#B45309' : 'var(--muted)') }}"> 
                  {{ $suggestion['confidence'] }}</span>
              </div>
            </div>
        </div>
        <div id="suggestion-card-body">
            @if($suggestion['bids_analyzed'] > 0)

               {{-- Suggested amount --}}
              <div id="suggestion-amount-card" style="background:#fff;border:1px solid var(--br-soft);border-radius:10px;
              padding:.8rem;margin-bottom:.7rem">
                <div style="font-size:.72rem;color:var(--muted);text-transform:uppercase;letter-spacing:.4px;
                margin-bottom:3px">Suggested Winning Bid</div>
                <div id="suggestion-amount" style="font-size:1.6rem;font-weight:800;color:var(--br)">PKR {{ number_format($suggestion['amount']) }}</div>
              </div>

              {{-- Bid button --}}
              <div style="display: flex; justify-content: center; width: 100%; margin-top: 10px;">
              <button type="button" id="use-suggestion-btn"
                      data-amount="{{ $suggestion['amount'] }}"
                      onclick="fillSuggestedBid({{ $suggestion['amount'] }})"
                      style="width:50%;background:var(--br);color:#fff;border:none;border-radius:9px;
                      padding:.6rem;font-size:.85rem;font-weight:700;cursor:pointer;"> Select
              </button></div>

              @else
              <div style="font-size:.83rem;color:var(--muted);text-align:center;padding:.5rem">
                <i class="bi bi-info-circle me-1" style="color:var(--br)"></i>
                Suggestion will appear after the first bid is placed
              </div>             
            @endif    
        </div>
        </div>
        @endif

        {{-- Bid form — manual bid + auto-bid option --}}
      @if($auction->status === 'active' && $auction->starts_at->isPast() && $auction->ends_at->isFuture())
          @auth
          @if(auth()->user()->id !== $auction->seller_id)
          <div style="background:#fff;border:1px solid var(--border);border-radius:16px;padding:1.4rem;margin-bottom:1rem">
                <form method="POST" action="{{ route('auctions.bid', $auction->id) }}" id="bidForm" novalidate>
                @csrf

                {{-- Validation error --}}
                  @if($errors->any())
                    <div style="background:var(--red-bg);border:1px solid var(--red-bd);border-radius:8px;
                                padding:.7rem .9rem;margin-bottom:.9rem;font-size:.82rem;color:var(--red)">
                      <i class="bi bi-exclamation-circle me-1"></i>
                      {{ $errors->first() }}
                    </div>
                  @endif

                  {{-- Bid amount --}}
                <div style="margin-bottom:1rem">                   
                     <div style="display:flex; align-items:center; justify-content:space-between; width:100%">
                      
                      <div><label class="form-label-ax"> Your Bid</label></div>
                      <span id="min-next-bid-label" style="font-size:.75rem;color:var(--muted);font-weight:400; margin-bottom:2px">
                         minimum PKR {{ number_format($auction->min_next_bid) }}
                      </span>
                    </div>
                    
                    <div style="position:relative">
                      <span style="position:absolute;left:10px;top:50%;transform:translateY(-50%);
                                   color:var(--muted);font-size:.8rem">PKR </span>
                      <input type="number"
                             id="bid_amount"
                             name="bid_amount"
                             class="form-control-ax"
                             style="padding-left:40px"
                             placeholder="{{ number_format( (int) $auction->min_next_bid) }}"
                             min="{{ (int) $auction->min_next_bid }}"
                             data-min="{{ (int) $auction->min_next_bid }}"
                             step="1"
                             value="{{ old('bid_amount') }}"
                             required/>
                    </div>
                  </div>

                  {{-- Auto-bid section --}}
                <div style="background:var(--br-pale);border:1px solid var(--br-soft);
                               border-radius:10px;padding:1rem;margin-bottom:1rem">
                      <div style="display:flex;align-items:center;gap:8px;margin-bottom:6px">
                      <input type="checkbox"
                             id="enable_auto_bid"
                             style="accent-color:var(--br);width:16px;height:16px;cursor:pointer"
                             onchange="toggleAutoBid(this)">
                      <label for="enable_auto_bid"
                             style="font-weight:700;font-size:.88rem;color:var(--br);cursor:pointer;margin:0">
                             Enable Auto-Bid<span style="font-size:.88rem;color:var(--muted);font-weight:400; margin-bottom:2px"> (optional)</span>
                      </label>
                    </div>

                    {{-- Max auto-bid input(hidden until checkbox checked) --}}
                    <div id="auto_bid_field" style="display:none">
                      <label class="form-label-ax">
                        Your Maximum Limit
                        <span style="font-size:.73rem;color:var(--muted);font-weight:400">— must be ≥ your bid</span>
                      </label>

                      <div style="position:relative">
                        <span style="position:absolute;left:10px;top:50%;transform:translateY(-50%);
                                     color:var(--muted);font-size:.9rem">PKR </span>
                        <input type="number"
                               id="max_auto_bid"
                               name="max_auto_bid"
                               class="form-control-ax"
                               style="padding-left:40px"
                               placeholder="enter maximum limit"
                               min="{{ (int) $auction->min_next_bid }}"
                               data-min="{{ (int) $auction->min_next_bid }}"
                               step="1"
                               value="{{ old('max_auto_bid') }}"
                               disabled/>
                      </div>
                    </div>             
                </div>

                {{-- Submit --}}
                <div class="text-center mb-2">
                <button type="submit" class="btn btn-brown btn-lg w-50">Place Bid</button>
                </div>
                </form>
          </div>             
          @else
              <div style="background:var(--br-pale);border:1px solid var(--br-soft);
                          border-radius:12px;padding:1rem;text-align:center;margin-bottom:1rem">
                <i class="bi bi-info-circle me-1" style="color:var(--br)"></i>
                <span style="font-size:.85rem;color:var(--muted)">You cannot bid on your own auction.</span>
              </div>
          @endif

          @else
              {{-- for guest  --}}
              <div style="background:#fff;border:1px solid var(--border);border-radius:16px;
                        padding:1.4rem;text-align:center;margin-bottom:1rem">
              <i class="bi bi-lock" style="font-size:1.8rem;color:var(--br);display:block;margin-bottom:.5rem"></i>
              <div style="font-weight:700;font-size:.92rem;color:var(--br);margin-bottom:.3rem">Login to Place a Bid</div>
              <div style="font-size:.8rem;color:var(--muted);margin-bottom:1rem">
                You need an account to participate in auctions.
              </div>
              <div class="d-flex justify-content-center gap-2 mb-2">
              <a href="{{ route('login') }}" class="btn btn-brown w-50">Sign In</a>
              <a href="{{ route('register') }}" class="btn btn-ghost-ax w-50 btn">Create Account</a>
              </div>
            </div>
          @endauth

           @elseif($auction->status === 'closed')
           <div style="background:var(--br-pale);border:1px solid var(--br-soft);
                      border-radius:14px;padding:1.3rem;text-align:center;margin-bottom:1rem">
            <i class="bi bi-trophy" style="font-size:2rem;color:var(--br);display:block;margin-bottom:.5rem"></i>
            <div style="font-weight:800;font-size:.95rem;color:var(--br);margin-bottom:.3rem">Auction Ended</div>
            @if($auction->winner)
              <div style="font-size:.83rem;color:var(--muted)">
                Won by <strong>{{ $auction->winner->name }}</strong>
                for <strong>PKR {{ number_format($auction->current_bid) }}</strong>
              </div>
            @else
              <div style="font-size:.83rem;color:var(--muted)">No winner declared</div>
            @endif
          </div>

      @endif

      </div>
    </div> 
  </div>
</div>
@endsection
@push('scripts')
<script>

let auctionEndsAt={{ $auction->ends_at->timestamp }} * 1000;
const auctionStartsAt={{ $auction->starts_at->timestamp }} * 1000;
let auctionClosed=false;

document.addEventListener('DOMContentLoaded',function(){
  function tick(){
    if(auctionClosed){
        document.getElementById('show-h').textContent='00';
        document.getElementById('show-m').textContent='00';
        document.getElementById('show-s').textContent='00';
        return;
    }
    const now=Date.now();
    const notStarted=now < auctionStartsAt;
    const target=notStarted ? auctionStartsAt : auctionEndsAt;
    const diff=Math.max(0, Math.floor((target - now) / 1000));
    const h=Math.floor(diff / 3600);
    const m=Math.floor((diff % 3600) / 60);
    const s=diff % 60;

    document.getElementById('show-h').textContent=String(h).padStart(2,'0');
    document.getElementById('show-m').textContent=String(m).padStart(2,'0');
    document.getElementById('show-s').textContent=String(s).padStart(2,'0');

    if(diff <= 0){
      setTimeout(() => location.reload(),1000);
      return;
    }
       setTimeout(tick,1000);
      }
      tick();       

  //Live bid updates via Pusher
  if(typeof AuctionXSocket === 'undefined') return;

  const auctionId={{ $auction->id }};
  const channel=AuctionXSocket.subscribe('auction.' + auctionId);

  channel.bind('bid.placed',function(pushData){
    refreshAuctionState();

    if(pushData.sniped){
      const banner=document.createElement('div');
      banner.className='alert alert-warning mt-2';
      banner.textContent='Anti-sniping protection activated — auction timer extended by 2 minutes!';
      const col=document.querySelector('.col-lg-7');
      if(col) 
        col.prepend(banner);
      setTimeout(function(){ banner.remove(); }, 6000);
    }
  });

  // Live auction close
   channel.bind('auction.status-changed',function(data){
    if(data.status === 'closed'){

    // Stop the countdown
    auctionClosed=true;

      // Hide the bid form and smart suggestion card
      const bidForm=document.getElementById('bidForm');
      const suggCard=document.getElementById('suggestion-card-body');
      if(bidForm)   
        bidForm.closest('div[style]').style.display='none';
      if(suggCard)  
        suggCard.closest('div[style]').style.display='none';

      // Replace the right-hand action column with an "Auction Ended" panel
      const actionCol=document.querySelector('.col-lg-5');
      if(actionCol){
        const winnerLine=data.winnerName 
          ? 'Won by <strong>' + data.winnerName + '</strong>'
          : 'No winner declared';

        const panel=document.createElement('div');
        panel.style.cssText='background:var(--br-pale);border:1px solid var(--br-soft);border-radius:14px;padding:1.3rem;text-align:center;margin-bottom:1rem';
        panel.innerHTML=
          '<i class="bi bi-trophy" style="font-size:2rem;color:var(--br);display:block;margin-bottom:.5rem"></i>' +
          '<div style="font-weight:800;font-size:.95rem;color:var(--br);margin-bottom:.3rem">Auction Ended</div>' +
          '<div style="font-size:.83rem;color:var(--muted)">' + winnerLine + '</div>';

        // insert panel at top
        actionCol.prepend(panel);
      }
    }

    if(data.status === 'active'){
      location.reload();
    }
  });
 
  function refreshAuctionState(){
    fetch('/auctions/' + auctionId + '/live-data')
      .then(function(res){ return res.json(); })
      .then(function(data){

        //Current bid price
        const priceEl=document.getElementById('current-bid');
        if(priceEl){
          priceEl.textContent='PKR ' + Number(data.currentBid).toLocaleString();
          priceEl.style.transition='color .2s';
          priceEl.style.color='var(--br)';
          setTimeout(function(){ priceEl.style.color = ''; },800);
        }

        //Sync countdown target in case anti-snipe extended ends_at
        const newEndsAt=new Date(data.endsAt).getTime();
        if(newEndsAt !== auctionEndsAt){
          auctionEndsAt=newEndsAt;
        }

        //Rebuild the ENTIRE bid history table from real server data
        const tbody=document.getElementById('bid-history-body');
        if(tbody && Array.isArray(data.bids)){
          tbody.innerHTML=data.bids.map(function(bid,i){
            const isLeading = i === 0;
            return '<tr style="border-bottom:1px solid var(--border);' + (isLeading ? 'background:var(--br-pale)' : '') + '">' +
              '<td style="padding:7px 8px;color:var(--muted)">' + (i + 1) + '</td>' +
              '<td style="padding:7px 8px;font-weight:' + (isLeading ? '700' : '400') + ';color:var(--text)">' +
                bid.bidderName +
                (isLeading ? ' <span style="background:var(--green);color:#fff;font-size:.65rem;padding:2px 6px;border-radius:10px;margin-left:4px">Leading</span>' : '') +
              '</td>' +
              '<td style="padding:7px 8px">' +
                (bid.isAutoBid
                  ? '<span style="background:#EEEDFE;color:#534AB7;font-size:.65rem;padding:2px 7px;border-radius:10px;font-weight:600">Auto</span>'
                  : '<span style="background:var(--br-pale);color:var(--br);font-size:.65rem;padding:2px 7px;border-radius:10px;font-weight:600">Manual</span>'
                ) +
              '</td>' +
              '<td style="padding:7px 8px;text-align:right;font-weight:700;color:var(--br)">PKR ' + Number(bid.amount).toLocaleString() + '</td>' +
              '<td style="padding:7px 8px;text-align:right;color:var(--muted)">' + bid.timeAgo + '</td>' +
            '</tr>';
          }).join('');
        }

        //Minimum next bid, update label + form input constraints
        const minLabel=document.getElementById('min-next-bid-label');
        if(minLabel) 
          minLabel.textContent='minimum PKR ' + Number(data.minNextBid).toLocaleString();

        const bidInput=document.getElementById('bid_amount');
        if(bidInput){
          bidInput.min=data.minNextBid;
          bidInput.dataset.min=data.minNextBid;
          bidInput.placeholder=Number(data.minNextBid).toLocaleString();
        }

        const maxAutoInput=document.getElementById('max_auto_bid');
        if(maxAutoInput){
          maxAutoInput.min=data.minNextBid;
          maxAutoInput.dataset.min=data.minNextBid;
        }

        //Smart bid suggestion card
        if(data.suggestion){
          const analyzedEl=document.getElementById('suggestion-bids-analyzed');
          if(analyzedEl){
            analyzedEl.textContent='Based on ' + data.suggestion.bids_analyzed +
              (data.suggestion.bids_analyzed === 1 ? ' bid' : ' bids');
          }

          const confEl=document.getElementById('suggestion-confidence');
          if(confEl){
            confEl.textContent=data.suggestion.confidence;
            confEl.style.color=data.suggestion.confidence === 'High' ? 'var(--green)'
              : (data.suggestion.confidence === 'Medium' ? '#B45309' : 'var(--muted)');
          }

          // Body amount card
          const bodyEl=document.getElementById('suggestion-card-body');
          if(bodyEl){
            if(data.suggestion.bids_analyzed > 0){
              bodyEl.innerHTML=
                '<div id="suggestion-amount-card" style="background:#fff;border:1px solid var(--br-soft);border-radius:10px;padding:.8rem;margin-bottom:.7rem">' +
                  '<div style="font-size:.72rem;color:var(--muted);text-transform:uppercase;letter-spacing:.4px;margin-bottom:3px">Suggested Winning Bid</div>' +
                  '<div id="suggestion-amount" style="font-size:1.6rem;font-weight:800;color:var(--br)">PKR ' + Number(data.suggestion.amount).toLocaleString() + '</div>' +
                '</div>' +
                '<div style="display:flex;justify-content:center;width:100%;margin-top:10px">' +
                  '<button type="button" id="use-suggestion-btn" data-amount="' + data.suggestion.amount + '" ' +
                  'onclick="fillSuggestedBid(' + data.suggestion.amount + ')" ' +
                  'style="width:50%;background:var(--br);color:#fff;border:none;border-radius:9px;padding:.6rem;font-size:.85rem;font-weight:700;cursor:pointer"> Select</button>' +
                '</div>';
            }else{
              bodyEl.innerHTML=
                '<div style="font-size:.83rem;color:var(--muted);text-align:center;padding:.5rem">' +
                  '<i class="bi bi-info-circle me-1" style="color:var(--br)"></i>' +
                  'Suggestion will appear after the first bid is placed' +
                '</div>';
            }
          }
        }
      })
      .catch(function(err){
        console.error('[AuctionX] Failed to refresh live auction state:', err);
      });
  }

  // If admin deletes THIS auction while someone is viewing it, send them away
  var feedCh = AuctionXSocket.subscribe('auctions.feed');
  feedCh.bind('auction.deleted', function(data){
    if(parseInt(data.auctionId) !== auctionId) return;

    // Show a brief notice then redirect to the auctions list
    var overlay = document.createElement('div');
    overlay.style.cssText = 'position:fixed;inset:0;background:rgba(0,0,0,.6);z-index:9999;' +
      'display:flex;align-items:center;justify-content:center';
    overlay.innerHTML =
      '<div style="background:#fff;border-radius:14px;padding:2rem;text-align:center;max-width:340px">' +
        '<i class="bi bi-trash" style="font-size:2rem;color:var(--red);display:block;margin-bottom:.6rem"></i>' +
        '<div style="font-weight:700;font-size:1rem;margin-bottom:.4rem">Auction Removed</div>' +
        '<div style="color:var(--muted);font-size:.85rem">This auction has been removed by the admin. Redirecting you now…</div>' +
      '</div>';
    document.body.appendChild(overlay);
    setTimeout(function(){ window.location.href = '/auctions'; }, 2500);
  });
});

    // Auto-bid toggle
  function toggleAutoBid(checkbox){
  const field=document.getElementById('auto_bid_field');
  const input=document.getElementById('max_auto_bid');
 
  if(checkbox.checked){
    field.style.display='block';
    input.disabled=false;

    const bidAmt=parseInt(document.getElementById('bid_amount').value);
    if(!isNaN(bidAmt) && !input.value){
      const increment=Math.max(10, Math.floor(bidAmt * 0.01)); 
      input.value=bidAmt + increment; // suggest just one step above bid
    }
  }else{
    field.style.display='none';
    input.disabled=true;
    input.value='';
  }
}

    // Fill bid from smart bid suggestion
  function fillSuggestedBid(amount){
  const bidInput=document.getElementById('bid_amount');
  if(bidInput){
    bidInput.value=amount;

    // Smooth scroll to bid form
    bidInput.scrollIntoView({ behavior: 'smooth',block: 'center' });

    // Pulse highlight
    bidInput.style.transition='border-color .3s';
    bidInput.style.borderColor='var(--br)';
    setTimeout(() => bidInput.style.borderColor = '', 2000);
  }
}

</script>
@endpush