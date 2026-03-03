@extends('layouts.master')
@section('title', 'View Company - ' . env('APP_NAME'))
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('components.alert')
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Company Details</h5>
                        <div>
                            <button type="button" class="btn btn-primary"
                                onclick="location.href='{{ route('companies.form', $company->company_id) }}'">
                                Edit
                            </button>
                            <button type="button" class="btn btn-secondary" onclick="location.href='{{ route('companies.index') }}'">
                                Back to Companies
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Company Code</label>
                                <h6 class="mb-0"><span class="badge bg-label-primary">{{ $company->company_code }}</span></h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Company Name</label>
                                <h6 class="mb-0">{{ $company->company_name }}</h6>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Email</label>
                                <h6 class="mb-0">{{ $company->email ?? 'N/A' }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Phone</label>
                                <h6 class="mb-0">{{ $company->phone ?? 'N/A' }}</h6>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">City</label>
                                <h6 class="mb-0">{{ $company->city ?? 'N/A' }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">State</label>
                                <h6 class="mb-0">{{ $company->state ?? 'N/A' }}</h6>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Country</label>
                                <h6 class="mb-0">{{ $company->country ?? 'N/A' }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">GST Number</label>
                                <h6 class="mb-0">{{ $company->gst_number ?? 'N/A' }}</h6>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Website</label>
                                <h6 class="mb-0">
                                    @if ($company->website)
                                        <a href="{{ $company->website }}" target="_blank">{{ $company->website }}</a>
                                    @else
                                        N/A
                                    @endif
                                </h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Status</label>
                                <h6 class="mb-0">
                                    <span class="badge {{ $company->status == 'Active' ? 'bg-label-success' : 'bg-label-danger' }}">
                                        {{ $company->status == 'Active' ? 'Active' : 'Inactive' }}
                                    </span>
                                </h6>
                            </div>
                        </div>

                        @if ($company->address)
                            <div class="mb-4">
                                <label class="form-label text-muted">Address</label>
                                <p class="mb-0">{{ $company->address }}</p>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Created At</label>
                                <h6 class="mb-0">{{ $company->created_at->format('d-m-Y H:i:s') }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Updated At</label>
                                <h6 class="mb-0">{{ $company->updated_at->format('d-m-Y H:i:s') }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
