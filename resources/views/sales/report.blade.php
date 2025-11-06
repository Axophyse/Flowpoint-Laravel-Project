@extends('layouts.app')

@section('title', 'Sales Report')

@section('content')

<link rel="stylesheet" href="{{ asset('css/custom.css') }}">

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
        <div class="sales-report-card">
            <h5>Total Revenue</h5>
            <p>${{ number_format($totalRevenue, 2) }}</p>
        </div>
        <div class="sales-report-card">
            <h5>Items Sold</h5>
            <p>{{ number_format($totalItemsSold) }}</p>
        </div>
        <div class="sales-report-card">
            <h5>Avg Transaction</h5>
            <p>${{ number_format($averageTransaction, 2) }}</p>
        </div>
        <div class="sales-report-card">
            <h5>Total Transactions</h5>
            <p>{{ number_format($salesByPayment->sum('transactions')) }}</p>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="sales-report-charts">
        <!-- Daily Sales Chart - Now matches dashboard style -->
        <div class="sales-report-chart-large">
            <h5>Daily Sales ({{ \Carbon\Carbon::now()->format('F') }})</h5>
            <canvas id="dailySalesChart" width="400" height="100"></canvas>
        </div>

        <!-- Sales by Payment Method -->
        <div class="sales-report-chart-small">
            <h5>Sales by Payment Method</h5>
            <canvas id="paymentMethodChart" width="400" height="200"></canvas>
        </div>
    </div>

    <!-- Tables Section -->
    <div class="sales-report-tables">
        <!-- Sales by Category -->
        <div class="sales-report-table-container">
            <div class="sales-report-table-header">
                <h5>Sales by Category</h5>
            </div>
            <div class="sales-report-table-wrapper">
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
                            <td>${{ number_format($category->total_sales, 2) }}</td>
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
            <div class="sales-report-table-wrapper">
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
                            <td>${{ number_format($product->total_revenue, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // Daily Sales Chart - Now matches dashboard exactly
    const dailySalesData = @json($dailySales);
    const labels = Object.keys(dailySalesData).map(day => `${day}`);
    const data = Object.values(dailySalesData);

    const ctx = document.getElementById('dailySalesChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar', // Changed from 'line' to 'bar'
        data: {
            labels: labels,
            datasets: [{
                label: 'Sales ($)',
                data: data,
                borderColor: '#00d1b2',
                backgroundColor: 'rgba(0, 209, 178, 0.4)', // Same as dashboard
                borderWidth: 2 // Same as dashboard
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    ticks: {
                        color: '#ffffff' // x-axis labels
                    },
                    grid: {
                        color: 'rgba(255,255,255,0.1)' // subtle grid lines
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: '#ffffff' // y-axis labels
                    },
                    grid: {
                        color: 'rgba(255,255,255,0.1)'
                    }
                }
            },
            plugins: {
                legend: {
                    labels: {
                        color: '#ffffff' // legend text
                    }
                },
                title: {
                    color: '#ffffff'
                }
            }
        }
    });

    // Payment Method Chart
    const paymentMethodCtx = document.getElementById('paymentMethodChart').getContext('2d');
    const paymentMethodChart = new Chart(paymentMethodCtx, {
        type: 'doughnut',
        data: {
            labels: @json($salesByPayment->pluck('payment_method')),
            datasets: [{
                data: @json($salesByPayment->pluck('total_sales')),
                backgroundColor: [
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(255, 205, 86, 0.8)',
                    'rgba(75, 192, 192, 0.8)'
                ],
                borderColor: '#ffffff',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: '#ffffff',
                        padding: 15
                    }
                }
            }
        }
    });
});
</script>
@endsection