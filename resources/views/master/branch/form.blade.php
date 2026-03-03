@extends('layouts.master')
@section('title', isset($branch) ? 'Edit Branch - ' . env('APP_NAME') : 'Add Branch - ' . env('APP_NAME'))
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('components.alert')
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">{{ isset($branch) ? 'Edit Branch' : 'Add New Branch' }}</h5>
                        <button type="button" class="btn btn-secondary"
                            onclick="location.href='{{ route('branches.index') }}'">
                            Back to Branches
                        </button>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('branches.save', $branch->branch_id ?? null) }}" method="POST">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="company_id">Company <span
                                            class="text-danger">*</span></label>
                                    @php
                                        $companyLocked = isset($selectedCompanyId) && $selectedCompanyId !== 'all';
                                        $companyValue = $companyLocked
                                            ? $selectedCompanyId
                                            : old('company_id', isset($branch) ? $branch->company_id : '');
                                    @endphp
                                    <select class="form-select @error('company_id') is-invalid @enderror" id="company_id"
                                        name="company_id" {{ $companyLocked ? 'disabled' : '' }} required>
                                        <option value="">Select Company</option>
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->company_id }}"
                                                {{ (string) $companyValue === (string) $company->company_id ? 'selected' : '' }}>
                                                {{ $company->company_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($companyLocked)
                                        <input type="hidden" name="company_id" value="{{ $companyValue }}">
                                    @endif
                                    @error('company_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="branch_code">Branch Code <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('branch_code') is-invalid @enderror"
                                        id="branch_code" name="branch_code"
                                        placeholder="Enter branch code (e.g., BRANCH-001)"
                                        value="{{ old('branch_code', isset($branch) ? $branch->branch_code : '') }}"
                                        required>
                                    @error('branch_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="branch_name">Branch Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('branch_name') is-invalid @enderror"
                                        id="branch_name" name="branch_name" placeholder="Enter branch name"
                                        value="{{ old('branch_name', isset($branch) ? $branch->branch_name : '') }}"
                                        required>
                                    @error('branch_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="email">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" placeholder="Enter email address"
                                        value="{{ old('email', isset($branch) ? $branch->email : '') }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="phone">Phone</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        id="phone" name="phone" placeholder="Enter phone number"
                                        value="{{ old('phone', isset($branch) ? $branch->phone : '') }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="city">City</label>
                                    <input type="text" class="form-control @error('city') is-invalid @enderror"
                                        id="city" name="city" placeholder="Enter city"
                                        value="{{ old('city', isset($branch) ? $branch->city : '') }}">
                                    @error('city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="state">State</label>
                                    <input type="text" class="form-control @error('state') is-invalid @enderror"
                                        id="state" name="state" placeholder="Enter state"
                                        value="{{ old('state', isset($branch) ? $branch->state : '') }}">
                                    @error('state')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="country">Country</label>
                                    <input type="text" class="form-control @error('country') is-invalid @enderror"
                                        id="country" name="country" placeholder="Enter country"
                                        value="{{ old('country', isset($branch) ? $branch->country : '') }}">
                                    @error('country')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="status">Status <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status"
                                        name="status" required>
                                        <option value="">Select Status</option>
                                        <option value="Active"
                                            {{ old('status', isset($branch) ? $branch->status : 'Active') == 'Active' ? 'selected' : '' }}>
                                            Active</option>
                                        <option value="Inactive"
                                            {{ old('status', isset($branch) ? $branch->status : 'Active') == 'Inactive' ? 'selected' : '' }}>
                                            Inactive</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="address">Address</label>
                                    <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address"
                                        placeholder="Enter complete address" rows="4">{{ old('address', isset($branch) ? $branch->address : '') }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-primary">
                                        {{ isset($branch) ? 'Update Branch' : 'Save Branch' }}
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
