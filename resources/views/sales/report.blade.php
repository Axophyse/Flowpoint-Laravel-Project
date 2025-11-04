@extends('layouts.app')

@section('title', 'Sales Report')

@section('content')
<div class="container-fluid">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4" style="color: white">
                <h1>Sales Report</h1>
                <a href="{{ route('sales.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Sales
                </a>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Total Revenue</h5>
                    <h2 class="card-text">${{ number_format($totalRevenue, 2) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Items Sold</h5>
                    <h2 class="card-text">{{ number_format($totalItemsSold) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h5 class="card-title">Avg Transaction</h5>
                    <h2 class="card-text">${{ number_format($averageTransaction, 2) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5 class="card-title">Total Transactions</h5>
                    <h2 class="card-text">{{ number_format($salesByPayment->sum('transactions')) }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Daily Sales Chart -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Daily Sales (Last 30 Days)</h5>
                    <canvas id="dailySalesChart" height="100"></canvas>
                </div>
            </div>
        </div>

        <!-- Sales by Payment Method -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Sales by Payment Method</h5>
                </div>
                <div class="card-body">
                    <canvas id="paymentMethodChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Sales by Category -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Sales by Category</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
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
            </div>
        </div>

        <!-- Top Selling Products -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Top Selling Products</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
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
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // Daily Sales Chart
    const dailySalesData = @json($dailySales);

    const labels = Object.keys(dailySalesData).map(day => `${day}`);
    const data = Object.values(dailySalesData);

    const ctx = document.getElementById('dailySalesChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Sales ($)',
                data: data,
                fill: false,
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

    // Payment Method Chart
    const paymentMethodCtx = document.getElementById('paymentMethodChart').getContext('2d');
    const paymentMethodChart = new Chart(paymentMethodCtx, {
        type: 'doughnut',
        data: {
            labels: @json($salesByPayment->pluck('payment_method')),
            datasets: [{
                data: @json($salesByPayment->pluck('total_sales')),
                backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)'
                ]
            }]
        },
        options: {
            responsive: true
        }
    });
});
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@endpush