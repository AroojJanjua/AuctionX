<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('admin.feed',function($user){
    return $user->role === 'admin';
});

Broadcast::channel('seller.{sellerId}',function($user,$sellerId){
    return (int) $user->id === (int) $sellerId;
});

Broadcast::channel('user.{userId}',function ($user,$userId){
    return (int) $user->id === (int) $userId;
});