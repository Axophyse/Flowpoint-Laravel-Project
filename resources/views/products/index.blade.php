@extends('layouts.app')

@section('title', 'Inventory Management')

@section('content')

<link rel="stylesheet" href="{{ asset('css/custom.css') }}">

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

    <!-- Inventory Table Section -->
    <div class="inventory-card">
        <div class="inventory-card-header">
            <h5>All Products</h5>
        </div>

        <div class="inventory-card-body">
            <table class="inventory-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Created Date</th>
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
                                <br><small class="text-muted">{{ Str::limit($product->description, 50) }}</small>
                            @endif
                        </td>
                        <td>${{ number_format($product->price, 2) }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>{{ $product->category }}</td>
                        <td>{{ $product->stock_status }}</td>
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

            <!-- Pagination -->
            <div class="inventory-pagination">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>

@endsection
