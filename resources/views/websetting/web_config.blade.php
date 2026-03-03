@extends('layouts.master')
@section('title', 'Web Setting - ' . env('APP_NAME'))
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y mx-auto">
        @include('components.alert')
        <!-- Basic Layout & Basic with Icons -->
        <div class="row">
            <!-- Basic Layout -->
            <div class="col-xxl">
                <div class="card mb-6">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Web Setting</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('web_setting') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-6">
                                <label class="col-sm-3 col-form-label" for="basic-default-name">Contact Person <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="contact_person" name="contact_person"
                                        value="{{ $setting->contact_person ?? '' }}" />

                                    <span class="text-danger">
                                        {{ $errors->first('contact_person') }}
                                    </span>
                                </div>
                            </div>

                            <div class="row mb-6">
                                <label class="col-sm-3 col-form-label" for="basic-default-phone">Contact Email <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" id="contact_email" name="contact_email"
                                        value="{{ $setting->contact_email ?? '' }}" />

                                    <span class="text-danger">
                                        {{ $errors->first('contact_email') }}
                                    </span>
                                </div>
                            </div>

                            <div class="row mb-6">
                                <label class="col-sm-3 col-form-label" for="basic-default-company">Contact Number <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="contact_phone" name="contact_phone"
                                        value="{{ $setting->contact_phone ?? '' }}" />
                                    <span class="text-danger">
                                        {{ $errors->first('contact_phone') }}
                                    </span>
                                </div>
                            </div>

                            <div class="row mb-6">
                                <label class="col-sm-3 col-form-label" for="basic-default-phone">Sales Email</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="sales_email" name="sales_email"
                                        value="{{ $setting->sales_email ?? '' }}" />
                                    <span class="text-danger">
                                        {{ $errors->first('sales_email') }}
                                    </span>
                                </div>
                            </div>

                            <div class="row mb-6">
                                <label class="col-sm-3 col-form-label" for="basic-default-phone">Address <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" id="address" name="address" rows="3">{{ $setting->address ?? '' }}</textarea>
                                    <span class="text-danger">
                                        {{ $errors->first('address') }}
                                    </span>
                                </div>
                            </div>

                            <div class="row mb-6">
                                <label class="col-sm-3 col-form-label" for="logo">Logo</label>
                                <div class="col-sm-9">
                                    <input type="file" class="form-control" id="logo" name="logo" accept="image/*" />
                                    <span class="text-danger">
                                        {{ $errors->first('logo') }}
                                    </span>
                                    @if (!empty($setting?->logo))
                                        <div class="mt-2">
                                            <img src="{{ asset('assets/img/' . $setting->logo) }}" alt="logo" height="48">
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="row mb-6">
                                <label class="col-sm-3 col-form-label" for="fav_icon">Favicon</label>
                                <div class="col-sm-9">
                                    <input type="file" class="form-control" id="fav_icon" name="fav_icon" accept="image/*" />
                                    <span class="text-danger">
                                        {{ $errors->first('fav_icon') }}
                                    </span>
                                    @if (!empty($setting?->fav_icon))
                                        <div class="mt-2">
                                            <img src="{{ asset('assets/img/' . $setting->fav_icon) }}" alt="favicon" height="32">
                                        </div>
                                    @endif
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
@endsection
