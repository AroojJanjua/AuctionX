@extends('layouts.app')
@section('title', 'Create Account')
@section('content')

<div class="auth-wrapper" style="padding:2rem 1rem">
  <div class="auth-card" style="max-width:500px">

    {{-- Logo --}}
    <div class="text-center mb-4">
      <a href="{{ route('home') }}" class="auth-logo text-decoration-none">
        Auction<span>X</span>
      </a>
    </div>

    {{-- Validation Errors --}}
    @if($errors->any())
      <div class="alert mb-3"
           style="background:var(--red-bg);border:1px solid var(--red-bd);border-radius:10px;padding:.75rem 1rem">
        <div class="d-flex gap-2">
          <i class="bi bi-exclamation-circle-fill" style="color:var(--red);margin-top:2px"></i>
          <div style="font-size:0.85rem;color:var(--red)">
            @foreach($errors->all() as $error)
              <div>{{ $error }}</div>
            @endforeach
          </div>
        </div>
      </div>
    @endif

    {{-- form  --}}
    <form method="POST">
      @csrf

      {{-- fullname --}}
      <div class="mb-3">
        <label class="form-label-ax" for="name">
          <i class="bi bi-person me-1"></i>Full Name
        </label>
        <input type="text" id="name" name="name"
          class="form-control-ax @error('name') is-invalid @enderror"
          value="{{ old('name') }}"
          placeholder="Enter your full name"
          required autofocus />
           @error('name')
          <div style="font-size:0.78rem;color:var(--red);margin-top:4px">{{ $message }}</div>
          @enderror
      </div>

      {{-- email --}}
      <div class="mb-3">
        <label class="form-label-ax" for="email">
          <i class="bi bi-envelope me-1"></i>Email Address
        </label>
        <input type="email" id="email" name="email"
          class="form-control-ax @error('email') is-invalid @enderror"
          value="{{ old('email') }}"
          placeholder="Username@gmail.com"
          required/>
          @error('email')
          <div style="font-size:0.78rem;color:var(--red);margin-top:4px">{{ $message }}</div>
          @enderror
      </div>

      {{-- Phone --}}
      <div class="mb-3">
        <label class="form-label-ax" for="phone">
          <i class="bi bi-telephone me-1"></i>Phone Number
        </label>
        <input type="tel" id="phone" name="phone"
          class="form-control-ax @error('phone') is-invalid @enderror"
          value="{{ old('phone') }}"
          placeholder="+92 "/>
          @error('phone')
          <div style="font-size:0.78rem;color:var(--red);margin-top:4px">{{ $message }}</div>
          @enderror
      </div>
      
      {{-- Account Role --}}
      <div class="mb-3">
        <label class="form-label-ax" for="role">
          <i class="bi bi-person-badge me-1"></i>I want to
        </label>
        <select id="role" name="role" 
        class="form-select-ax @error('role') is-invalid @enderror" required>
          <option value="" disabled {{ old('role') ? '' : 'selected' }}>Select your role</option>
          <option value="bidder" {{ old('role') === 'bidder'  ? 'selected' : '' }}>
            Bidder
          </option>
          <option value="seller" {{ old('role') === 'seller'  ? 'selected' : '' }}>
            Seller
          </option>
        </select>
        @error('role')
          <div style="font-size:0.78rem;color:var(--red);margin-top:4px">{{ $message }}</div>
        @enderror
      </div>
      {{-- Password --}}
      <div class="mb-3">
        <label class="form-label-ax" for="password">
          <i class="bi bi-lock me-1"></i>Password
        </label>
        <div class="position-relative">
          <input
            type="password" id="password" name="password"
            class="form-control-ax @error('password') is-invalid @enderror"
            placeholder="Enter password" required
            style="padding-right:2.8rem"/>
        </div>
        @error('password')
          <div style="font-size:0.78rem;color:var(--red);margin-top:4px">{{ $message }}</div>
        @enderror
      </div>
      {{-- Confirm Password --}}
      <div class="mb-4">
        <label class="form-label-ax" for="password_confirmation">
          <i class="bi bi-lock-fill me-1"></i>Confirm Password
        </label>
        <div class="position-relative">
          <input
            type="password" id="password_confirmation" name="password_confirmation"
            class="form-control-ax"
            placeholder="Re-enter your password"required
            style="padding-right:2.8rem"/>
        </div>
      </div>
      {{-- City and Country --}}
      <div class="row g-3 mb-3">
            <div class="col-sm-6">
              <label class="form-label-ax">City</label>
              <input type="text" name="city" 
              class="form-control-ax @error('city') is-invalid @enderror"
                 placeholder="Your city" />
                 @error('city')
                 <div style="font-size:0.78rem;color:var(--red);margin-top:4px">{{ $message }}</div>
                 @enderror
            </div>
            <div class="col-sm-6">
              <label class="form-label-ax">Country</label>
              <input type="text" name="country" 
              class="form-control-ax @error('country') is-invalid @enderror"
                placeholder="Your country" />
                @error('country')
                <div style="font-size:0.78rem;color:var(--red);margin-top:4px">{{ $message }}</div>
                @enderror
            </div>
          </div>
          {{-- Bio --}}
          <div class="mb-4">
            <label class="form-label-ax">Bio</label>
            <textarea name="bio" rows="3" 
            class="form-control-ax @error('bio') is-invalid @enderror"
                  placeholder="Tell something about you..."></textarea>
            @error('bio')
            <div style="font-size:0.78rem;color:var(--red);margin-top:4px">{{ $message }}</div>
            @enderror
          </div>
      {{-- Terms --}}
      <div class="d-flex align-items-start gap-2 mb-4">
        <input type="checkbox" id="terms" name="terms"
               style="accent-color:var(--br);width:15px;height:15px;margin-top:3px;cursor:pointer"
               required />
        <label for="terms" style="font-size:0.83rem;color:var(--muted);cursor:pointer;margin:0">
          I agree to the
          <a href="#" style="color:var(--br);font-weight:700;text-decoration:none">Terms of Service</a>
          and
          <a href="#" style="color:var(--br);font-weight:700;text-decoration:none">Privacy Policy</a>
        </label>
      </div>

      <div class="text-center mb-2">
      <button type="submit" class="btn btn-brown btn-lg w-50 py-2">Create Account</button>
      </div>
    </form>

  </div>
</div>
@endsection