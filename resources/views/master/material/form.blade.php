@extends('layouts.master')
@section('title', isset($material) ? 'Edit Material - ' . env('APP_NAME') : 'Add Material - ' . env('APP_NAME'))
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('components.alert')
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">{{ isset($material) ? 'Edit Material' : 'Add New Material' }}</h5>
                        <button type="button" class="btn btn-secondary"
                            onclick="location.href='{{ route('materials.index') }}'">
                            Back to Materials
                        </button>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('materials.save', $material->material_id ?? null) }}" method="POST">
                            @csrf

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="material_name">Material Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('material_name') is-invalid @enderror"
                                        id="material_name" name="material_name" placeholder="Enter material name"
                                        value="{{ old('material_name', isset($material) ? $material->material_name : '') }}"
                                        required>
                                    @error('material_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="carat_purity">Carat/Purity</label>
                                    <input type="text" class="form-control @error('carat_purity') is-invalid @enderror"
                                        id="carat_purity" name="carat_purity" placeholder="Enter carat or purity"
                                        value="{{ old('carat_purity', isset($material) ? $material->carat_purity : '') }}">
                                    @error('carat_purity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="density">Density</label>
                                    <input type="number" step="0.0001"
                                        class="form-control @error('density') is-invalid @enderror" id="density"
                                        name="density" placeholder="Enter density"
                                        value="{{ old('density', isset($material) ? $material->density : '') }}">
                                    @error('density')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="status">Status <span class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status"
                                        name="status" required>
                                        <option value="">Select Status</option>
                                        <option value="Active"
                                            {{ old('status', isset($material) ? $material->status : 'Active') == 'Active' ? 'selected' : '' }}>
                                            Active
                                        </option>
                                        <option value="Inactive"
                                            {{ old('status', isset($material) ? $material->status : 'Active') == 'Inactive' ? 'selected' : '' }}>
                                            Inactive
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="description">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                                        name="description" placeholder="Material description (optional)"
                                        rows="3">{{ old('description', isset($material) ? $material->description : '') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-primary">
                                        {{ isset($material) ? 'Update Material' : 'Save Material' }}
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
