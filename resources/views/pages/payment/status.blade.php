@extends('layouts.app')
@section('title','Payment Status')
@section('content')

<div class="page-header">
  <div class="container">
    <h2>Payment Status</h2>
    <p>{{ $auction->title }}</p>
  </div>
</div>

<div class="container py-4" style="max-width:640px">

  @php
    $statusMap=[
      'pending'   => ['label'=>'Awaiting Payment', 'class'=>'badge-drafted', 'icon'=>'bi-clock',                 'color'=>'#795548'],
      'submitted' => ['label'=>'Proof Submitted',  'class'=>'badge-drafted', 'icon'=>'bi-hourglass-split',       'color'=>'#0C447C'],
      'held'      => ['label'=>'Confirmed',        'class'=>'badge-drafted', 'icon'=>'bi-shield-lock-fill',      'color'=>'#0C447C'],
      'shipped'   => ['label'=>'Shipped',          'class'=>'badge-timed',   'icon'=>'bi-truck',                 'color'=>'var(--green)'],
      'received'  => ['label'=>'Received by Buyer','class'=>'badge-timed',   'icon'=>'bi-box-seam-fill',         'color'=>'var(--green)'],
      'released'  => ['label'=>'Payment Released', 'class'=>'badge-timed',   'icon'=>'bi-check-circle-fill',     'color'=>'var(--green)'],
      'refunded'  => ['label'=>'Refunded',         'class'=>'badge-closed',  'icon'=>'bi-arrow-counterclockwise','color'=>'var(--red)'],
      'disputed'  => ['label'=>'Under Dispute',    'class'=>'badge-closed',  'icon'=>'bi-flag-fill',             'color'=>'var(--red)'],
    ];
    $s=$statusMap[$payment->status] ?? $statusMap['pending'];
  @endphp

  {{-- Status header --}}
  <div style="background:#fff;border:1px solid var(--border);border-radius:16px;padding:2rem;text-align:center;margin-bottom:1.5rem">
    <i class="bi {{ $s['icon'] }}" style="font-size:2.5rem;color:{{ $s['color'] }};display:block;margin-bottom:.8rem"></i>
    <span class="badge rounded-pill {{ $s['class'] }}" style="font-size:.85rem;padding:5px 14px;margin-bottom:.8rem;display:inline-block">
      {{ $s['label'] }}
    </span>
    <div style="font-size:.85rem;color:var(--muted);margin-top:.5rem">
      @if($payment->isPending())       payment is not submitted yet.
      @elseif($payment->isSubmitted()) Your proof is under review. Admin will confirm within 24 hours.
      @elseif($payment->isHeld())      Payment confirmed. Waiting for seller to ship the item.
      @elseif($payment->isShipped())   Item is on its way. Confirm receipt once it arrives.
      @elseif($payment->isReleased())  Payment was released to the seller on {{ $payment->released_at->format('M d, Y') }}.
      @elseif($payment->isRefunded())  Refund was processed on {{ $payment->refunded_at->format('M d, Y') }}.
      @elseif($payment->isDisputed())  Dispute is under review. Admin will resolve it within 48 hours.
      @endif
    </div>
  </div>

  {{-- Progress steps --}}
  @php
    $steps=[
      ['label'=>'Payment Submitted', 'done'=>!$payment->isPending()],
      ['label'=>'Admin Confirmed',   'done'=>in_array($payment->status,['held','shipped','received','released'])],
      ['label'=>'Item Shipped',      'done'=>in_array($payment->status,['shipped','received','released'])],
      ['label'=>'Buyer Received',    'done'=>in_array($payment->status,['received','released'])],
      ['label'=>'Released',          'done'=>$payment->isReleased()],
    ];
  @endphp
  <div class="d-flex align-items-center mb-4" style="padding:0 .5rem">
    @foreach($steps as $i => $step)
      <div class="d-flex flex-column align-items-center" style="flex:1">
        <div style="width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;
        font-size:.75rem;font-weight:700;background:{{ $step['done'] ? 'var(--green)':'var(--border)' }};
        color:{{ $step['done'] ? '#fff':'var(--muted)'}}">
        @if($step['done'])<i class="bi bi-check2"></i>
        @else{{ $i+1 }}
        @endif
        </div>
        <div style="font-size:.62rem;color:{{ $step['done'] ? 'var(--green)':'var(--muted)' }};margin-top:4px;text-align:center;line-height:1.2">
        {{ $step['label'] }}
        </div>
      </div>
      @if(!$loop->last)
        <div style="flex:1;height:2px;margin-bottom:18px;background:{{ $step['done'] ? 'var(--green)' : 'var(--border)' }}"></div>
      @endif
    @endforeach
  </div>

  {{-- Payment details --}}
  <div style="background:#fff;border:1px solid var(--border);border-radius:16px;padding:1.5rem;margin-bottom:1.5rem">
    <div style="font-weight:700;margin-bottom:1rem">Payment Details</div>

    <div class="d-flex justify-content-between mb-2" style="font-size:.88rem">
      <span style="color:var(--muted)">Amount paid</span>
      <span style="font-weight:700">PKR {{ number_format($payment->amount) }}</span>
    </div>
    <div class="d-flex justify-content-between mb-2" style="font-size:.88rem">
      <span style="color:var(--muted)">Platform fee(5%)</span>
      <span>PKR {{ number_format($payment->platform_fee) }}</span>
    </div>
    <div class="d-flex justify-content-between mb-2" style="font-size:.88rem">
      <span style="color:var(--muted)">Seller receives</span>
      <span style="font-weight:700;color:var(--green)">PKR {{ number_format($payment->seller_amount) }}</span>
    </div>

    @if($payment->payment_method)
    <div class="d-flex justify-content-between mb-2" style="font-size:.88rem">
      <span style="color:var(--muted)">Payment method</span>
      <span style="font-weight:700">{{ $payment->methodLabel() }}</span>
    </div>
    @endif

    @if($payment->transaction_id)
    <div class="d-flex justify-content-between mb-2" style="font-size:.88rem">
      <span style="color:var(--muted)">Transaction ID</span>
      <span style="font-size:.82rem">{{ $payment->transaction_id }}</span>
    </div>
    @endif

    @if($payment->submitted_at)
    <div class="d-flex justify-content-between mb-2" style="font-size:.88rem">
      <span style="color:var(--muted)">Submitted</span>
      <span>{{ $payment->submitted_at->format('M d, Y H:i') }}</span>
    </div>
    @endif

    @if($payment->paid_at)
    <div class="d-flex justify-content-between mb-2" style="font-size:.88rem">
      <span style="color:var(--muted)">Confirmed</span>
      <span>{{ $payment->paid_at->format('M d, Y H:i') }}</span>
    </div>
    @endif

    @if($payment->shipped_at)
    <hr style="border-color:var(--border)">
    <div style="font-weight:700;font-size:.85rem;margin-bottom:.5rem">Shipping Info</div>
    <div class="d-flex justify-content-between mb-2" style="font-size:.88rem">
      <span style="color:var(--muted)">Courier</span>
      <span style="font-weight:600">{{ $payment->courier_name }}</span>
    </div>
    @if($payment->tracking_number)
    <div class="d-flex justify-content-between mb-2" style="font-size:.88rem">
      <span style="color:var(--muted)">Tracking #</span>
      <span style="font-size:.82rem">{{ $payment->tracking_number }}</span>
    </div>
    @endif
    <div class="d-flex justify-content-between mb-2" style="font-size:.88rem">
      <span style="color:var(--muted)">Shipped on</span>
      <span>{{ $payment->shipped_at->format('M d, Y H:i') }}</span>
    </div>

    {{-- notes --}}
    @if($payment->seller_note)
    <div style="margin-top:1rem;padding:.10rem;border-radius:8px;font-size:.83rem;color:var(--muted)">
      <strong>Seller note:</strong> {{ $payment->seller_note }}
    </div>
    @endif
    @endif

    @if($payment->admin_note)
    <div style="padding:.10rem;border-radius:8px;font-size:.83rem;color:var(--muted)">
      <strong>Admin note:</strong> {{ $payment->admin_note }}
    </div>
    @endif

    @if($payment->buyer_note)
    <div style="padding:.10rem;border-radius:8px;font-size:.83rem;color:var(--muted)">
      <strong>Buyer note:</strong> {{ $payment->buyer_note }}
    </div>
    @endif

    @if($payment->proof_image)
    <div style="margin-top:1rem">
      <div style="font-size:.82rem;color:var(--muted);margin-bottom:.4rem">Payment screenshot:</div>
      <img src="{{ Storage::url($payment->proof_image) }}" alt="Payment proof"
           style="max-width:100%;border-radius:10px;border:1px solid var(--border);max-height:280px;object-fit:contain">
    </div>
    @endif
  </div>

  {{-- Buyer confirm receipt --}}
  @if($payment->isShipped() && auth()->id() === $payment->buyer_id)
  <div style="background:#E1F5EE;border:1px solid #A8DFC9;border-radius:16px;padding:1.5rem;margin-bottom:1.5rem;text-align:center">
    <div style="font-weight:700;margin-bottom:.3rem">Did you receive your item?</div>
    <div style="font-size:.83rem;color:var(--muted);margin-bottom:1rem">
      Confirm only after you have received the item in good condition.<br>
      This will automatically release the payment to the seller.
    </div>
    <form method="POST" action="{{ route('payment.confirm-receipt', $payment->id) }}">
      @csrf
      <button class="btn btn-green py-2 px-3" style="font-weight:600"
        onclick="return confirm('Confirm that you received the item? This will release the payment to the seller.')">
        <i class="bi bi-check-circle me-2"></i>Received
      </button>
    </form>
  </div>
  @endif

  {{-- Dispute, buyer and seller each have their own statement --}}
  @if($payment->isDisputed() && (auth()->id() === $payment->buyer_id || auth()->id() === $payment->seller_id))
  @php 
  $myRole=$payment->roleOf(auth()->id()); 
  @endphp
  <div style="background:#FFF5F5;border:1px solid var(--red-bd);border-radius:16px;padding:1.5rem;margin-bottom:1.5rem">
    <div style="font-weight:700;margin-bottom:.2rem;color:var(--red)">Dispute Under Review</div>
    <div style="font-size:.83rem;color:var(--muted);margin-bottom:1rem">
      Our admin team will review both statements and resolve this within 48 hours.
    </div>

    {{-- buyer statement --}}
    <div style="background:#fff;border:1px solid var(--border);border-radius:10px;padding:1rem;margin-bottom:.8rem">
      <div style="font-weight:700;font-size:.85rem;margin-bottom:.4rem">Buyer's Statement</div>
      @if($payment->buyer_statement)
        <div style="font-size:.85rem;color:var(--text);margin-bottom:.5rem">{{ $payment->buyer_statement }}</div>
        <div style="font-size:.72rem;color:var(--muted)">Submitted {{ $payment->buyer_statement_at?->format('M d, Y g:ia') }}</div>
        @if($payment->buyer_statement_evidence)
          <img src="{{ Storage::url($payment->buyer_statement_evidence) }}" alt="Buyer evidence"
            style="max-width:100%;max-height:150px;border-radius:8px;margin-top:.6rem">
        @endif
      @elseif($myRole === 'buyer')
      <form method="POST" action="{{ route('payment.dispute', $payment->id) }}" enctype="multipart/form-data">
      @csrf
      <textarea name="statement" class="form-control-ax mb-2" rows="3" placeholder="Explain your side clearly..." 
      required style="resize:none"></textarea>
    
    {{-- Evidence --}}
      <div class="mb-2">
        <div onclick="document.getElementById('evidence').click()"
        style="border:2px dashed var(--border);border-radius:10px;padding:1.2rem;text-align:center;cursor:pointer">
          <i class="bi bi-cloud-upload" style="font-size:1.6rem;color:var(--muted);display:block;margin-bottom:.3rem"></i>
          <div id="evidence-text" style="font-size:.8rem;color:var(--muted)">Upload evidence image</div>
          <img id="evidence-preview" src="" alt="" style="display:none;max-width:100%;border-radius:8px;margin-top:.8rem">
        </div>
          <input type="file" id="evidence" name="evidence" accept="image/jpeg,image/png" style="display:none" onchange="previewEvidence(this)">
        </div>  
          <button class="btn btn-brown btn-sm py-2 px-6">Submit</button>    
        </form>
        @else
        <div style="font-size:.83rem;color:var(--muted);font-style:italic">Waiting for the buyer to submit their statement…</div>
        @endif
      </div>

    {{-- seller statement --}}
    <div style="background:#fff;border:1px solid var(--border);border-radius:10px;padding:1rem">
      <div style="font-weight:700;font-size:.85rem;margin-bottom:.4rem">Seller's Statement</div>
      @if($payment->seller_statement)
        <div style="font-size:.85rem;color:var(--text);margin-bottom:.5rem">{{ $payment->seller_statement }}</div>
        <div style="font-size:.72rem;color:var(--muted)">Submitted {{ $payment->seller_statement_at?->format('M d, Y g:ia') }}</div>
        @if($payment->seller_statement_evidence)
          <img src="{{ Storage::url($payment->seller_statement_evidence) }}" alt="Seller evidence"
          style="max-width:100%;max-height:200px;border-radius:8px;margin-top:.6rem">
        @endif
      @elseif($myRole === 'seller')
        <form method="POST" action="{{ route('payment.dispute', $payment->id) }}" enctype="multipart/form-data">
        @csrf
      <textarea name="statement" class="form-control-ax mb-2" rows="3" placeholder="Explain your side clearly..."
      required style="resize:none"></textarea>

      {{-- Evidence --}}
      <div class="mb-2">
        <div onclick="document.getElementById('evidence').click()" style="border:2px dashed var(--border);
        border-radius:10px;padding:1.2rem;text-align:center;cursor:pointer">
        <i class="bi bi-cloud-upload" style="font-size:1.6rem;color:var(--muted);display:block;margin-bottom:.3rem"></i>
        <div id="evidence-text" style="font-size:.8rem;color:var(--muted)">Upload evidence image</div>
        <img id="evidence-preview" src="" alt="" style="display:none;max-width:100%;border-radius:8px;margin-top:.8rem">
      </div>
      <input type="file" id="evidence" name="evidence" accept="image/jpeg,image/png" style="display:none" onchange="previewEvidence(this)">
    </div>
       <button class="btn btn-brown btn-sm py-2 px-5">Submit</button>
    </form>
      @else
        <div style="font-size:.83rem;color:var(--muted);font-style:italic">Waiting for the seller to submit their statement…</div>
      @endif
    </div>
  </div>
  @endif

  {{-- dispute --}}
  @if(in_array($payment->status,['held','shipped']) && (auth()->id() === $payment->buyer_id || auth()->id() === $payment->seller_id))
  <div style="background:#fff;border:1px solid var(--border);border-radius:16px;padding:1.5rem">
    <div style="font-weight:700;margin-bottom:.4rem">Raise a Dispute</div>
    <div style="font-size:.83rem;color:var(--muted);margin-bottom:1rem">
      if something wrong then raise a dispute and our admin team will investigate within 48 hours.
    </div>
    <form method="POST" action="{{ route('payment.dispute', $payment->id) }}" enctype="multipart/form-data">
      @csrf
      <div class="mb-3">
        <textarea name="statement" class="form-control-ax" rows="3"
          placeholder="Describe the issue clearly…" required style="resize:none"></textarea>
      </div>
      <div class="mb-3">
      <label class="form-label-ax"> Evidence <span style="color:var(--muted)">(optional)</span></label>

    <div style="border:2px dashed var(--border);border-radius:10px;
    padding:1.5rem;text-align:center;cursor:pointer;transition:border-color .2s" 
    onclick="document.getElementById('evidence').click()">

      <i class="bi bi-cloud-upload" style="font-size:1.8rem;color:var(--muted);display:block;margin-bottom:.4rem"></i>
      <div id="evidence-text" style="font-size:.85rem;color:var(--muted)">Upload evidence image here</div>
      <img id="evidence-preview" src="" alt="" style="display:none;max-width:100%;border-radius:8px;margin-top:.8rem">
    </div>

    <input type="file" id="evidence" name="evidence" accept="image/jpeg,image/png" style="display:none" 
    onchange="previewEvidence(this)"> 
    </div>
    <button class="btn btn-brown">Raise Dispute</button>
    </form>
  </div>
  @endif
</div>

@push('scripts')
<script>
  function previewEvidence(input){ 
    if(input.files && input.files[0]){ 
      const file=input.files[0]; 
      document.getElementById('evidence-text').textContent=file.name;
       const preview=document.getElementById('evidence-preview');
        preview.src=URL.createObjectURL(file); 
        preview.style.display='block';
       }
    } 
</script>
@endpush
@endsection