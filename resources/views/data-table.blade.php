@extends('layouts.app')

@section('title', 'Products Data Table')

@section('content')


<div class="main-body">

    <!-- Data Table Header -->
    <div class="data-table-header">
        <h1>Products Data Table</h1>
        <a href="{{ route('reports') }}" class="button-secondary">Back to Reports</a>
    </div>

    <!-- Sorting Info -->
    <div class="sorting-info">
        <p>Click on any column header to sort. Click again to reverse order.</p>
    </div>

    <!-- Products Table -->
    <div class="data-table-container">
        <div class="data-table-header-inner">
            <h5>All Products</h5>
        </div>
        <div class="data-table-wrapper" tabindex="0" role="region" aria-label="Products data table">
            <table class="data-table" id="productsTable">
                <thead>
                    <tr>
                        <th class="sortable" data-sort="id">
                            ID 
                            <span class="sort-indicator">↕</span>
                        </th>
                        <th class="sortable" data-sort="name">
                            Name 
                            <span class="sort-indicator">↕</span>
                        </th>
                        <th class="sortable" data-sort="price">
                            Price 
                            <span class="sort-indicator">↕</span>
                        </th>
                        <th class="sortable" data-sort="quantity">
                            Quantity 
                            <span class="sort-indicator">↕</span>
                        </th>
                        <th class="sortable" data-sort="category">
                            Category 
                            <span class="sort-indicator">↕</span>
                        </th>
                        <th class="sortable" data-sort="total_value">
                            Total Value 
                            <span class="sort-indicator">↕</span>
                        </th>
                        <th class="sortable" data-sort="created_date">
                            Created Date 
                            <span class="sort-indicator">↕</span>
                        </th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td><strong>{{ $product->name }}</strong></td>
                        <td>₱{{ number_format($product->price, 2) }}</td>
                        <td>
                            <span class="quantity-badge {{ $product->quantity > 20 ? 'quantity-high' : ($product->quantity > 10 ? 'quantity-medium' : 'quantity-low') }}">
                                {{ $product->quantity }}
                            </span>
                        </td>
                        <td>
                            <span class="category-badge">{{ $product->category }}</span>
                        </td>
                        <td>
                            <strong>₱{{ number_format($product->price * $product->quantity, 2) }}</strong>
                        </td>
                        <td>{{ $product->created_date->format('M d, Y') }}</td>
                        <td>
                            @if($product->quantity == 0)
                                <span class="status-badge status-out">Out of Stock</span>
                            @elseif($product->quantity < 10)
                                <span class="status-badge status-low">Low Stock</span>
                            @else
                                <span class="status-badge status-in">In Stock</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">No products found.</td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="5" class="text-end">Total:</th>
                        <th>₱{{ number_format($products->sum(function($product) {
                            return $product->price * $product->quantity;
                        }), 2) }}</th>
                        <th colspan="2"></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<script src="{{ asset('js/custom.js') }}?v=phase2"></script>
@endsection