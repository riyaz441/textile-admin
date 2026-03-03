@extends('layouts.master')
@section('title', 'Admin Setting - ' . env('APP_NAME'))
@section('content')

<div class="container-xxl flex-grow-1 container-p-y mx-auto" >
        @include('components.alert')
        <!-- Basic Layout & Basic with Icons -->
        <div class="row">
            <!-- Basic Layout -->
            <div class="col-xxl">
                <div class="card mb-6">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Update Admin Setting</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('admin_setting') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-6">
                                <label class="col-sm-3 col-form-label" for="basic-default-name">Logo  <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                <input class="form-control" type="file" id="logo" name="logo" />
                                    <span class="text-danger">
                                        {{ $errors->first('logo') }}
                                    </span>
                                </div>
                                <div class="col-sm-3 text-center">
                                     <img src="{{ asset('assets/img/' . $setting->logo) }}" class="rounded"
                                        alt="logo image" width="" height="">
                                </div>
                            </div>

                            <div class="row mb-6">
                                <label class="col-sm-3 col-form-label" for="basic-default-phone">Fav Icon <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                <input class="form-control" type="file" id="fav_icon" name="fav_icon" />
                                    <span class="text-danger">
                                        {{ $errors->first('fav_icon') }}
                                    </span>
                                </div>
                                <div class="col-sm-3 text-center">
                                    <img src="{{ asset('assets/img/' . $setting->fav_icon) }}" class="rounded"
                                        alt="fav icon" width="" height="">
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
