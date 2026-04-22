@extends('layouts.app')
@section('title', 'Sign In')
@section('content')

<div class="auth-wrapper">
  <div class="auth-card">
    {{-- Logo --}}
    <div class="text-center mb-4">
      <a href="{{ route('home') }}" class="auth-logo text-decoration-none">
        Auction<span>X</span>
      </a>
    </div>
{{-- Login Form --}}
    <form method="POST" id="loginForm">
      @csrf
      {{-- Email --}}
      <div class="mb-3">
        <label class="form-label-ax" for="email">
          <i class="bi bi-envelope me-1"></i>Email Address
        </label>
        <input
          type="email" id="email" name="email"
          class="form-control-ax"
          placeholder="Username@gmail.com"
          required autofocus/>
      </div>
      {{-- Password --}}
      <div class="mb-3">
        <div class="d-flex justify-content-between align-items-center mb-1">
          <label class="form-label-ax mb-0" for="password">
            <i class="bi bi-lock me-1"></i>Password
          </label>
            <a style="font-size:0.8rem;color:var(--br);text-decoration:none;font-weight:600">
              Forgot password?
            </a>
        </div>
        <div class="position-relative">
          <input
            type="password" id="password" name="password"
            class="form-control-ax"
            placeholder="Enter your password"
            required style="padding-right:2.8rem"/>
        </div>
      </div>
      {{-- Remember Me --}}
      <div class="d-flex align-items-center gap-2 mb-4">
        <input type="checkbox" id="remember" name="remember"
               style="accent-color:var(--br);width:15px;height:15px;cursor:pointer"/>
        <label for="remember" style="font-size:0.85rem;color:var(--muted);cursor:pointer;margin:0">
          Keep me signed in
        </label>
      </div>
      {{-- Submit --}}
      <button type="submit" class="btn btn-brown btn-lg w-100 py-2">
        <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
      </button>
    </form>
    {{-- Divider --}}
    <div class="divider-text">or</div>
    {{-- Register Link --}}
    <div class="text-center" style="font-size:0.88rem;color:var(--muted)">
      Don't have an account?
      <a href="{{ route('register') }}"
         style="color:var(--br);font-weight:700;text-decoration:none">
        Create account
      </a>
    </div>
    {{-- Guest Browse --}}
    <div class="text-center mt-2">
      <a href="{{ route('home') }}"
         style="font-size:0.82rem;color:var(--muted);text-decoration:none">
        <i class="bi bi-eye me-1"></i>Browse auctions as guest
      </a>
    </div>

  </div>
</div>
@endsection
