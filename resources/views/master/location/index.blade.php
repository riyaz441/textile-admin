@extends('layouts.master')
@section('title', 'Locations - ' . env('APP_NAME'))

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('components.alert')

        <div class="card">
            <div class="d-flex justify-content-between align-items-center p-3">
                <h5 class="card-header mb-0">Locations</h5>

                <div class="ms-auto">
                    <button class="btn btn-primary" onclick="location.href='{{ route('locations.form') }}'">
                        + Add Location
                    </button>
                </div>
            </div>

            <div class="table-responsive text-nowrap p-3">
                <table id="locations-table" class="table">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Location Code</th>
                            <th>Location Name</th>
                            <th>Type</th>
                            <th>Company</th>
                            <th>Branch</th>
                            <th>Parent</th>
                            <th>Contact</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody class="table-border-bottom-0">
                        @forelse ($locations as $location)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    <span class="badge bg-label-primary">
                                        {{ $location->location_code }}
                                    </span>
                                </td>

                                <td>{{ $location->location_name }}</td>

                                <td>
                                    {{ ucfirst(str_replace('_', ' ', $location->location_type)) }}
                                </td>

                                <td>
                                    {{ $location->company->company_name ?? 'N/A' }}
                                </td>

                                <td>
                                    {{ $location->branch->branch_name ?? 'N/A' }}
                                </td>

                                <td>
                                    {{ $location->parent->location_name ?? 'N/A' }}
                                </td>

                                <td>{{ $location->contact_person ?? 'N/A' }}</td>
                                <td>{{ $location->phone ?? 'N/A' }}</td>

                                <td>
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input change_location_status" type="checkbox"
                                            data-id="{{ $location->location_id }}"
                                            {{ $location->status == 'Active' ? 'checked' : '' }}>
                                    </div>
                                </td>

                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>

                                        <div class="dropdown-menu company-action-menu">

                                            <a class="dropdown-item"
                                                href="{{ route('locations.form', $location->location_id) }}">
                                                <i class="bx bx-edit-alt me-1"></i> Edit
                                            </a>

                                            <a class="dropdown-item"
                                                href="{{ route('locations.show', $location->location_id) }}">
                                                <i class="bx bx-show me-1"></i> View
                                            </a>

                                            <a class="dropdown-item delete-item" href="#" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal" data-id="{{ $location->location_id }}"
                                                data-name="locations/delete">
                                                <i class="bx bx-trash me-1"></i> Delete
                                            </a>

                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center">No locations found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
