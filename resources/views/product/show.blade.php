@extends('layouts.master')
@section('title', 'View Product - ' . env('APP_NAME'))
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('components.alert')
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Product Details</h5>
                        <div>
                            <button type="button" class="btn btn-primary"
                                onclick="location.href='{{ route('products.form', $product->product_id) }}'">
                                Edit
                            </button>
                            <button type="button" class="btn btn-secondary"
                                onclick="location.href='{{ route('products.index') }}'">
                                Back to Products
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Product Image and Basic Info -->
                        <div class="row mb-4">
                            <div class="col-md-3 mb-3">
                                @if ($product->image_url)
                                    <div class="text-center mb-2">
                                        <img src="{{ $product->image_url }}" alt="{{ $product->product_name }}"
                                            class="img-fluid rounded" style="max-height: 250px;">
                                    </div>
                                @else
                                    <div class="text-center text-muted mb-2">
                                        <p>No image available</p>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-9">
                                <div class="row mb-3">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-muted">SKU</label>
                                        <h6 class="mb-0"><span class="badge bg-label-primary">{{ $product->sku }}</span>
                                        </h6>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-muted">Barcode</label>
                                        <h6 class="mb-0">{{ $product->barcode ?? 'N/A' }}</h6>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-6 mb-3">
                                        <label class="form-label text-muted">Product Name</label>
                                        <h5 class="mb-0">{{ $product->product_name }}</h5>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label class="form-label text-muted">Company Name</label>
                                        <h6 class="mb-0">{{ $product->company->company_name }}</h6>
                                    </div>
                                </div>

                                @if ($product->description)
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label class="form-label text-muted">Description</label>
                                            <p class="mb-0">{{ $product->description }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <hr>

                        <!-- Classification Section -->
                        <h6 class="mb-3 text-primary">Classification</h6>
                        <div class="row mb-4">
                            <div class="col-md-3 mb-3">
                                <label class="form-label text-muted">Category</label>
                                <h6 class="mb-0">{{ $product->category->name ?? 'N/A' }}</h6>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label text-muted">Material</label>
                                <h6 class="mb-0">{{ $product->material->name ?? 'N/A' }}</h6>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label text-muted">Gemstone</label>
                                <h6 class="mb-0">{{ $product->gemstone->name ?? 'N/A' }}</h6>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label text-muted">Supplier</label>
                                <h6 class="mb-0">{{ $product->supplier->supplier_name ?? 'N/A' }}</h6>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-3 mb-3">
                                <label class="form-label text-muted">Collection</label>
                                <h6 class="mb-0">{{ $product->collection ?? 'N/A' }}</h6>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label text-muted">Designer</label>
                                <h6 class="mb-0">{{ $product->designer ?? 'N/A' }}</h6>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label text-muted">Country of Origin</label>
                                <h6 class="mb-0">{{ $product->country_of_origin ?? 'N/A' }}</h6>
                            </div>
                        </div>

                        <hr>

                        <!-- Physical Attributes Section -->
                        <h6 class="mb-3 text-primary">Physical Attributes</h6>
                        <div class="row mb-4">
                            <div class="col-md-3 mb-3">
                                <label class="form-label text-muted">Weight (grams)</label>
                                <h6 class="mb-0">{{ $product->weight_grams ?? 'N/A' }} g</h6>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label text-muted">Metal Weight</label>
                                <h6 class="mb-0">{{ $product->metal_weight ?? 'N/A' }} g</h6>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label text-muted">Gemstone Weight</label>
                                <h6 class="mb-0">{{ $product->gemstone_weight ?? 'N/A' }} g</h6>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label text-muted">Gemstone Count</label>
                                <h6 class="mb-0">{{ $product->gemstone_count }}</h6>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-3 mb-3">
                                <label class="form-label text-muted">Carat Purity</label>
                                <h6 class="mb-0">{{ $product->carat_purity ?? 'N/A' }}</h6>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label text-muted">Size</label>
                                <h6 class="mb-0">{{ $product->size ?? 'N/A' }}</h6>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label text-muted">Color</label>
                                <h6 class="mb-0">{{ $product->color ?? 'N/A' }}</h6>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label text-muted">Gender</label>
                                <h6 class="mb-0"><span class="badge bg-label-info">{{ ucfirst($product->gender) }}</span>
                                </h6>
                            </div>
                        </div>

                        <hr>

                        <!-- Pricing Section -->
                        <h6 class="mb-3 text-primary">Pricing</h6>
                        <div class="row mb-4">
                            <div class="col-md-3 mb-3">
                                <label class="form-label text-muted">Cost Price</label>
                                <h6 class="mb-0">৳ {{ number_format($product->cost_price, 2) }}</h6>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label text-muted">Selling Price</label>
                                <h6 class="mb-0">৳ {{ number_format($product->selling_price, 2) }}</h6>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label text-muted">Wholesale Price</label>
                                <h6 class="mb-0">
                                    {{ $product->wholesale_price ? '৳ ' . number_format($product->wholesale_price, 2) : 'N/A' }}
                                </h6>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label text-muted">Discount Price</label>
                                <h6 class="mb-0">
                                    {{ $product->discount_price ? '৳ ' . number_format($product->discount_price, 2) : 'N/A' }}
                                </h6>
                            </div>
                        </div>

                        @if ($product->markup_percentage)
                            <div class="row mb-4">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label text-muted">Markup Percentage</label>
                                    <h6 class="mb-0">{{ $product->markup_percentage }}%</h6>
                                </div>
                            </div>
                        @endif

                        <hr>

                        <!-- Inventory Section -->
                        <h6 class="mb-3 text-primary">Inventory</h6>
                        <div class="row mb-4">
                            <div class="col-md-3 mb-3">
                                <label class="form-label text-muted">Quantity in Stock</label>
                                <h6 class="mb-0">
                                    <span
                                        class="badge {{ $product->quantity_in_stock <= $product->minimum_stock_level ? 'bg-label-danger' : 'bg-label-success' }}">
                                        {{ $product->quantity_in_stock }}
                                    </span>
                                </h6>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label text-muted">Minimum Stock Level</label>
                                <h6 class="mb-0">{{ $product->minimum_stock_level }}</h6>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label text-muted">Reorder Quantity</label>
                                <h6 class="mb-0">{{ $product->reorder_quantity ?? 'N/A' }}</h6>
                            </div>
                        </div>

                        <hr>

                        <!-- Product Composition Section -->
                        @if ($product->component_based || $product->is_set)
                            <h6 class="mb-3 text-primary">Product Composition</h6>
                            <div class="row mb-4">
                                @if ($product->component_based)
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-muted">Component Based</label>
                                        <h6 class="mb-0"><span class="badge bg-label-success">Yes</span></h6>
                                    </div>
                                @endif
                                @if ($product->is_set)
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-muted">Set Count</label>
                                        <h6 class="mb-0">{{ $product->set_count }}</h6>
                                    </div>
                                @endif
                            </div>
                            <hr>
                        @endif

                        @if (!empty($productComponents) && count($productComponents))
                            <h6 class="mb-3 text-primary">Components</h6>
                            <div class="table-responsive mb-4">
                                <table class="table table-sm table-bordered align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 40px;">#</th>
                                            <th>Component</th>
                                            <th>Type</th>
                                            <th>Material</th>
                                            <th>Gemstone</th>
                                            <th>Weights</th>
                                            <th>Costs</th>
                                            <th>Position</th>
                                            <th>Main</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($productComponents as $index => $component)
                                            @php
                                                $typeName =
                                                    optional($componentTypes->get($component->component_type_id))
                                                        ->type_name ?? 'N/A';
                                                $materialName =
                                                    optional($materials->get($component->material_id))->material_name ??
                                                    'N/A';
                                                $gemstoneName =
                                                    optional($gemstones->get($component->gemstone_id))->gemstone_name ??
                                                    'N/A';

                                                $materialInfo = [];
                                                if (!is_null($component->material_weight)) {
                                                    $materialInfo[] =
                                                        number_format($component->material_weight, 3) . ' g';
                                                }
                                                if (!empty($component->material_purity)) {
                                                    $materialInfo[] = $component->material_purity;
                                                }

                                                $gemstoneInfo = [];
                                                if (!is_null($component->gemstone_quantity)) {
                                                    $gemstoneInfo[] = 'Qty: ' . $component->gemstone_quantity;
                                                }
                                                if (!is_null($component->gemstone_weight)) {
                                                    $gemstoneInfo[] =
                                                        number_format($component->gemstone_weight, 3) . ' g';
                                                }
                                                if (!is_null($component->gemstone_carat_weight)) {
                                                    $gemstoneInfo[] =
                                                        number_format($component->gemstone_carat_weight, 3) . ' ct';
                                                }

                                                $costLines = [];
                                                if (!is_null($component->component_cost)) {
                                                    $costLines[] =
                                                        'Comp: à§³ ' . number_format($component->component_cost, 2);
                                                }
                                                if (!is_null($component->labor_cost)) {
                                                    $costLines[] =
                                                        'Labor: à§³ ' . number_format($component->labor_cost, 2);
                                                }
                                                if (!is_null($component->setting_cost)) {
                                                    $costLines[] =
                                                        'Setting: à§³ ' . number_format($component->setting_cost, 2);
                                                }
                                                if (!is_null($component->total_component_cost)) {
                                                    $costLines[] =
                                                        'Total: à§³ ' .
                                                        number_format($component->total_component_cost, 2);
                                                }
                                            @endphp
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    <div class="fw-semibold">{{ $component->component_name }}</div>
                                                    @if (!empty($component->notes))
                                                        <div class="text-muted small">{{ $component->notes }}</div>
                                                    @endif
                                                </td>
                                                <td>{{ $typeName }}</td>
                                                <td>{{ $materialName }}</td>
                                                <td>{{ $gemstoneName }}</td>
                                                <td>
                                                    <div>
                                                        <div class="text-muted small">Material</div>
                                                        <div>
                                                            {{ count($materialInfo) ? implode(' / ', $materialInfo) : 'N/A' }}
                                                        </div>
                                                    </div>
                                                    <div class="mt-1">
                                                        <div class="text-muted small">Gemstone</div>
                                                        <div>
                                                            {{ count($gemstoneInfo) ? implode(' / ', $gemstoneInfo) : 'N/A' }}
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if (count($costLines))
                                                        @foreach ($costLines as $line)
                                                            <div>{{ $line }}</div>
                                                        @endforeach
                                                    @else
                                                        <div class="text-muted">N/A</div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div>#{{ $component->position_order }}</div>
                                                    <div class="text-muted small">
                                                        {{ $component->position_description ?? 'N/A' }}</div>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge {{ $component->is_main_component ? 'bg-label-success' : 'bg-label-secondary' }}">
                                                        {{ $component->is_main_component ? 'Yes' : 'No' }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <hr>
                        @elseif ($product->component_based)
                            <h6 class="mb-3 text-primary">Components</h6>
                            <p class="text-muted mb-4">No components added for this product.</p>
                            <hr>
                        @endif

                        @if (!empty($productLabors) && count($productLabors))
                            <h6 class="mb-3 text-primary">Labor</h6>
                            <div class="table-responsive mb-4">
                                <table class="table table-sm table-bordered align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 40px;">#</th>
                                            <th>Labor Type</th>
                                            <th>Quantity</th>
                                            <th>Actual Hours</th>
                                            <th>Labor Cost</th>
                                            <th>Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($productLabors as $index => $labor)
                                            @php
                                                $laborName =
                                                    optional($laborTypes->get($labor->labor_id))->labor_name ?? 'N/A';
                                            @endphp
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $laborName }}</td>
                                                <td>{{ $labor->quantity ?? 1 }}</td>
                                                <td>
                                                    {{ $labor->actual_hours !== null ? number_format($labor->actual_hours, 2) : 'N/A' }}
                                                </td>
                                                <td>
                                                    {{ $labor->labor_cost !== null ? 'à§³ ' . number_format($labor->labor_cost, 2) : 'N/A' }}
                                                </td>
                                                <td>{{ $labor->notes ?? 'N/A' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <hr>
                        @endif

                        @if (!empty($productMeasurements) && count($productMeasurements))
                            <h6 class="mb-3 text-primary">Measurements</h6>
                            <div class="table-responsive mb-4">
                                <table class="table table-sm table-bordered align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 40px;">#</th>
                                            <th>Type</th>
                                            <th>Unit</th>
                                            <th>Value</th>
                                            <th>Position</th>
                                            <th>Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($productMeasurements as $index => $measurement)
                                            @php
                                                $typeName =
                                                    $measurement->measurement_type ??
                                                    optional($measurementTypes->get($measurement->measurement_id))->name ??
                                                    'N/A';
                                                $unitValue =
                                                    $measurement->unit ??
                                                    optional($measurementTypes->get($measurement->measurement_id))->UOM ??
                                                    'N/A';
                                                $valueParts = [];
                                                if (!is_null($measurement->value_decimal)) {
                                                    $valueParts[] = number_format($measurement->value_decimal, 2);
                                                }
                                                if (!empty($measurement->value_string)) {
                                                    $valueParts[] = $measurement->value_string;
                                                }
                                            @endphp
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $typeName }}</td>
                                                <td>{{ $unitValue }}</td>
                                                <td>{{ count($valueParts) ? implode(' / ', $valueParts) : 'N/A' }}</td>
                                                <td>{{ $measurement->position ?? 'N/A' }}</td>
                                                <td>{{ $measurement->notes ?? 'N/A' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <hr>
                        @endif

                        <!-- Certification Section -->
                        @if ($product->requires_certificate || $product->certificate_number)
                            <h6 class="mb-3 text-primary">Certification & Hallmarking</h6>
                            <div class="row mb-4">
                                @if ($product->certificate_number)
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label text-muted">Certificate Number</label>
                                        <h6 class="mb-0">{{ $product->certificate_number }}</h6>
                                    </div>
                                @endif
                                @if ($product->certificate_issuer)
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label text-muted">Certificate Issuer</label>
                                        <h6 class="mb-0">{{ $product->certificate_issuer }}</h6>
                                    </div>
                                @endif
                                @if ($product->certificate_date)
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label text-muted">Certificate Date</label>
                                        <h6 class="mb-0">{{ date('d-m-Y', strtotime($product->certificate_date)) }}</h6>
                                    </div>
                                @endif
                                @if ($product->hallmark)
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label text-muted">Hallmark</label>
                                        <h6 class="mb-0">{{ $product->hallmark }}</h6>
                                    </div>
                                @endif
                            </div>
                            <hr>
                        @endif

                        <!-- Status Section -->
                        <h6 class="mb-3 text-primary">Status</h6>
                        <div class="row mb-4">
                            <div class="col-md-3 mb-3">
                                <label class="form-label text-muted">Active Status</label>
                                <h6 class="mb-0">
                                    <span
                                        class="badge {{ $product->status === 'Active' ? 'bg-label-success' : 'bg-label-danger' }}">
                                        {{ $product->status }}
                                    </span>
                                </h6>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label text-muted">Featured</label>
                                <h6 class="mb-0">
                                    <span
                                        class="badge {{ $product->is_featured ? 'bg-label-success' : 'bg-label-secondary' }}">
                                        {{ $product->is_featured ? 'Yes' : 'No' }}
                                    </span>
                                </h6>
                            </div>
                        </div>

                        <hr>

                        <!-- Timestamps -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Created At</label>
                                <h6 class="mb-0">{{ $product->created_at->format('d-m-Y H:i') }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Last Updated</label>
                                <h6 class="mb-0">{{ $product->updated_at->format('d-m-Y H:i') }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
