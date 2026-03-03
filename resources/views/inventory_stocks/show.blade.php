@extends('layouts.master')
@section('title', 'View Inventory Stock - ' . env('APP_NAME'))

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('components.alert')

        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Inventory Stock Details</h5>
                        <div>
                            <button type="button" class="btn btn-primary"
                                onclick="location.href='{{ route('inventory-stocks.form', $inventoryStock->stock_id) }}'">
                                Edit
                            </button>
                            <button type="button" class="btn btn-secondary"
                                onclick="location.href='{{ route('inventory-stocks.index') }}'">
                                Back to Inventory Stocks
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted">Product</label>
                                <h6 class="mb-0">{{ $inventoryStock->product->product_name ?? 'N/A' }}</h6>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted">Location</label>
                                <h6 class="mb-0">{{ $inventoryStock->location->location_name ?? 'N/A' }}</h6>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted">Status</label>
                                <span class="badge {{ $inventoryStock->status === 'Active' ? 'bg-label-success' : 'bg-label-danger' }}">
                                    {{ $inventoryStock->status ?? 'N/A' }}
                                </span>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted">Quantity On Hand</label>
                                <h6 class="mb-0">{{ $inventoryStock->quantity_on_hand }}</h6>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted">Quantity Allocated</label>
                                <h6 class="mb-0">{{ $inventoryStock->quantity_allocated }}</h6>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted">Quantity Available</label>
                                <h6 class="mb-0">{{ $inventoryStock->quantity_available }}</h6>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted">Reorder Point</label>
                                <h6 class="mb-0">{{ $inventoryStock->reorder_point }}</h6>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted">Reorder Quantity</label>
                                <h6 class="mb-0">{{ $inventoryStock->reorder_quantity ?? 'N/A' }}</h6>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted">Stock Turnover Rate</label>
                                <h6 class="mb-0">{{ $inventoryStock->stock_turnover_rate ?? 'N/A' }}</h6>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted">Average Cost</label>
                                <h6 class="mb-0">{{ number_format((float) $inventoryStock->average_cost, 2) }}</h6>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted">Total Value</label>
                                <h6 class="mb-0">{{ number_format((float) $inventoryStock->total_value, 2) }}</h6>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted">Days In Stock</label>
                                <h6 class="mb-0">{{ $inventoryStock->days_in_stock }}</h6>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted">Safety Stock Level</label>
                                <h6 class="mb-0">{{ $inventoryStock->safety_stock_level }}</h6>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted">Minimum Stock Level</label>
                                <h6 class="mb-0">{{ $inventoryStock->minimum_stock_level }}</h6>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted">Maximum Stock Level</label>
                                <h6 class="mb-0">{{ $inventoryStock->maximum_stock_level ?? 'N/A' }}</h6>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted">Last Reorder Date</label>
                                <h6 class="mb-0">{{ optional($inventoryStock->last_reorder_date)->format('d-m-Y') ?? 'N/A' }}</h6>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted">Next Reorder Date</label>
                                <h6 class="mb-0">{{ optional($inventoryStock->next_reorder_date)->format('d-m-Y') ?? 'N/A' }}</h6>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted">Last Movement Date</label>
                                <h6 class="mb-0">{{ optional($inventoryStock->last_movement_date)->format('d-m-Y') ?? 'N/A' }}</h6>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Created At</label>
                                <h6 class="mb-0">{{ optional($inventoryStock->created_at)->format('d-m-Y H:i:s') ?? 'N/A' }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Updated At</label>
                                <h6 class="mb-0">{{ optional($inventoryStock->updated_at)->format('d-m-Y H:i:s') ?? 'N/A' }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
