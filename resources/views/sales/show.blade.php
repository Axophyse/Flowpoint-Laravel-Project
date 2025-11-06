@extends('layouts.app')

@section('title', 'Sale Details - ' . $sale->sale_number)

@section('content')

<link rel="stylesheet" href="{{ asset('css/custom.css') }}">
<link rel="stylesheet" href="{{ asset('css/sales.css') }}">

<div class="main-body">

    <!-- Sale Details Header -->
    <div class="sales-header">
        <h1>Sale Details</h1>
        <a href="{{ route('sales.index') }}" class="button-secondary">
            ← Back to Sales
        </a>
    </div>

    <div class="sales-details-container">
        <div class="sales-details-main">
            <div class="sales-card">
                <div class="sales-card-header">
                    <h5>Sale Information</h5>
                </div>
                <div class="sales-card-body">
                    <div class="sale-info-grid">
                        <div class="sale-info-section">
                            <table class="sale-info-table">
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
                        <div class="sale-info-section">
                            <table class="sale-info-table">
                                <tr>
                                    <th>Total Amount:</th>
                                    <td><strong>${{ number_format($sale->total_amount, 2) }}</strong></td>
                                </tr>
                                <tr>
                                    <th>Payment Method:</th>
                                    <td>
                                        <span class="payment-badge payment-{{ $sale->payment_method }}">
                                            {{ ucfirst($sale->payment_method) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        <span class="status-badge status-{{ $sale->status }}">
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

                    <div class="customer-info-section">
                        <h6>Customer Information</h6>
                        <table class="sale-info-table">
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

                    @if($sale->notes)
                    <div class="notes-section">
                        <h6>Notes</h6>
                        <div class="notes-content">
                            {{ $sale->notes }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="sales-details-sidebar">
            <div class="action-card">
                <div class="sales-card-header">
                    <h5>Actions</h5>
                </div>
                <div class="sales-card-body">
                    <div class="action-buttons">
                        <a href="{{ route('sales.edit', $sale) }}" class="button button-edit">
                            Edit Sale
                        </a>
                        <form action="{{ route('sales.destroy', $sale) }}" method="POST" class="action-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="button button-delete" onclick="return confirm('Are you sure you want to delete this sale?')">
                                Delete Sale
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="product-information-card">
                <div class="sales-card-header">
                    <h5>Product Information</h5>
                </div>
                
                <div class="sales-card-body">
                    <div class="product-info-list">
                        <p>Name: {{ $sale->product->name }}</p>
                        <p>Current Price:</strong> ${{ number_format($sale->product->price, 2) }}</p>
                        <p>Current Stock: {{ $sale->product->quantity }}</p>
                        <p>
                            Stock Status:
                            <span class="status-badge status-{{ $sale->product->stock_status_class }}">
                                {{ $sale->product->stock_status }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection