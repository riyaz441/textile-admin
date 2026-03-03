@extends('layouts.master')
@section('title', 'Inventory Stocks - ' . env('APP_NAME'))

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('components.alert')

        <div class="card">
            <div class="d-flex justify-content-between align-items-center p-3">
                <h5 class="card-header mb-0">Inventory Stocks</h5>
                <div class="ms-auto">
                    <button class="btn btn-primary" onclick="location.href='{{ route('inventory-stocks.form') }}'">
                        + Add Inventory Stocks
                    </button>
                </div>
            </div>

            <div class="table-responsive text-nowrap p-3">
                <table id="inventory-stocks-table" class="table">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Location</th>
                            <th>On Hand</th>
                            <th>Allocated</th>
                            <th>Available</th>
                            <th>Avg Cost</th>
                            <th>Total Value</th>
                            <th>Reorder Point</th>
                            <th>Last Movement</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($inventoryStocks as $stock)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <span class="badge bg-label-primary">
                                        {{ $stock->product->product_name ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>{{ $stock->location->location_name ?? 'N/A' }}</td>
                                <td>{{ $stock->quantity_on_hand }}</td>
                                <td>{{ $stock->quantity_allocated }}</td>
                                <td>{{ $stock->quantity_available }}</td>
                                <td>{{ number_format((float) $stock->average_cost, 2) }}</td>
                                <td>{{ number_format((float) $stock->total_value, 2) }}</td>
                                <td>{{ $stock->reorder_point }}</td>
                                <td>{{ optional($stock->last_movement_date)->format('Y-m-d') ?? 'N/A' }}</td>
                                <td>
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input change_inventory_stock_status" type="checkbox"
                                            id="inventoryStockStatus{{ $stock->stock_id }}"
                                            data-id="{{ $stock->stock_id }}"
                                            {{ $stock->status === 'Active' ? 'checked' : '' }}>
                                    </div>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button"
                                            class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>

                                        <div class="dropdown-menu company-action-menu">

                                            <a class="dropdown-item"
                                                href="{{ route('inventory-stocks.form', $stock->stock_id) }}">
                                                <i class="bx bx-edit-alt me-1"></i> Edit
                                            </a>

                                            <a class="dropdown-item"
                                                href="{{ route('inventory-stocks.show', $stock->stock_id) }}">
                                                <i class="bx bx-show me-1"></i> View
                                            </a>

                                            <a class="dropdown-item delete-item"
                                                href="#"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteModal"
                                                data-id="{{ $stock->stock_id }}"
                                                data-name="inventory-stocks/delete">
                                                <i class="bx bx-trash me-1"></i> Delete
                                            </a>

                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
