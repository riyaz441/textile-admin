@extends('layouts.master')
@section('title', 'Application Settings - ' . env('APP_NAME'))
@section('content')
    @php
        use Illuminate\Support\Str;
    @endphp
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('components.alert')
        <div class="card">
            <div class="d-flex justify-content-between align-items-center p-3">
                <h5 class="card-header mb-0">Application Settings</h5>
                <div class="ms-auto">
                    <button class="btn btn-primary" onclick="location.href='{{ route('application-settings.form') }}'">
                        + Add Setting
                    </button>
                </div>
            </div>
            <div class="table-responsive text-nowrap p-3">
                <table id="application-settings-table" class="table">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Key</th>
                            <th>Value</th>
                            <th>Type</th>
                            <th>Category</th>
                            <th>Company</th>
                            <th>Branch</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($settings as $setting)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><span class="badge bg-label-primary">{{ $setting->setting_key }}</span></td>
                                <td>{{ Str::limit($setting->setting_value ?? 'N/A', 60) }}</td>
                                <td>
                                    <span class="badge bg-label-info">{{ ucfirst($setting->setting_type) }}</span>
                                </td>
                                <td>{{ $setting->category ?? 'N/A' }}</td>
                                <td>{{ $setting->company->company_name ?? 'N/A' }}</td>
                                <td>{{ $setting->branch->branch_name ?? 'N/A' }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu company-action-menu">
                                            <a class="dropdown-item" href="javascript:void(0);"
                                                onclick="location.href='{{ route('application-settings.form', $setting->setting_id) }}'">
                                                <i class="bx bx-edit-alt me-1"></i> Edit
                                            </a>
                                            <a class="dropdown-item" href="javascript:void(0);"
                                                onclick="location.href='{{ route('application-settings.show', $setting->setting_id) }}'">
                                                <i class="bx bx-show me-1"></i> View
                                            </a>
                                            <a class="dropdown-item delete-item" href="#" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal" data-id="{{ $setting->setting_id }}"
                                                data-name="application-settings/delete">
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
