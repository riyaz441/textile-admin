@extends('layouts.master')
@section('title', 'Doctors - ' . env('APP_NAME'))
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('components.alert')
        <div class="card">
            <div class="d-flex justify-content-between align-items-center p-3">
                <h5 class="card-header mb-0">Doctors</h5>
                <div class="ms-auto">
                    <button class="btn btn-primary" onclick="location.href='{{ route('doctors.form') }}'">
                        + Add Doctor
                    </button>
                </div>
            </div>
            <div class="table-responsive text-nowrap p-3">
                <table id="doctors-table" class="table">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($doctors as $doctor)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if ($doctor->image)
                                        <img src="{{ asset($doctor->image) }}" alt="{{ $doctor->name }}" width="50" height="50"
                                            style="object-fit: cover; border-radius: 4px;">
                                    @else
                                        <span class="badge bg-label-secondary">No Image</span>
                                    @endif
                                </td>
                                <td>{{ $doctor->name }}</td>
                                <td>{{ $doctor->mobile_no }}</td>
                                <td>{{ $doctor->email ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge {{ $doctor->priority ? 'bg-label-success' : 'bg-label-secondary' }}">
                                        {{ $doctor->priority ? 'Yes' : 'No' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input change_doctor_status" type="checkbox"
                                            data-id="{{ $doctor->doctor_id }}"
                                            {{ $doctor->status == 'Active' ? 'checked' : '' }}>
                                    </div>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu doctor-action-menu">
                                            <a class="dropdown-item" href="javascript:void(0);"
                                                onclick="location.href='{{ route('doctors.form', $doctor->doctor_id) }}'">
                                                <i class="bx bx-edit-alt me-1"></i> Edit
                                            </a>
                                            <a class="dropdown-item" href="javascript:void(0);"
                                                onclick="location.href='{{ route('doctors.show', $doctor->doctor_id) }}'">
                                                <i class="bx bx-show me-1"></i> View
                                            </a>
                                            <a class="dropdown-item delete-item" href="#" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal" data-id="{{ $doctor->doctor_id }}"
                                                data-name="doctors/delete">
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

    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this doctor?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('.change_doctor_status').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                const doctorId = this.getAttribute('data-id');
                const status = this.checked ? 'Active' : 'Inactive';

                fetch('{{ url('change_doctor_status') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            id: doctorId,
                            status: status
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const alertDiv = document.createElement('div');
                            alertDiv.className = 'alert alert-success alert-dismissible fade show';
                            alertDiv.innerHTML = data.message +
                                '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
                            document.querySelector('.container-xxl').insertBefore(alertDiv, document.querySelector('.card'));
                            setTimeout(() => alertDiv.remove(), 3000);
                        }
                    });
            });
        });

        const deleteModal = document.getElementById('deleteModal');
        deleteModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const doctorId = button.getAttribute('data-id');
            const actionName = button.getAttribute('data-name');
            const form = document.getElementById('deleteForm');
            form.action = '{{ url('/') }}/' + actionName + '/' + doctorId;
        });
    </script>
@endpush
