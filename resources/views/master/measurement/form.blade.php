@extends('layouts.master')
@section('title', isset($measurement) ? 'Edit Measurement - ' . env('APP_NAME') : 'Add Measurement - ' . env('APP_NAME'))
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('components.alert')
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">{{ isset($measurement) ? 'Edit Measurement' : 'Add New Measurement' }}</h5>
                        <button type="button" class="btn btn-secondary" onclick="location.href='{{ route('measurements.index') }}'">
                            Back to Measurements
                        </button>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('measurements.save', $measurement->measurement_id ?? null) }}" method="POST">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="name">Measurement Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" placeholder="Enter measurement name"
                                        value="{{ old('name', isset($measurement) ? $measurement->name : '') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="UOM">UOM <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('UOM') is-invalid @enderror"
                                        id="UOM" name="UOM" placeholder="Enter unit of measurement"
                                        value="{{ old('UOM', isset($measurement) ? $measurement->UOM : '') }}" required>
                                    @error('UOM')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="status">Status <span class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror"
                                        id="status" name="status" required>
                                        <option value="">Select Status</option>
                                        <option value="Active" {{ old('status', isset($measurement) ? $measurement->status : '') == 'Active' ? 'selected' : '' }}>Active</option>
                                        <option value="Inactive" {{ old('status', isset($measurement) ? $measurement->status : '') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-primary">
                                        {{ isset($measurement) ? 'Update Measurement' : 'Save Measurement' }}
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
