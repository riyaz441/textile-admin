@extends('layouts.master')
@section('title', 'View Supplier - ' . env('APP_NAME'))
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('components.alert')
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Supplier Details</h5>
                        <div>
                            <button type="button" class="btn btn-primary"
                                onclick="location.href='{{ route('suppliers.form', $supplier->supplier_id) }}'">
                                Edit
                            </button>
                            <button type="button" class="btn btn-secondary" onclick="location.href='{{ route('suppliers.index') }}'">
                                Back to Suppliers
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Supplier Code</label>
                                <h6 class="mb-0"><span class="badge bg-label-primary">{{ $supplier->supplier_code }}</span></h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Company Name</label>
                                <h6 class="mb-0">{{ $supplier->company_name }}</h6>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Contact Person</label>
                                <h6 class="mb-0">{{ $supplier->contact_person ?? 'N/A' }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Email</label>
                                <h6 class="mb-0">
                                    @if ($supplier->email)
                                        <a href="mailto:{{ $supplier->email }}">{{ $supplier->email }}</a>
                                    @else
                                        N/A
                                    @endif
                                </h6>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Phone</label>
                                <h6 class="mb-0">{{ $supplier->phone ?? 'N/A' }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Mobile</label>
                                <h6 class="mb-0">{{ $supplier->mobile ?? 'N/A' }}</h6>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">City</label>
                                <h6 class="mb-0">{{ $supplier->city ?? 'N/A' }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">State</label>
                                <h6 class="mb-0">{{ $supplier->state ?? 'N/A' }}</h6>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Country</label>
                                <h6 class="mb-0">{{ $supplier->country ?? 'N/A' }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Tax ID</label>
                                <h6 class="mb-0">{{ $supplier->tax_id ?? 'N/A' }}</h6>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Payment Terms</label>
                                <h6 class="mb-0">{{ $supplier->payment_terms ?? 'N/A' }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Rating</label>
                                <h6 class="mb-0">
                                    @if ($supplier->rating > 0)
                                        <span class="badge bg-label-warning">{{ $supplier->rating }}/5</span>
                                    @else
                                        <span class="badge bg-label-secondary">N/A</span>
                                    @endif
                                </h6>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Status</label>
                                <h6 class="mb-0">
                                    <span class="badge {{ $supplier->status == 'Active' ? 'bg-label-success' : 'bg-label-danger' }}">
                                        {{ $supplier->status }}
                                    </span>
                                </h6>
                            </div>
                        </div>

                        @if ($supplier->address)
                            <div class="mb-4">
                                <label class="form-label text-muted">Address</label>
                                <p class="mb-0">{{ $supplier->address }}</p>
                            </div>
                        @endif

                        @if ($supplier->bank_details)
                            <div class="mb-4">
                                <label class="form-label text-muted">Bank Details</label>
                                <p class="mb-0">{{ $supplier->bank_details }}</p>
                            </div>
                        @endif

                        @if ($supplier->notes)
                            <div class="mb-4">
                                <label class="form-label text-muted">Notes</label>
                                <p class="mb-0">{{ $supplier->notes }}</p>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Created At</label>
                                <h6 class="mb-0">{{ $supplier->created_at->format('d-m-Y H:i:s') }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Updated At</label>
                                <h6 class="mb-0">{{ $supplier->updated_at->format('d-m-Y H:i:s') }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
