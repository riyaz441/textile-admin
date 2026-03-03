@extends('layouts.master')
@section('title', 'View Branch - ' . env('APP_NAME'))
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('components.alert')
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Branch Details</h5>
                        <div>
                            <button type="button" class="btn btn-primary"
                                onclick="location.href='{{ route('branches.form', $branch->branch_id) }}'">
                                Edit
                            </button>
                            <button type="button" class="btn btn-secondary"
                                onclick="location.href='{{ route('branches.index') }}'">
                                Back to Branches
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Branch Code</label>
                                <h6 class="mb-0"><span class="badge bg-label-primary">{{ $branch->branch_code }}</span></h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Branch Name</label>
                                <h6 class="mb-0">{{ $branch->branch_name }}</h6>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Company</label>
                                <h6 class="mb-0">{{ $branch->company->company_name ?? 'N/A' }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Status</label>
                                <h6 class="mb-0">
                                    <span
                                        class="badge {{ $branch->status == 'Active' ? 'bg-label-success' : 'bg-label-danger' }}">
                                        {{ $branch->status }}
                                    </span>
                                </h6>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Email</label>
                                <h6 class="mb-0">{{ $branch->email ?? 'N/A' }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Phone</label>
                                <h6 class="mb-0">{{ $branch->phone ?? 'N/A' }}</h6>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">City</label>
                                <h6 class="mb-0">{{ $branch->city ?? 'N/A' }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">State</label>
                                <h6 class="mb-0">{{ $branch->state ?? 'N/A' }}</h6>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Country</label>
                                <h6 class="mb-0">{{ $branch->country ?? 'N/A' }}</h6>
                            </div>
                        </div>

                        @if ($branch->address)
                            <div class="mb-4">
                                <label class="form-label text-muted">Address</label>
                                <p class="mb-0">{{ $branch->address }}</p>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Created At</label>
                                <h6 class="mb-0">{{ $branch->created_at->format('d-m-Y H:i:s') }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Updated At</label>
                                <h6 class="mb-0">{{ $branch->updated_at->format('d-m-Y H:i:s') }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection