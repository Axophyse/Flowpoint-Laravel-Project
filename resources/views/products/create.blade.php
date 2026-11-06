@extends('layouts.app')

@section('title', 'Create Product')

@section('content')

<link rel="stylesheet" href="{{ asset('css/inventory.css') }}?v=phase2">

<div class="main-body">

    <!-- Create Product Header -->
    <div class="inventory-header">
        <h1>Create New Product</h1>
        <a href="{{ route('products.index') }}" class="button-secondary">
            ← Back to Products
        </a>
    </div>

    <div class="inventory-form-container">
        <div class="inventory-form-main">
            <div class="inventory-card">
                <div class="inventory-card-header">
                    <h5>Product Information</h5>
                </div>
                <div class="inventory-card-body">
                    <form action="{{ route('products.store') }}" method="POST" class="inventory-form">
                        @csrf
                        <div class="form-row">
                            <div class="form-group">
                                <label for="name" class="form-label">Product Name *</label>
                                <input type="text" class="form-input @error('name') form-input-error @enderror" 
                                    id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="category" class="form-label">Category *</label>
                                <select class="form-input @error('category') form-input-error @enderror" 
                                    id="category" name="category" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category }}" {{ old('category') == $category ? 'selected' : '' }}>
                                            {{ $category }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="price" class="form-label">Price (₱) *</label>
                                <input type="number" step="0.01" class="form-input @error('price') form-input-error @enderror"
                                    id="price" name="price" value="{{ old('price') }}" required>
                                @error('price')
                                    <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="quantity" class="form-label">Quantity *</label>
                                <input type="number" class="form-input @error('quantity') form-input-error @enderror"
                                    id="quantity" name="quantity" value="{{ old('quantity') }}" required>
                                @error('quantity')
                                    <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-input @error('description') form-input-error @enderror"
                                id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="created_date" class="form-label">Created Date *</label>
                            <input type="date" class="form-input @error('created_date') form-input-error @enderror"
                                id="created_date" name="created_date" value="{{ old('created_date') }}" required>
                            @error('created_date')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="button-primary">
                                Create Product
                            </button>
                            <a href="{{ route('products.index') }}" class="button-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection