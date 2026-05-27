@extends('layouts.master')
@section('title', 'View Doctor - ' . env('APP_NAME'))
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('components.alert')
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Doctor Details</h5>
                        <div>
                            <button type="button" class="btn btn-primary"
                                onclick="location.href='{{ route('doctors.form', $doctor->doctor_id) }}'">
                                Edit
                            </button>
                            <button type="button" class="btn btn-secondary" onclick="location.href='{{ route('doctors.index') }}'">
                                Back to Doctors
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Image</label>
                                <div>
                                    @if ($doctor->image)
                                        <img src="{{ asset($doctor->image) }}" alt="{{ $doctor->name }}" width="120" height="120"
                                            style="object-fit: cover; border-radius: 6px;">
                                    @else
                                        <span class="badge bg-label-secondary">No Image</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Doctor Name</label>
                                <h6 class="mb-0">{{ $doctor->name }}</h6>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Mobile Number</label>
                                <h6 class="mb-0">{{ $doctor->mobile_no }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Email</label>
                                <h6 class="mb-0">{{ $doctor->email ?? 'N/A' }}</h6>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Priority</label>
                                <h6 class="mb-0">
                                    <span class="badge {{ $doctor->priority ? 'bg-label-success' : 'bg-label-secondary' }}">
                                        {{ $doctor->priority ? 'Yes' : 'No' }}
                                    </span>
                                </h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Status</label>
                                <h6 class="mb-0">
                                    <span class="badge {{ $doctor->status == 'Active' ? 'bg-label-success' : 'bg-label-danger' }}">
                                        {{ $doctor->status }}
                                    </span>
                                </h6>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Created At</label>
                                <h6 class="mb-0">{{ $doctor->created_at->format('d-m-Y H:i:s') }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Updated At</label>
                                <h6 class="mb-0">{{ $doctor->updated_at->format('d-m-Y H:i:s') }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
