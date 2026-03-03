@extends('layouts.master')
@section('title', 'Branches - ' . env('APP_NAME'))
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('components.alert')
        <!-- Bootstrap Table with Header - Light -->
        <div class="card">
            <div class="d-flex justify-content-between align-items-center p-3">
                <h5 class="card-header mb-0">Branches</h5>
                <div class="ms-auto">
                    <button class="btn btn-primary" onclick="location.href='{{ route('branches.form') }}'">
                        + Add Branch
                    </button>
                </div>
            </div>
            <div class="table-responsive text-nowrap p-3">
                <table id="branches-table" class="table">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Branch Code</th>
                            <th>Branch Name</th>
                            <th>Company</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>City</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @forelse ($branches as $branch)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><span class="badge bg-label-primary">{{ $branch->branch_code }}</span></td>
                                <td>{{ $branch->branch_name }}</td>
                                <td>{{ $branch->company->company_name ?? 'N/A' }}</td>
                                <td>{{ $branch->email ?? 'N/A' }}</td>
                                <td>{{ $branch->phone ?? 'N/A' }}</td>
                                <td>{{ $branch->city ?? 'N/A' }}</td>
                                <td>
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input change_branch_status" type="checkbox"
                                            id="flexSwitchCheckChecked" data-id="{{ $branch->branch_id }}"
                                            {{ $branch->status == 'Active' ? 'checked' : '' }}>
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
                                                onclick="location.href='{{ route('branches.form', $branch->branch_id) }}'">
                                                <i class="bx bx-edit-alt me-1"></i> Edit
                                            </a>
                                            <a class="dropdown-item" href="javascript:void(0);"
                                                onclick="location.href='{{ route('branches.show', $branch->branch_id) }}'">
                                                <i class="bx bx-show me-1"></i> View
                                            </a>
                                            <a class="dropdown-item delete-item" href="#" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal" data-id="{{ $branch->branch_id }}"
                                                data-name="branches/delete">
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
