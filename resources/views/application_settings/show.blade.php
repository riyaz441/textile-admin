@extends('layouts.master')
@section('title', 'View Setting - ' . env('APP_NAME'))
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('components.alert')
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Setting Details</h5>
                        <div>
                            <button type="button" class="btn btn-primary"
                                onclick="location.href='{{ route('application-settings.form', $setting->setting_id) }}'">
                                Edit
                            </button>
                            <button type="button" class="btn btn-secondary"
                                onclick="location.href='{{ route('application-settings.index') }}'">
                                Back to Settings
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Setting Key</label>
                                <h6 class="mb-0"><span class="badge bg-label-primary">{{ $setting->setting_key }}</span>
                                </h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Setting Type</label>
                                <h6 class="mb-0">
                                    <span class="badge bg-label-info">{{ ucfirst($setting->setting_type) }}</span>
                                </h6>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Category</label>
                                <h6 class="mb-0">{{ $setting->category ?? 'N/A' }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Setting Value</label>
                                <h6 class="mb-0">{{ $setting->setting_value ?? 'N/A' }}</h6>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Company</label>
                                <h6 class="mb-0">{{ $setting->company->company_name ?? 'N/A' }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Branch</label>
                                <h6 class="mb-0">{{ $setting->branch->branch_name ?? 'N/A' }}</h6>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-muted">Description</label>
                            <p class="mb-0">{{ $setting->description ?? 'N/A' }}</p>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Created At</label>
                                <h6 class="mb-0">
                                    {{ $setting->created_at ? $setting->created_at->format('d-m-Y H:i:s') : 'N/A' }}
                                </h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Updated At</label>
                                <h6 class="mb-0">
                                    {{ $setting->updated_at ? $setting->updated_at->format('d-m-Y H:i:s') : 'N/A' }}
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
