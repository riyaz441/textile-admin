@extends('layouts.master')
@section('title', isset($product) ? 'Edit Product - ' . env('APP_NAME') : 'Add Product - ' . env('APP_NAME'))
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('components.alert')
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">{{ isset($product) ? 'Edit Product' : 'Add New Product' }}</h5>
                        <button type="button" class="btn btn-secondary"
                            onclick="location.href='{{ route('products.index') }}'">
                            Back to Products
                        </button>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('products.save', $product->id ?? null) }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Basic Information -->
                            <div class="mb-3">
                                <h6 class="fw-bold mb-3">Basic Information</h6>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="name">Product Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" placeholder="Enter product name"
                                        value="{{ old('name', isset($product) ? $product->name : '') }}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="sku">SKU (Stock Keeping Unit) <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('sku') is-invalid @enderror"
                                        id="sku" name="sku" placeholder="e.g., PRD-001"
                                        value="{{ old('sku', isset($product) ? $product->sku : '') }}">
                                    @error('sku')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="category">Category <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select @error('category') is-invalid @enderror" id="category"
                                        name="category">
                                        <option value="">Select Category</option>
                                        <option value="male"
                                            {{ old('category', isset($product) ? $product->category : '') == 'male' ? 'selected' : '' }}>
                                            Male</option>
                                        <option value="female"
                                            {{ old('category', isset($product) ? $product->category : '') == 'female' ? 'selected' : '' }}>
                                            Female</option>
                                        <option value="kids"
                                            {{ old('category', isset($product) ? $product->category : '') == 'kids' ? 'selected' : '' }}>
                                            Kids</option>
                                    </select>
                                    @error('category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="description">Description <span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control @error('description') is-invalid @enderror"
                                        id="description" name="description" placeholder="Enter detailed description"
                                        rows="4">{{ old('description', isset($product) ? $product->description : '') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="short_description">Short Description</label>
                                    <textarea class="form-control @error('short_description') is-invalid @enderror"
                                        id="short_description" name="short_description" placeholder="Enter short description"
                                        rows="4">{{ old('short_description', isset($product) ? $product->short_description : '') }}</textarea>
                                    @error('short_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <hr class="my-4">

                            <!-- Pricing Information -->
                            <div class="mb-3">
                                <h6 class="fw-bold mb-3">Pricing Information</h6>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label" for="price">Selling Price (₹) <span
                                            class="text-danger">*</span></label>
                                    <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror"
                                        id="price" name="price" placeholder="Enter selling price"
                                        value="{{ old('price', isset($product) ? $product->price : '') }}">
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label" for="cost_price">Cost Price (₹)</label>
                                    <input type="number" step="0.01" class="form-control @error('cost_price') is-invalid @enderror"
                                        id="cost_price" name="cost_price" placeholder="Enter cost price"
                                        value="{{ old('cost_price', isset($product) ? $product->cost_price : '') }}">
                                    @error('cost_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label" for="discount_percentage">Discount (%)</label>
                                    <input type="number" step="0.01" class="form-control @error('discount_percentage') is-invalid @enderror"
                                        id="discount_percentage" name="discount_percentage" placeholder="Enter discount percentage"
                                        value="{{ old('discount_percentage', isset($product) ? $product->discount_percentage : '0') }}">
                                    @error('discount_percentage')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <hr class="my-4">

                            <!-- Inventory Information -->
                            <div class="mb-3">
                                <h6 class="fw-bold mb-3">Inventory Information</h6>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="stock_quantity">Stock Quantity <span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('stock_quantity') is-invalid @enderror"
                                        id="stock_quantity" name="stock_quantity" placeholder="Enter stock quantity"
                                        value="{{ old('stock_quantity', isset($product) ? $product->stock_quantity : '0') }}">
                                    @error('stock_quantity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="min_stock_level">Minimum Stock Level</label>
                                    <input type="number" class="form-control @error('min_stock_level') is-invalid @enderror"
                                        id="min_stock_level" name="min_stock_level" placeholder="Enter minimum stock level"
                                        value="{{ old('min_stock_level', isset($product) ? $product->min_stock_level : '0') }}">
                                    @error('min_stock_level')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <hr class="my-4">

                            <!-- Images -->
                            <div class="mb-3">
                                <h6 class="fw-bold mb-3">Product Images</h6>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="image">Main Image <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror"
                                        id="image" name="image" accept="image/*">
                                    @if (isset($product) && $product->image)
                                        <small class="text-muted">Current: <img src="{{ asset($product->image) }}" alt="Product" width="50" height="50" style="margin-top: 5px; border-radius: 4px;"></small>
                                    @endif
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="image_1">Image 1</label>
                                    <input type="file" class="form-control @error('image_1') is-invalid @enderror"
                                        id="image_1" name="image_1" accept="image/*">
                                    @if (isset($product) && $product->image_1)
                                        <small class="text-muted">Current: <img src="{{ asset($product->image_1) }}" alt="Product" width="50" height="50" style="margin-top: 5px; border-radius: 4px;"></small>
                                    @endif
                                    @error('image_1')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="image_2">Image 2</label>
                                    <input type="file" class="form-control @error('image_2') is-invalid @enderror"
                                        id="image_2" name="image_2" accept="image/*">
                                    @if (isset($product) && $product->image_2)
                                        <small class="text-muted">Current: <img src="{{ asset($product->image_2) }}" alt="Product" width="50" height="50" style="margin-top: 5px; border-radius: 4px;"></small>
                                    @endif
                                    @error('image_2')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="image_3">Image 3</label>
                                    <input type="file" class="form-control @error('image_3') is-invalid @enderror"
                                        id="image_3" name="image_3" accept="image/*">
                                    @if (isset($product) && $product->image_3)
                                        <small class="text-muted">Current: <img src="{{ asset($product->image_3) }}" alt="Product" width="50" height="50" style="margin-top: 5px; border-radius: 4px;"></small>
                                    @endif
                                    @error('image_3')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <hr class="my-4">

                            <!-- Rating & Status -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="rating">Rating (Out of 5)</label>
                                    <input type="number" step="0.01" min="0" max="5" class="form-control @error('rating') is-invalid @enderror"
                                        id="rating" name="rating" placeholder="Enter rating"
                                        value="{{ old('rating', isset($product) ? $product->rating : '0') }}">
                                    @error('rating')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="status">Status <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status"
                                        name="status">
                                        <option value="">Select Status</option>
                                        <option value="Active"
                                            {{ old('status', isset($product) ? $product->status : 'Active') == 'Active' ? 'selected' : '' }}>
                                            Active</option>
                                        <option value="Inactive"
                                            {{ old('status', isset($product) ? $product->status : 'Active') == 'Inactive' ? 'selected' : '' }}>
                                            Inactive</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-primary">
                                        {{ isset($product) ? 'Update Product' : 'Save Product' }}
                                    </button>
                                    <button type="reset" class="btn btn-outline-secondary ms-2">Reset</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
