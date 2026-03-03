@extends('layouts.master')
@section('title', 'View Material - ' . env('APP_NAME'))
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Material Details</h5>
                        <div>
                            <button type="button" class="btn btn-primary"
                                onclick="location.href='{{ route('materials.form', $material->material_id) }}'">
                                Edit
                            </button>
                            <button type="button" class="btn btn-secondary"
                                onclick="location.href='{{ route('materials.index') }}'">
                                Back to Materials
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Material Name</label>
                                <h6 class="mb-0">{{ $material->material_name }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Carat/Purity</label>
                                <h6 class="mb-0">{{ $material->carat_purity ?? '-' }}</h6>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Density</label>
                                <h6 class="mb-0">{{ $material->density ?? '-' }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Status</label>
                                <h6 class="mb-0">
                                    <span
                                        class="badge {{ $material->status == 'Active' ? 'bg-label-success' : 'bg-label-danger' }}">
                                        {{ $material->status ?? '-' }}
                                    </span>
                                </h6>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Description</label>
                                <h6 class="mb-0">{{ $material->description ?? '-' }}</h6>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Created At</label>
                                <h6 class="mb-0">
                                    {{ $material->created_at ? $material->created_at->format('d-m-Y H:i:s') : '-' }}
                                </h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Updated At</label>
                                <h6 class="mb-0">
                                    {{ $material->updated_at ? $material->updated_at->format('d-m-Y H:i:s') : '-' }}
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
