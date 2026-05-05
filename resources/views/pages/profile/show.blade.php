@extends('layouts.app')
@section('title', 'My Profile')
@section('content')

<div class="page-header">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
      <div>
        <h2><i class="bi bi-person-circle me-2"></i>My Profile</h2>
        <p>Manage your account information</p>
      </div>
      <a href="{{ route('profile.edit') }}" class="btn btn-brown px-4">
        <i class="bi bi-pencil me-2"></i>Edit Profile
      </a>
    </div>
  </div>
</div>

<div class="container py-4">
  <div class="row g-4">

   {{-- Profile Card --}}
    <div class="col-lg-4">
    <div style="background:#fff;border:1px solid var(--border);
      border-radius:16px;padding:2rem;text-align:center">
        <div style="width:80px;height:80px;border-radius:50%;background:var(--br-pale);
        border:2px solid var(--br-soft);display:flex;align-items:center;justify-content:center;
        font-size:2rem;font-weight:800;color:var(--br);margin:0 auto 1rem">
          {{ strtoupper(substr($user, 0, 2)) }}
        </div>
        <div style="font-size:1.1rem;font-weight:800;color:var(--text)">{{ $user->name }}</div>
        <div style="font-size:.83rem;color:var(--muted);margin-top:2px">{{ $user->email }}</div>
        <div class="mt-2">
          <span class="badge rounded-pill {{ $user->role === 'admin' ? 'badge-admin' : ($user->role === 'seller' ? 'badge-seller' : 'badge-bidder') }}">
            {{ ucfirst($user->role) }}
          </span>
        </div>
        @if($user->bio)
          <p style="font-size:.85rem;color:var(--muted);margin-top:1rem;line-height:1.6">{{ $user->bio }}</p>
        @endif
        <div class="mt-3 pt-3" style="border-top:1px solid var(--border)">
          @foreach([
            ['bi-telephone',$user->phone ?? 'Not set'],
            ['bi-geo-alt',($user->city && $user->country)
                          ? $user->city . ', ' . $user->country
                          : ($user->city ?? $user->country ?? 'Not set')]
            ] as [$icon,$val])
          <div class="d-flex align-items-center gap-2 mb-2" style="font-size:.83rem;color:var(--muted)">
            <i class="bi {{ $icon }}" style="color:var(--br)"></i> {{ $val }}
          </div>
          @endforeach
        </div>
        <div class="mt-3 pt-3 d-flex justify-content-around" style="border-top:1px solid var(--border)">
          <div class="text-center">
            <div style="font-size:1.2rem;font-weight:800;color:var(--br)">{{ $user->bids_count ?? 0 }}</div>
            <div style="font-size:.72rem;color:var(--muted)">Bids Placed</div>
          </div>
          @if($user->role === 'seller')
          <div class="text-center">
            <div style="font-size:1.2rem;font-weight:800;color:var(--br)">{{ $user->auctions_count ?? 0 }}</div>
            <div style="font-size:.72rem;color:var(--muted)">Listings</div>
          </div>
          @endif
          <div class="text-center">
            <div style="font-size:1.2rem;font-weight:800;color:var(--br)">{{ $user->created_at->format('Y') }}</div>
            <div style="font-size:.72rem;color:var(--muted)">Joined</div>
          </div>
        </div>
       </div>
      </div>

      {{-- Recent Bids  --}}
      <div class="col-lg-8">
      <div style="background:#fff;border:1px solid var(--border);border-radius:16px;overflow:hidden">
        <div class="d-flex justify-content-between align-items-center p-3" style="border-bottom:1px solid var(--border)">
          <div class="section-title" style="font-size:1rem">Recent Bids</div>
          <a 
          {{-- href="{{ route('my-bids') }}"  --}}
          class="see-all-btn">View all</a>
          {{-- @forelse($user->bids->take(5) as $bid)
        <div class="d-flex justify-content-between align-items-center p-3" style="border-bottom:1px solid var(--border)">
          <div>
            <div style="font-weight:700;font-size:.9rem">{{ Str::limit($bid->auction->title, 40) }}</div>
            <div style="font-size:.75rem;color:var(--muted)">{{ $bid->created_at->diffForHumans() }}</div>
          </div>
          <div style="font-weight:800;color:var(--br)">${{ number_format($bid->amount) }}</div>
        </div>
        @empty
        <div class="text-center py-4" style="color:var(--muted);font-size:.88rem">No bids placed yet.</div>
        @endforelse --}}
        </div>
      </div>
      </div>

  </div>
</div>

@endsection