<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>@yield('title', 'AuctionX')</title>
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
            <a class="nav-link {{ request()->routeIs('auctions.*') ? 'active' : '' }}">
              <i class="bi bi-grid me-1"></i>View Items
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('favorites') ? 'active' : '' }}">
              <i class="bi bi-substack me-1"></i>Blogs
            </a>
          </li>
          @auth
            @if(auth()->user()->role === 'seller' || auth()->user()->role === 'admin')
            <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('seller.*') ? 'active' : '' }}"
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
        <form method="GET" 
              class="ax-search-form d-flex mx-auto mt-2 mt-lg-0">
          <input
            type="text"
            name="search"
            class="form-control"
            placeholder="Search auctions, items..."
            value="{{ request('search') }}"
            autocomplete="off"
          />
          <button type="submit" class="btn-search" title="Search">
            <i class="bi bi-search"></i>
          </button>
        </form>
 
        <div class="d-flex align-items-center gap-2 mt-2 mt-lg-0">
          @guest
            <a href="{{ route('login') }}" class="btn btn-ghost-ax btn-sm px-3">Sign In</a>
            <a href="{{ route('register') }}" class="btn btn-brown btn-sm px-3">Register</a>
          @else
            <button class="btn btn-ghost-ax btn-sm px-2" title="Notifications">
              <i class="bi bi-bell"></i>
            </button>
            {{-- User Dropdown --}}
            <div class="dropdown">
              <button class="btn btn-ghost-ax btn-sm px-3 dropdown-toggle" data-bs-toggle="dropdown">
                <i class="bi bi-person-circle me-1"></i>
                {{ auth()->user()->name }}
              </button>
              <ul class="dropdown-menu dropdown-menu-end shadow-sm border" style="border-color:var(--border)!important;border-radius:12px;font-family:'Nunito',sans-serif">
                <li>
                  <a class="dropdown-item">
                    <i class="bi bi-person me-2"></i>My Profile
                  </a>
                </li>
                <li>
                  <a class="dropdown-item" 
                  >
                    <i class="bi bi-hammer me-2"></i>My Bids
                  </a>
                </li>
                <li>
                  <a class="dropdown-item" 
                  >
                    <i class="bi bi-heart me-2"></i>Favorites
                  </a>
                </li>
                @if(auth()->user()->role === 'admin')
                <li><hr class="dropdown-divider"></li>
                <li>
                  <a class="dropdown-item">
                    <i class="bi bi-shield-check me-2"></i>Admin Panel
                  </a>
                </li>
                @endif
                <li><hr class="dropdown-divider"></li>
                <li>
                  <form method="POST">
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
  {{-- AuctionX JS --}}
  <script src="{{ asset('js/auctionx.js') }}"></script>
  @stack('scripts')
</body>
</html>