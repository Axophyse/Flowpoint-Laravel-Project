@extends('layouts.app')

@section('title', 'Sales Management')

@section('content')

<link rel="stylesheet" href="{{ asset('css/sales.css') }}">

<div class="main-body">

    <!-- Sales Header -->
    <div class="sales-header">
        <h1>Sales</h1>
        <div class="sales-actions">
            <a href="{{ route('sales.create') }}" class="button-primary">+ New Sale</a>
            <a href="{{ route('sales.report') }}" class="button-secondary">Sales Report</a>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="sales-alert success">
        {{ session('success') }}
    </div>
    @endif

    <!-- Summary Cards -->
    <div class="sales-summary">
        <div class="sales-card">
            <h5>Total Revenue</h5>
            <p>${{ number_format($totalSales, 2) }}</p>
        </div>
        <div class="sales-card">
            <h5>Total Transactions</h5>
            <p>{{ number_format($totalTransactions) }}</p>
        </div>
        <div class="sales-card">
            <h5>Average Sale</h5>
            <p>${{ number_format($averageSale, 2) }}</p>
        </div>
        <div class="sales-card">
            <h5>This Month</h5>
            <p>${{ number_format($totalSales, 2) }}</p>
        </div>
    </div>

    <!-- Sales Table -->
    <div class="sales-table-container">
        <div class="sales-table-header">
            <h5>All Sales</h5>
        </div>

        <div class="sales-table-wrapper">
            <table class="sales-table" id="salesTable">
                <thead>
                    <tr>
                        <th class="sortable" data-sort="sale_number">
                            Sale # <span class="sort-indicator">↕</span>
                        </th>
                        <th class="sortable" data-sort="product_name">
                            Product <span class="sort-indicator">↕</span>
                        </th>
                        <th class="sortable" data-sort="customer_name">
                            Customer <span class="sort-indicator">↕</span>
                        </th>
                        <th class="sortable" data-sort="quantity_sold">
                            Qty <span class="sort-indicator">↕</span>
                        </th>
                        <th class="sortable" data-sort="unit_price">
                            Unit Price <span class="sort-indicator">↕</span>
                        </th>
                        <th class="sortable" data-sort="total_amount">
                            Total <span class="sort-indicator">↕</span>
                        </th>
                        <th class="sortable" data-sort="payment_method">
                            Payment <span class="sort-indicator">↕</span>
                        </th>
                        <th class="sortable" data-sort="status">
                            Status <span class="sort-indicator">↕</span>
                        </th>
                        <th class="sortable" data-sort="sale_date">
                            Date <span class="sort-indicator">↕</span>
                        </th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sales as $sale)
                    <tr>
                        <td><strong>{{ $sale->sale_number }}</strong></td>
                        <td>
                            <strong>{{ $sale->product->name }}</strong><br>
                            <small>{{ $sale->product->category }}</small>
                        </td>
                        <td>
                            {{ $sale->customer_name }}
                            @if($sale->customer_email)
                                <br><small>{{ $sale->customer_email }}</small>
                            @endif
                        </td>
                        <td>{{ $sale->quantity_sold }}</td>
                        <td>${{ number_format($sale->unit_price, 2) }}</td>
                        <td><strong>${{ number_format($sale->total_amount, 2) }}</strong></td>
                        <td>
                            <span class="payment-badge payment-{{ $sale->payment_method }}">
                                {{ ucfirst($sale->payment_method) }}
                            </span>
                        </td>
                        <td>
                            <span class="status-badge status-{{ $sale->status }}">
                                {{ ucfirst($sale->status) }}
                            </span>
                        </td>
                        <td>{{ $sale->sale_date->format('M d, Y') }}</td>
                        <td class="sales-actions">
                            <a href="{{ route('sales.show', $sale) }}" class="button button-view">View</a>
                            <a href="{{ route('sales.edit', $sale) }}" class="button button-edit">Edit</a>
                            <form action="{{ route('sales.destroy', $sale) }}" method="POST" class="inline-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="button button-delete"
                                    onclick="return confirm('Are you sure you want to delete this sale?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center">
                            No sales found. <a href="{{ route('sales.create') }}">Create the first sale</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="sales-pagination">
            {{ $sales->links() }}
        </div>
    </div>

</div>

<script src="{{ asset('js/custom.js') }}"></script>
@endsection