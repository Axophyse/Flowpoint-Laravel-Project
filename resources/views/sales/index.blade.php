@extends('layouts.app')

@section('title', 'Sales Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Sales</h1>
                <div>
                    <a href="{{ route('sales.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> New Sale
                    </a>
                    <a href="{{ route('sales.report') }}" class="btn btn-info">
                        <i class="fas fa-chart-bar"></i> Sales Report
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Total Revenue</h5>
                    <h2 class="card-text">${{ number_format($totalSales, 2) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Total Transactions</h5>
                    <h2 class="card-text">{{ number_format($totalTransactions) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h5 class="card-title">Average Sale</h5>
                    <h2 class="card-text">${{ number_format($averageSale, 2) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5 class="card-title">This Month</h5>
                    <h2 class="card-text">${{ number_format($totalSales, 2) }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">All Sales</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Sale #</th>
                                    <th>Product</th>
                                    <th>Customer</th>
                                    <th>Qty</th>
                                    <th>Unit Price</th>
                                    <th>Total</th>
                                    <th>Payment</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sales as $sale)
                                <tr>
                                    <td>
                                        <strong>{{ $sale->sale_number }}</strong>
                                    </td>
                                    <td>
                                        <strong>{{ $sale->product->name }}</strong>
                                        <br><small class="text-muted">{{ $sale->product->category }}</small>
                                    </td>
                                    <td>
                                        {{ $sale->customer_name }}
                                        @if($sale->customer_email)
                                        <br><small class="text-muted">{{ $sale->customer_email }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $sale->quantity_sold }}</td>
                                    <td>${{ number_format($sale->unit_price, 2) }}</td>
                                    <td>
                                        <strong>${{ number_format($sale->total_amount, 2) }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $sale->payment_method_class }}">
                                            {{ ucfirst($sale->payment_method) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $sale->status_class }}">
                                            {{ ucfirst($sale->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $sale->sale_date->format('M d, Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('sales.show', $sale) }}" class="btn btn-info btn-sm" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('sales.edit', $sale) }}" class="btn btn-warning btn-sm" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('sales.destroy', $sale) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm('Are you sure you want to delete this sale?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center">No sales found. <a href="{{ route('sales.create') }}">Create the first sale</a></td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $sales->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection