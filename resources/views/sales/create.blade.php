@extends('layouts.app')

@section('title', 'Create New Sale')

@section('content')

<link rel="stylesheet" href="{{ asset('css/sales.css') }}?v=phase2">

<div class="main-body">

    <!-- Create Sale Header -->
    <div class="sales-header">
        <h1>Create New Sale</h1>
        <a href="{{ route('sales.index') }}" class="button-secondary">
            ← Back to Sales
        </a>
    </div>

    <div class="sales-form-container">
        <div class="sales-form-main">
            <div class="sales-card">
                <div class="sales-card-header">
                    <h5>Sale Information</h5>
                </div>
                <div class="sales-card-body">
                    <form action="{{ route('sales.store') }}" method="POST" id="saleForm" class="sales-form">
                        @csrf
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="product_id" class="form-label">Product *</label>
                                <select class="form-input @error('product_id') form-input-error @enderror" 
                                    id="product_id" name="product_id" required>
                                    <option value="">Select Product</option>
                                    @foreach($products as $product)
                                    <option value="{{ $product->id }}" 
                                        data-price="{{ $product->price }}"
                                        data-stock="{{ $product->quantity }}"
                                        {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }} - ₱{{ number_format($product->price, 2) }} (Stock: {{ $product->quantity }})
                                    </option>
                                    @endforeach
                                </select>
                                @error('product_id')
                                <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="sale_date" class="form-label">Sale Date *</label>
                                <input type="date" class="form-input @error('sale_date') form-input-error @enderror"
                                    id="sale_date" name="sale_date" value="{{ old('sale_date', date('Y-m-d')) }}" required>
                                @error('sale_date')
                                <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="quantity_sold" class="form-label">Quantity *</label>
                                <input type="number" class="form-input @error('quantity_sold') form-input-error @enderror"
                                    id="quantity_sold" name="quantity_sold" value="{{ old('quantity_sold', 1) }}" min="1" required>
                                @error('quantity_sold')
                                <div class="form-error">{{ $message }}</div>
                                @enderror
                                <small class="form-hint" id="stockInfo">Available stock: 0</small>
                            </div>
                            <div class="form-group">
                                <label for="unit_price" class="form-label">Unit Price (₱) *</label>
                                <input type="number" step="0.01" class="form-input @error('unit_price') form-input-error @enderror"
                                    id="unit_price" name="unit_price" value="{{ old('unit_price') }}" required>
                                @error('unit_price')
                                <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Total Amount</label>
                                <input type="text" class="form-input form-input-readonly" id="total_amount" readonly value="₱0.00">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="customer_name" class="form-label">Customer Name *</label>
                                <input type="text" class="form-input @error('customer_name') form-input-error @enderror"
                                    id="customer_name" name="customer_name" value="{{ old('customer_name') }}" required>
                                @error('customer_name')
                                <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="customer_email" class="form-label">Customer Email</label>
                                <input type="email" class="form-input @error('customer_email') form-input-error @enderror"
                                    id="customer_email" name="customer_email" value="{{ old('customer_email') }}">
                                @error('customer_email')
                                <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="customer_phone" class="form-label">Customer Phone</label>
                                <input type="text" class="form-input @error('customer_phone') form-input-error @enderror"
                                    id="customer_phone" name="customer_phone" value="{{ old('customer_phone') }}">
                                @error('customer_phone')
                                <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="payment_method" class="form-label">Payment Method *</label>
                                <select class="form-input @error('payment_method') form-input-error @enderror"
                                    id="payment_method" name="payment_method" required>
                                    @foreach($paymentMethods as $value => $label)
                                    <option value="{{ $value }}" {{ old('payment_method') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('payment_method')
                                <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="status" class="form-label">Status *</label>
                                <select class="form-input @error('status') form-input-error @enderror"
                                    id="status" name="status" required>
                                    @foreach($statuses as $value => $label)
                                    <option value="{{ $value }}" {{ old('status') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('status')
                                <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-input @error('notes') form-input-error @enderror"
                                id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                            @error('notes')
                            <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="button-primary">
                                Create Sale
                            </button>
                            <a href="{{ route('sales.index') }}" class="button-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="sales-form-sidebar">
            <div class="sales-card">
                <div class="sales-card-header">
                    <h5>Sale Summary</h5>
                </div>
                <div class="sales-card-body">
                    <div id="saleSummary" class="sale-summary">
                        <p class="text-muted">Select a product to see summary</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
        totalAmountInput.value = '₱' + total.toFixed(2);
        updateSummary();
    }

    function updateStockInfo() {
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        if (selectedOption && selectedOption.value) {
            const stock = parseInt(selectedOption.dataset.stock);
            stockInfo.textContent = 'Available stock: ' + stock;

            // Set unit price from product
            if (!unitPriceInput.value) {
                unitPriceInput.value = selectedOption.dataset.price;
            }

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
                <h6>Sale Details:</h6>
                <div class="summary-list">
                    <p><strong>Product:</strong> ${productName}</p>
                    <p><strong>Quantity:</strong> ${quantity}</p>
                    <p><strong>Unit Price:</strong> ₱${unitPrice.toFixed(2)}</p>
                    <p><strong>Total Amount:</strong> ₱${total.toFixed(2)}</p>
                </div>
            `;
        } else {
            saleSummary.innerHTML = '<p>Select a product to see summary</p>';
        }
    }

    productSelect.addEventListener('change', updateStockInfo);
    quantityInput.addEventListener('input', calculateTotal);
    unitPriceInput.addEventListener('input', calculateTotal);

    // Initialize
    updateStockInfo();
});
</script>
@endsection