@extends('layouts.master')
@section('title', isset($labor) ? 'Edit Labor - ' . env('APP_NAME') : 'Add Labor - ' . env('APP_NAME'))
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('components.alert')
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">{{ isset($labor) ? 'Edit Labor' : 'Add New Labor' }}</h5>
                        <button type="button" class="btn btn-secondary" onclick="location.href='{{ route('labors.index') }}'">
                            Back to Labors
                        </button>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('labors.save', $labor->labor_id ?? null) }}" method="POST">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="company_id">Company <span class="text-danger">*</span></label>
                                    @php
                                        $companyLocked = isset($selectedCompanyId) && $selectedCompanyId !== 'all';
                                        $companyValue = $companyLocked
                                            ? $selectedCompanyId
                                            : old('company_id', isset($labor) ? $labor->company_id : '');
                                    @endphp
                                    <select class="form-select @error('company_id') is-invalid @enderror"
                                        id="company_id" name="company_id" {{ $companyLocked ? 'disabled' : '' }} required>
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
                                    <label class="form-label" for="labor_code">Labor Code <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('labor_code') is-invalid @enderror"
                                        id="labor_code" name="labor_code" placeholder="Enter labor code (e.g., LAB-001)"
                                        value="{{ old('labor_code', isset($labor) ? $labor->labor_code : '') }}" required>
                                    @error('labor_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="labor_name">Labor Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('labor_name') is-invalid @enderror"
                                        id="labor_name" name="labor_name" placeholder="Enter labor name"
                                        value="{{ old('labor_name', isset($labor) ? $labor->labor_name : '') }}" required>
                                    @error('labor_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="skill_level">Skill Level <span class="text-danger">*</span></label>
                                    <select class="form-select @error('skill_level') is-invalid @enderror"
                                        id="skill_level" name="skill_level" required>
                                        <option value="">Select Skill Level</option>
                                        <option value="basic" {{ old('skill_level', isset($labor) ? $labor->skill_level : '') == 'basic' ? 'selected' : '' }}>Basic</option>
                                        <option value="intermediate" {{ old('skill_level', isset($labor) ? $labor->skill_level : '') == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                        <option value="advanced" {{ old('skill_level', isset($labor) ? $labor->skill_level : '') == 'advanced' ? 'selected' : '' }}>Advanced</option>
                                        <option value="master" {{ old('skill_level', isset($labor) ? $labor->skill_level : '') == 'master' ? 'selected' : '' }}>Master</option>
                                    </select>
                                    @error('skill_level')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label" for="base_cost">Base Cost</label>
                                    <input type="number" step="0.01" min="0"
                                        class="form-control @error('base_cost') is-invalid @enderror"
                                        id="base_cost" name="base_cost" placeholder="Enter base cost"
                                        value="{{ old('base_cost', isset($labor) ? $labor->base_cost : '') }}">
                                    @error('base_cost')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label" for="cost_per_hour">Cost Per Hour</label>
                                    <input type="number" step="0.01" min="0"
                                        class="form-control @error('cost_per_hour') is-invalid @enderror"
                                        id="cost_per_hour" name="cost_per_hour" placeholder="Enter cost per hour"
                                        value="{{ old('cost_per_hour', isset($labor) ? $labor->cost_per_hour : '') }}">
                                    @error('cost_per_hour')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label" for="estimated_hours">Estimated Hours</label>
                                    <input type="number" step="0.01" min="0"
                                        class="form-control @error('estimated_hours') is-invalid @enderror"
                                        id="estimated_hours" name="estimated_hours" placeholder="Enter estimated hours"
                                        value="{{ old('estimated_hours', isset($labor) ? $labor->estimated_hours : '') }}">
                                    @error('estimated_hours')
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
                                        <option value="Active" {{ old('status', isset($labor) ? $labor->status : 'Active') == 'Active' ? 'selected' : '' }}>Active</option>
                                        <option value="Inactive" {{ old('status', isset($labor) ? $labor->status : 'Active') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="description">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                    id="description" name="description" placeholder="Enter description"
                                    rows="4">{{ old('description', isset($labor) ? $labor->description : '') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-primary">
                                        {{ isset($labor) ? 'Update Labor' : 'Save Labor' }}
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
