@extends('layouts.master')
@section('title', isset($setting) ? 'Edit Setting - ' . env('APP_NAME') : 'Add Setting - ' . env('APP_NAME'))
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('components.alert')
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">{{ isset($setting) ? 'Edit Setting' : 'Add New Setting' }}</h5>
                        <button type="button" class="btn btn-secondary"
                            onclick="location.href='{{ route('application-settings.index') }}'">
                            Back to Settings
                        </button>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('application-settings.save', $setting->setting_id ?? null) }}"
                            method="POST">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="company_id">Company</label>
                                    @php
                                        $companyLocked = isset($selectedCompanyId) && $selectedCompanyId !== 'all';
                                        $companyValue = $companyLocked
                                            ? $selectedCompanyId
                                            : old('company_id', isset($setting) ? $setting->company_id : '');
                                    @endphp
                                    <select class="form-select @error('company_id') is-invalid @enderror" id="company_id"
                                        name="company_id" {{ $companyLocked ? 'disabled' : '' }}>
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
                                    <label class="form-label" for="branch_id">Branch</label>
                                    <select class="form-select @error('branch_id') is-invalid @enderror" id="branch_id"
                                        name="branch_id"
                                        data-selected="{{ old('branch_id', isset($setting) ? $setting->branch_id : '') }}">
                                        <option value="">Select Branch</option>
                                    </select>
                                    @error('branch_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="setting_key">Setting Key <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('setting_key') is-invalid @enderror"
                                        id="setting_key" name="setting_key"
                                        placeholder="e.g., site.title or payment.tax_rate"
                                        value="{{ old('setting_key', isset($setting) ? $setting->setting_key : '') }}"
                                        required>
                                    @error('setting_key')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="setting_type">Setting Type <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select @error('setting_type') is-invalid @enderror"
                                        id="setting_type" name="setting_type" required>
                                        <option value="">Select Type</option>
                                        @php
                                            $typeValue = old(
                                                'setting_type',
                                                isset($setting) ? $setting->setting_type : 'string',
                                            );
                                        @endphp
                                        <option value="string" {{ $typeValue == 'string' ? 'selected' : '' }}>String
                                        </option>
                                        <option value="number" {{ $typeValue == 'number' ? 'selected' : '' }}>Number
                                        </option>
                                        <option value="boolean" {{ $typeValue == 'boolean' ? 'selected' : '' }}>Boolean
                                        </option>
                                        <option value="json" {{ $typeValue == 'json' ? 'selected' : '' }}>JSON</option>
                                    </select>
                                    @error('setting_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="setting_value">Setting Value</label>
                                <textarea class="form-control @error('setting_value') is-invalid @enderror" id="setting_value" name="setting_value"
                                    rows="4" placeholder="For boolean use true/false or 1/0. For JSON use valid JSON like {\"key\":\"value\"}.">{{ old('setting_value', isset($setting) ? $setting->setting_value : '') }}</textarea>
                                @error('setting_value')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="category">Category</label>
                                    <input type="text" class="form-control @error('category') is-invalid @enderror"
                                        id="category" name="category" placeholder="e.g., General, Payment"
                                        value="{{ old('category', isset($setting) ? $setting->category : '') }}">
                                    @error('category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="description">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                        rows="3" placeholder="Describe what this setting controls">{{ old('description', isset($setting) ? $setting->description : '') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-primary">
                                        {{ isset($setting) ? 'Update Setting' : 'Save Setting' }}
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
