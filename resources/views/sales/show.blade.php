@extends('layouts.app')

@section('title', 'Sale Details - ' . $sale->sale_number)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Sale Details</h1>
                <a href="{{ route('sales.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Sales
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Sale Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Sale Number:</th>
                                    <td>{{ $sale->sale_number }}</td>
                                </tr>
                                <tr>
                                    <th>Product:</th>
                                    <td>{{ $sale->product->name }}</td>
                                </tr>
                                <tr>
                                    <th>Category:</th>
                                    <td>{{ $sale->product->category }}</td>
                                </tr>
                                <tr>
                                    <th>Quantity Sold:</th>
                                    <td>{{ $sale->quantity_sold }}</td>
                                </tr>
                                <tr>
                                    <th>Unit Price:</th>
                                    <td>${{ number_format($sale->unit_price, 2) }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Total Amount:</th>
                                    <td><strong>${{ number_format($sale->total_amount, 2) }}</strong></td>
                                </tr>
                                <tr>
                                    <th>Payment Method:</th>
                                    <td>
                                        <span class="badge bg-{{ $sale->payment_method_class }}">
                                            {{ ucfirst($sale->payment_method) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        <span class="badge bg-{{ $sale->status_class }}">
                                            {{ ucfirst($sale->status) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Sale Date:</th>
                                    <td>{{ $sale->sale_date->format('M d, Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Created At:</th>
                                    <td>{{ $sale->created_at->format('M d, Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <h6>Customer Information</h6>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Customer Name:</th>
                                    <td>{{ $sale->customer_name }}</td>
                                </tr>
                                <tr>
                                    <th>Customer Email:</th>
                                    <td>{{ $sale->customer_email ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Customer Phone:</th>
                                    <td>{{ $sale->customer_phone ?? 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @if($sale->notes)
                    <div class="row mt-3">
                        <div class="col-12">
                            <h6>Notes</h6>
                            <div class="card">
                                <div class="card-body">
                                    {{ $sale->notes }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('sales.edit', $sale) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit Sale
                        </a>
                        <form action="{{ route('sales.destroy', $sale) }}" method="POST" class="d-grid">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this sale?')">
                                <i class="fas fa-trash"></i> Delete Sale
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title">Product Information</h5>
                </div>
                <div class="card-body">
                    <p><strong>Name:</strong> {{ $sale->product->name }}</p>
                    <p><strong>Current Price:</strong> ${{ number_format($sale->product->price, 2) }}</p>
                    <p><strong>Current Stock:</strong> {{ $sale->product->quantity }}</p>
                    <p>
                        <strong>Stock Status:</strong>
                        <span class="badge bg-{{ $sale->product->stock_status_class }}">
                            {{ $sale->product->stock_status }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection