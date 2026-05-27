@extends('layouts.master')
@section('title', 'Dashboard - ' . env('APP_NAME'))
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
            <div>
                <h4 class="mb-1">Dashboard</h4>
                <p class="text-muted mb-0">Active modules overview</p>
            </div>
            <div class="badge bg-label-primary">Updated {{ now()->format('M d, Y') }}</div>
        </div>

        <div class="row g-4 mb-4">
            @foreach ($moduleCards as $card)
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between mb-3">
                                <span class="badge bg-label-{{ $card['color'] }} p-2">
                                    <i class="bx {{ $card['icon'] }}"></i>
                                </span>
                                <span class="text-muted small">{{ $card['note'] }}</span>
                            </div>
                            <h4 class="mb-1">{{ $card['value'] }}</h4>
                            <p class="mb-0 text-muted">{{ $card['label'] }}</p>
                            <a href="{{ $card['url'] }}" class="stretched-link" aria-label="{{ $card['label'] }}"></a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row g-4">
            <div class="col-12 col-lg-7">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Module Status</h5>
                        <span class="text-muted small">Current data check</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-borderless mb-0">
                                <thead>
                                    <tr class="text-muted">
                                        <th>Module</th>
                                        <th>Status</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($moduleStatus as $item)
                                        <tr>
                                            <td class="fw-medium">{{ $item['module'] }}</td>
                                            <td>{{ $item['status'] }}</td>
                                            <td class="text-muted">{{ $item['details'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-5">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Quick Access</h5>
                        <span class="text-muted small">Active modules</span>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <a href="{{ url('dashboard') }}" class="list-group-item list-group-item-action px-0">Dashboard</a>
                            <a href="{{ route('doctors.index') }}" class="list-group-item list-group-item-action px-0">Doctor</a>
                            <a href="{{ url('about_setting') }}" class="list-group-item list-group-item-action px-0">About</a>
                            <a href="{{ route('galleries.index') }}" class="list-group-item list-group-item-action px-0">Gallery</a>
                            <a href="{{ url('web_setting') }}" class="list-group-item list-group-item-action px-0">Header & Footer Setting</a>
                            <a href="{{ route('profile') }}" class="list-group-item list-group-item-action px-0">Profile</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
        @include('components.alert')
    @endif
@endsection
