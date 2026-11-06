@extends('layouts.app')

@section('title', 'Sales Report')

@section('content')

<link rel="stylesheet" href="{{ asset('css/sales.css') }}?v=phase2">

<div class="main-body">

    <!-- Sales Report Header -->
    <div class="sales-report-header">
        <h1>Sales Report</h1>
        <a href="{{ route('sales.index') }}" class="button-secondary">
            ← Back to Sales
        </a>
    </div>

    <!-- Summary Cards -->
    <div class="sales-report-cards">
        <div class="sales-card">
            <h5>Total Revenue</h5>
            <p>₱{{ number_format($totalRevenue, 2) }}</p>
        </div>
        <div class="sales-card">
            <h5>Items Sold</h5>
            <p>{{ number_format($totalItemsSold) }}</p>
        </div>
        <div class="sales-card">
            <h5>Avg Transaction</h5>
            <p>₱{{ number_format($averageTransaction, 2) }}</p>
        </div>
        <div class="sales-card">
            <h5>Total Transactions</h5>
            <p>{{ number_format($salesByPayment->sum('transactions')) }}</p>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="sales-report-charts">
        <!-- Daily Sales Chart - Now matches dashboard style -->
        <div class="sales-report-chart-large">
            <h5>Daily Sales ({{ \Carbon\Carbon::now()->format('F') }})</h5>
            <div class="chart-frame">
                <canvas id="dailySalesChart" role="img" aria-label="Bar chart of daily sales for the current month"></canvas>
            </div>
        </div>

        <!-- Sales by Payment Method -->
        <div class="sales-report-chart-small">
            <h5>Sales by Payment Method</h5>
            <div class="chart-frame">
                <canvas id="paymentMethodChart" role="img" aria-label="Doughnut chart of sales by payment method"></canvas>
            </div>
        </div>
    </div>

    <!-- Tables Section -->
    <div class="sales-report-tables">
        <!-- Sales by Category -->
        <div class="sales-report-table-container">
            <div class="sales-report-table-header">
                <h5>Sales by Category</h5>
            </div>
            <div class="sales-report-table-wrapper" tabindex="0" role="region" aria-label="Report table">
                <table class="sales-report-table">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Total Sales</th>
                            <th>Quantity Sold</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($salesByCategory as $category)
                        <tr>
                            <td>{{ $category->category }}</td>
                            <td>₱{{ number_format($category->total_sales, 2) }}</td>
                            <td>{{ number_format($category->total_quantity) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Top Selling Products -->
        <div class="sales-report-table-container">
            <div class="sales-report-table-header">
                <h5>Top Selling Products</h5>
            </div>
            <div class="sales-report-table-wrapper" tabindex="0" role="region" aria-label="Report table">
                <table class="sales-report-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity Sold</th>
                            <th>Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topProducts as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ number_format($product->total_sold) }}</td>
                            <td>₱{{ number_format($product->total_revenue, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.6.1/dist/chart.umd.min.js"></script>
<script src="{{ asset('js/chart-theme.js') }}?v=phase2"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {

    // Daily Sales Chart (same look as the dashboard)
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

    // Payment Method Chart (colours match the payment badges on the Sales page)
    const paymentLabels = @json($salesByPayment->pluck('payment_method'));
    const paymentTotals = @json($salesByPayment->pluck('total_sales'));
    const paymentColors = { cash: '#166534', card: '#2563EB', digital: '#7C3AED', transfer: '#D97706' };
    const fallback = StockwiseChart.categorical(paymentLabels.length);

    StockwiseChart.create('paymentMethodChart', {
        type: 'doughnut',
        data: {
            labels: paymentLabels.map(l => String(l).charAt(0).toUpperCase() + String(l).slice(1)),
            datasets: [{
                data: paymentTotals,
                backgroundColor: paymentLabels.map((l, i) => paymentColors[l] || fallback[i]),
                borderColor: '#FFFFFF',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '62%',
            plugins: {
                legend: { position: 'bottom' },
                tooltip: {
                    callbacks: {
                        label: function (ctx) { return ' ' + ctx.label + ': ' + StockwiseChart.peso(ctx.parsed, 2); }
                    }
                }
            }
        }
    });
});
</script>
@endsection
