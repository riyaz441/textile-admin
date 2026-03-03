@extends('layouts.master')
@section('title', 'Suppliers - ' . env('APP_NAME'))
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('components.alert')
        <!-- Bootstrap Table with Header - Light -->
        <div class="card">
            <div class="d-flex justify-content-between align-items-center p-3">
                <h5 class="card-header mb-0">Suppliers</h5>
                <div class="ms-auto">
                    <button class="btn btn-primary" onclick="location.href='{{ route('suppliers.form') }}'">
                        + Add Supplier
                    </button>
                </div>
            </div>
            <div class="table-responsive text-nowrap p-3">
                <table id="suppliers-table" class="table">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Supplier Code</th>
                            <th>Company Name</th>
                            <th>Contact Person</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>City</th>
                            <th>Rating</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @forelse ($suppliers as $supplier)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><span class="badge bg-label-primary">{{ $supplier->supplier_code }}</span></td>
                                <td>{{ $supplier->company->company_name }}</td>
                                <td>{{ $supplier->contact_person ?? 'N/A' }}</td>
                                <td>{{ $supplier->email ?? 'N/A' }}</td>
                                <td>{{ $supplier->mobile ?? 'N/A' }}</td>
                                <td>{{ $supplier->city ?? 'N/A' }}</td>
                                <td>
                                    @if ($supplier->rating > 0)
                                        <span class="badge bg-label-warning">{{ $supplier->rating }}/5</span>
                                    @else
                                        <span class="badge bg-label-secondary">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input change_supplier_status" type="checkbox"
                                            id="flexSwitchCheckChecked" data-id="{{ $supplier->supplier_id }}"
                                            {{ $supplier->status == 'Active' ? 'checked' : '' }}>
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
                                                onclick="location.href='{{ route('suppliers.form', $supplier->supplier_id) }}'">
                                                <i class="bx bx-edit-alt me-1"></i> Edit
                                            </a>
                                            <a class="dropdown-item" href="javascript:void(0);"
                                                onclick="location.href='{{ route('suppliers.show', $supplier->supplier_id) }}'">
                                                <i class="bx bx-show me-1"></i> View
                                            </a>
                                            <a class="dropdown-item delete-item" href="#" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal" data-id="{{ $supplier->supplier_id }}"
                                                data-name="suppliers/delete">
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
