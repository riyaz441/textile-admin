@extends('layouts.master')
@section('title', 'View Component Type - ' . env('APP_NAME'))
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Component Type Details</h5>
                        <div>
                            <button type="button" class="btn btn-primary"
                                onclick="location.href='{{ route('component-types.form', $componentType->type_id) }}'">
                                Edit
                            </button>
                            <button type="button" class="btn btn-secondary"
                                onclick="location.href='{{ route('component-types.index') }}'">
                                Back to Component Types
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Company</label>
                                <h6 class="mb-0">{{ $componentType->company->company_name ?? 'N/A' }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Component Type Name</label>
                                <h6 class="mb-0">{{ $componentType->type_name }}</h6>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Status</label>
                                <h6 class="mb-0">
                                    <span class="badge {{ $componentType->status == 'Active' ? 'bg-label-success' : 'bg-label-danger' }}">
                                        {{ $componentType->status }}
                                    </span>
                                </h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Category</label>
                                <h6 class="mb-0">
                                    {{ $componentType->category ?? '-' }}
                                </h6>
                            </div>
                        </div>

                        @if ($componentType->description)
                            <div class="mb-4">
                                <label class="form-label text-muted">Description</label>
                                <p class="mb-0">{{ $componentType->description }}</p>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Created At</label>
                                <h6 class="mb-0">{{ $componentType->created_at->format('d-m-Y H:i:s') }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Updated At</label>
                                <h6 class="mb-0">{{ $componentType->updated_at->format('d-m-Y H:i:s') }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
