@extends('layouts.app')
@section('title', 'Edit Profile')
@section('content')

<div class="page-header">
  <div class="container">
    <h2><i class="bi bi-pencil me-2"></i>Edit Profile</h2>
    <p>Update your account information</p>
  </div>
</div>

<div class="container py-4">
  <div class="row justify-content-center g-4">
  <div class="col-lg-7">
  {{-- Profile Info --}}
    <div style="background:#fff;border:1px solid var(--border);border-radius:16px;
    padding:1.8rem;margin-bottom:1.2rem">
    <div class="section-title mb-4" style="font-size:1rem">
          <i class="bi bi-person me-1"></i>Personal Information
        </div>
      <form method="POST" action="{{ route('profile.update') }}">
          @csrf 
          @method('PUT')
          <div class="mb-3">
            <label class="form-label-ax">Full Name</label>
            <input type="text" name="name" class="form-control-ax @error('name') is-invalid @enderror"
                   value="{{ old('name', $user->name) }}" required />
            @error('name')
            <div style="font-size:.78rem;color:var(--red);margin-top:4px">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label class="form-label-ax">Email Address</label>
            <input type="email" name="email" class="form-control-ax @error('email') is-invalid @enderror"
                   value="{{ old('email', $user->email) }}" required />
            @error('email')
            <div style="font-size:.78rem;color:var(--red);margin-top:4px">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label class="form-label-ax">Phone Number</label>
            <input type="tel" name="phone" class="form-control-ax"
                   value="{{ old('phone', $user->phone) }}" placeholder="Your phone no."/>
          </div>

          <div class="row g-3 mb-3">
            <div class="col-sm-6">
              <label class="form-label-ax">City</label>
              <input type="text" name="city" class="form-control-ax"
                     value="{{ old('city', $user->city) }}" placeholder="Your city" />
            </div>
            <div class="col-sm-6">
              <label class="form-label-ax">Country</label>
              <input type="text" name="country" class="form-control-ax"
                     value="{{ old('country', $user->country) }}" placeholder="Your country" />
            </div>
          </div>

          <div class="mb-4">
            <label class="form-label-ax">Bio</label>
            <textarea name="bio" rows="3" class="form-control-ax"
                      placeholder="Tell something about you...">{{ old('bio', $user->bio) }}</textarea>
          </div>

          <button type="submit" class="btn btn-brown px-5">
            <i class="bi bi-check2 me-2"></i>Save Changes
          </button>
      </form>

    </div>

  {{-- Change Password  --}}
    <div style="background:#fff;border:1px solid var(--border);border-radius:16px;padding:1.8rem">
<div class="section-title mb-4" style="font-size:1rem">
          <i class="bi bi-lock me-1"></i>Change Password
        </div>
        <form method="POST" action="{{ route('profile.password') }}">
          @csrf 
          @method('PUT')
          <div class="mb-3">
            <label class="form-label-ax">Current Password</label>
            <input type="password" name="current_password"
                   class="form-control-ax @error('current_password') is-invalid @enderror"
                   placeholder="Enter current password" />
            @error('current_password')
            <div style="font-size:.78rem;color:var(--red);margin-top:4px">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label class="form-label-ax">New Password</label>
            <input type="password" name="password" class="form-control-ax"
                   placeholder="Min 8 characters" />
          </div>

          <div class="mb-4">
            <label class="form-label-ax">Confirm New Password</label>
            <input type="password" name="password_confirmation" class="form-control-ax"
                   placeholder="Repeat new password" />
          </div>

          <button type="submit" class="btn btn-brown-outline px-5">
            <i class="bi bi-lock me-2"></i>Update Password
          </button>
        </form>

    </div>

  </div>
  </div>
</div>

@endsection