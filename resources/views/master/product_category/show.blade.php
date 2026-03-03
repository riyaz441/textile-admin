@extends('layouts.master')
@section('title', 'View Product Category - ' . env('APP_NAME'))
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Product Category Details</h5>
                        <div>
                            <button type="button" class="btn btn-primary"
                                onclick="location.href='{{ route('product-categories.form', $category->category_id) }}'">
                                Edit
                            </button>
                            <button type="button" class="btn btn-secondary" onclick="location.href='{{ route('product-categories.index') }}'">
                                Back to Categories
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted">Company</label>
                                <h6 class="mb-0">{{ $category->company ? $category->company->company_name : '-' }}</h6>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted">Category Name</label>
                                <h6 class="mb-0">{{ $category->category_name }}</h6>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted">Category Code</label>
                                <h6 class="mb-0"><span class="badge bg-label-primary">{{ $category->category_code }}</span></h6>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Status</label>
                                <h6 class="mb-0">
                                    <span class="badge {{ $category->status == 'Active' ? 'bg-label-success' : 'bg-label-danger' }}">
                                        {{ $category->status }}
                                    </span>
                                </h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Parent Category</label>
                                <h6 class="mb-0">
                                    {{ $category->parentCategory ? $category->parentCategory->category_name : '-' }}
                                </h6>
                            </div>
                        </div>

                        @if ($category->description)
                            <div class="mb-4">
                                <label class="form-label text-muted">Description</label>
                                <p class="mb-0">{{ $category->description }}</p>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Created At</label>
                                <h6 class="mb-0">{{ $category->created_at->format('d-m-Y H:i:s') }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Updated At</label>
                                <h6 class="mb-0">{{ $category->updated_at->format('d-m-Y H:i:s') }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
