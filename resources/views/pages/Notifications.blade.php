@extends('layouts.app')
@section('title', 'Notifications — AuctionX')
@section('content')

<div class="page-header">
  <div class="container">
    <h2>Notifications</h2>
    <p>All updates about your bids, auctions, and activity</p>
  </div>
</div>

<div class="container py-4" style="max-width:700px">

  @if($notifications->isEmpty())
    <div class="text-center py-5" style="color:var(--muted)">
      <i class="bi bi-bell-slash" style="font-size:2.5rem;display:block;margin-bottom:1rem"></i>
      <div style="font-size:1rem;font-weight:600">No notifications yet</div>
    </div>
  @else
    <div class="d-flex justify-content-between align-items-center mb-3">
      <div style="font-size:.85rem;color:var(--muted)">{{ $notifications->total() }} notifications</div>
    </div>

    <div style="background:#fff;border:1px solid var(--border);border-radius:16px;overflow:hidden">
      @foreach($notifications as $notif)
        @php
          $href=$notif->auction_id ? route('auctions.show', $notif->auction_id) : '#';
        @endphp

        <div class="d-flex align-items-start gap-3 px-4 py-3"
          style="border-bottom:1px solid var(--border)">
          <div class="flex-grow-1">
            <div style="font-weight:500;font-size:.88rem;margin-bottom:2px">
              {{ $notif->title }}
            </div>
            <div style="font-size:.8rem;color:var(--muted);line-height:1.5;margin-bottom:4px">
              {{ $notif->message }}
            </div>
            <div class="d-flex align-items-center gap-3">
              <span style="font-size:.72rem;color:var(--muted)">
                <i class="bi bi-clock me-1"></i>{{ $notif->created_at->diffForHumans() }}
              </span>
              @if($notif->auction_id)
                <a href="{{ $href }}" style="font-size:.72rem;color:var(--br);font-weight:600;text-decoration:none">
                  View auction</a>
              @endif
            </div>
          </div>

          {{-- Delete --}}
          <form method="POST" action="{{ route('notifications.destroy', $notif->id) }}">
            @csrf @method('DELETE')
            <button class="btn btn-sm" style="background:none;border:none;color:var(--muted);padding:4px;font-size:.85rem"
              title="Delete" onclick="return confirm('Delete this notification?')">
              <i class="bi bi-x"></i>
            </button>
          </form>

        </div>
      @endforeach
    </div>

   {{-- Pagination --}}
    @if($notifications->hasPages())
      <div class="mt-3 d-flex justify-content-center">
        {{ $notifications->links('vendor.pagination.bootstrap-5') }}
      </div>
    @endif

  @endif

</div>
@endsection
