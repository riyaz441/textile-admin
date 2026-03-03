@extends('layouts.master')
@section('title', isset($category) ? 'Edit Product Category - ' . env('APP_NAME') : 'Add Product Category - ' .
    env('APP_NAME'))
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('components.alert')
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">{{ isset($category) ? 'Edit Product Category' : 'Add New Product Category' }}</h5>
                        <button type="button" class="btn btn-secondary"
                            onclick="location.href='{{ route('product-categories.index') }}'">
                            Back to Categories
                        </button>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('product-categories.save', $category->category_id ?? null) }}"
                            method="POST">
                            @csrf

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="company_id">Company <span
                                            class="text-danger">*</span></label>
                                    @php
                                        $companyLocked = isset($selectedCompanyId) && $selectedCompanyId !== 'all';
                                        $companyValue = $companyLocked
                                            ? $selectedCompanyId
                                            : old('company_id', isset($category) ? $category->company_id : '');
                                    @endphp
                                    <select class="form-select @error('company_id') is-invalid @enderror" id="company_id"
                                        name="company_id" {{ $companyLocked ? 'disabled' : '' }} required>
                                        <option value="">Select Company</option>
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->company_id }}"
                                                {{ (string) $companyValue === (string) $company->company_id ? 'selected' : '' }}>
                                                {{ $company->company_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($companyLocked)
                                        <input type="hidden" name="company_id" value="{{ $companyValue }}">
                                    @endif
                                    @error('company_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="category_name">Category Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('category_name') is-invalid @enderror"
                                        id="category_name" name="category_name" placeholder="Enter category name"
                                        value="{{ old('category_name', isset($category) ? $category->category_name : '') }}"
                                        required>
                                    @error('category_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="category_code">Category Code <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('category_code') is-invalid @enderror"
                                        id="category_code" name="category_code"
                                        placeholder="Enter category code (e.g., CAT-001)"
                                        value="{{ old('category_code', isset($category) ? $category->category_code : '') }}"
                                        required>
                                    @error('category_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="parent_category_id">Parent Category</label>
                                    <select class="form-select @error('parent_category_id') is-invalid @enderror"
                                        id="parent_category_id" name="parent_category_id">
                                        <option value="">Select Parent Catagory</option>
                                        @foreach ($parentCategories as $parentCategory)
                                            <option value="{{ $parentCategory->category_id }}"
                                                {{ (int) old('parent_category_id', isset($category) ? $category->parent_category_id : 0) === (int) $parentCategory->category_id ? 'selected' : '' }}>
                                                {{ $parentCategory->category_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('parent_category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="status">Status <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status"
                                        name="status" required>
                                        <option value="">Select Status</option>
                                        <option value="Active"
                                            {{ old('status', isset($category) ? $category->status : 'Active') == 'Active' ? 'selected' : 'Active' }}>
                                            Active</option>
                                        <option value="Inactive"
                                            {{ old('status', isset($category) ? $category->status : 'Active') == 'Inactive' ? 'selected' : 'Active' }}>
                                            Inactive</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="description">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                        placeholder="Category description (optional)" rows="4">{{ old('description', isset($category) ? $category->description : '') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-primary">
                                        {{ isset($category) ? 'Update Category' : 'Save Category' }}
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
