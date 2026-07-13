@extends('layouts.app')
@section('title','Forgot Password')
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

    <form method="POST" action="{{ route('password.email') }}">
      @csrf

      <div class="mb-4">
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

      <div class="text-center mb-3">
        <button type="submit" class="btn btn-brown btn-lg w-auto py-2">
          Send Reset Link
        </button>
      </div>
    </form>

    <div class="text-center" style="font-size:.88rem;color:var(--muted)">
      Remembered it?
      <a href="{{ route('login') }}" style="color:var(--br);font-weight:700;text-decoration:none">
        Sign in
      </a>
    </div>

  </div>
</div>
@endsection