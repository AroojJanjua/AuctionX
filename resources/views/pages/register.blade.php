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
    {{-- form  --}}
    <form method="POST">
      @csrf
      {{-- Full Name --}}
      <div class="mb-3">
        <label class="form-label-ax" for="name">
          <i class="bi bi-person me-1"></i>Full Name
        </label>
        <input type="text" id="name" name="name"
          class="form-control-ax"
          placeholder="Enter your full name"
          required autofocus />
      </div>
      {{-- Email --}}
      <div class="mb-3">
        <label class="form-label-ax" for="email">
          <i class="bi bi-envelope me-1"></i>Email Address
        </label>
        <input type="email" id="email" name="email"
          class="form-control-ax"
          placeholder="Username@gmail.com"
          required/>
      </div>
      {{-- Phone --}}
      <div class="mb-3">
        <label class="form-label-ax" for="phone">
          <i class="bi bi-telephone me-1"></i>Phone Number
        </label>
        <input type="tel" id="phone" name="phone"
          class="form-control-ax"
          placeholder="+92 "/>
      </div>
      {{-- Account Role --}}
      <div class="mb-3">
        <label class="form-label-ax" for="role">
          <i class="bi bi-person-badge me-1"></i>I want to
        </label>
        <select id="role" name="role" class="form-select-ax" required>
          <option value="" disabled selected>Select your role</option>
          <option value="bidder">
            Bidder
          </option>
          <option value="seller">
            Seller
          </option>
        </select>
      </div>
      {{-- Password --}}
      <div class="mb-3">
        <label class="form-label-ax" for="password">
          <i class="bi bi-lock me-1"></i>Password
        </label>
        <div class="position-relative">
          <input
            type="password" id="password" name="password"
            class="form-control-ax"
            placeholder="Enter password" required
            style="padding-right:2.8rem"/>
        </div>
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
              <input type="text" name="city" class="form-control-ax"
                 placeholder="Your city" />
            </div>
            <div class="col-sm-6">
              <label class="form-label-ax">Country</label>
              <input type="text" name="country" class="form-control-ax"
                    placeholder="Your country" />
            </div>
          </div>
          {{-- Bio --}}
          <div class="mb-4">
            <label class="form-label-ax">Bio</label>
            <textarea name="bio" rows="3" class="form-control-ax"
                      placeholder="Tell something about you..."></textarea>
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

      <button type="submit" class="btn btn-brown btn-lg w-100 py-2">
        <i class="bi bi-person-plus me-2"></i>Create Account
      </button>
    </form>

    <div class="divider-text">already have an account?</div>

    <div class="text-center">
      <a href="{{ route('login') }}" class="btn btn-brown-outline w-100 py-2">
        <i class="bi bi-box-arrow-in-right me-2"></i>Sign In Instead
      </a>
    </div>

  </div>
</div>
@endsection