@extends('layouts.master')
@section('title', 'Measurements - ' . env('APP_NAME'))
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('components.alert')
        <div class="card">
            <div class="d-flex justify-content-between align-items-center p-3">
                <h5 class="card-header mb-0">Measurements</h5>
                <div class="ms-auto">
                    <button class="btn btn-primary" onclick="location.href='{{ route('measurements.form') }}'">
                        + Add Measurement
                    </button>
                </div>
            </div>
            <div class="table-responsive text-nowrap p-3">
                <table id="measurements-table" class="table">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Measurement Name</th>
                            <th>UOM</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($measurements as $measurement)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><span class="badge bg-label-primary">{{ $measurement->name ?? 'N/A' }}</span></td>
                                <td>{{ $measurement->UOM ?? 'N/A' }}</td>
                                <td>
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input change_measurement_status" type="checkbox"
                                            id="flexSwitchCheckChecked" data-id="{{ $measurement->measurement_id }}"
                                            {{ $measurement->status == 'Active' ? 'checked' : '' }}>
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
                                                onclick="location.href='{{ route('measurements.form', $measurement->measurement_id) }}'">
                                                <i class="bx bx-edit-alt me-1"></i> Edit
                                            </a>
                                            <a class="dropdown-item" href="javascript:void(0);"
                                                onclick="location.href='{{ route('measurements.show', $measurement->measurement_id) }}'">
                                                <i class="bx bx-show me-1"></i> View
                                            </a>
                                            <a class="dropdown-item delete-item" href="#" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal" data-id="{{ $measurement->measurement_id }}"
                                                data-name="measurements/delete">
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
