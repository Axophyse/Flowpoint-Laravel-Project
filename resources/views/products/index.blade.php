@extends('layouts.app')

@section('title', 'Inventory Management')

@section('content')

<link rel="stylesheet" href="{{ asset('css/custom.css') }}">
<link rel="stylesheet" href="{{ asset('css/inventory.css') }}">

<div class="main-body">

    <!-- Inventory Header -->
    <div class="inventory-header">
        <h1>Inventory</h1>
        <a href="{{ route('products.create') }}" class="button-primary">
            + Add New Product
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="inventory-alert success">
        {{ session('success') }}
    </div>
    @endif

    <!-- Sorting Info -->
    <div class="sorting-info">
        <p>Click on any column header to sort. Click again to reverse order.</p>
    </div>

    <!-- Inventory Table Section -->
    <div class="inventory-card">
        <div class="inventory-card-header">
            <h5>All Products</h5>
        </div>

        <div class="inventory-card-body">
            <div class="inventory-table-wrapper">
                <table class="inventory-table" id="inventoryTable">
                    <thead>
                        <tr>
                            <th class="sortable" data-sort="id">
                                ID <span class="sort-indicator">↕</span>
                            </th>
                            <th class="sortable" data-sort="name">
                                Name <span class="sort-indicator">↕</span>
                            </th>
                            <th class="sortable" data-sort="price">
                                Price <span class="sort-indicator">↕</span>
                            </th>
                            <th class="sortable" data-sort="quantity">
                                Quantity <span class="sort-indicator">↕</span>
                            </th>
                            <th class="sortable" data-sort="category">
                                Category <span class="sort-indicator">↕</span>
                            </th>
                            <th class="sortable" data-sort="status">
                                Status <span class="sort-indicator">↕</span>
                            </th>
                            <th class="sortable" data-sort="created_date">
                                Created Date <span class="sort-indicator">↕</span>
                            </th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>
                                <strong>{{ $product->name }}</strong>
                                @if($product->description)
                                    <br><small>{{ Str::limit($product->description, 50) }}</small>
                                @endif
                            </td>
                            <td>${{ number_format($product->price, 2) }}</td>
                            <td>
                                <span class="quantity-badge {{ $product->quantity > 20 ? 'quantity-high' : ($product->quantity > 10 ? 'quantity-medium' : 'quantity-low') }}">
                                    {{ $product->quantity }}
                                </span>
                            </td>
                            <td>
                                <span class="category-badge">{{ $product->category }}</span>
                            </td>
                            <td>
                                <span class="status-badge status-{{ $product->stock_status_class }}">
                                    {{ $product->stock_status }}
                                </span>
                            </td>
                            <td>{{ $product->created_date->format('M d, Y') }}</td>
                            <td class="inventory-actions">
                                <a href="{{ route('products.show', $product) }}" class="button button-view">View</a>
                                <a href="{{ route('products.edit', $product) }}" class="button button-edit">Edit</a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="button button-delete"
                                        onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">No products found. <a href="{{ route('products.create') }}">Create one</a></td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="inventory-pagination">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/custom.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize inventory table sorting
    if (typeof makeTableSortable === 'function') {
        makeTableSortable('inventoryTable');
    }
});
</script>

@endsection