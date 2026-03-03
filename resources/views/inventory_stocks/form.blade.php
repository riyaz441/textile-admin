@extends('layouts.master')
@section('title', isset($inventoryStock) ? 'Edit Inventory Stocks - ' . env('APP_NAME') : 'Add Inventory Stock - ' . env('APP_NAME'))

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('components.alert')

        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">{{ isset($inventoryStock) ? 'Edit Inventory Stock' : 'Add New Inventory Stock' }}</h5>
                        <button type="button" class="btn btn-secondary"
                            onclick="location.href='{{ route('inventory-stocks.index') }}'">
                            Back to Inventory Stocks
                        </button>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('inventory-stocks.save', $inventoryStock->stock_id ?? null) }}" method="POST">
                            @csrf

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label" for="product_id">Product <span class="text-danger">*</span></label>
                                    <select class="form-select @error('product_id') is-invalid @enderror" id="product_id"
                                        name="product_id">
                                        <option value="">Select Product</option>
                                        @foreach ($products ?? [] as $product)
                                            <option value="{{ $product->product_id }}"
                                                {{ old('product_id', $inventoryStock->product_id ?? '') == $product->product_id ? 'selected' : '' }}>
                                                {{ $product->product_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('product_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label" for="location_id">Location <span class="text-danger">*</span></label>
                                    <select class="form-select @error('location_id') is-invalid @enderror" id="location_id"
                                        name="location_id">
                                        <option value="">Select Location</option>
                                        @foreach ($locations ?? [] as $location)
                                            <option value="{{ $location->location_id }}"
                                                {{ old('location_id', $inventoryStock->location_id ?? '') == $location->location_id ? 'selected' : '' }}>
                                                {{ $location->location_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('location_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label" for="status">Status <span class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                        <option value="Active"
                                            {{ old('status', $inventoryStock->status ?? 'Active') == 'Active' ? 'selected' : '' }}>
                                            Active
                                        </option>
                                        <option value="Inactive"
                                            {{ old('status', $inventoryStock->status ?? 'Active') == 'Inactive' ? 'selected' : '' }}>
                                            Inactive
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label" for="quantity_on_hand">Quantity On Hand <span class="text-danger">*</span></label>
                                    <input type="number" min="0"
                                        class="form-control @error('quantity_on_hand') is-invalid @enderror"
                                        id="quantity_on_hand" name="quantity_on_hand"
                                        value="{{ old('quantity_on_hand', $inventoryStock->quantity_on_hand ?? '') }}">
                                    @error('quantity_on_hand')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="quantity_allocated">Quantity Allocated <span class="text-danger">*</span></label>
                                    <input type="number" min="0"
                                        class="form-control @error('quantity_allocated') is-invalid @enderror"
                                        id="quantity_allocated" name="quantity_allocated"
                                        value="{{ old('quantity_allocated', $inventoryStock->quantity_allocated ?? '') }}">
                                    @error('quantity_allocated')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="quantity_available">Quantity Available <span class="text-danger">*</span></label>
                                    <input type="number" min="0"
                                        class="form-control @error('quantity_available') is-invalid @enderror"
                                        id="quantity_available" name="quantity_available"
                                        value="{{ old('quantity_available', $inventoryStock->quantity_available ?? '') }}">
                                    @error('quantity_available')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label" for="reorder_point">Reorder Point <span class="text-danger">*</span></label>
                                    <input type="number" min="0" class="form-control @error('reorder_point') is-invalid @enderror"
                                        id="reorder_point" name="reorder_point"
                                        value="{{ old('reorder_point', $inventoryStock->reorder_point ?? '') }}">
                                    @error('reorder_point')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="reorder_quantity">Reorder Quantity</label>
                                    <input type="number" min="0"
                                        class="form-control @error('reorder_quantity') is-invalid @enderror"
                                        id="reorder_quantity" name="reorder_quantity"
                                        value="{{ old('reorder_quantity', $inventoryStock->reorder_quantity ?? '') }}">
                                    @error('reorder_quantity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="stock_turnover_rate">Stock Turnover Rate</label>
                                    <input type="number" step="0.01"
                                        class="form-control @error('stock_turnover_rate') is-invalid @enderror"
                                        id="stock_turnover_rate" name="stock_turnover_rate"
                                        value="{{ old('stock_turnover_rate', $inventoryStock->stock_turnover_rate ?? '') }}">
                                    @error('stock_turnover_rate')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label" for="average_cost">Average Cost <span class="text-danger">*</span></label>
                                    <input type="number" min="0" step="0.01"
                                        class="form-control @error('average_cost') is-invalid @enderror"
                                        id="average_cost" name="average_cost"
                                        value="{{ old('average_cost', $inventoryStock->average_cost ?? '') }}">
                                    @error('average_cost')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="total_value">Total Value <span class="text-danger">*</span></label>
                                    <input type="number" min="0" step="0.01"
                                        class="form-control @error('total_value') is-invalid @enderror"
                                        id="total_value" name="total_value"
                                        value="{{ old('total_value', $inventoryStock->total_value ?? '') }}">
                                    @error('total_value')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="days_in_stock">Days In Stock <span class="text-danger">*</span></label>
                                    <input type="number" min="0" class="form-control @error('days_in_stock') is-invalid @enderror"
                                        id="days_in_stock" name="days_in_stock"
                                        value="{{ old('days_in_stock', $inventoryStock->days_in_stock ?? '') }}">
                                    @error('days_in_stock')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label" for="safety_stock_level">Safety Stock Level <span class="text-danger">*</span></label>
                                    <input type="number" min="0"
                                        class="form-control @error('safety_stock_level') is-invalid @enderror"
                                        id="safety_stock_level" name="safety_stock_level"
                                        value="{{ old('safety_stock_level', $inventoryStock->safety_stock_level ?? '') }}">
                                    @error('safety_stock_level')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="minimum_stock_level">Minimum Stock Level <span class="text-danger">*</span></label>
                                    <input type="number" min="0"
                                        class="form-control @error('minimum_stock_level') is-invalid @enderror"
                                        id="minimum_stock_level" name="minimum_stock_level"
                                        value="{{ old('minimum_stock_level', $inventoryStock->minimum_stock_level ?? '') }}">
                                    @error('minimum_stock_level')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="maximum_stock_level">Maximum Stock Level</label>
                                    <input type="number" min="0"
                                        class="form-control @error('maximum_stock_level') is-invalid @enderror"
                                        id="maximum_stock_level" name="maximum_stock_level"
                                        value="{{ old('maximum_stock_level', $inventoryStock->maximum_stock_level ?? '') }}">
                                    @error('maximum_stock_level')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label" for="last_reorder_date">Last Reorder Date</label>
                                    <input type="date" class="form-control @error('last_reorder_date') is-invalid @enderror"
                                        id="last_reorder_date" name="last_reorder_date"
                                        value="{{ old('last_reorder_date', isset($inventoryStock->last_reorder_date) ? $inventoryStock->last_reorder_date->format('Y-m-d') : '') }}">
                                    @error('last_reorder_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="next_reorder_date">Next Reorder Date</label>
                                    <input type="date" class="form-control @error('next_reorder_date') is-invalid @enderror"
                                        id="next_reorder_date" name="next_reorder_date"
                                        value="{{ old('next_reorder_date', isset($inventoryStock->next_reorder_date) ? $inventoryStock->next_reorder_date->format('Y-m-d') : '') }}">
                                    @error('next_reorder_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="last_movement_date">Last Movement Date</label>
                                    <input type="date" class="form-control @error('last_movement_date') is-invalid @enderror"
                                        id="last_movement_date" name="last_movement_date"
                                        value="{{ old('last_movement_date', isset($inventoryStock->last_movement_date) ? $inventoryStock->last_movement_date->format('Y-m-d') : '') }}">
                                    @error('last_movement_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-primary">
                                        {{ isset($inventoryStock) ? 'Update Inventory Stock' : 'Save Inventory Stock' }}
                                    </button>
                                    <button type="reset" class="btn btn-outline-secondary ms-2">Reset</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
