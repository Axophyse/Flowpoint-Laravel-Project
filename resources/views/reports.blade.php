@extends('layouts.app')

@section('title', 'Summary Reports')

@section('content')


<div class="main-body">

    <!-- Reports Header -->
    <div class="reports-header">
        <h1>Summary Reports</h1>
    </div>

    <!-- Summary Cards -->
    <div class="reports-cards">
        <div class="reports-card">
            <h5>Total Products</h5>
            <p>{{ $products->count() }}</p>
        </div>

        <div class="reports-card">
            <h5>Total Value</h5>
            <p>₱{{ number_format($products->sum(function($product) {
                return $product->price * $product->quantity;
            }), 2) }}</p>
        </div>

        <div class="reports-card">
            <h5>Avg Price</h5>
            <p>₱{{ number_format($products->avg('price'), 2) }}</p>
        </div>

        <div class="reports-card">
            <h5>Categories</h5>
            <p>{{ $categoryData->count() }}</p>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="reports-charts">
        <!-- Category Distribution -->
        <div class="reports-chart">
            <h5>Products by Category</h5>
            <div class="chart-frame chart-frame--sm">
                <canvas id="categoryChart" role="img" aria-label="Bar chart of products by category"
                        data-labels='{!! json_encode($categoryData->pluck('category')) !!}'
                        data-values='{!! json_encode($categoryData->pluck('count')) !!}'></canvas>
            </div>
        </div>

        <!-- Price Range Distribution -->
        <div class="reports-chart">
            <h5>Products by Price Range</h5>
            <div class="chart-frame chart-frame--sm">
                <canvas id="priceRangeChart" role="img" aria-label="Bar chart of products by price range"
                        data-labels='{!! json_encode($priceRangeData->pluck('price_range')) !!}'
                        data-values='{!! json_encode($priceRangeData->pluck('count')) !!}'></canvas>
            </div>
        </div>
    </div>

    <!-- Monthly Sales Chart -->
    <div class="reports-chart-full">
        <h5>Monthly Sales</h5>
        <div class="chart-frame">
            <canvas id="monthlySalesChart" role="img" aria-label="Bar chart of monthly sales"
                    data-values='{!! json_encode($allMonthsData) !!}'></canvas>
        </div>
    </div>

    <!-- Products Table -->
    <div class="reports-table-container">
        <div class="reports-table-header">
            <h5>Products List</h5>
            <a href="/data-table" class="button-primary">View Full Table</a>
        </div>
        <div class="reports-table-wrapper" tabindex="0" role="region" aria-label="Products list table">
            <table class="reports-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Category</th>
                        <th>Total Value</th>
                        <th>Created Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products->take(5) as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>₱{{ number_format($product->price, 2) }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>
                            <span class="category-badge">{{ $product->category }}</span>
                        </td>
                        <td>₱{{ number_format($product->price * $product->quantity, 2) }}</td>
                        <td>{{ $product->created_date->format('M d, Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">No products found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.6.1/dist/chart.umd.min.js"></script>
<script src="{{ asset('js/chart-theme.js') }}?v=phase2"></script>
<script src="{{ asset('js/custom.js') }}?v=phase2"></script>
@endsection