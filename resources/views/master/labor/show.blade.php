@extends('layouts.master')
@section('title', 'View Labor - ' . env('APP_NAME'))
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('components.alert')
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Labor Details</h5>
                        <div>
                            <button type="button" class="btn btn-primary"
                                onclick="location.href='{{ route('labors.form', $labor->labor_id) }}'">
                                Edit
                            </button>
                            <button type="button" class="btn btn-secondary" onclick="location.href='{{ route('labors.index') }}'">
                                Back to Labors
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Labor Code</label>
                                <h6 class="mb-0"><span class="badge bg-label-primary">{{ $labor->labor_code }}</span></h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Labor Name</label>
                                <h6 class="mb-0">{{ $labor->labor_name }}</h6>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Company</label>
                                <h6 class="mb-0">{{ $labor->company->company_name ?? 'N/A' }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Skill Level</label>
                                <h6 class="mb-0">{{ ucfirst($labor->skill_level) }}</h6>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted">Base Cost</label>
                                <h6 class="mb-0">
                                    {{ $labor->base_cost !== null ? number_format($labor->base_cost, 2) : 'N/A' }}
                                </h6>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted">Cost Per Hour</label>
                                <h6 class="mb-0">
                                    {{ $labor->cost_per_hour !== null ? number_format($labor->cost_per_hour, 2) : 'N/A' }}
                                </h6>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted">Estimated Hours</label>
                                <h6 class="mb-0">
                                    {{ $labor->estimated_hours !== null ? number_format($labor->estimated_hours, 2) : 'N/A' }}
                                </h6>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Status</label>
                                <h6 class="mb-0">
                                    <span class="badge {{ $labor->status == 'Active' ? 'bg-label-success' : 'bg-label-danger' }}">
                                        {{ $labor->status }}
                                    </span>
                                </h6>
                            </div>
                        </div>

                        @if ($labor->description)
                            <div class="mb-4">
                                <label class="form-label text-muted">Description</label>
                                <p class="mb-0">{{ $labor->description }}</p>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Created At</label>
                                <h6 class="mb-0">{{ $labor->created_at->format('d-m-Y H:i:s') }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Updated At</label>
                                <h6 class="mb-0">{{ $labor->updated_at->format('d-m-Y H:i:s') }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
