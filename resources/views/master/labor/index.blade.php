@extends('layouts.master')
@section('title', 'Labors - ' . env('APP_NAME'))
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('components.alert')
        <!-- Bootstrap Table with Header - Light -->
        <div class="card">
            <div class="d-flex justify-content-between align-items-center p-3">
                <h5 class="card-header mb-0">Labors</h5>
                <div class="ms-auto">
                    <button class="btn btn-primary" onclick="location.href='{{ route('labors.form') }}'">
                        + Add Labor
                    </button>
                </div>
            </div>
            <div class="table-responsive text-nowrap p-3">
                <table id="labors-table" class="table">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Labor Code</th>
                            <th>Labor Name</th>
                            <th>Company</th>
                            <th>Base Cost</th>
                            <th>Cost/Hour</th>
                            <th>Est. Hours</th>
                            <th>Skill Level</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @forelse ($labors as $labor)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><span class="badge bg-label-primary">{{ $labor->labor_code }}</span></td>
                                <td>{{ $labor->labor_name }}</td>
                                <td>{{ $labor->company->company_name ?? 'N/A' }}</td>
                                <td>{{ $labor->base_cost !== null ? number_format($labor->base_cost, 2) : 'N/A' }}</td>
                                <td>{{ $labor->cost_per_hour !== null ? number_format($labor->cost_per_hour, 2) : 'N/A' }}</td>
                                <td>{{ $labor->estimated_hours !== null ? number_format($labor->estimated_hours, 2) : 'N/A' }}</td>
                                <td>{{ ucfirst($labor->skill_level) }}</td>
                                <td>
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input change_labor_status" type="checkbox"
                                            id="flexSwitchCheckChecked" data-id="{{ $labor->id }}"
                                            {{ $labor->status == 'Active' ? 'checked' : '' }}>
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
                                                onclick="location.href='{{ route('labors.form', $labor->labor_id) }}'">
                                                <i class="bx bx-edit-alt me-1"></i> Edit
                                            </a>
                                            <a class="dropdown-item" href="javascript:void(0);"
                                                onclick="location.href='{{ route('labors.show', $labor->labor_id) }}'">
                                                <i class="bx bx-show me-1"></i> View
                                            </a>
                                            <a class="dropdown-item delete-item" href="#" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal" data-id="{{ $labor->labor_id }}"
                                                data-name="labors/delete">
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
