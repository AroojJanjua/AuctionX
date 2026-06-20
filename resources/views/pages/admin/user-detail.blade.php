@extends('layouts.app')
@section('title',$user->name)
@section('content')

<div class="page-header">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
      <div><h2><i class="bi bi-person me-2"></i>{{ $user->name }}</h2>
        <p>{{ $user->email }}</p></div>
    </div>
  </div>
</div>

<div class="container py-4">
  <div class="row g-4">

  <div class="col-lg-4">
      <div style="background:#fff;border:1px solid var(--border);border-radius:16px;padding:1.8rem;text-align:center">
        <div style="width:72px;height:72px;border-radius:50%;background:var(--br-pale);border:2px solid var(--br-soft);display:flex;align-items:center;justify-content:center;font-size:1.6rem;font-weight:800;color:var(--br);margin:0 auto 1rem">
          {{ strtoupper(substr($user->name,0,2)) }}
        </div>
        <div style="font-size:1.05rem;font-weight:800">{{ $user->name }}</div>
        <div style="font-size:.83rem;color:var(--muted)">{{ $user->email }}</div>
        <span class="badge rounded-pill {{ $user->role==='admin'?'badge-admin':($user->role==='seller'?'badge-seller':'badge-bidder') }} mt-2">{{ ucfirst($user->role) }}</span>
        <div class="mt-3 pt-3 d-flex justify-content-around" style="border-top:1px solid var(--border)">
          <div><div style="font-weight:800;color:var(--br)">{{ $user->bids_count }}</div><div style="font-size:.72rem;color:var(--muted)">Bids</div></div>
          <div><div style="font-weight:800;color:var(--br)">{{ $user->auctions_count }}</div><div style="font-size:.72rem;color:var(--muted)">Listings</div></div>
          <div><div style="font-weight:800;color:var(--br)">{{ $user->created_at->format('Y') }}</div><div style="font-size:.72rem;color:var(--muted)">Joined</div></div>
        </div>
        @if($user->id !== auth()->id())
        <div class="mt-3 d-grid gap-2">
          <form method="POST" action="{{ route('admin.users.ban', $user->id) }}">
            @csrf @method('PUT')
            <button class="btn w-100 "
                    style="{{ $user->is_banned ? 'background:var(--green-bg);color:var(--green);border:1px solid var(--green-bd)' : 'background:var(--red-bg);color:var(--red);border:1px solid var(--red-bd)' }}">
              <i class="bi {{ $user->is_banned ? 'bi-unlock' : 'bi-lock' }} me-1"></i>
              {{ $user->is_banned ? 'Unban User' : 'Ban User' }}
            </button>
          </form>
        </div>
        @endif
      </div>
    </div>

    <div class="col-lg-8">
      <div style="background:#fff;border:1px solid var(--border);border-radius:16px;overflow:hidden">
        <div class="p-3" style="border-bottom:1px solid var(--border)"><div class="section-title" style="font-size:1rem"><i class="bi bi-hammer me-1"></i>Recent Bids</div></div>
        @forelse($user->bids->take(10) as $bid)
        <div class="d-flex justify-content-between align-items-center p-3" style="border-bottom:1px solid var(--border)">
          <div>
            <div style="font-weight:700;font-size:.88rem">{{ Str::limit($bid->auction->title, 45) }}</div>
            <div style="font-size:.75rem;color:var(--muted)">{{ $bid->created_at->format('M d, Y · h:i A') }}</div>
          </div>
          <div style="font-weight:800;color:var(--br)">PKR {{ number_format($bid->amount) }}</div>
        </div>
        @empty
        <div class="text-center py-4" style="color:var(--muted);font-size:.88rem">No bids placed yet</div>
        @endforelse
      </div>
    </div>

  </div>
</div>

@endsection