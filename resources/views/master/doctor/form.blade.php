@extends('layouts.master')
@section('title', isset($doctor) ? 'Edit Doctor - ' . env('APP_NAME') : 'Add Doctor - ' . env('APP_NAME'))
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('components.alert')
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">{{ isset($doctor) ? 'Edit Doctor' : 'Add New Doctor' }}</h5>
                        <button type="button" class="btn btn-secondary" onclick="location.href='{{ route('doctors.index') }}'">
                            Back to Doctors
                        </button>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('doctors.save', $doctor->doctor_id ?? null) }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="name">Doctor Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                        name="name" placeholder="Enter doctor name"
                                        value="{{ old('name', isset($doctor) ? $doctor->name : '') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="mobile_no">Mobile Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('mobile_no') is-invalid @enderror" id="mobile_no"
                                        name="mobile_no" placeholder="Enter mobile number"
                                        value="{{ old('mobile_no', isset($doctor) ? $doctor->mobile_no : '') }}" required>
                                    @error('mobile_no')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="email">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                        name="email" placeholder="Enter email"
                                        value="{{ old('email', isset($doctor) ? $doctor->email : '') }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="image">Image {{ isset($doctor) ? '' : '*' }}</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                                        name="image" accept="image/*">
                                    @if (isset($doctor) && $doctor->image)
                                        <small class="text-muted">Current: <img src="{{ asset($doctor->image) }}" alt="Doctor" width="50"
                                                height="50" style="margin-top: 5px; border-radius: 4px;"></small>
                                    @endif
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="status">Status <span class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                        <option value="">Select Status</option>
                                        <option value="Active"
                                            {{ old('status', isset($doctor) ? $doctor->status : 'Active') == 'Active' ? 'selected' : '' }}>
                                            Active
                                        </option>
                                        <option value="Inactive"
                                            {{ old('status', isset($doctor) ? $doctor->status : 'Active') == 'Inactive' ? 'selected' : '' }}>
                                            Inactive
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 d-flex align-items-end">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input @error('priority') is-invalid @enderror" type="checkbox"
                                            id="priority" name="priority" value="1"
                                            {{ old('priority', isset($doctor) ? $doctor->priority : false) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="priority">
                                            Priority Doctor (Max 4 allowed)
                                        </label>
                                        @error('priority')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-primary">
                                        {{ isset($doctor) ? 'Update Doctor' : 'Save Doctor' }}
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
