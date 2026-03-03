@extends('layouts.master')
@section('title', 'Products - ' . env('APP_NAME'))
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('components.alert')
        <!-- Bootstrap Table with Header - Light -->
        <div class="card">
            <div class="d-flex justify-content-between align-items-center p-3">
                <h5 class="card-header mb-0">Products</h5>
                <div class="ms-auto">
                    <button class="btn btn-primary" onclick="location.href='{{ route('products.form') }}'">
                        + Add Product
                    </button>
                </div>
            </div>
            <div class="table-responsive text-nowrap p-3">
                <table id="products-table" class="table">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>SKU</th>
                            <th>Company Name</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Cost Price</th>
                            <th>Selling Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @forelse ($products as $product)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><span class="badge bg-label-primary">{{ $product->sku }}</span></td>
                                <td>{{ $product->company->company_name }}</td>
                                <td>{{ $product->product_name }}</td>
                                <td>{{ $product->category->category_name ?? 'N/A' }}</td>
                                <td>৳ {{ number_format($product->cost_price, 2) }}</td>
                                <td>৳ {{ number_format($product->selling_price, 2) }}</td>
                                <td>
                                    <span
                                        class="badge {{ $product->quantity_in_stock <= $product->minimum_stock_level ? 'bg-label-danger' : 'bg-label-success' }}">
                                        {{ $product->quantity_in_stock }}
                                    </span>
                                </td>
                                <td>
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input change_product_status" type="checkbox"
                                            id="flexSwitchCheckChecked" data-id="{{ $product->product_id }}"
                                            {{ $product->status == 'Active' ? 'checked' : '' }}>
                                    </div>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu company-action-menu">
                                            <a class="dropdown-item" href="javascript:void(0);"
                                                onclick="location.href='{{ route('products.form', $product->product_id) }}'">
                                                <i class="bx bx-edit-alt me-1"></i> Edit
                                            </a>
                                            <a class="dropdown-item" href="javascript:void(0);"
                                                onclick="location.href='{{ route('products.show', $product->product_id) }}'">
                                                <i class="bx bx-show me-1"></i> View
                                            </a>
                                            <a class="dropdown-item delete-item" href="#" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal" data-id="{{ $product->product_id }}"
                                                data-name="products/delete">
                                                <i class="bx bx-trash me-1"></i> Delete
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
