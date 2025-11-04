@extends('layouts.app')

@section('title', 'Products Data Table')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Products Data Table</h1>
                <a href="{{ route('reports') }}" class="btn btn-secondary">Back to Reports</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">All Products</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="productsTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Category</th>
                                    <th>Total Value</th>
                                    <th>Created Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td><strong>{{ $product->name }}</strong></td>
                                    <td>${{ number_format($product->price, 2) }}</td>
                                    <td>
                                        <span class="badge {{ $product->quantity > 20 ? 'bg-success' : ($product->quantity > 10 ? 'bg-warning' : 'bg-danger') }}">
                                            {{ $product->quantity }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $product->category }}</span>
                                    </td>
                                    <td>
                                        <strong>${{ number_format($product->price * $product->quantity, 2) }}</strong>
                                    </td>
                                    <td>{{ $product->created_date->format('M d, Y') }}</td>
                                    <td>
                                        @if($product->quantity == 0)
                                            <span class="badge bg-danger">Out of Stock</span>
                                        @elseif($product->quantity < 10)
                                            <span class="badge bg-warning">Low Stock</span>
                                        @else
                                            <span class="badge bg-success">In Stock</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="5" class="text-end">Total:</th>
                                    <th>${{ number_format($products->sum(function($product) {
                                        return $product->price * $product->quantity;
                                    }), 2) }}</th>
                                    <th colspan="2"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .table th {
        background-color: #f8f9fa;
        font-weight: 600;
    }

    .badge {
        font-size: 0.75em;
    }
</style>
@endpush