@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/custom.css') }}?v=phase2">

<div class="home-body">

    <div class="home-welcome dashboard-header">
        <div>
            <h1>Welcome {{ Auth::user()->name }}</h1>
            <h5>What do you want to do today?</h5>
        </div>
    </div>

    <div class="home-links">
        <a href="{{ route('dashboard') }}" class="home-link"><i class="fa-solid fa-gauge-high" aria-hidden="true"></i> Dashboard</a>
        <a href="{{ route('products.index') }}" class="home-link"><i class="fa-solid fa-boxes-stacked" aria-hidden="true"></i> Inventory</a>
        <a href="{{ route('sales.index') }}" class="home-link"><i class="fa-solid fa-cart-shopping" aria-hidden="true"></i> Sales</a>
        <a href="{{ route('reports') }}" class="home-link"><i class="fa-solid fa-chart-column" aria-hidden="true"></i> Reports</a>
    </div>

</div>
@endsection
