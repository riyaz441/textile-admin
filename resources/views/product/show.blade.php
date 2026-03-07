@extends('layouts.master')
@section('title', 'View Product - ' . env('APP_NAME'))
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('components.alert')
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Product Details</h5>
                        <div>
                            <button type="button" class="btn btn-primary"
                                onclick="location.href='{{ route('products.form', $product->id) }}'">
                                Edit
                            </button>
                            <button type="button" class="btn btn-secondary" onclick="location.href='{{ route('products.index') }}'">
                                Back to Products
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Basic Information -->
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">Basic Information</h6>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Product Name</label>
                                <h6 class="mb-0">{{ $product->name }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">SKU</label>
                                <h6 class="mb-0"><span class="badge bg-label-primary">{{ $product->sku }}</span></h6>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Slug</label>
                                <h6 class="mb-0">{{ $product->slug }}</h6>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Category</label>
                                <h6 class="mb-0">
                                    <span class="badge {{ $product->category == 'male' ? 'bg-label-info' : ($product->category == 'female' ? 'bg-label-danger' : 'bg-label-success') }}">
                                        {{ ucfirst($product->category) }}
                                    </span>
                                </h6>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-12 mb-3">
                                <label class="form-label text-muted">Description</label>
                                <p class="mb-0">{{ $product->description }}</p>
                            </div>
                        </div>

                        @if ($product->short_description)
                            <div class="row mb-4">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label text-muted">Short Description</label>
                                    <p class="mb-0">{{ $product->short_description }}</p>
                                </div>
                            </div>
                        @endif

                        <hr class="my-4">

                        <!-- Pricing Information -->
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">Pricing Information</h6>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted">Selling Price</label>
                                <h6 class="mb-0 text-success fw-bold">₹{{ number_format($product->price, 2) }}</h6>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted">Cost Price</label>
                                <h6 class="mb-0">₹{{ $product->cost_price ? number_format($product->cost_price, 2) : 'N/A' }}</h6>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted">Discount</label>
                                <h6 class="mb-0">{{ $product->discount_percentage }}%</h6>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Inventory Information -->
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">Inventory Information</h6>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Stock Quantity</label>
                                <h6 class="mb-0">
                                    <span class="badge {{ $product->stock_quantity > $product->min_stock_level ? 'bg-label-success' : 'bg-label-warning' }}">
                                        {{ $product->stock_quantity }} units
                                    </span>
                                </h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Minimum Stock Level</label>
                                <h6 class="mb-0">{{ $product->min_stock_level }} units</h6>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Product Images -->
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">Product Images</h6>
                        </div>

                        <div class="row mb-4">
                            @if ($product->image)
                                <div class="col-md-3 mb-3">
                                    <label class="form-label text-muted">Main Image</label>
                                    <br>
                                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="img-fluid" style="max-height: 200px; object-fit: cover; border-radius: 4px;">
                                </div>
                            @endif

                            @if ($product->image_1)
                                <div class="col-md-3 mb-3">
                                    <label class="form-label text-muted">Image 1</label>
                                    <br>
                                    <img src="{{ asset($product->image_1) }}" alt="{{ $product->name }}" class="img-fluid" style="max-height: 200px; object-fit: cover; border-radius: 4px;">
                                </div>
                            @endif

                            @if ($product->image_2)
                                <div class="col-md-3 mb-3">
                                    <label class="form-label text-muted">Image 2</label>
                                    <br>
                                    <img src="{{ asset($product->image_2) }}" alt="{{ $product->name }}" class="img-fluid" style="max-height: 200px; object-fit: cover; border-radius: 4px;">
                                </div>
                            @endif

                            @if ($product->image_3)
                                <div class="col-md-3 mb-3">
                                    <label class="form-label text-muted">Image 3</label>
                                    <br>
                                    <img src="{{ asset($product->image_3) }}" alt="{{ $product->name }}" class="img-fluid" style="max-height: 200px; object-fit: cover; border-radius: 4px;">
                                </div>
                            @endif
                        </div>

                        <hr class="my-4">

                        <!-- Rating & Status -->
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Rating</label>
                                <h6 class="mb-0">
                                    @if ($product->rating > 0)
                                        <span class="badge bg-label-info">⭐ {{ $product->rating }}/5</span>
                                    @else
                                        <span class="badge bg-label-secondary">Not Rated</span>
                                    @endif
                                </h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Status</label>
                                <h6 class="mb-0">
                                    <span class="badge {{ $product->status == 'Active' ? 'bg-label-success' : 'bg-label-danger' }}">
                                        {{ $product->status == 'Active' ? 'Active' : 'Inactive' }}
                                    </span>
                                </h6>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Timestamps -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Created At</label>
                                <h6 class="mb-0">{{ $product->created_at->format('d-m-Y H:i:s') }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Updated At</label>
                                <h6 class="mb-0">{{ $product->updated_at->format('d-m-Y H:i:s') }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
