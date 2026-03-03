@extends('layouts.master')
@section('title', 'Product Category - ' . env('APP_NAME'))
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('components.alert')
        <!-- Bootstrap Table with Header - Light -->
        <div class="card">
            <div class="d-flex justify-content-between align-items-center p-3">
                <h5 class="card-header mb-0">Product Category</h5>
                <div class="ms-auto">
                    <button class="btn btn-primary" onclick="location.href='{{ route('product-categories.form') }}'">
                        + Add Product Category
                    </button>
                </div>
            </div>
            <div class="table-responsive text-nowrap p-3">
                <table id="product-category-table" class="table">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Company</th>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Parent</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @forelse ($categories as $category)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $category->company ? $category->company->company_name : 'N/A' }}</td>
                                <td>{{ $category->category_name }}</td>
                                <td><span class="badge bg-label-primary">{{ $category->category_code }}</span></td>
                                <td>{{ $category->parentCategory ? $category->parentCategory->category_name : 'N/A' }}</td>
                                <td>
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input change_category_status" type="checkbox"
                                            id="flexSwitchCheckChecked" data-id="{{ $category->category_id }}"
                                            {{ $category->status == 'Active' ? 'checked' : '' }}>
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
                                                onclick="location.href='{{ route('product-categories.form', $category->category_id) }}'">
                                                <i class="bx bx-edit-alt me-1"></i> Edit
                                            </a>
                                            <a class="dropdown-item" href="javascript:void(0);"
                                                onclick="location.href='{{ route('product-categories.show', $category->category_id) }}'">
                                                <i class="bx bx-show me-1"></i> View
                                            </a>
                                            <a class="dropdown-item delete-item" href="#" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal" data-id="{{ $category->category_id }}"
                                                data-name="product-categories/delete">
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
