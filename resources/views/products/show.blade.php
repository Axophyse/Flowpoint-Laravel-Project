@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Product Details</h1>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Products
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">{{ $product->name }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
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
                                        <span class="badge bg-{{ $product->stock_status_class }}">
                                            {{ $product->quantity }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Category:</th>
                                    <td>
                                        <span class="badge bg-info">{{ $product->category }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        <span class="badge bg-{{ $product->stock_status_class }}">
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
                    <div class="row mt-3">
                        <div class="col-12">
                            <h6>Description:</h6>
                            <p class="text-muted">{{ $product->description }}</p>
                        </div>
                    </div>
                    @endif

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="btn-group" role="group">
                                <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">
                                    <i class="fas fa-edit"></i> Edit Product
                                </a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" 
                                        onclick="return confirm('Are you sure you want to delete this product?')">
                                        <i class="fas fa-trash"></i> Delete Product
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('products.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add New Product
                        </a>
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit This Product
                        </a>
                        <a href="{{ route('products.index') }}" class="btn btn-secondary">
                            <i class="fas fa-list"></i> View All Products
                        </a>
                    </div>
                </div>
            </div>
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title">Product Statistics</h5>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <h3>${{ number_format($product->total_value, 2) }}</h3>
                        <p class="text-muted">Total Inventory Value</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection