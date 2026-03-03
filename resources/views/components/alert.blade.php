@php
    $successMessage = session('success');
    $dangerMessage = session('danger');
    $isDeleteSuccess = is_string($successMessage) && str_contains(strtolower($successMessage), 'deleted');
    $isDanger = $dangerMessage || $isDeleteSuccess;
    $toastClass = $isDanger ? 'bg-danger' : 'bg-success';
    $toastTitle = $isDanger ? 'Alert' : 'Success';
    $toastMessage = $successMessage ?: $dangerMessage;
@endphp

@if ($successMessage || $dangerMessage)
    <style>
        .toast-container-custom {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index:999;
        }
    </style>
    <div class="toast-container-custom">
        <div class="bs-toast toast fade {{ $toastClass }}" role="alert"
            aria-live="assertive" aria-atomic="true" id="autoHideToast">
            <div class="toast-header">
                <i class="icon-base bx bx-bell me-2"></i>
                <div class="me-auto fw-medium">{{ $toastTitle }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                <strong>{{ $toastMessage }}</strong>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toastElement = document.getElementById('autoHideToast');
            if (toastElement) {
                const toast = new bootstrap.Toast(toastElement, {
                    autohide: true,
                    delay: 3000
                });
                toast.show();
            }
        });
    </script>
@endif
