@extends('layouts.master')
@section('title', isset($supplier) ? 'Edit Supplier - ' . env('APP_NAME') : 'Add Supplier - ' . env('APP_NAME'))
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('components.alert')
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">{{ isset($supplier) ? 'Edit Supplier' : 'Add New Supplier' }}</h5>
                        <button type="button" class="btn btn-secondary" onclick="location.href='{{ route('suppliers.index') }}'">
                            Back to Suppliers
                        </button>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('suppliers.save', $supplier->supplier_id ?? null) }}" method="POST">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="supplier_code">Supplier Code <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('supplier_code') is-invalid @enderror"
                                        id="supplier_code" name="supplier_code" placeholder="Enter supplier code (e.g., SUP-001)"
                                        value="{{ old('supplier_code', isset($supplier) ? $supplier->supplier_code : '') }}" required>
                                    @error('supplier_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="company_id">Company <span class="text-danger">*</span></label>
                                    @php
                                        $companyLocked = isset($selectedCompanyId) && $selectedCompanyId !== 'all';
                                        $companyValue = $companyLocked
                                            ? $selectedCompanyId
                                            : old('company_id', isset($supplier) ? $supplier->company_id : '');
                                    @endphp
                                    <select class="form-select @error('company_id') is-invalid @enderror" id="company_id" name="company_id" {{ $companyLocked ? 'disabled' : '' }} required>
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
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="contact_person">Contact Person</label>
                                    <input type="text" class="form-control @error('contact_person') is-invalid @enderror"
                                        id="contact_person" name="contact_person" placeholder="Enter contact person name"
                                        value="{{ old('contact_person', isset($supplier) ? $supplier->contact_person : '') }}">
                                    @error('contact_person')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="email">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" placeholder="Enter email address"
                                        value="{{ old('email', isset($supplier) ? $supplier->email : '') }}">
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
                                        value="{{ old('phone', isset($supplier) ? $supplier->phone : '') }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="mobile">Mobile</label>
                                    <input type="text" class="form-control @error('mobile') is-invalid @enderror"
                                        id="mobile" name="mobile" placeholder="Enter mobile number"
                                        value="{{ old('mobile', isset($supplier) ? $supplier->mobile : '') }}">
                                    @error('mobile')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="city">City</label>
                                    <input type="text" class="form-control @error('city') is-invalid @enderror"
                                        id="city" name="city" placeholder="Enter city"
                                        value="{{ old('city', isset($supplier) ? $supplier->city : '') }}">
                                    @error('city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="state">State</label>
                                    <input type="text" class="form-control @error('state') is-invalid @enderror"
                                        id="state" name="state" placeholder="Enter state"
                                        value="{{ old('state', isset($supplier) ? $supplier->state : '') }}">
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
                                        value="{{ old('country', isset($supplier) ? $supplier->country : '') }}">
                                    @error('country')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="tax_id">Tax ID</label>
                                    <input type="text" class="form-control @error('tax_id') is-invalid @enderror"
                                        id="tax_id" name="tax_id" placeholder="Enter tax ID"
                                        value="{{ old('tax_id', isset($supplier) ? $supplier->tax_id : '') }}">
                                    @error('tax_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="payment_terms">Payment Terms</label>
                                    <input type="text" class="form-control @error('payment_terms') is-invalid @enderror"
                                        id="payment_terms" name="payment_terms" placeholder="Enter payment terms"
                                        value="{{ old('payment_terms', isset($supplier) ? $supplier->payment_terms : '') }}">
                                    @error('payment_terms')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="rating">Rating (0-5)</label>
                                    <input type="number" step="0.01" class="form-control @error('rating') is-invalid @enderror"
                                        id="rating" name="rating" placeholder="Enter rating" min="0" max="5"
                                        value="{{ old('rating', isset($supplier) ? $supplier->rating : '') }}">
                                    @error('rating')
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
                                        <option value="Active" {{ old('status', isset($supplier) ? $supplier->status : 'Active') == 'Active' ? 'selected' : '' }}>Active</option>
                                        <option value="Inactive" {{ old('status', isset($supplier) ? $supplier->status : 'Active') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="address">Address</label>
                                <textarea class="form-control @error('address') is-invalid @enderror"
                                    id="address" name="address" placeholder="Enter complete address"
                                    rows="3">{{ old('address', isset($supplier) ? $supplier->address : '') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="bank_details">Bank Details</label>
                                <textarea class="form-control @error('bank_details') is-invalid @enderror"
                                    id="bank_details" name="bank_details" placeholder="Enter bank details (account number, IFSC code, etc.)"
                                    rows="3">{{ old('bank_details', isset($supplier) ? $supplier->bank_details : '') }}</textarea>
                                @error('bank_details')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="notes">Notes</label>
                                <textarea class="form-control @error('notes') is-invalid @enderror"
                                    id="notes" name="notes" placeholder="Enter additional notes"
                                    rows="3">{{ old('notes', isset($supplier) ? $supplier->notes : '') }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-primary">
                                        {{ isset($supplier) ? 'Update Supplier' : 'Save Supplier' }}
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
