@extends('layouts.app')
@section('title','Reset Password')
@section('content')

<div class="auth-wrapper">
  <div class="auth-card">

    <div class="text-center mb-4">
      <a href="{{ route('home') }}" class="auth-logo text-decoration-none">
        Auction<span>X</span>
      </a>
    </div>

    @if($errors->any())
      <div class="alert d-flex align-items-start gap-2 mb-3"
        style="background:var(--red-bg);border:1px solid var(--red-bd);border-radius:10px;padding:.75rem 1rem">
        <i class="bi bi-exclamation-circle-fill" style="color:var(--red);margin-top:2px"></i>
        <div style="font-size:.85rem;color:var(--red)">
          @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
          @endforeach
        </div>
      </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
      @csrf
      <input type="hidden" name="token" value="{{ $token }}">

      <div class="mb-3">
        <label class="form-label-ax" for="email">
          <i class="bi bi-envelope me-1"></i>Email Address
        </label>
        <input
          type="email" id="email" name="email"
          class="form-control-ax @error('email') is-invalid @enderror"
          placeholder="Username@email.com"
          value="{{ old('email') }}"
          required autofocus />
        @error('email')
          <div style="font-size:.78rem;color:var(--red);margin-top:4px">
            <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
          </div>
        @enderror
      </div>

      <div class="mb-3">
        <label class="form-label-ax" for="password">
          <i class="bi bi-lock me-1"></i>New Password
        </label>
        <input
          type="password" id="password" name="password"
          class="form-control-ax @error('password') is-invalid @enderror"
          placeholder="Enter your new password"
          required />
        @error('password')
          <div style="font-size:.78rem;color:var(--red);margin-top:4px">
            <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
          </div>
        @enderror
      </div>

      <div class="mb-4">
        <label class="form-label-ax" for="password_confirmation">
          <i class="bi bi-lock-fill me-1"></i>Confirm Password
        </label>
        <input
          type="password" id="password_confirmation" name="password_confirmation"
          class="form-control-ax"
          placeholder="Re-enter your new password"
          required />
      </div>

      <div class="text-center mb-3">
        <button type="submit" class="btn btn-brown btn-lg w-50 py-2">
          Reset Password
        </button>
      </div>
    </form>

    <div class="text-center" style="font-size:.88rem;color:var(--muted)">
      Back to
      <a href="{{ route('login') }}" style="color:var(--br);font-weight:700;text-decoration:none">
        Sign in
      </a>
    </div>

  </div>
</div>
@endsection