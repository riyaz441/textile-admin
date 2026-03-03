@extends('layouts.master')
@section('title', isset($location) ? 'Edit Location - ' . env('APP_NAME') : 'Add Location - ' . env('APP_NAME'))
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('components.alert')
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">{{ isset($location) ? 'Edit Location' : 'Add New Location' }}</h5>
                        <button type="button" class="btn btn-secondary"
                            onclick="location.href='{{ route('locations.index') }}'">
                            Back to Locations
                        </button>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('locations.save', $location->location_id ?? null) }}" method="POST">
                            @csrf
                            <!-- Row 1 : Company + Branch -->
                            <div class="row mb-3">

                                <div class="col-md-6">
                                    <label class="form-label" for="company_id">Company <span
                                            class="text-danger">*</span></label>
                                    @php
                                        $companyLocked = isset($selectedCompanyId) && $selectedCompanyId !== 'all';
                                        $companyValue = $companyLocked
                                            ? $selectedCompanyId
                                            : old('company_id', isset($location) ? $location->company_id : '');
                                    @endphp
                                    <select class="form-select @error('company_id') is-invalid @enderror" id="company_id"
                                        name="company_id" {{ $companyLocked ? 'disabled' : '' }} required>
                                        <option value="">Select Company</option>
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->company_id }}" {{ (string) $companyValue === (string) $company->company_id ? 'selected' : '' }}>
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
                                    <label class="form-label" for="branch_id">Branch <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select @error('branch_id') is-invalid @enderror" id="branch_id"
                                        name="branch_id"
                                        data-selected="{{ old('branch_id', isset($location) ? $location->branch_id : '') }}"
                                        required>
                                        <option value="">Select Branch</option>
                                    </select>
                                    @error('branch_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                            </div>


                            <!-- Row 2 : Location Name + Location Code -->
                            <div class="row mb-3">

                                <div class="col-md-6">
                                    <label class="form-label" for="location_name">Location Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('location_name') is-invalid @enderror"
                                        id="location_name" name="location_name" placeholder="Enter location name"
                                        value="{{ old('location_name', isset($location) ? $location->location_name : '') }}"
                                        required>
                                    @error('location_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="location_code">Location Code <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('location_code') is-invalid @enderror"
                                        id="location_code" name="location_code"
                                        placeholder="Enter location code (e.g., LOC-001)"
                                        value="{{ old('location_code', isset($location) ? $location->location_code : '') }}"
                                        required>
                                    @error('location_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                            <!-- Row : Location Type + Parent Location -->
                            <div class="row mb-3">

                                <div class="col-md-6">
                                    <label class="form-label" for="location_type">
                                        Location Type <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('location_type') is-invalid @enderror"
                                        id="location_type" name="location_type" required>

                                        <option value="">Select Type</option>

                                        @foreach (['store', 'warehouse', 'display_case', 'safe', 'vault', 'counter', 'workshop', 'qc_area', 'quarantine'] as $type)
                                            <option value="{{ $type }}" {{ old('location_type', isset($location) ? $location->location_type : 'store') == $type ? 'selected' : '' }}>
                                                {{ ucfirst(str_replace('_', ' ', $type)) }}
                                            </option>
                                        @endforeach

                                    </select>
                                    @error('location_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="parent_location_id">Parent Location</label>
                                    <select class="form-select @error('parent_location_id') is-invalid @enderror"
                                        id="parent_location_id" name="parent_location_id">

                                        <option value="">None</option>

                                        @foreach ($parentLocations as $parentLocation)
                                            <option value="{{ $parentLocation->location_id }}" {{ old('parent_location_id', isset($location) ? $location->parent_location_id : '') == $parentLocation->location_id ? 'selected' : '' }}>
                                                {{ $parentLocation->location_name }} ({{ $parentLocation->location_code }})
                                            </option>
                                        @endforeach

                                    </select>
                                    @error('parent_location_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                            <!-- Row : Contact Person + Phone -->
                            <div class="row mb-3">

                                <div class="col-md-6">
                                    <label class="form-label" for="contact_person">Contact Person</label>
                                    <input type="text" class="form-control @error('contact_person') is-invalid @enderror"
                                        id="contact_person" name="contact_person" placeholder="Enter contact person"
                                        value="{{ old('contact_person', isset($location) ? $location->contact_person : '') }}">
                                    @error('contact_person')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="phone">Phone</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                                        name="phone" placeholder="Enter phone number"
                                        value="{{ old('phone', isset($location) ? $location->phone : '') }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                            <!-- Row : Capacity + Temperature -->
                            <div class="row mb-3">

                                <div class="col-md-6">
                                    <label class="form-label" for="capacity">Capacity</label>
                                    <input type="number" min="0"
                                        class="form-control @error('capacity') is-invalid @enderror" id="capacity"
                                        name="capacity" placeholder="Enter capacity"
                                        value="{{ old('capacity', isset($location) ? $location->capacity : '') }}">
                                    @error('capacity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="temperature_controlled">
                                        Temperature Controlled <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('temperature_controlled') is-invalid @enderror"
                                        id="temperature_controlled" name="temperature_controlled" required>

                                        <option value="">Select Option</option>
                                        <option value="1" {{ old('temperature_controlled', isset($location) ? $location->temperature_controlled : 0) == 1 ? 'selected' : '' }}>
                                            Yes
                                        </option>
                                        <option value="0" {{ old('temperature_controlled', isset($location) ? $location->temperature_controlled : 0) == 0 ? 'selected' : '' }}>
                                            No
                                        </option>

                                    </select>
                                    @error('temperature_controlled')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                            <!-- Row : Humidity + Security -->
                            <div class="row mb-3">

                                <div class="col-md-6">
                                    <label class="form-label" for="humidity_controlled">
                                        Humidity Controlled <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('humidity_controlled') is-invalid @enderror"
                                        id="humidity_controlled" name="humidity_controlled" required>

                                        <option value="">Select Option</option>
                                        <option value="1" {{ old('humidity_controlled', isset($location) ? $location->humidity_controlled : 0) == 1 ? 'selected' : '' }}>
                                            Yes
                                        </option>
                                        <option value="0" {{ old('humidity_controlled', isset($location) ? $location->humidity_controlled : 0) == 0 ? 'selected' : '' }}>
                                            No
                                        </option>

                                    </select>
                                    @error('humidity_controlled')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="security_level">
                                        Security Level <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('security_level') is-invalid @enderror"
                                        id="security_level" name="security_level" required>

                                        <option value="">Select Level</option>

                                        @foreach (['low', 'medium', 'high', 'maximum'] as $level)
                                            <option value="{{ $level }}" {{ old('security_level', isset($location) ? $location->security_level : 'medium') == $level ? 'selected' : '' }}>
                                                {{ ucfirst($level) }}
                                            </option>
                                        @endforeach

                                    </select>
                                    @error('security_level')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                            <!-- Row : Address + Notes -->
                            <div class="row mb-3">

                                <div class="col-md-6">
                                    <label class="form-label" for="address">Address</label>
                                    <textarea class="form-control @error('address') is-invalid @enderror" id="address"
                                        name="address" rows="4"
                                        placeholder="Enter complete address">{{ old('address', isset($location) ? $location->address : '') }}</textarea>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="notes">Notes</label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes"
                                        name="notes" rows="4"
                                        placeholder="Enter notes">{{ old('notes', isset($location) ? $location->notes : '') }}</textarea>
                                </div>

                            </div>

                            <!-- Row : Status -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="status">
                                        Status <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status"
                                        name="status" required>

                                        <option value="">Select Status</option>
                                        <option value="Active" {{ old('status', isset($location) ? $location->status : 'Active') == 'Active' ? 'selected' : '' }}>
                                            Active
                                        </option>
                                        <option value="Inactive" {{ old('status', isset($location) ? $location->status : 'Active') == 'Inactive' ? 'selected' : '' }}>
                                            Inactive
                                        </option>

                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="row">
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-primary">
                                        {{ isset($location) ? 'Update Location' : 'Save Location' }}
                                    </button>
                                    <button type="reset" class="btn btn-outline-secondary ms-2">Reset</button>
                                </div>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
