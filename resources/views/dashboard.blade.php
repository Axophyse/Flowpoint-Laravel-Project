@extends('layouts.app')

@section('title','Dashboard')

@section('content')


<div class="main-body">

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
            <p>₱{{ number_format($monthlyTotalSales, 2) }}</p>
        </div>

        <div class="dashboard-card">
            <h5>Total Transactions</h5>
            <p>{{ $monthlyTotalTransaction }}</p>
        </div>

        <div class="dashboard-card">
            <h5>Monthly Average Sale</h5>
            <p>₱{{ number_format($monthlyAverageSales, 2) }}</p>
        </div>
    </div>

    <!-- Daily Sales Chart -->
    <div class="dashboard-chart">
        <h5>Daily Sales ({{ $currentMonth }})</h5>
        <div class="chart-frame">
            <canvas id="dailySalesChart" role="img" aria-label="Bar chart of daily sales for {{ $currentMonth }}"></canvas>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.6.1/dist/chart.umd.min.js"></script>
<script src="{{ asset('js/chart-theme.js') }}?v=phase2"></script>

<script>
    (function () {
        const dailySalesData = @json($dailySales);
        const labels = Object.keys(dailySalesData).map(day => `${day}`);
        const data = Object.values(dailySalesData);

        StockwiseChart.create('dailySalesChart', {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [StockwiseChart.barDataset('Sales (₱)', data)]
            },
            options: StockwiseChart.barOptions({ currency: true })
        });
    })();
</script>

@endsection
