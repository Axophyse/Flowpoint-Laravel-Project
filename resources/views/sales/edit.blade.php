@extends('layouts.app')

@section('title', 'Edit Sale - ' . $sale->sale_number)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Edit Sale</h1>
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
                    <h5 class="card-title">Edit Sale Information</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('sales.update', $sale) }}" method="POST" id="saleForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="product_id" class="form-label">Product *</label>
                                    <select class="form-control @error('product_id') is-invalid @enderror" 
                                        id="product_id" name="product_id" required>
                                        <option value="">Select Product</option>
                                        @foreach($products as $product)
                                        <option value="{{ $product->id }}" 
                                            data-price="{{ $product->price }}"
                                            data-stock="{{ $product->quantity }}"
                                            {{ old('product_id', $sale->product_id) == $product->id ? 'selected' : '' }}>
                                            {{ $product->name }} - ${{ number_format($product->price, 2) }} (Stock: {{ $product->quantity }})
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('product_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="sale_date" class="form-label">Sale Date *</label>
                                    <input type="date" class="form-control @error('sale_date') is-invalid @enderror"
                                        id="sale_date" name="sale_date" value="{{ old('sale_date', $sale->sale_date->format('Y-m-d')) }}" required>
                                    @error('sale_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="quantity_sold" class="form-label">Quantity *</label>
                                    <input type="number" class="form-control @error('quantity_sold') is-invalid @enderror"
                                        id="quantity_sold" name="quantity_sold" value="{{ old('quantity_sold', $sale->quantity_sold) }}" min="1" required>
                                    @error('quantity_sold')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted" id="stockInfo">Available stock: 0</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="unit_price" class="form-label">Unit Price ($) *</label>
                                    <input type="number" step="0.01" class="form-control @error('unit_price') is-invalid @enderror"
                                        id="unit_price" name="unit_price" value="{{ old('unit_price', $sale->unit_price) }}" required>
                                    @error('unit_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Total Amount</label>
                                    <input type="text" class="form-control" id="total_amount" readonly value="${{ number_format($sale->total_amount, 2) }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="customer_name" class="form-label">Customer Name *</label>
                                    <input type="text" class="form-control @error('customer_name') is-invalid @enderror"
                                        id="customer_name" name="customer_name" value="{{ old('customer_name', $sale->customer_name) }}" required>
                                    @error('customer_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="customer_email" class="form-label">Customer Email</label>
                                    <input type="email" class="form-control @error('customer_email') is-invalid @enderror"
                                        id="customer_email" name="customer_email" value="{{ old('customer_email', $sale->customer_email) }}">
                                    @error('customer_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="customer_phone" class="form-label">Customer Phone</label>
                                    <input type="text" class="form-control @error('customer_phone') is-invalid @enderror"
                                        id="customer_phone" name="customer_phone" value="{{ old('customer_phone', $sale->customer_phone) }}">
                                    @error('customer_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="payment_method" class="form-label">Payment Method *</label>
                                    <select class="form-control @error('payment_method') is-invalid @enderror"
                                        id="payment_method" name="payment_method" required>
                                        @foreach($paymentMethods as $value => $label)
                                        <option value="{{ $value }}" {{ old('payment_method', $sale->payment_method) == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('payment_method')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status *</label>
                                    <select class="form-control @error('status') is-invalid @enderror"
                                        id="status" name="status" required>
                                        @foreach($statuses as $value => $label)
                                        <option value="{{ $value }}" {{ old('status', $sale->status) == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror"
                                id="notes" name="notes" rows="3">{{ old('notes', $sale->notes) }}</textarea>
                            @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Sale
                            </button>
                            <a href="{{ route('sales.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Sale Summary</h5>
                </div>
                <div class="card-body">
                    <div id="saleSummary">
                        <h6>Current Details:</h6>
                        <p><strong>Product:</strong> {{ $sale->product->name }}</p>
                        <p><strong>Quantity:</strong> {{ $sale->quantity_sold }}</p>
                        <p><strong>Unit Price:</strong> ${{ number_format($sale->unit_price, 2) }}</p>
                        <p><strong>Total Amount:</strong> ${{ number_format($sale->total_amount, 2) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const productSelect = document.getElementById('product_id');
    const quantityInput = document.getElementById('quantity_sold');
    const unitPriceInput = document.getElementById('unit_price');
    const totalAmountInput = document.getElementById('total_amount');
    const stockInfo = document.getElementById('stockInfo');
    const saleSummary = document.getElementById('saleSummary');

    function calculateTotal() {
        const quantity = parseInt(quantityInput.value) || 0;
        const unitPrice = parseFloat(unitPriceInput.value) || 0;
        const total = quantity * unitPrice;
        totalAmountInput.value = '$' + total.toFixed(2);
        updateSummary();
    }

    function updateStockInfo() {
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        if (selectedOption && selectedOption.value) {
            const stock = parseInt(selectedOption.dataset.stock);
            stockInfo.textContent = 'Available stock: ' + stock;

            // Validate quantity
            const quantity = parseInt(quantityInput.value) || 0;
            if (quantity > stock) {
                quantityInput.setCustomValidity('Quantity exceeds available stock');
            } else {
                quantityInput.setCustomValidity('');
            }
        } else {
            stockInfo.textContent = 'Available stock: 0';
        }
        calculateTotal();
    }

    function updateSummary() {
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        if (selectedOption && selectedOption.value) {
            const productName = selectedOption.text.split(' - ')[0];
            const quantity = parseInt(quantityInput.value) || 0;
            const unitPrice = parseFloat(unitPriceInput.value) || 0;
            const total = quantity * unitPrice;

            saleSummary.innerHTML = `
                <h6>Updated Details:</h6>
                <p><strong>Product:</strong> ${productName}</p>
                <p><strong>Quantity:</strong> ${quantity}</p>
                <p><strong>Unit Price:</strong> $${unitPrice.toFixed(2)}</p>
                <p><strong>Total Amount:</strong> $${total.toFixed(2)}</p>
            `;
        } else {
            saleSummary.innerHTML = '<p class="text-muted">Select a product to see summary</p>';
        }
    }

    productSelect.addEventListener('change', updateStockInfo);
    quantityInput.addEventListener('input', calculateTotal);
    unitPriceInput.addEventListener('input', calculateTotal);

    // Initialize
    updateStockInfo();
});
</script>
@endpush