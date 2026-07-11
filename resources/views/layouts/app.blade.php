<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>@yield('title','AuctionX')</title>
  {{-- Bootstrap 5 CSS --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
  {{-- Bootstrap Icons --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  {{-- Google Fonts --}}
  <link rel="preconnect" href="https://fonts.googleapis.com" /> 
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  {{-- AuctionX CSS --}}
  <link rel="stylesheet" href="{{ asset('css/auctionx.css') }}" />
  @stack('styles')
</head>
<body>
   {{-- NAVBAR --}}
   <nav class="navbar navbar-expand-lg ax-navbar sticky-top">
    <div class="container">
      <a class="navbar-brand" href="{{ route('home') }}">Auction<span>X</span></a>
 
      <button class="navbar-toggler" type="button"
        data-bs-toggle="collapse" data-bs-target="#mainNav"
        aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
 
      <div class="collapse navbar-collapse" id="mainNav">
        <ul class="navbar-nav me-auto ms-3 gap-1">
         <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
              href="{{ route('home') }}">
              <i class="bi bi-house me-1"></i>Home
            </a>
          </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('auctions.*') ? 'active' : '' }}"
              href="{{ route('auctions.index') }}">
              <i class="bi bi-grid me-1"></i>View Items
            </a>
          </li>
          @auth
            @if(auth()->user()->role === 'seller')
            <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('seller.*') ? 'active' : '' }}"
                href="{{ route('seller.dashboard') }}">
                <i class="bi bi-tag me-1"></i>Sell
              </a>
            </li>
            @endif
          @endauth
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('how-it-works') ? 'active' : '' }}"
              href="{{ route('how-it-works') }}">
              <i class="bi bi-info-circle me-1"></i>How It Works
            </a>
          </li>
        </ul>

        {{-- Search Bar   --}}
        <form method="GET" action="{{ route('auctions.index') }}" 
        class="ax-search-form d-flex mx-auto mt-2 mt-lg-0">
          <input
            type="text"
            name="search"
            class="form-control"
            placeholder="search about auction..."
            value="{{ request('search') }}"
            autocomplete="off"/>
          <button type="submit" class="btn-search" title="Search">
            <i class="bi bi-search"></i>
          </button>
        </form>
 
        <div class="d-flex align-items-center gap-2 mt-2 mt-lg-0">
          @guest
            <a href="{{ route('login') }}" class="btn btn-ghost-ax btn-sm px-3">Sign In</a>
            <a href="{{ route('register') }}" class="btn btn-brown btn-sm px-3">Register</a>
          @else
            {{-- Notification Bell --}}
            @auth
            <div class="dropdown" id="notifDropdown">
              <button
                class="btn btn-ghost-ax btn-sm px-2 position-relative"
                id="notifBell"
                data-bs-toggle="dropdown"
                data-bs-auto-close="outside"
                aria-expanded="false"
                title="Notifications"
                onclick="loadNotifDropdown()">
                <i class="bi bi-bell"></i>
                <span id="notifBadge"
                  class="position-absolute top-0 start-100 translate-middle badge rounded-pill"
                  style="background:var(--br);font-size:.6rem;padding:2px 5px;display:none">0</span>
              </button>

              <div class="dropdown-menu dropdown-menu-end p-0 shadow"
                style="width:320px;border-radius:14px;border:1px solid var(--border);font-family:'Nunito',sans-serif;overflow:hidden">

                {{-- Header --}}
                <div class="d-flex align-items-center justify-content-between px-3 py-2"
                  style="border-bottom:1px solid var(--border)">
                  <span style="font-weight:700;font-size:.88rem">Notifications</span>
                  <div class="d-flex gap-2 align-items-center">
                    <button onclick="markAllRead()" class="btn btn-ghost-ax btn-sm"
                      style="font-size:.72rem;padding:2px 8px">Mark all read</button>
                    <a href="{{ route('notifications.index') }}"
                      style="font-size:.72rem;color:var(--br);font-weight:600;text-decoration:none">See all</a>
                  </div>
                </div>

                {{-- List --}}
                <div id="notifList" style="max-height:380px;overflow-y:auto">
                  <div id="notifLoading" class="text-center py-4" style="color:var(--muted);font-size:.82rem">
                    <i class="bi bi-hourglass-split me-1"></i> Loading…
                  </div>
                </div>

              </div>
            </div>
            @endauth
            {{-- User Dropdown --}}
            <div class="dropdown">
              <button class="btn btn-ghost-ax btn-sm px-3 dropdown-toggle" data-bs-toggle="dropdown">
                <i class="bi bi-person-circle me-1"></i>
                {{ auth()->user()->name }}
              </button>
              <ul class="dropdown-menu dropdown-menu-end shadow-sm border" style="border-color:var(--border)!important;border-radius:12px;font-family:'Nunito',sans-serif">
                <li>
                  <a class="dropdown-item" href="{{ route('profile') }}">
                    <i class="bi bi-person me-2"></i>My Profile
                  </a>
                </li>
                <li>
                  <a class="dropdown-item"  href="{{ route('my-bids') }}">
                    <i class="bi bi-coin me-2"></i>My Bids
                  </a>
                </li>
                @if(auth()->user()->role === 'admin')
                <li><hr class="dropdown-divider"></li>
                <li>
                  <a class="dropdown-item" href="{{ route('admin.reports') }}">
                    <i class="bi bi-bar-chart me-2"></i>Reports
                  </a>
                </li>
                <li>
                  <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-shield-check me-2"></i>Admin Panel
                  </a>
                </li>
                @endif
                <li><hr class="dropdown-divider"></li>
                <li>
                  <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger">
                      <i class="bi bi-box-arrow-right me-2"></i>Sign Out
                    </button>
                  </form>
                </li>
              </ul>
            </div>
          @endguest
        </div>
      </div>
    </div>
  </nav>

  {{-- PAGE CONTENT --}}
  <main>
    @yield('content')
  </main>


  {{-- FOOTER --}}
  <footer class="ax-footer py-4 mt-auto">
    <div class="container">
      <div class="row align-items-center g-3">
        <div class="col-md-2">
          <div class="footer-logo">Auction<span>X</span></div>
          <div style="font-size:0.78rem;color:var(--muted);margin-top:4px">
            Bid. Win. Own Something Remarkable
          </div>
        </div>

        <div class="col-md-8">
          <div class="d-flex flex-wrap justify-content-md-center gap-3">
            <a href="{{ route('home') }}"
            class="footer-link">Home</a>
            <a class="footer-link">Auctions</a>
            <a href="{{ route('how-it-works') }}"    
            class="footer-link">How It Works</a>
            <a href="{{ route('about') }}"           
            class="footer-link">About</a>
            <a href="{{ route('privacy') }}"         
            class="footer-link">Privacy</a>
            <a href="{{ route('terms') }}"           
            class="footer-link">Terms</a>
            <a href="{{ route('support') }}"         
            class="footer-link">Support</a>
            <a href="{{ route('contact') }}"       
            class="footer-link">Contact</a>
          </div>
        </div>

        <div class="col-md-2 text-md-end">
          <div style="font-size:0.78rem;color:var(--muted)">
            &copy; {{ date('Y') }} AuctionX All rights reserved.
          </div>
        </div>
        
      </div>
    </div>
  </footer>
    
    {{-- Bootstrap 5 JS --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  {{-- Pusher JS + global socket connection for real-time bidding --}}
  <script src="https://js.pusher.com/8.4/pusher.min.js"></script>
  <script>
    // Single shared Pusher connection used across all pages
    window.AuctionXSocket = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
      cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
      // Required for private channels (admin.feed, seller.{id})
      authEndpoint: '/broadcasting/auth',
      auth: {
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
      }
    });
  </script>
  {{-- AuctionX JS --}}
  <script src="{{ asset('js/auctionx.js') }}"></script>

  @foreach(['success', 'error', 'info'] as $type)
  @if(session($type))
    <script>
      document.addEventListener('DOMContentLoaded',function(){
        showToast(null,{
           type:'{{ $type }}',
           title:@json(session($type)) 
          });
      });
    </script>
  @endif
  @endforeach

  @auth
  <script>


  //badge helpers
  function getUnreadCount(){ 
    var b=document.getElementById('notifBadge'); 
    return b?(parseInt(b.textContent,10)||0):0; 
  }
  function setUnreadCount(n){
    var b=document.getElementById('notifBadge');
    if(!b) return;
    if(n<=0){ 
      b.style.display='none'; 
      b.textContent='0'; return; 
    }
    b.textContent=n>99?'99+':n; 
    b.style.display='';
  }
  function incUnread(){ 
    setUnreadCount(getUnreadCount()+1); 
  }

  //build one dropdown row
  function buildNotifRow(n){
    var href=n.auctionId ? '/auctions/'+n.auctionId : '/notifications';
    var bg=n.isUnread ? 'background:#FFF5F2' : '';
    return '<a href="'+href+'" class="d-flex align-items-start gap-2 px-3 py-2 text-decoration-none notif-row"'+
      'data-notif-id="'+n.id+'" style="border-bottom:1px solid var(--border);'+bg+';"'+
      'onclick="markOneRead(event,\''+n.id+'\')">' +
      '<div class="flex-grow-1" style="min-width:0">'+
      '<div style="font-weight:'+(n.isUnread?'700':'500')+';font-size:.82rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">'+n.title+'</div>'+
      '<div style="font-size:.75rem;color:var(--muted);line-height:1.4;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">'+n.message+'</div>'+
      '<div style="font-size:.7rem;color:var(--muted);margin-top:2px">'+(n.ago||'')+'</div></div></a>';
  }

  //load dropdown via AJAX
  var notifLoaded=false;
  function loadNotifDropdown(){
    fetch('/notifications/dropdown',{headers:{'X-Requested-With':'XMLHttpRequest'}})
      .then(function(r){
        return r.json();
      })
      .then(function(data){
        notifLoaded=true; //only mark loaded on success
        setUnreadCount(data.unreadCount);
        var list=document.getElementById('notifList');
        list.innerHTML=data.notifications.map(buildNotifRow).join('');
      }).catch(function(){});
  }

  //mark one as read
  function markOneRead(e,id){
    fetch('/notifications/'+id+'/read',{method:'POST',headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','X-Requested-With':'XMLHttpRequest'}});
    var row=document.querySelector('[data-notif-id="'+id+'"]');
    if(row){ 
      row.style.background=''; 
      var t=row.querySelector('[style*="font-weight:700"]'); 
    if(t) 
    t.style.fontWeight='500'; 
  }
    var c=getUnreadCount(); 
    if(c>0) 
       setUnreadCount(c-1);
  }

  //mark all as read
  function markAllRead(){
    fetch('/notifications/mark-all',{method:'POST',headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','X-Requested-With':'XMLHttpRequest'}});
    setUnreadCount(0);
    document.querySelectorAll('.notif-row').forEach(function(row){
      row.style.background='';
      var t=row.querySelector('[style*="font-weight:700"]'); 
      if(t) 
       t.style.fontWeight='500';
    });
  }

  //pusher confi for real time updation
  var userCh=AuctionXSocket.subscribe('private-user.{{ auth()->id() }}');
  userCh.bind('notification.sent',function(data){
    incUnread();
    var list=document.getElementById('notifList');
    if(list && notifLoaded){
      data.isUnread=true;
      list.insertAdjacentHTML('afterbegin',buildNotifRow(data));
      var rows=list.querySelectorAll('.notif-row');
      if(rows.length>8) 
        rows[rows.length-1].remove();
    }
    showToast(null,{
      type:'info',
      title:data.title,
      sub:data.message
    });
  });

  //load badge count
  fetch('/notifications/dropdown',{headers:{'X-Requested-With':'XMLHttpRequest'}})
    .then(function(r){return r.json();})
    .then(function(d){setUnreadCount(d.unreadCount);})
    .catch(function(){});

  </script>
  @endauth

  @stack('scripts')
</body>
</html>