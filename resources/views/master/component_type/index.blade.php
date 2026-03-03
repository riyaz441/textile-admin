@extends('layouts.master')
@section('title', 'Component Type - ' . env('APP_NAME'))
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('components.alert')
        <div class="card">
            <div class="d-flex justify-content-between align-items-center p-3">
                <h5 class="card-header mb-0">Component Type</h5>
                <div class="ms-auto">
                    <button class="btn btn-primary" onclick="location.href='{{ route('component-types.form') }}'">
                        + Add Component Type
                    </button>
                </div>
            </div>
            <div class="table-responsive text-nowrap p-3">
                <table id="component-type-table" class="table">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Company</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @forelse ($componentTypes as $componentType)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $componentType->company->company_name ?? 'N/A' }}</td>
                                <td><span class="badge bg-label-primary">{{ $componentType->type_name }}</span></td>
                                <td>{{ $componentType->category ?? 'N/A' }}</td>
                                <td>
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input change_component_type_status" type="checkbox"
                                            id="flexSwitchCheckChecked" data-id="{{ $componentType->type_id }}"
                                            {{ $componentType->status == 'Active' ? 'checked' : '' }}>
                                    </div>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu company-action-menu">
                                            <a class="dropdown-item" href="javascript:void(0);"
                                                onclick="location.href='{{ route('component-types.form', $componentType->type_id) }}'">
                                                <i class="bx bx-edit-alt me-1"></i> Edit
                                            </a>
                                            <a class="dropdown-item" href="javascript:void(0);"
                                                onclick="location.href='{{ route('component-types.show', $componentType->type_id) }}'">
                                                <i class="bx bx-show me-1"></i> View
                                            </a>
                                            <a class="dropdown-item delete-item" href="#" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal" data-id="{{ $componentType->type_id }}"
                                                data-name="component-types/delete">
                                                <i class="bx bx-trash me-1"></i> Delete
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
