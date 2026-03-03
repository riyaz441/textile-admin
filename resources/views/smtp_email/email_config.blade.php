@extends('layouts.master')
@section('title', 'Email configuration - ' . env('APP_NAME'))
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y mx-auto" >
    @include('components.alert')
        <!-- Basic Layout & Basic with Icons -->
        <div class="row">
            <!-- Basic Layout -->
            <div class="col-xxl">
                <div class="card mb-6">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Email Configuration</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('email_configuration') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-6">
                                <label class="col-sm-3 col-form-label" for="basic-default-name">Protocol  <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="protocol" name="protocol" value="{{$Config->protocol}}"/>
                                    <div class="text-primary mt-3">e.g. smtp</div>
                                    <span class="text-danger">
                                        {{ $errors->first('protocol') }}
                                    </span>
                                </div>
                            </div>

                            <div class="row mb-6">
                                <label class="col-sm-3 col-form-label" for="basic-default-phone">Mailtype  <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                <select class="form-select" name="mailtype_id" id="mailtype_id">
                                    <option value="">Select</option>
                                    <option value="1" {{ isset($Config) && $Config->mailtype == 1 ? 'selected' : '' }}>Html</option>
                                    <option value="2" {{ isset($Config) && $Config->mailtype == 2 ? 'selected' : '' }}>Text</option>
                                </select>
                                    <span class="text-danger">
                                        {{ $errors->first('mailtype_id') }}
                                    </span>
                                </div>
                            </div>

                            <div class="row mb-6">
                                <label class="col-sm-3 col-form-label" for="basic-default-phone">SMTP Host  <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                <input type="text" class="form-control" id="smtp_host" name="smtp_host" value="{{$Config->smtp_host}}"/>
                                    <div class="text-primary mt-3">e.g. mail.yourdomain.com</div>
                                    <span class="text-danger">
                                        {{ $errors->first('smtp_host') }}
                                    </span>
                                </div>
                            </div>
                            <div class="row mb-6">
                                <label class="col-sm-3 col-form-label" for="basic-default-company">SMTP Port <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                <input type="text" class="form-control" id="smtp_port" name="smtp_port" value="{{$Config->smtp_port}}"/>
                                <div class="text-primary mt-3">e.g. 25 | 465 | 587 | 2525</div>
                                <span class="text-danger">
                                        {{ $errors->first('smtp_port') }}
                                    </span>
                                </div>
                            </div>

                            <div class="row mb-6">
                                <label class="col-sm-3 col-form-label" for="basic-default-company">Sender Email <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                <input type="text" class="form-control" id="sender_email" name="sender_email" value="{{$Config->sender_email}}"/>
                                <span class="text-danger">
                                        {{ $errors->first('sender_email') }}
                                    </span>
                                </div>
                            </div>

                            <div class="row mb-6">
                                <label class="col-sm-3 col-form-label" for="basic-default-message">Password <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <div class="input-group position-relative">
                                        <input type="password" class="form-control" id="password" name="smtp_pwd" placeholder="Enter password"  value="{{ Crypt::decryptString($Config->password) }}">
                                        <span class="input-group-text" id="toggle-password"><i class="bx bx-low-vision" id="eye-icon"></i></span>
                                    </div>

                                    <span class="text-danger">
                                        {{ $errors->first('password') }}
                                    </span>
                                </div>
                            </div>

                            <div class="row justify-content-end">
                                <div class="col-sm-10 text-end">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).on('keydown', '#password', function(e) {
            if (e.keyCode == 32 || e.key === ' ') {
                return false;
            }
        });

        $(document).ready(function() {
            $('#toggle-password').on('click', function() {
                let passwordInput = $('#password');
                let eyeIcon = $('#eye-icon');

                if (passwordInput.attr('type') === 'password') {
                    passwordInput.attr('type', 'text');
                    eyeIcon.removeClass('bx bx-low-vision').addClass('bx bx-show');
                } else {
                    passwordInput.attr('type', 'password');
                    eyeIcon.removeClass('bx bx-show').addClass('bx bx-low-vision');
                }
            });
        });

    </script>
@endsection
