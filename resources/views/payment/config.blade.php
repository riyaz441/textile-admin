@extends('layouts.master')
@section('title', 'Payment Gateway Setting - ' . env('APP_NAME'))
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y mx-auto" >
        @include('components.alert')
        <!-- Basic Layout & Basic with Icons -->
        <div class="row">
            <!-- Basic Layout -->
            <div class="col-xxl">
                <div class="card mb-6">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Payment Gateway Setting</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('payment_gateway_setting') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-6">
                                <label class="col-sm-3 col-form-label" for="basic-default-name">Agent <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="agent" name="agent"
                                        value="{{ $payment->agent }}" />

                                    <span class="text-danger">
                                        {{ $errors->first('agent') }}
                                    </span>
                                </div>
                            </div>

                            <div class="row mb-6">
                                <label class="col-sm-3 col-form-label" for="basic-default-phone">Merchant ID <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="merchant_id" name="merchant_id"
                                        value="{{ $payment->merchant_id }}" />

                                    <span class="text-danger">
                                        {{ $errors->first('merchant_id') }}
                                    </span>
                                </div>
                            </div>

                            <div class="row mb-6">
                                <label class="col-sm-3 col-form-label" for="basic-default-company">API key <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="api_key" name="api_key"
                                        value="{{ $payment->api_key }}" />

                                    <span class="text-danger">
                                        {{ $errors->first('api_key') }}
                                    </span>
                                </div>
                            </div>


                            <div class="row mb-6">
                                <label class="col-sm-3 col-form-label" for="basic-default-phone">Status <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <select class="form-select" name="status" id="status">
                                        <option value="">Select</option>
                                        <option value="Test"
                                            {{ isset($payment) && $payment->status == 'Test' ? 'selected' : '' }}>Test
                                        </option>
                                        <option value="Live"
                                            {{ isset($payment) && $payment->status == 'Live' ? 'selected' : '' }}>Live
                                        </option>
                                    </select>
                                    <span class="text-danger">
                                        {{ $errors->first('status') }}
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
@endsection
