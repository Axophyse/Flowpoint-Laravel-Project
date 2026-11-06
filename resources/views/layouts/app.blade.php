<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@hasSection('title')@yield('title') | @endif{{ config('app.name', 'Stockwise') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ @filemtime(public_path('css/app.css')) }}">
</head>

<body class="{{ auth()->check() ? 'has-sidebar' : 'is-guest' }}">

    <a class="skip-link" href="#main-content">Skip to main content</a>

    <div class="app-frame">

        {{-- Sidebar Navigation (Bootstrap responsive offcanvas: slide-in drawer below 992px, fixed column above) --}}
        @auth
        <aside class="offcanvas-lg offcanvas-start app-sidebar" tabindex="-1" id="appSidebar" aria-label="Main navigation">
            <div class="app-sidebar-inner">

                <div class="offcanvas-header">
                    <a href="{{ route('dashboard') }}" class="sw-brand-link">
                        <img src="{{ asset('images/stockwise-logo-white.svg') }}" alt="{{ config('app.name') }} logo">
                    </a>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#appSidebar" aria-label="Close navigation menu"></button>
                </div>

                <div class="offcanvas-body">
                    <a href="{{ route('dashboard') }}" class="sw-brand d-none d-lg-block">
                        <img src="{{ asset('images/stockwise-logo-white.svg') }}" alt="{{ config('app.name') }} logo">
                    </a>

                    <nav class="sw-nav" aria-label="Primary">
                        <a href="{{ route('dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}" @if(request()->is('dashboard')) aria-current="page" @endif>
                            <i class="fa-solid fa-gauge-high" aria-hidden="true"></i> Dashboard
                        </a>
                        <a href="{{ route('products.index') }}" class="{{ request()->is('products*') ? 'active' : '' }}" @if(request()->is('products*')) aria-current="page" @endif>
                            <i class="fa-solid fa-boxes-stacked" aria-hidden="true"></i> Inventory
                        </a>
                        <a href="{{ route('sales.index') }}" class="{{ request()->is('sales*') ? 'active' : '' }}" @if(request()->is('sales*')) aria-current="page" @endif>
                            <i class="fa-solid fa-cart-shopping" aria-hidden="true"></i> Sales
                        </a>
                        <a href="{{ route('reports') }}" class="{{ request()->is('reports', 'data-table') ? 'active' : '' }}" @if(request()->is('reports', 'data-table')) aria-current="page" @endif>
                            <i class="fa-solid fa-chart-column" aria-hidden="true"></i> Reports
                        </a>
                        <a href="{{ route('about') }}" class="{{ request()->is('about') ? 'active' : '' }}" @if(request()->is('about')) aria-current="page" @endif>
                            <i class="fa-solid fa-users" aria-hidden="true"></i> Members
                        </a>
                        <a href="{{ route('contact') }}" class="{{ request()->is('contact') ? 'active' : '' }}" @if(request()->is('contact')) aria-current="page" @endif>
                            <i class="fa-solid fa-envelope" aria-hidden="true"></i> Contact
                        </a>
                    </nav>
                </div>

            </div>
        </aside>
        @endauth

        <div class="app-main">

            {{-- Top Bar --}}
            @auth
            <header class="app-topbar">
                <button type="button" class="sw-icon-btn d-lg-none" data-bs-toggle="offcanvas" data-bs-target="#appSidebar"
                        aria-controls="appSidebar" aria-label="Open navigation menu">
                    <i class="fa-solid fa-bars" aria-hidden="true"></i>
                </button>

                <p class="app-topbar-title">@hasSection('title')@yield('title')@else{{ config('app.name') }}@endif</p>

                <div class="app-topbar-spacer"></div>

                <div class="dropdown">
                    <a class="user-menu-toggle dropdown-toggle" href="#" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false" aria-label="Account menu for {{ Auth::user()->name }}">
                        <span class="user-avatar" aria-hidden="true">{{ strtoupper(mb_substr(Auth::user()->name, 0, 1)) }}</span>
                        <span class="user-name d-none d-sm-inline">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#">Profile (no info)</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item"
                               href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                               document.getElementById('logout-form').submit();">
                                <i class="fa-solid fa-right-from-bracket me-2" aria-hidden="true"></i>Logout
                            </a>
                        </li>
                    </ul>
                </div>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </header>
            @else
            {{-- Public pages (About, Contact, Reports, Data Table when signed out) --}}
            <header class="guest-header">
                <a href="{{ route('login') }}" class="sw-brand-link">
                    <img src="{{ asset('images/stockwise-logo-white.svg') }}" alt="{{ config('app.name') }} logo">
                </a>
                <nav class="guest-nav" aria-label="Public navigation">
                    <a href="{{ route('about') }}">Members</a>
                    <a href="{{ route('contact') }}">Contact</a>
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('register') }}" class="button-primary">Register</a>
                </nav>
            </header>
            @endauth

            {{-- Main Content Area --}}
            <main class="main-content" id="main-content">
                @yield('content')
            </main>

            <footer class="app-footer">
                © {{ date('Y') }} ZenFour {{ config('app.name') }}
            </footer>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
