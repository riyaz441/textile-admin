@extends('layouts.master')
@section('title', 'Gemstones - ' . env('APP_NAME'))
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('components.alert')
        <!-- Bootstrap Table with Header - Light -->
        <div class="card">
            <div class="d-flex justify-content-between align-items-center p-3">
                <h5 class="card-header mb-0">Gemstones</h5>
                <div class="ms-auto">
                    <button class="btn btn-primary" onclick="location.href='{{ route('gemstones.form') }}'">
                        + Add Gemstone
                    </button>
                </div>
            </div>
            <div class="table-responsive text-nowrap p-3">
                <table id="gemstones-table" class="table">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Gemstone Name</th>
                            <th>Company</th>
                            <th>Branch</th>
                            <th>Type</th>
                            <th>Color</th>
                            <th>Clarity</th>
                            <th>Cut Grade</th>
                            <th>Default Carat Weight</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @forelse ($gemstones as $gemstone)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><span class="badge bg-label-primary">{{ $gemstone->gemstone_name }}</span></td>
                                <td>{{ $gemstone->company->company_name ?? 'N/A' }}</td>
                                <td>{{ $gemstone->branch->branch_name ?? 'N/A' }}</td>
                                <td>{{ ucfirst($gemstone->type) }}</td>
                                <td>{{ $gemstone->color ?? 'N/A' }}</td>
                                <td>{{ $gemstone->clarity ?? 'N/A' }}</td>
                                <td>{{ $gemstone->cut_grade ?? 'N/A' }}</td>
                                <td>{{ $gemstone->default_carat_weight ?? 'N/A' }}</td>
                                <td>
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input change_gemstone_status" type="checkbox"
                                            id="flexSwitchCheckChecked" data-id="{{ $gemstone->gemstone_id }}"
                                            {{ $gemstone->status == 'Active' ? 'checked' : '' }}>
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
                                                onclick="location.href='{{ route('gemstones.form', $gemstone->gemstone_id) }}'">
                                                <i class="bx bx-edit-alt me-1"></i> Edit
                                            </a>
                                            <a class="dropdown-item" href="javascript:void(0);"
                                                onclick="location.href='{{ route('gemstones.show', $gemstone->gemstone_id) }}'">
                                                <i class="bx bx-show me-1"></i> View
                                            </a>
                                            <a class="dropdown-item delete-item" href="#" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal" data-id="{{ $gemstone->gemstone_id }}"
                                                data-name="gemstones/delete">
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
