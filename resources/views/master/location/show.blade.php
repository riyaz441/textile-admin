@extends('layouts.master')
@section('title', 'View Location - ' . env('APP_NAME'))
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('components.alert')
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Location Details</h5>
                        <div>
                            <button type="button" class="btn btn-primary"
                                onclick="location.href='{{ route('locations.form', $location->location_id) }}'">
                                Edit
                            </button>
                            <button type="button" class="btn btn-secondary"
                                onclick="location.href='{{ route('locations.index') }}'">
                                Back to Locations
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Location Code</label>
                                <h6 class="mb-0">
                                    <span class="badge bg-label-primary">{{ $location->location_code }}</span>
                                </h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Location Name</label>
                                <h6 class="mb-0">{{ $location->location_name }}</h6>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Company</label>
                                <h6 class="mb-0">{{ $location->company->company_name ?? 'N/A' }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Branch</label> <!-- ✅ ADDED -->
                                <h6 class="mb-0">{{ $location->branch->branch_name ?? 'N/A' }}</h6> <!-- ✅ ADDED -->
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Location Type</label>
                                <h6 class="mb-0">{{ ucfirst(str_replace('_', ' ', $location->location_type)) }}</h6>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Parent Location</label>
                                <h6 class="mb-0">{{ $location->parent->location_name ?? 'N/A' }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Security Level</label>
                                <h6 class="mb-0">{{ ucfirst($location->security_level) }}</h6>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Contact Person</label>
                                <h6 class="mb-0">{{ $location->contact_person ?? 'N/A' }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Phone</label>
                                <h6 class="mb-0">{{ $location->phone ?? 'N/A' }}</h6>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Capacity</label>
                                <h6 class="mb-0">{{ $location->capacity ?? 'N/A' }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Temperature Controlled</label>
                                <h6 class="mb-0">{{ $location->temperature_controlled ? 'Yes' : 'No' }}</h6>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Humidity Controlled</label>
                                <h6 class="mb-0">{{ $location->humidity_controlled ? 'Yes' : 'No' }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Status</label>
                                <h6 class="mb-0">
                                    <span
                                        class="badge {{ $location->status == 'Active' ? 'bg-label-success' : 'bg-label-danger' }}">
                                        {{ $location->status }}
                                    </span>
                                </h6>
                            </div>
                        </div>

                        @if ($location->address)
                            <div class="mb-4">
                                <label class="form-label text-muted">Address</label>
                                <p class="mb-0">{{ $location->address }}</p>
                            </div>
                        @endif

                        @if ($location->notes)
                            <div class="mb-4">
                                <label class="form-label text-muted">Notes</label>
                                <p class="mb-0">{{ $location->notes }}</p>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Created At</label>
                                <h6 class="mb-0">{{ $location->created_at->format('d-m-Y H:i:s') }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Updated At</label>
                                <h6 class="mb-0">{{ $location->updated_at->format('d-m-Y H:i:s') }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection