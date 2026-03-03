@extends('layouts.master')
@section('title', 'Dashboard - ' . env('APP_NAME'))
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
            <div>
                <h4 class="mb-1">Dashboard</h4>
                <p class="text-muted mb-0">Master data overview and operational snapshot</p>
            </div>
            <div class="badge bg-label-primary">Updated {{ now()->format('M d, Y') }}</div>
        </div>

        <div class="row g-4 mb-4">
            @foreach ($masterCards as $card)
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
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row g-4 mb-4">
            @foreach ($kpis as $kpi)
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <span class="text-muted">{{ $kpi['label'] }}</span>
                                <span class="badge bg-label-secondary p-2">
                                    <i class="bx {{ $kpi['icon'] }}"></i>
                                </span>
                            </div>
                            <div class="d-flex align-items-end justify-content-between">
                                <div>
                                    <h4 class="mb-1">{{ $kpi['value'] }}</h4>
                                    <small class="text-muted">{{ $kpi['sub'] }}</small>
                                </div>
                                <span class="fw-medium {{ $kpi['trend_class'] }}">
                                    <i class="bx bx-trending-up"></i> {{ $kpi['trend'] }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row g-4">
            <div class="col-12 col-lg-7">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Recent Activity</h5>
                        <span class="text-muted small">Last 48 hours</span>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            @foreach ($activity as $item)
                                <div class="list-group-item px-0">
                                    <div class="d-flex align-items-start justify-content-between">
                                        <div>
                                            <h6 class="mb-1">{{ $item['title'] }}</h6>
                                            <small class="text-muted">{{ $item['meta'] }}</small>
                                        </div>
                                        <small class="text-muted">{{ $item['time'] }}</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-5">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Top Branches</h5>
                        <span class="text-muted small">By revenue</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-borderless mb-0">
                                <thead>
                                    <tr class="text-muted">
                                        <th>Branch</th>
                                        <th class="text-end">Orders</th>
                                        <th class="text-end">Revenue</th>
                                        <th class="text-end">Growth</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($topBranches as $branch)
                                        <tr>
                                            <td class="fw-medium">{{ $branch['name'] }}</td>
                                            <td class="text-end">{{ $branch['orders'] }}</td>
                                            <td class="text-end">{{ $branch['revenue'] }}</td>
                                            <td class="text-end {{ $branch['growth_class'] }}">{{ $branch['growth'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3 text-muted small">Demo data for layout preview.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
        @include('components.alert')
    @endif
@endsection
