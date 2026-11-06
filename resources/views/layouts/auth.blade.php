<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@hasSection('title')@yield('title') | @endif{{ config('app.name', 'Stockwise') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ @filemtime(public_path('css/app.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}?v={{ @filemtime(public_path('css/auth.css')) }}">
</head>

<body class="auth-body">

    <div class="auth-wrapper">

        <!-- BRANDING -->
        <section class="auth-branding">
            <img src="{{ asset('images/stockwise-logo-white.svg') }}" alt="{{ config('app.name') }} logo">
        </section>

        <!-- LOGIN / REGISTER / PASSWORD PANEL -->
        <section class="auth-sidebar">
            <main class="auth-main">
                @yield('content')
            </main>

            <footer class="footer-small">
                © {{ date('Y') }} ZenFour {{ config('app.name') }}
            </footer>
        </section>

    </div>

</body>
</html>
