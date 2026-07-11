<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Public channels (auction.{id}, auctions.feed) need no auth callback —
| anyone can subscribe. Private channels verify the user before allowing
| a WebSocket subscription.
|
*/

// ── Private: Admin feed ────────────────────────────────────────────────
// Only users with role=admin can subscribe to admin.feed.
// The browser sends a POST to /broadcasting/auth; Laravel runs this
// callback and returns 200 (allowed) or 403 (denied).
Broadcast::channel('admin.feed',function($user){
    return $user->role === 'admin';
});

// ── Private: Seller's own channel ─────────────────────────────────────
// Each seller gets their own channel: seller.5, seller.12, etc.
// A seller can only subscribe to their OWN channel (id must match).
Broadcast::channel('seller.{sellerId}',function($user,$sellerId){
    return (int) $user->id === (int) $sellerId;
});
// ── Private: Per-user notification channel ─────────────────────────────
// Each user gets their own channel: user.5, user.12, etc.
// Only that exact user can subscribe.
Broadcast::channel('user.{userId}',function ($user,$userId){
    return (int) $user->id === (int) $userId;
});