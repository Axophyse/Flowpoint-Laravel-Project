@extends('layouts.app')

@section('title', $product->name)

@section('content')

<link rel="stylesheet" href="{{ asset('css/inventory.css') }}">

<div class="main-body">

    <!-- Product Details Header -->
    <div class="inventory-header">
        <h1>Product Details</h1>
        <a href="{{ route('products.index') }}" class="button-secondary">
            ← Back to Products
        </a>
    </div>

    <div class="product-details-container">
        <div class="product-details-main">
            <div class="inventory-card">
                <div class="inventory-card-header">
                    <h5>{{ $product->name }}</h5>
                </div>
                <div class="inventory-card-body">
                    <div class="product-info-grid">
                        <div class="product-info-section">
                            <table class="product-info-table">
                                <tr>
                                    <th>ID:</th>
                                    <td>{{ $product->id }}</td>
                                </tr>
                                <tr>
                                    <th>Name:</th>
                                    <td>{{ $product->name }}</td>
                                </tr>
                                <tr>
                                    <th>Price:</th>
                                    <td>${{ number_format($product->price, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Quantity:</th>
                                    <td>
                                        <span class="quantity-badge {{ $product->stock_status_class }}">
                                            {{ $product->quantity }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="product-info-section">
                            <table class="product-info-table">
                                <tr>
                                    <th>Category:</th>
                                    <td>
                                        <span class="category-badge">{{ $product->category }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        <span class="status-badge status-{{ $product->stock_status_class }}">
                                            {{ $product->stock_status }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Total Value:</th>
                                    <td><strong>${{ number_format($product->total_value, 2) }}</strong></td>
                                </tr>
                                <tr>
                                    <th>Created Date:</th>
                                    <td>{{ $product->created_date->format('M d, Y') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @if($product->description)
                    <div class="product-description">
                        <h6>Description:</h6>
                        <p class="description-text">{{ $product->description }}</p>
                    </div>
                    @endif

                    <div class="product-actions">
                        <a href="{{ route('products.edit', $product) }}" class="button button-edit">
                            Edit Product
                        </a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="button button-delete" 
                                onclick="return confirm('Are you sure you want to delete this product?')">
                                Delete Product
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="product-details-sidebar">
            <div class="inventory-card">
                <div class="inventory-card-header">
                    <h5>Quick Actions</h5>
                </div>
                <div class="inventory-card-body">
                    <div class="action-buttons">
                        <a href="{{ route('products.create') }}" class="button button-primary">
                            Add New Product
                        </a>
                        <a href="{{ route('products.edit', $product) }}" class="button button-edit">
                            Edit This Product
                        </a>
                        <a href="{{ route('products.index') }}" class="button button-secondary">
                            View All Products
                        </a>
                    </div>
                </div>
            </div>
            <div class="inventory-card">
                <div class="inventory-card-header">
                    <h5>Product Statistics</h5>
                </div>
                <div class="inventory-card-body">
                    <div class="statistics-display">
                        <h3>${{ number_format($product->total_value, 2) }}</h3>
                        <p class="statistics-label">Total Inventory Value</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection