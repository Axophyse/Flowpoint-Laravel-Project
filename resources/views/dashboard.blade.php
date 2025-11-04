@extends('layouts.app')

@section('title','Dashboard')

@section('content')

<link rel="stylesheet" href="{{ asset('css/custom.css') }}">

<div class="dashboard-container">

    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <h1>Dashboard</h1>
    </div>

    <!-- KPI Cards -->
    <div class="dashboard-cards">
        <div class="dashboard-card">
            <h5>Total Products</h5>
            <p>{{ $totalProducts }}</p>
        </div>

        <div class="dashboard-card">
            <h5>Monthly Total Sales</h5>
            <p>${{ number_format($monthlyTotalSales, 2) }}</p>
        </div>

        <div class="dashboard-card">
            <h5>Total Transactions</h5>
            <p>{{ $monthlyTotalTransaction }}</p>
        </div>

        <div class="dashboard-card">
            <h5>Monthly Average Sale</h5>
            <p>${{ number_format($monthlyAverageSales, 2) }}</p>
        </div>
    </div>

    <!-- Daily Sales Chart -->
    <div class="dashboard-chart">
        <h5>Daily Sales ({{ $currentMonth }})</h5>
        <canvas id="dailySalesChart" width="400" height="100"></canvas>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const dailySalesData = @json($dailySales);
    const labels = Object.keys(dailySalesData).map(day => `${day}`);
    const data = Object.values(dailySalesData);

    const ctx = document.getElementById('dailySalesChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Sales ($)',
                data: data,
                borderColor: '#00d1b2',
                backgroundColor: 'rgba(0, 209, 178, 0.2)',
                fill: true,
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>

@endsection
