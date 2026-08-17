@extends('layouts.app')
@section('title', 'Checkout')
@section('content')

<div class="page-header">
  <div class="container">
    <h2>Complete Your Payment</h2>
  </div>
</div>

<div class="container py-4" style="max-width:640px">

  {{-- Escrow notice --}}
  <div style="background:#E6F1FB;border:1px solid #B3D1F5;border-radius:12px;padding:1rem;margin-bottom:1.5rem;font-size:.85rem;color:#0C447C">
    <i class="bi bi-shield-lock-fill me-2"></i>
    <strong>Your money is protected.</strong> Payment is held in escrow and only released to the seller after you confirm receipt. You can raise a dispute if there is a problem.
  </div>

  {{-- Payment --}}
    <div style="background:#fff;border:1px solid var(--border);border-radius:16px;padding:1.5rem;margin-bottom:1.5rem">
    <div style="font-weight:700;margin-bottom:1rem">
      <i class="bi bi-receipt me-2"></i>Order Summary
    </div>
    <div class="d-flex justify-content-between">
      <span style="font-weight:700">Winning bid</span>
      <span style="font-weight:800;font-size:1.2rem;color:var(--br)">PKR {{ number_format($payment->amount) }}</span>
    </div>
    </div>
  <div style="background:#fff;border:1px solid var(--border);border-radius:16px;padding:1.5rem">
    
    <div style="font-weight:700;margin-bottom:.2rem">
        <i class="bi bi-wallet me-2"></i>Transfer to</div>
    <div style="font-size:.82rem;color:var(--muted);margin-bottom:1.2rem">
      Choose an account, send <strong>PKR {{ number_format($payment->amount) }}</strong>, then enter the transaction details below.
    </div>

    <form method="POST" action="{{ route('payment.submit', $auction->id) }}" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="payment_method" id="payment_method_input" value="">
      <div class="mb-3">
        <label class="form-label-ax">Payment Method</label>
        <div class="row g-3">
          <div class="col-6">
            <div id="card-jazzcash" onclick="selectMethod('jazzcash')" class="payment-account-card">
              <div class="d-flex align-items-center gap-2 mb-2">
                <img class="payment-account-icon" src="{{ asset('image/jazzcash.png') }}" alt="Logo">
                <span style="font-weight:700;font-size:.9rem">JazzCash</span>
              </div>
              <div style="font-size:.9rem;font-weight:700">
                {{ $jazzcash['account_number'] ?? 'Not configured' }}
              </div>
              <div style="font-size:.78rem;color:var(--muted)">{{ $jazzcash['account_name'] ?? '—' }}</div>
            </div>
          </div>
          <div class="col-6">
            <div id="card-easypaisa" onclick="selectMethod('easypaisa')" class="payment-account-card">
              <div class="d-flex align-items-center gap-2 mb-2">
                <img class="payment-account-icon" src="{{ asset('image/easypaisa.png') }}" alt="Logo">
                <span style="font-weight:700;font-size:.9rem">EasyPaisa</span>
              </div>
              <div style="font-size:.9rem;font-weight:700">
                {{ $easypaisa['account_number'] ?? 'Not configured' }}
              </div>
              <div style="font-size:.78rem;color:var(--muted)">{{ $easypaisa['account_name'] ?? '—' }}</div>
            </div>
          </div>
        </div>
        @error('payment_method')
          <div style="font-size:.78rem;color:var(--red);margin-top:6px">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label class="form-label-ax" for="transaction_id">Transaction ID</label>
        <input type="text" id="transaction_id" name="transaction_id"
          class="form-control-ax @error('transaction_id') is-invalid @enderror"
          placeholder="TX1*********"
          value="{{ old('transaction_id') }}" required>
        <div style="font-size:.75rem;color:var(--muted);margin-top:3px">
          Found in your JazzCash/EasyPaisa SMS or app receipt
        </div>
        @error('transaction_id')
          <div style="font-size:.78rem;color:var(--red);margin-top:4px">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label class="form-label-ax">Payment Screenshot</label>
        <div id="drop-zone"
          style="border:2px dashed var(--border);border-radius:10px;padding:1.5rem;text-align:center;
          cursor:pointer;transition:border-color .2s"
          onclick="document.getElementById('proof_image').click()">

          <i class="bi bi-cloud-upload" style="font-size:1.8rem;color:var(--muted);display:block;margin-bottom:.4rem"></i>
          <div id="drop-text" style="font-size:.85rem;color:var(--muted)">Upload your screenshot here</div>
          <img id="preview" src="" alt="" style="display:none;max-width:100%;border-radius:8px;margin-top:.8rem;max-height:auto">
        </div>

        <input type="file" id="proof_image" name="proof_image" accept="image/jpeg,image/png" style="display:none"
        onchange="previewImage(this)" required>
        @error('proof_image')
          <div style="font-size:.78rem;color:var(--red);margin-top:4px">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-4">
        <label class="form-label-ax" for="buyer_note">Additional Note (optional)</label>
        <textarea id="buyer_note" name="buyer_note" class="form-control-ax"
          rows="2" style="resize:none"
          placeholder="Anything you want to tell us about the payment…">{{ old('buyer_note') }}</textarea>
      </div>
       
      <div class="d-flex justify-content-center">
      <button type="submit" id="submit-btn" class="btn btn-brown w-50 py-2" disabled>Submit</button></div>
      <div style="font-size:.75rem;color:var(--muted);text-align:center;margin-top:.7rem">
        Admin will verify and confirm within 24 hours
      </div>
    </form>
  </div>
</div>

@push('styles')
<style>
.payment-account-card{
  border:2px solid var(--border);
  border-radius:12px;
  padding:1rem;
  cursor:pointer;
  transition:border-color .15s, background .15s;
}
.payment-account-card:hover{ 
  background:var(--surface, #F5F0EB); 
}
.payment-account-icon{
  width:30px;
  height:30px;
  border-radius:8px;
  display:flex;
  align-items:center;
  justify-content:center;
  color:#fff;
  font-size:.95rem;
  flex-shrink:0;
}
</style>
@endpush

@push('scripts')
<script>
var selectedMethod='';

function selectMethod(method){
  selectedMethod=method;
  document.getElementById('payment_method_input').value=method;
  var br='var(--br)', bd='var(--border)';
  document.getElementById('card-jazzcash').style.borderColor=method==='jazzcash'  ? br : bd;
  document.getElementById('card-easypaisa').style.borderColor=method==='easypaisa' ? br : bd;
  checkSubmit();
}

function previewImage(input){
  if(input.files && input.files[0]){
    const file=input.files[0]; 
      document.getElementById('drop-text').textContent=file.name;
       const preview=document.getElementById('preview');
        preview.src=URL.createObjectURL(file); 
        preview.style.display='block';
    };
    checkSubmit();
  }

function checkSubmit(){
  var ok=selectedMethod !== '' && document.getElementById('transaction_id').value.trim() !== '' &&
      document.getElementById('proof_image').files.length > 0;
      document.getElementById('submit-btn').disabled=!ok;
}

document.getElementById('transaction_id').addEventListener('input',checkSubmit);
</script>
@endpush
@endsection