@extends('layouts.app')
@section('title','Verify Your Email')
@section('content')

<div class="auth-wrapper">
  <div class="auth-card">
    <div class="text-center mb-4">
      <a class="navbar-brand" href="{{ route('home') }}">
        <img src="{{ asset('image/auctionxlogo.png') }}" alt="AuctionX" class="logo-img"></a>
    </div>

    @if(session('success'))
      <div class="alert d-flex align-items-start gap-2 mb-3"
           style="background:var(--green-bg,#eafaf0);border:1px solid var(--green-bd,#bdeccf);border-radius:10px;padding:.75rem 1rem">
        <i class="bi bi-check-circle-fill" style="color:var(--green,#1a9c53);margin-top:2px"></i>
        <div style="font-size:.85rem;color:var(--green,#1a9c53)">{{ session('success') }}</div>
      </div>
    @endif

    @if($errors->any())
      <div class="alert d-flex align-items-start gap-2 mb-3"
           style="background:var(--red-bg,#fdecec);border:1px solid var(--red-bd,#f3bcbc);border-radius:10px;padding:.75rem 1rem">
        <i class="bi bi-exclamation-circle-fill" style="color:var(--red,#c0392b);margin-top:2px"></i>
        <div style="font-size:.85rem;color:var(--red,#c0392b)">{{ $errors->first('code') }}</div>
      </div>
    @endif

    <h5 class="text-center mb-2" style="font-weight:700">Two Factor Authentication</h5>
    <p class="text-center mb-4" style="font-size:.9rem;color:var(--muted)">
      Please enter the four-digit code sent on your E-mail address.</p>

    <form method="POST" action="{{ route('verification.verify') }}" id="otp-form">
      @csrf
      <input type="hidden" name="code" id="otp-hidden">
      <div class="d-flex justify-content-center gap-2 mb-4" id="otp-boxes">
        @for ($i=0; $i<4; $i++)
          <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1"
                 class="form-control text-center otp-box @error('code') is-invalid @enderror"
                 style="width:56px;height:56px;font-size:1.5rem;font-weight:700">
        @endfor
      </div>
      <div class="text-center mb-2">
        <button type="submit" class="btn btn-brown btn-lg w-50 py-2">Submit</button>
      </div>
    </form>

    <form method="POST" action="{{ route('verification.send') }}">
      @csrf
      <div class="text-center mb-3">
        <button type="submit" class="btn btn-link p-0" style="color:var(--br);font-weight:700;text-decoration:none;font-size:.88rem">
          Re-send code</button>
      </div>
    </form>

    <div class="text-center" style="font-size:.88rem;color:var(--muted)">
      Wrong email?
      <form method="POST" action="{{ route('logout') }}" class="d-inline">
        @csrf
        <button type="submit" class="btn btn-link p-0" style="color:var(--br);font-weight:700;text-decoration:none;font-size:.88rem">
          Log out and register again</button>
      </form>
    </div>
  </div>
</div>

<script>
(function () {
  const boxes = Array.from(document.querySelectorAll('.otp-box'));
  const hidden = document.getElementById('otp-hidden');
  const form = document.getElementById('otp-form');

  boxes.forEach((box, i) => {
    box.addEventListener('input', () => {
      box.value = box.value.replace(/[^0-9]/g, '');
      if (box.value && i < boxes.length - 1) {
        boxes[i + 1].focus();
      }
    });
    box.addEventListener('keydown', (e) => {
      if (e.key === 'Backspace' && !box.value && i > 0) {
        boxes[i - 1].focus();
      }
    });
    box.addEventListener('paste', (e) => {
      e.preventDefault();
      const digits = (e.clipboardData.getData('text').match(/[0-9]/g) || []).slice(0, boxes.length);
      digits.forEach((d, idx) => { if (boxes[idx]) boxes[idx].value = d; });
      if (digits.length) boxes[Math.min(digits.length, boxes.length) - 1].focus();
    });
  });

  form.addEventListener('submit', () => {
    hidden.value = boxes.map(b => b.value).join('');
  });

  if (boxes[0]) boxes[0].focus();
})();
</script>
@endsection