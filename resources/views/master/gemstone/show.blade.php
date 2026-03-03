@extends('layouts.master')
@section('title', 'View Gemstone - ' . env('APP_NAME'))
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('components.alert')
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Gemstone Details</h5>
                        <div>
                            <button type="button" class="btn btn-primary"
                                onclick="location.href='{{ route('gemstones.form', $gemstone->gemstone_id) }}'">
                                Edit
                            </button>
                            <button type="button" class="btn btn-secondary"
                                onclick="location.href='{{ route('gemstones.index') }}'">
                                Back to Gemstones
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <h6 class="text-primary mb-2">Basic Information</h6>
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Gemstone Name</label>
                                <h6 class="mb-0"><span class="badge bg-label-primary">{{ $gemstone->gemstone_name }}</span></h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Type</label>
                                <h6 class="mb-0">
                                    <span class="badge bg-label-info">{{ ucfirst($gemstone->type) }}</span>
                                </h6>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Company</label>
                                <h6 class="mb-0">{{ $gemstone->company->company_name ?? 'N/A' }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Branch</label>
                                <h6 class="mb-0">{{ $gemstone->branch->branch_name ?? 'N/A' }}</h6>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Gemstone Code</label>
                                <h6 class="mb-0">{{ $gemstone->gemstone_code ?? 'N/A' }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Status</label>
                                <h6 class="mb-0">
                                    <span class="badge {{ $gemstone->status === 'Active' ? 'bg-label-success' : 'bg-label-danger' }}">
                                        {{ $gemstone->status }}
                                    </span>
                                </h6>
                            </div>
                        </div>

                        <hr>
                        <h6 class="text-primary mb-2">Quality & Appearance</h6>
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Color</label>
                                <h6 class="mb-0">{{ $gemstone->color ?? 'N/A' }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Clarity</label>
                                <h6 class="mb-0">{{ $gemstone->clarity ?? 'N/A' }}</h6>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Cut Grade</label>
                                <h6 class="mb-0">{{ $gemstone->cut_grade ?? 'N/A' }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Default Carat Weight</label>
                                <h6 class="mb-0">{{ $gemstone->default_carat_weight ?? 'N/A' }}</h6>
                            </div>
                        </div>

                        <hr>
                        <h6 class="text-primary mb-2">Cut & Shape</h6>
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Cut</label>
                                <h6 class="mb-0">{{ $gemstone->cut ?? 'N/A' }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Shape</label>
                                <h6 class="mb-0">{{ $gemstone->shape ?? 'N/A' }}</h6>
                            </div>
                        </div>

                        <hr>
                        <h6 class="text-primary mb-2">Measurements</h6>
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Measurements (L x W x D)</label>
                                <h6 class="mb-0">
                                    {{ $gemstone->measurement_length ?? 'N/A' }}
                                    x {{ $gemstone->measurement_width ?? 'N/A' }}
                                    x {{ $gemstone->measurement_depth ?? 'N/A' }}
                                </h6>
                            </div>
                        </div>

                        <hr>
                        <h6 class="text-primary mb-2">Additional Details</h6>
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Treatment</label>
                                <h6 class="mb-0">{{ $gemstone->treatment ?? 'N/A' }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Origin</label>
                                <h6 class="mb-0">{{ $gemstone->origin ?? 'N/A' }}</h6>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Fluorescence</label>
                                <h6 class="mb-0">{{ $gemstone->fluorescence ?? 'N/A' }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Symmetry</label>
                                <h6 class="mb-0">{{ $gemstone->symmetry ?? 'N/A' }}</h6>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Polish</label>
                                <h6 class="mb-0">{{ $gemstone->polish ?? 'N/A' }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Girdle</label>
                                <h6 class="mb-0">{{ $gemstone->girdle ?? 'N/A' }}</h6>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Culet</label>
                                <h6 class="mb-0">{{ $gemstone->culet ?? 'N/A' }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Table %</label>
                                <h6 class="mb-0">{{ $gemstone->table_percentage ?? 'N/A' }}</h6>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Depth %</label>
                                <h6 class="mb-0">{{ $gemstone->depth_percentage ?? 'N/A' }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Certification Lab</label>
                                <h6 class="mb-0">{{ $gemstone->certification_lab ?? 'N/A' }}</h6>
                            </div>
                        </div>

                        <hr>
                        <h6 class="text-primary mb-2">Certification</h6>
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Certification Number</label>
                                <h6 class="mb-0">{{ $gemstone->certification_number ?? 'N/A' }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Certification Date</label>
                                <h6 class="mb-0">
                                    {{ $gemstone->certification_date ? \Carbon\Carbon::parse($gemstone->certification_date)->format('d-m-Y') : 'N/A' }}
                                </h6>
                            </div>
                        </div>

                        <hr>
                        <h6 class="text-primary mb-2">System</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Created At</label>
                                <h6 class="mb-0">{{ $gemstone->created_at->format('d-m-Y H:i:s') }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Updated At</label>
                                <h6 class="mb-0">{{ $gemstone->updated_at->format('d-m-Y H:i:s') }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
