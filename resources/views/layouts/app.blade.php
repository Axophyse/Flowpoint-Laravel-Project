<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Flowpoint')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>

<body>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Sidebar Navigation --}}
    @auth
    <div class="sidebar">

        <img src="{{ asset('images/zenfour-logo-white.svg') }}" class="brandLogo" alt="Logo" >


        <div class="sidebar-buttons">
            <a href="{{ route('dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}">
                <i class="fa fa-home me-2"></i> Dashboard
            </a>
            <a href="{{ route('products.index') }}" class="{{ request()->is('products*') ? 'active' : '' }}">
                <i class="fa fa-box me-2"></i> Inventory
            </a>
            <a href="{{ route('sales.index') }}" class="{{ request()->is('sales*') ? 'active' : '' }}">
                <i class="fa fa-chart-line me-2"></i> Sales
            </a>
            <a href="{{ route('reports') }}" class="{{ request()->is('reports') ? 'active' : '' }}">
                <i class="fa fa-file-alt me-2"></i> Reports
            </a>
            <a href="{{ route('about') }}" class="{{ request()->is('about') ? 'active' : '' }}">
                <i class="fa fa-file-alt me-2"></i> Members
            </a>
        </div>
    </div>
    @endauth

    {{-- Top Bar --}}
    <div class="topbar">
        @auth

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
        @endauth
    </div>

    {{-- Main Content Area --}}
    <main class="main-content">
        @yield('content')
    </main>

    <footer class="body-footer">
        © {{ date('Y') }} ZenFour Flowpoint
    </footer>

</body>
</html>
