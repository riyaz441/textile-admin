@extends('layouts.master')
@section('title', 'About Setting - ' . env('APP_NAME'))
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y mx-auto">
        @include('components.alert')
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-6">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">About Setting</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('about_setting') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row mb-6">
                                <label class="col-sm-3 col-form-label" for="image">About Image <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="file" class="form-control" id="image" name="image" accept="image/*" required />
                                    <span class="text-danger">
                                        {{ $errors->first('image') }}
                                    </span>

                                    @if (!empty($about?->image))
                                        <div class="mt-3">
                                            <img src="{{ asset('assets/img/' . $about->image) }}" alt="about" class="img-fluid rounded" style="max-height: 220px;">
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
