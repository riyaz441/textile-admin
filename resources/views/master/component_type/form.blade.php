@extends('layouts.master')
@section('title', isset($componentType) ? 'Edit Component Type - ' . env('APP_NAME') : 'Add Component Type - ' .
    env('APP_NAME'))
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('components.alert')
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">{{ isset($componentType) ? 'Edit Component Type' : 'Add New Component Type' }}
                        </h5>
                        <button type="button" class="btn btn-secondary"
                            onclick="location.href='{{ route('component-types.index') }}'">
                            Back to Component Types
                        </button>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('component-types.save', $componentType->type_id ?? null) }}" method="POST">
                            @csrf

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="company_id">Company <span
                                            class="text-danger">*</span></label>
                                    @php
                                        $companyLocked = isset($selectedCompanyId) && $selectedCompanyId !== 'all';
                                        $companyValue = $companyLocked
                                            ? $selectedCompanyId
                                            : old('company_id', isset($componentType) ? $componentType->company_id : '');
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
                                    <label class="form-label" for="type_name">Component Type Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('type_name') is-invalid @enderror"
                                        id="type_name" name="type_name" placeholder="Enter component type name"
                                        value="{{ old('type_name', isset($componentType) ? $componentType->type_name : '') }}"
                                        required>
                                    @error('type_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="category">Category</label>
                                    <input type="text" class="form-control @error('category') is-invalid @enderror"
                                        id="category" name="category" placeholder="Enter category"
                                        value="{{ old('category', isset($componentType) ? $componentType->category : '') }}">
                                    @error('category')
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
                                            {{ old('status', isset($componentType) ? $componentType->status : 'Active') == 'Active' ? 'selected' : 'Active' }}>
                                            Active</option>
                                        <option value="Inactive"
                                            {{ old('status', isset($componentType) ? $componentType->status : 'Active') == 'Inactive' ? 'selected' : 'Active' }}>
                                            Inactive</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="form-label" for="description">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                        placeholder="Component type description (optional)" rows="4">{{ old('description', isset($componentType) ? $componentType->description : '') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-primary">
                                        {{ isset($componentType) ? 'Update Component Type' : 'Save Component Type' }}
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
