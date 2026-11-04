<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@hasSection('title')@yield('title') | @endif{{ config('app.name', 'Stockwise') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Sidebar Navigation --}}
    @auth
    <div class="sidebar">

        <img src="{{ asset('images/stockwise-logo-white.svg') }}" class="brandLogo" alt="{{ config('app.name') }} logo">

        <div class="sidebar-buttons">
            <a href="{{ route('dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}">
                <i class="#"></i> Dashboard
            </a>
            <a href="{{ route('products.index') }}" class="{{ request()->is('products*') ? 'active' : '' }}">
                <i class="#"></i> Inventory
            </a>
            <a href="{{ route('sales.index') }}" class="{{ request()->is('sales*') ? 'active' : '' }}">
                <i class="f#"></i> Sales
            </a>
            <a href="{{ route('reports') }}" class="{{ request()->is('reports') ? 'active' : '' }}">
                <i class="#"></i> Reports
            </a>
            <a href="{{ route('about') }}" class="{{ request()->is('about') ? 'active' : '' }}">
                <i class="#"></i> Members
            </a>
        </div>
    </div>

    {{-- Top Bar --}}
    <div class="topbar">

        <div class="dropdown">
            <a class="text-light dropdown-toggle" href="#" role="button"
               data-bs-toggle="dropdown">
                {{ Auth::user()->name }}
            </a>
            <ul class="dropdown-menu dropdown-menu-white dropdown-menu-end">
                <li><a class="dropdown-item" href="#">Profile (no info)</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item"
                       href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                       document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                </li>
            </ul>
        </div>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
    @endauth

    {{-- Main Content Area --}}
    <main class="main-content">
        @yield('content')
    </main>

    <footer class="body-footer">
        © {{ date('Y') }} {{ config('app.name') }}
    </footer>

</body>
</html>
