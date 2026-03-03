@extends('layouts.master')
@section('title', 'Profile - ' . env('APP_NAME'))
@section('content')

    <div class="container-xxl flex-grow-1">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1">Profile</h4>
                <p class="text-muted mb-0">Manage your personal information and account settings</p>
            </div>
            <div class="d-flex align-items-center">
                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                    <i class="bx bx-arrow-back me-2"></i>Back to Dashboard
                </a>
            </div>
        </div>

        <div class="row">
            <!-- Left Column - Profile Information -->
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div class="avatar me-3 d-flex align-items-center justify-content-center"
                                style="width: 50px; height: 50px;">
                                @if ($user->profile)
                                    <img src="{{ asset('assets/img/profile/' . $user->profile) }}" alt="Profile"
                                        class="rounded-circle d-block" style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                    <div class="avatar-initial bg-label-primary rounded-circle d-flex align-items-center justify-content-center"
                                        style="width: 50px; height: 50px;">
                                        <span class="fw-bold fs-4">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <h5 class="mb-0">Personal Information</h5>
                                <small class="text-muted">Update your personal details</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @include('components.alert')

                        <form action="{{ route('profile') }}" method="POST" enctype="multipart/form-data" id="profileForm">
                            @csrf

                            <div class="row">
                                <!-- Full Name -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="name">
                                        Full Name <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" value="{{ old('name', $user->name) }}"
                                            placeholder="Enter your full name" required>
                                    </div>
                                    @error('name')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="email">
                                        Email Address <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-merge">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="email" name="email" value="{{ old('email', $user->email) }}"
                                            placeholder="Enter your email" required>
                                    </div>
                                    @error('email')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Phone Number -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="phone">
                                        Phone Number
                                    </label>
                                    <div class="input-group input-group-merge">
                                        <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                            id="phone" name="phone"
                                            value="{{ old('phone', $user->phone_number ?? '') }}"
                                            placeholder="+1 (123) 456-7890">
                                    </div>
                                    @error('phone')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Address -->
                                <div class="col-12 mb-3">
                                    <label class="form-label" for="address">
                                        Address
                                    </label>
                                    <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="2"
                                        placeholder="Enter your address">{{ old('address', $user->address ?? '') }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Password Section -->
                            <div class="card mt-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">
                                        <i class="bx bx-lock me-2"></i>Password Settings
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <!-- New Password -->
                                        <div class="col-md-6 mb-3 mt-3">
                                            <label class="form-label" for="password">
                                                New Password
                                            </label>
                                            <div class="input-group input-group-merge">
                                                <input type="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    id="password" name="password" placeholder="Enter new password"
                                                    value="">
                                                <span class="input-group-text toggle-password" data-target="password">
                                                    <i class="bx bx-low-vision"></i>
                                                </span>
                                            </div>
                                            @error('password')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Password Strength Indicator -->
                                        <div class="col-md-6 mb-3 mt-3">
                                            <label class="form-label">Password Strength</label>
                                            <div class="progress mb-1" style="height: 6px;">
                                                <div class="progress-bar" id="password-strength-bar" role="progressbar"
                                                    style="width: 0%"></div>
                                            </div>
                                            <small class="text-muted" id="password-strength-text">Enter a password</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Profile Picture Upload -->
                            <div class="card mt-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">
                                        <i class="bx bx-image me-2"></i>Profile Picture
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-md-3 text-center mb-3 mb-md-0">
                                            <div class="position-relative d-inline-block">
                                                @if ($user->profile)
                                                    <img src="{{ asset('assets/img/profile/' . $user->profile) }}"
                                                        class="rounded-circle border" alt="Profile" width="120"
                                                        height="120" id="profile-preview">
                                                @else
                                                    <div class="rounded-circle border bg-label-primary d-flex align-items-center justify-content-center"
                                                        style="width: 120px; height: 120px;" id="profile-preview">
                                                        <span
                                                            class="fw-bold fs-1">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                                    </div>
                                                @endif
                                                <div class="position-absolute bottom-0 end-0">
                                                    <label for="profile_upload"
                                                        class="btn btn-primary btn-sm rounded-circle">
                                                        <i class="bx bx-camera"></i>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="mb-3 mt-3">
                                                <input class="form-control @error('profile_upload') is-invalid @enderror"
                                                    type="file" id="profile_upload" name="profile_upload"
                                                    accept="image/jpeg,image/png,image/jpg" style="display: none;">
                                                <label for="profile_upload" class="btn btn-outline-primary">
                                                    <i class="bx bx-upload me-2"></i>Upload New Photo
                                                </label>
                                                <button type="button" class="btn btn-outline-danger" id="remove-photo">
                                                    <i class="bx bx-trash me-2"></i>Remove Photo
                                                </button>
                                            </div>
                                            <div class="alert alert-info">
                                                <small>
                                                    <strong>Requirements:</strong><br>
                                                    • Recommended Size: 200 x 200 px<br>
                                                    • Allowed Types: JPG, JPEG, PNG<br>
                                                    • Max File Size: 2MB
                                                </small>
                                            </div>
                                            @error('profile_upload')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="row mt-4 ">
                                <div class="col-12">
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-primary" id="submitBtn">
                                            Update Profile
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right Column - Stats & Information -->
            <div class="col-lg-4">
                <!-- Account Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Account Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar avatar-sm me-3">
                                <span class="avatar-initial rounded-circle bg-label-primary">
                                    <i class="bx bx-id-card"></i>
                                </span>
                            </div>
                            <div>
                                <small class="text-muted">Member Since</small>
                                <p class="mb-0 fw-semibold">{{ $user->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar avatar-sm me-3">
                                <span class="avatar-initial rounded-circle bg-label-success">
                                    <i class="bx bx-calendar-check"></i>
                                </span>
                            </div>
                            <div>
                                <small class="text-muted">Last Updated</small>
                                <p class="mb-0 fw-semibold">{{ $user->updated_at->format('M d, Y') }}</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-sm me-3">
                                <span class="avatar-initial rounded-circle bg-label-warning">
                                    <i class="bx bx-shield-quarter"></i>
                                </span>
                            </div>
                            <div>
                                <small class="text-muted">Account Status</small>
                                <p class="mb-0 fw-semibold">
                                    <span class="badge bg-label-{{ $user->status ? 'success' : 'danger' }}">
                                        {{ $user->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Security Tips -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Security Tips</h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-warning mb-3">
                            <h6 class="alert-heading">
                                <i class="bx bx-shield-quarter me-2"></i>Keep your account secure
                            </h6>
                            <small>• Use a strong, unique password<br>
                                • Update your password regularly<br>
                                • Never share your credentials</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Timezone detection
            const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
            $('#timezone-display').text(timezone);

            // Password visibility toggle
            $('.toggle-password').on('click', function() {
                const target = $(this).data('target');
                const input = $('#' + target);
                const icon = $(this).find('i');

                if (input.attr('type') === 'password') {
                    input.attr('type', 'text');
                    icon.removeClass('bx-low-vision').addClass('bx-show');
                } else {
                    input.attr('type', 'password');
                    icon.removeClass('bx-show').addClass('bx-low-vision');
                }
            });

            // Profile picture preview
            $('#profile_upload').on('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const previewContainer = $('#profile-preview');
                        // Check if it's an img tag or div, then replace appropriately
                        if (previewContainer.is('img')) {
                            previewContainer.attr('src', e.target.result);
                        } else {
                            previewContainer.replaceWith(
                                `<img src="${e.target.result}" class="rounded-circle border" alt="Profile" width="120" height="120" id="profile-preview">`
                            );
                        }
                    }
                    reader.readAsDataURL(file);
                }
            });

            // Remove profile picture
            $('#remove-photo').on('click', function() {
                $('#profile_upload').val('');
                const previewContainer = $('#profile-preview');
                const firstLetter = $('#name').val().charAt(0).toUpperCase();

                // Replace with initial div
                previewContainer.replaceWith(
                    `<div class="rounded-circle border bg-label-primary d-flex align-items-center justify-content-center" style="width: 120px; height: 120px;" id="profile-preview">
                    <span class="fw-bold fs-1">${firstLetter}</span>
                </div>`
                );
            });

            // Password strength indicator
            $('#password').on('input', function() {
                const password = $(this).val();
                const strengthBar = $('#password-strength-bar');
                const strengthText = $('#password-strength-text');

                let strength = 0;
                let text = 'Very Weak';
                let color = '#dc3545';

                if (password.length >= 8) strength += 25;
                if (/[A-Z]/.test(password)) strength += 25;
                if (/[0-9]/.test(password)) strength += 25;
                if (/[^A-Za-z0-9]/.test(password)) strength += 25;

                if (strength >= 75) {
                    text = 'Strong';
                    color = '#198754';
                } else if (strength >= 50) {
                    text = 'Good';
                    color = '#ffc107';
                } else if (strength >= 25) {
                    text = 'Weak';
                    color = '#fd7e14';
                }

                strengthBar.css({
                    'width': strength + '%',
                    'background-color': color
                });
                strengthText.text(text).css('color', color);
            });

            // Disable space in password field
            $(document).on('keydown', '#password, #current_password, #password_confirmation', function(e) {
                if (e.keyCode == 32) {
                    return false;
                }
            });

            // Form submission loading state
            $('#profileForm').on('submit', function() {
                $('#submitBtn').prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm me-2"></span>Saving...');
            });

            // Auto-save draft (optional feature)
            let draftTimeout;
            $('input, textarea').on('input', function() {
                clearTimeout(draftTimeout);
                draftTimeout = setTimeout(() => {
                    // Implement draft saving logic here
                    console.log('Draft saved');
                }, 2000);
            });
        });
    </script>
@endsection
