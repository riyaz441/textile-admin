@extends('layouts.master')
@section('title', isset($company) ? 'Edit Company - ' . env('APP_NAME') : 'Add Company - ' . env('APP_NAME'))
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('components.alert')
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">{{ isset($company) ? 'Edit Company' : 'Add New Company' }}</h5>
                        <button type="button" class="btn btn-secondary"
                            onclick="location.href='{{ route('companies.index') }}'">
                            Back to Companies
                        </button>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('companies.save', $company->company_id ?? null) }}" method="POST">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="company_code">Company Code <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('company_code') is-invalid @enderror"
                                        id="company_code" name="company_code"
                                        placeholder="Enter company code (e.g., COMP-001)"
                                        value="{{ old('company_code', isset($company) ? $company->company_code : '') }}"
                                        required>
                                    @error('company_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="company_name">Company Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('company_name') is-invalid @enderror"
                                        id="company_name" name="company_name" placeholder="Enter company name"
                                        value="{{ old('company_name', isset($company) ? $company->company_name : '') }}"
                                        required>
                                    @error('company_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="email">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" placeholder="Enter email address"
                                        value="{{ old('email', isset($company) ? $company->email : '') }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="phone">Phone</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        id="phone" name="phone" placeholder="Enter phone number"
                                        value="{{ old('phone', isset($company) ? $company->phone : '') }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="city">City</label>
                                    <input type="text" class="form-control @error('city') is-invalid @enderror"
                                        id="city" name="city" placeholder="Enter city"
                                        value="{{ old('city', isset($company) ? $company->city : '') }}">
                                    @error('city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="state">State</label>
                                    <input type="text" class="form-control @error('state') is-invalid @enderror"
                                        id="state" name="state" placeholder="Enter state"
                                        value="{{ old('state', isset($company) ? $company->state : '') }}">
                                    @error('state')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="country">Country</label>
                                    <input type="text" class="form-control @error('country') is-invalid @enderror"
                                        id="country" name="country" placeholder="Enter country"
                                        value="{{ old('country', isset($company) ? $company->country : '') }}">
                                    @error('country')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="gst_number">GST Number</label>
                                    <input type="text" class="form-control @error('gst_number') is-invalid @enderror"
                                        id="gst_number" name="gst_number" placeholder="Enter GST number"
                                        value="{{ old('gst_number', isset($company) ? $company->gst_number : '') }}">
                                    @error('gst_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="website">Website</label>
                                    <input type="url" class="form-control @error('website') is-invalid @enderror"
                                        id="website" name="website"
                                        placeholder="Enter website URL (e.g., https://example.com)"
                                        value="{{ old('website', isset($company) ? $company->website : '') }}">
                                    @error('website')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="status">Status <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status"
                                        name="status" required>
                                        <option value="">Select Status</option>
                                        <option value="Active"
                                            {{ old('status', isset($company) ? $company->status : 'Active') == 'Active' ? 'selected' : '' }}>
                                            Active</option>
                                        <option value="Inactive"
                                            {{ old('status', isset($company) ? $company->status : 'Active') == 'Inactive' ? 'selected' : '' }}>
                                            Inactive</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="address">Address</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address"
                                    placeholder="Enter complete address" rows="4">{{ old('address', isset($company) ? $company->address : '') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-primary">
                                        {{ isset($company) ? 'Update Company' : 'Save Company' }}
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
