@extends('layouts.master')
@section('title', 'View Measurement - ' . env('APP_NAME'))
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('components.alert')
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Measurement Details</h5>
                        <div>
                            <button type="button" class="btn btn-primary"
                                onclick="location.href='{{ route('measurements.form', $measurement->measurement_id) }}'">
                                Edit
                            </button>
                            <button type="button" class="btn btn-secondary"
                                onclick="location.href='{{ route('measurements.index') }}'">
                                Back to Measurements
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Measurement Name</label>
                                <h6 class="mb-0"><span
                                        class="badge bg-label-primary">{{ $measurement->name ?? 'N/A' }}</span></h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">UOM</label>
                                <h6 class="mb-0">{{ $measurement->UOM ?? 'N/A' }}</h6>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Status</label>
                                <h6 class="mb-0">{{ $measurement->status ?? 'N/A' }}</h6>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Created At</label>
                                <h6 class="mb-0">{{ $measurement->created_at->format('d-m-Y H:i:s') }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Updated At</label>
                                <h6 class="mb-0">{{ $measurement->updated_at->format('d-m-Y H:i:s') }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
