@extends('layouts.app')
@section('title', 'Sign In')
@section('content')

<div class="auth-wrapper">
  <div class="auth-card">

    {{-- Logo --}}
    <div class="text-center mb-4">
      <a href="{{ route('home') }}" class="auth-logo text-decoration-none">
      Auction<span>X</span> </a>
    </div>

    {{-- Validation errors --}}
    @if($errors->any())
      <div class="alert d-flex align-items-start gap-2 mb-3"
           style="background:var(--red-bg);border:1px solid var(--red-bd);border-radius:10px;padding:.75rem 1rem">
        <i class="bi bi-exclamation-circle-fill" style="color:var(--red);margin-top:2px"></i>
        <div style="font-size:0.85rem;color:var(--red)">
          @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
          @endforeach
        </div>
      </div>
    @endif

    {{-- Login Form --}}
    <form method="POST"  action="{{ route('login') }}" id="loginForm">
      @csrf

      {{-- Email --}}
      <div class="mb-3">
        <label class="form-label-ax" for="email">
          <i class="bi bi-envelope me-1"></i>Email Address
        </label>
        <input
          type="email" id="email" name="email"
          class="form-control-ax @error('email') is-invalid @enderror"
          placeholder="Username@gmail.com"
          required autofocus/>
          @error('email')
          <div style="font-size:0.78rem;color:var(--red);margin-top:4px">
            <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
          </div>
        @enderror
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
            class="form-control-ax @error('password') is-invalid @enderror"
            placeholder="Enter your password"
            required style="padding-right:2.8rem"/>
        </div>
             @error('password')
             <div style="font-size:0.78rem;color:var(--red);margin-top:4px">
             <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
             </div>
             @enderror
      </div>

      {{-- Remember Me --}}
      <div class="d-flex align-items-center gap-2 mb-4">
        <input type="checkbox" id="remember" name="remember"
               style="accent-color:var(--br);width:15px;height:15px;cursor:pointer"
               {{ old('remember') ? 'checked' : '' }} />
        <label for="remember" style="font-size:0.85rem;color:var(--muted);cursor:pointer;margin:0">
          Keep me signed in
        </label>
      </div>

      {{-- Submit --}}
      <div class="text-center mb-2">
      <button type="submit" class="btn btn-brown btn-lg w-50 py-2">Sign In</button>
      </div>
    </form>

    {{-- Register Link --}}
    <div class="text-center" style="font-size:0.88rem;color:var(--muted)">
      Don't have an account?
      <a href="{{ route('register') }}"
         style="color:var(--br);font-weight:700;text-decoration:none">
        Create account
      </a>
    </div>


  </div>
</div>
@endsection
