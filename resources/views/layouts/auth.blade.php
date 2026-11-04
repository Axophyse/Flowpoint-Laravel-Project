<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@hasSection('title')@yield('title') | @endif{{ config('app.name', 'Stockwise') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>

<body class="auth-body">

    <div class="auth-wrapper">
        
        <!-- BRANDING -->
        <section class="auth-branding d-flex flex-column justify-content-center">
            
            <div class="text-center">
                <img src="{{ asset('images/stockwise-logo-white.svg') }}"
                alt="{{ config('app.name') }} logo"
                style="width: 75%; height: auto; border-radius: auto;">
            </div>

        </section>

        <!-- RIGHT LOGIN/REGISTER SIDEBAR -->
        <section class="auth-sidebar d-flex flex-column justify-content-center px-5">
            @yield('content')
            
            <footer class="text-center text-light footer-small">
                © {{ date('Y') }} {{ config('app.name') }}
            </footer>
        </section>

    </div>

</body>
</html>
