@extends('layouts.master')
@section('title', isset($product) ? 'Edit Product - ' . env('APP_NAME') : 'Add Product - ' . env('APP_NAME'))
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('components.alert')
        <form action="{{ route('products.save', $product->product_id ?? null) }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-xxl">
                    <div class="card mb-4">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="mb-0">{{ isset($product) ? 'Edit Product' : 'Add New Product' }}</h5>
                            <div class="d-flex align-items-center gap-2">
                                <button type="button" class="btn btn-secondary"
                                    onclick="location.href='{{ route('products.index') }}'">
                                    Back to Products
                                </button>
                                <button type="reset" class="btn btn-outline-secondary">Reset</button>
                                <button type="submit" class="btn btn-primary">
                                    {{ isset($product) ? 'Update Product' : 'Create Product' }}
                                </button>
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <div class="nav-align-top nav-tabs-shadow">
                                @php
                                    $componentErrorFields = [
                                        'component_name.*',
                                        'component_type_id.*',
                                        'component_material_id.*',
                                        'material_weight.*',
                                        'material_purity.*',
                                        'component_gemstone_id.*',
                                        'gemstone_quantity.*',
                                        'gemstone_weight.*',
                                        'gemstone_carat_weight.*',
                                        'gemstone_shape.*',
                                        'gemstone_color.*',
                                        'gemstone_clarity.*',
                                        'gemstone_cut_grade.*',
                                        'gemstone_certificate.*',
                                        'dimension_length.*',
                                        'dimension_width.*',
                                        'dimension_height.*',
                                        'diameter.*',
                                        'component_cost.*',
                                        'labor_cost.*',
                                        'setting_cost.*',
                                        'position_order.*',
                                        'position_description.*',
                                        'is_main_component.*',
                                        'product_notes.*',
                                    ];
                                    $hasComponentErrors = $errors->hasAny($componentErrorFields);
                                    $laborErrorFields = [
                                        'labor_type_id.*',
                                        'labor_quantity.*',
                                        'labor_actual_hours.*',
                                        'labor_cost_amount.*',
                                        'labor_notes.*',
                                    ];
                                    $hasLaborErrors = $errors->hasAny($laborErrorFields);
                                    $measurementErrorFields = [
                                        'measurement_id.*',
                                        'unit.*',
                                        'value_decimal.*',
                                        'value_string.*',
                                        'position.*',
                                        'measurement_notes.*',
                                    ];
                                    $hasMeasurementErrors = $errors->hasAny($measurementErrorFields);
                                    $activeTab = $hasLaborErrors
                                        ? 'labor'
                                        : ($hasMeasurementErrors ? 'measurements' : ($hasComponentErrors ? 'components' : 'product'));
                                @endphp
                                <ul class="nav nav-tabs flex-nowrap overflow-auto" role="tablist">
                                    <li class="nav-item">
                                        <button type="button"
                                            class="nav-link {{ $activeTab === 'product' ? 'active' : '' }}" role="tab"
                                            data-bs-toggle="tab"
                                            data-bs-target="#navs-top-home" aria-controls="navs-top-home"
                                            aria-selected="{{ $activeTab === 'product' ? 'true' : 'false' }}">Product</button>
                                    </li>
                                    <li class="nav-item">
                                        <button type="button"
                                            class="nav-link {{ $activeTab === 'components' ? 'active' : '' }}" role="tab"
                                            data-bs-toggle="tab"
                                            data-bs-target="#navs-top-components" aria-controls="navs-top-components"
                                            aria-selected="{{ $activeTab === 'components' ? 'true' : 'false' }}">Components</button>
                                    </li>
                                    <li class="nav-item">
                                        <button type="button"
                                            class="nav-link {{ $activeTab === 'labor' ? 'active' : '' }}" role="tab"
                                            data-bs-toggle="tab"
                                            data-bs-target="#navs-top-labor" aria-controls="navs-top-labor"
                                            aria-selected="{{ $activeTab === 'labor' ? 'true' : 'false' }}">Labor</button>
                                    </li>
                                    <li class="nav-item">
                                        <button type="button"
                                            class="nav-link {{ $activeTab === 'measurements' ? 'active' : '' }}"
                                            role="tab" data-bs-toggle="tab"
                                            data-bs-target="#navs-top-measurements" aria-controls="navs-top-measurements"
                                            aria-selected="{{ $activeTab === 'measurements' ? 'true' : 'false' }}">Measurements</button>
                                    </li>
                                    <li class="nav-item">
                                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                            data-bs-target="#navs-top-cost-breakdown"
                                            aria-controls="navs-top-cost-breakdown" aria-selected="false">Cost
                                            Breakdown</button>
                                    </li>
                                    <li class="nav-item">
                                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                            data-bs-target="#navs-top-treatments" aria-controls="navs-top-treatments"
                                            aria-selected="false">Treatments</button>
                                    </li>
                                    <li class="nav-item">
                                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                            data-bs-target="#navs-top-images" aria-controls="navs-top-images"
                                            aria-selected="false">Images</button>
                                    </li>

                                    <li class="nav-item">
                                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                            data-bs-target="#navs-top-tags" aria-controls="navs-top-tags"
                                            aria-selected="false">Tags</button>
                                    </li>
                                    <li class="nav-item">
                                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                            data-bs-target="#navs-top-hallmarks" aria-controls="navs-top-hallmarks"
                                            aria-selected="false">Hallmarks</button>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade {{ $activeTab === 'product' ? 'show active' : '' }}"
                                        id="navs-top-home" role="tabpanel">

                                        <!-- Identification Section -->
                                        <h6 class="mb-3 text-primary">Identification</h6>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label" for="company_id">Company <span
                                                        class="text-danger">*</span></label>
                                                @php
                                                    $companyLocked = isset($selectedCompanyId) && $selectedCompanyId !== 'all';
                                                    $companyValue = $companyLocked
                                                        ? $selectedCompanyId
                                                        : old('company_id', isset($product) ? $product->company_id : '');
                                                @endphp
                                                <select class="form-select @error('company_id') is-invalid @enderror"
                                                    id="company_id" name="company_id" {{ $companyLocked ? 'disabled' : '' }}>
                                                    <option value="">Select Company</option>
                                                    @foreach ($companies as $company)
                                                        <option value="{{ $company->company_id }}"
                                                            {{ (string) $companyValue === (string) $company->company_id ? 'selected' : '' }}>
                                                            {{ $company->company_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @if ($companyLocked)
                                                    <input type="hidden" name="company_id" value="{{ $companyValue }}">
                                                @endif
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label" for="sku">SKU <span
                                                        class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control @error('sku') is-invalid @enderror" id="sku"
                                                    name="sku" placeholder="Enter SKU (e.g., PRD-001)"
                                                    value="{{ old('sku', isset($product) ? $product->sku : '') }}">
                                                @error('sku')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label" for="barcode">Barcode</label>
                                                <input type="text"
                                                    class="form-control @error('barcode') is-invalid @enderror"
                                                    id="barcode" name="barcode" placeholder="Enter barcode (optional)"
                                                    value="{{ old('barcode', isset($product) ? $product->barcode : '') }}">
                                                @error('barcode')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label" for="product_name">Product Name <span
                                                        class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control @error('product_name') is-invalid @enderror"
                                                    id="product_name" name="product_name"
                                                    placeholder="Enter product name"
                                                    value="{{ old('product_name', isset($product) ? $product->product_name : '') }}">
                                                @error('product_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <label class="form-label" for="description">Description</label>
                                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                                    placeholder="Product description (optional)" rows="3">{{ old('description', isset($product) ? $product->description : '') }}</textarea>
                                                @error('description')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Classification Section -->
                                        <h6 class="mb-3 mt-4 text-primary">Classification</h6>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label" for="category_id">Category</label>
                                                <select class="form-select @error('category_id') is-invalid @enderror"
                                                    id="category_id" name="category_id">
                                                    <option value="" selected>Select Category</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->category_id }}"
                                                            {{ old('category_id', isset($product) ? $product->category_id : '') == $category->category_id ? 'selected' : '' }}>
                                                            {{ $category->category_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('category_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label" for="material_id">Material</label>
                                                <select class="form-select @error('material_id') is-invalid @enderror"
                                                    id="material_id" name="material_id">
                                                    <option value="">Select Material</option>
                                                    @foreach ($materials as $material)
                                                        <option value="{{ $material->material_id }}"
                                                            {{ old('material_id', isset($product) ? $product->material_id : '') == $material->material_id ? 'selected' : '' }}>
                                                            {{ $material->material_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('material_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label" for="gemstone_id">Gemstone</label>
                                                <select class="form-select @error('gemstone_id') is-invalid @enderror"
                                                    id="gemstone_id" name="gemstone_id">
                                                    <option value="">Select Gemstone</option>
                                                    @foreach ($gemstones as $gemstone)
                                                        <option value="{{ $gemstone->gemstone_id }}"
                                                            {{ old('gemstone_id', isset($product) ? $product->gemstone_id : '') == $gemstone->gemstone_id ? 'selected' : '' }}>
                                                            {{ $gemstone->gemstone_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('gemstone_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label" for="supplier_id">Supplier</label>
                                                <select class="form-select @error('supplier_id') is-invalid @enderror"
                                                    id="supplier_id" name="supplier_id">
                                                    <option value="">Select Supplier</option>
                                                    @foreach ($suppliers as $supplier)
                                                        <option value="{{ $supplier->supplier_id }}"
                                                            {{ old('supplier_id', isset($product) ? $product->supplier_id : '') == $supplier->supplier_id ? 'selected' : '' }}>
                                                            {{ $supplier->contact_person }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('supplier_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label" for="collection">Collection</label>
                                                <input type="text"
                                                    class="form-control @error('collection') is-invalid @enderror"
                                                    id="collection" name="collection"
                                                    placeholder="Collection name (optional)"
                                                    value="{{ old('collection', isset($product) ? $product->collection : '') }}">
                                                @error('collection')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label" for="designer">Designer</label>
                                                <input type="text"
                                                    class="form-control @error('designer') is-invalid @enderror"
                                                    id="designer" name="designer" placeholder="Designer name (optional)"
                                                    value="{{ old('designer', isset($product) ? $product->designer : '') }}">
                                                @error('designer')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label" for="country_of_origin">Country of
                                                    Origin</label>
                                                <input type="text"
                                                    class="form-control @error('country_of_origin') is-invalid @enderror"
                                                    id="country_of_origin" name="country_of_origin"
                                                    placeholder="Country (optional)"
                                                    value="{{ old('country_of_origin', isset($product) ? $product->country_of_origin : '') }}">
                                                @error('country_of_origin')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Physical Attributes Section -->
                                        <h6 class="mb-3 mt-4 text-primary">Physical Attributes</h6>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label" for="weight_grams">Weight (grams)</label>
                                                <input type="number"
                                                    class="form-control @error('weight_grams') is-invalid @enderror"
                                                    id="weight_grams" name="weight_grams" placeholder="0.000"
                                                    step="0.001"
                                                    value="{{ old('weight_grams', isset($product) ? $product->weight_grams : '') }}">
                                                @error('weight_grams')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label" for="metal_weight">Metal Weight</label>
                                                <input type="number"
                                                    class="form-control @error('metal_weight') is-invalid @enderror"
                                                    id="metal_weight" name="metal_weight" placeholder="0.000"
                                                    step="0.001"
                                                    value="{{ old('metal_weight', isset($product) ? $product->metal_weight : '') }}">
                                                @error('metal_weight')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label" for="gemstone_weight">Gemstone
                                                    Weight</label>
                                                <input type="number"
                                                    class="form-control @error('gemstone_weight') is-invalid @enderror"
                                                    id="gemstone_weight" name="gemstone_weight" placeholder="0.000"
                                                    step="0.001"
                                                    value="{{ old('gemstone_weight', isset($product) ? $product->gemstone_weight : '') }}">
                                                @error('gemstone_weight')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label" for="gemstone_count">Gemstone Count</label>
                                                <input type="number"
                                                    class="form-control @error('gemstone_count') is-invalid @enderror"
                                                    id="gemstone_count" name="gemstone_count" placeholder="0"
                                                    min="0"
                                                    value="{{ old('gemstone_count', isset($product) ? $product->gemstone_count : 0) }}">
                                                @error('gemstone_count')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label" for="carat_purity">Carat Purity</label>
                                                <input type="text"
                                                    class="form-control @error('carat_purity') is-invalid @enderror"
                                                    id="carat_purity" name="carat_purity"
                                                    placeholder="e.g., 18K, 22K (optional)"
                                                    value="{{ old('carat_purity', isset($product) ? $product->carat_purity : '') }}">
                                                @error('carat_purity')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label" for="gender">Gender</label>
                                                <select class="form-select @error('gender') is-invalid @enderror"
                                                    id="gender" name="gender">
                                                    <option value="">Select Gender</option>
                                                    <option value="unisex"
                                                        {{ old('gender', isset($product) ? $product->gender : '') == 'unisex' ? 'selected' : '' }}>
                                                        Unisex</option>
                                                    <option value="male"
                                                        {{ old('gender', isset($product) ? $product->gender : '') == 'male' ? 'selected' : '' }}>
                                                        Male</option>
                                                    <option value="female"
                                                        {{ old('gender', isset($product) ? $product->gender : '') == 'female' ? 'selected' : '' }}>
                                                        Female</option>
                                                </select>
                                                @error('gender')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label" for="size">Size</label>
                                                <input type="text"
                                                    class="form-control @error('size') is-invalid @enderror"
                                                    id="size" name="size" placeholder="e.g., 8, M (optional)"
                                                    value="{{ old('size', isset($product) ? $product->size : '') }}">
                                                @error('size')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label" for="color">Color</label>
                                                <input type="text"
                                                    class="form-control @error('color') is-invalid @enderror"
                                                    id="color" name="color"
                                                    placeholder="e.g., Gold, White (optional)"
                                                    value="{{ old('color', isset($product) ? $product->color : '') }}">
                                                @error('color')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label" for="style">Style</label>
                                                <input type="text"
                                                    class="form-control @error('style') is-invalid @enderror"
                                                    id="style" name="style"
                                                    placeholder="e.g., Ring, Bracelet (optional)"
                                                    value="{{ old('style', isset($product) ? $product->style : '') }}">
                                                @error('style')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Pricing Section -->
                                        <h6 class="mb-3 mt-4 text-primary">Pricing</h6>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label" for="cost_price">Cost Price <span
                                                        class="text-danger">*</span></label>
                                                <input type="number"
                                                    class="form-control @error('cost_price') is-invalid @enderror"
                                                    id="cost_price" name="cost_price" placeholder="0.00" step="0.01"
                                                    value="{{ old('cost_price', isset($product) ? $product->cost_price : '') }}">
                                                @error('cost_price')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label" for="markup_percentage">Markup Percentage
                                                    (%)</label>
                                                <input type="number"
                                                    class="form-control @error('markup_percentage') is-invalid @enderror"
                                                    id="markup_percentage" name="markup_percentage" placeholder="0.00"
                                                    step="0.01"
                                                    value="{{ old('markup_percentage', isset($product) ? $product->markup_percentage : '') }}">
                                                @error('markup_percentage')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label" for="selling_price">Selling Price <span
                                                        class="text-danger">*</span></label>
                                                <input type="number"
                                                    class="form-control @error('selling_price') is-invalid @enderror"
                                                    id="selling_price" name="selling_price" placeholder="0.00"
                                                    step="0.01"
                                                    value="{{ old('selling_price', isset($product) ? $product->selling_price : '') }}">
                                                @error('selling_price')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label" for="wholesale_price">Wholesale
                                                    Price</label>
                                                <input type="number"
                                                    class="form-control @error('wholesale_price') is-invalid @enderror"
                                                    id="wholesale_price" name="wholesale_price" placeholder="0.00"
                                                    step="0.01"
                                                    value="{{ old('wholesale_price', isset($product) ? $product->wholesale_price : '') }}">
                                                @error('wholesale_price')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label" for="discount_price">Discount Price</label>
                                                <input type="number"
                                                    class="form-control @error('discount_price') is-invalid @enderror"
                                                    id="discount_price" name="discount_price" placeholder="0.00"
                                                    step="0.01"
                                                    value="{{ old('discount_price', isset($product) ? $product->discount_price : '') }}">
                                                @error('discount_price')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Inventory Section -->
                                        <h6 class="mb-3 mt-4 text-primary">Inventory</h6>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label" for="quantity_in_stock">Quantity in Stock
                                                    <span class="text-danger">*</span></label>
                                                <input type="number"
                                                    class="form-control @error('quantity_in_stock') is-invalid @enderror"
                                                    id="quantity_in_stock" name="quantity_in_stock" placeholder="0"
                                                    min="0"
                                                    value="{{ old('quantity_in_stock', isset($product) ? $product->quantity_in_stock : 0) }}">
                                                @error('quantity_in_stock')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label" for="minimum_stock_level">Minimum Stock
                                                    Level <span class="text-danger">*</span></label>
                                                <input type="number"
                                                    class="form-control @error('minimum_stock_level') is-invalid @enderror"
                                                    id="minimum_stock_level" name="minimum_stock_level" placeholder="5"
                                                    min="0"
                                                    value="{{ old('minimum_stock_level', isset($product) ? $product->minimum_stock_level : 5) }}">
                                                @error('minimum_stock_level')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label" for="reorder_quantity">Reorder
                                                    Quantity</label>
                                                <input type="number"
                                                    class="form-control @error('reorder_quantity') is-invalid @enderror"
                                                    id="reorder_quantity" name="reorder_quantity" placeholder="0"
                                                    min="0"
                                                    value="{{ old('reorder_quantity', isset($product) ? $product->reorder_quantity : '') }}">
                                                @error('reorder_quantity')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Product Composition Section -->
                                        <h6 class="mb-3 mt-4 text-primary">Product Composition</h6>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input
                                                        class="form-check-input @error('component_based') is-invalid @enderror"
                                                        type="checkbox" id="component_based" name="component_based"
                                                        {{ isset($product) && $product->component_based ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="component_based">
                                                        Component Based
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input @error('is_set') is-invalid @enderror"
                                                        type="checkbox" id="is_set" name="is_set"
                                                        {{ isset($product) && $product->is_set ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="is_set">
                                                        Is Set
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label" for="set_count">Set Count</label>
                                                <input type="number"
                                                    class="form-control @error('set_count') is-invalid @enderror"
                                                    id="set_count" name="set_count" placeholder="1" min="1"
                                                    value="{{ old('set_count', isset($product) ? $product->set_count : 1) }}">
                                                @error('set_count')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Certification Section -->
                                        <h6 class="mb-3 mt-4 text-primary">Certification</h6>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input
                                                        class="form-check-input @error('requires_certificate') is-invalid @enderror"
                                                        type="checkbox" id="requires_certificate"
                                                        name="requires_certificate"
                                                        {{ isset($product) && $product->requires_certificate ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="requires_certificate">
                                                        Requires Certificate
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label" for="certificate_number">Certificate
                                                    Number</label>
                                                <input type="text"
                                                    class="form-control @error('certificate_number') is-invalid @enderror"
                                                    id="certificate_number" name="certificate_number"
                                                    placeholder="Certificate number (optional)"
                                                    value="{{ old('certificate_number', isset($product) ? $product->certificate_number : '') }}">
                                                @error('certificate_number')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label" for="certificate_issuer">Certificate
                                                    Issuer</label>
                                                <input type="text"
                                                    class="form-control @error('certificate_issuer') is-invalid @enderror"
                                                    id="certificate_issuer" name="certificate_issuer"
                                                    placeholder="Issuer name (optional)"
                                                    value="{{ old('certificate_issuer', isset($product) ? $product->certificate_issuer : '') }}">
                                                @error('certificate_issuer')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label" for="certificate_date">Certificate
                                                    Date</label>
                                                <input type="date"
                                                    class="form-control @error('certificate_date') is-invalid @enderror"
                                                    id="certificate_date" name="certificate_date"
                                                    value="{{ old('certificate_date', isset($product) ? $product->certificate_date : '') }}">
                                                @error('certificate_date')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Status Section -->
                                        <h6 class="mb-3 mt-4 text-primary">Status</h6>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="status" class="form-label">Status</label>
                                                <select class="form-select @error('status') is-invalid @enderror"
                                                    id="status" name="status">
                                                    <option value="">Select Status</option>
                                                    <option value="Active"
                                                        {{ old('status', isset($product) ? $product->status : 'Active') == 'Active' ? 'selected' : '' }}>
                                                        Active</option>
                                                    <option value="Inactive"
                                                        {{ old('status', isset($product) ? $product->status : 'Active') == 'Inactive' ? 'selected' : '' }}>
                                                        Inactive</option>
                                                </select>
                                                @error('status')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input
                                                        class="form-check-input @error('is_featured') is-invalid @enderror"
                                                        type="checkbox" id="is_featured" name="is_featured"
                                                        {{ isset($product) && $product->is_featured ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="is_featured">
                                                        Featured
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="navs-top-cost-breakdown" role="tabpanel">
                                        <h6 class="mb-3 text-primary">Product Cost Breakdown</h6>
                                        <div id="cost-breakdown-list">
                                            <div class="cost-breakdown-template mb-4">
                                                <div class="card border shadow-sm">
                                                    <div class="card-body">
                                                        <div class="row mb-3">
                                                            <div class="col-md-2">
                                                                <label class="form-label">Category</label>
                                                                <input type="text" class="form-control"
                                                                    name="category[]" placeholder="e.g. Material, Labor">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label class="form-label">Item Description</label>
                                                                <input type="text" class="form-control"
                                                                    name="item_description[]" placeholder="Description">
                                                            </div>
                                                            <div class="col-md-1">
                                                                <label class="form-label">Quantity</label>
                                                                <input type="number" step="0.01" class="form-control"
                                                                    name="quantity[]" placeholder="Qty">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <label class="form-label">Unit Cost</label>
                                                                <input type="number" step="0.01" class="form-control"
                                                                    name="unit_cost[]" placeholder="Unit Cost">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <label class="form-label">Total Cost</label>
                                                                <input type="number" step="0.01" class="form-control"
                                                                    name="total_cost[]" placeholder="Total Cost">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <label class="form-label">% of Total</label>
                                                                <input type="number" step="0.01" class="form-control"
                                                                    name="percentage_of_total[]" placeholder="%">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-10">
                                                                <label class="form-label">Notes</label>
                                                                <textarea class="form-control" name="product_cost_breakdown_notes[]" rows="2" placeholder="Additional notes"></textarea>
                                                            </div>
                                                            <div class="col-md-2 d-flex align-items-end">
                                                                <button type="button"
                                                                    class="btn btn-outline-danger remove-cost-breakdown">Remove</button>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="breakdown_id[]">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-12 text-end">
                                                <button type="button" class="btn btn-primary add-cost-breakdown">Add Cost
                                                    Item</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="navs-top-images" role="tabpanel">
                                        <h6 class="mb-3 text-primary">Product Images</h6>
                                        <div id="image-list">
                                            <div class="image-template mb-4">
                                                <div class="card border shadow-sm">
                                                    <div class="card-body">
                                                        <div class="row mb-3">
                                                            <div class="col-md-4">
                                                                <label class="form-label">Image</label>
                                                                <input type="file" class="form-control"
                                                                    name="product_image[]" accept="image/*">
                                                            </div>

                                                            <div class="col-md-2">
                                                                <label class="form-label">Primary?</label><br>
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="is_primary[]" value="1">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <label class="form-label">Display Order</label>
                                                                <input type="number" class="form-control"
                                                                    name="display_order[]" placeholder="Order">
                                                            </div>
                                                            <div class="col-md-2 d-flex align-items-end">
                                                                <button type="button"
                                                                    class="btn btn-outline-danger remove-image">Remove</button>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="image_id[]">
                                                        <input type="hidden" name="product_id[]">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-12 text-end">
                                                <button type="button" class="btn btn-primary add-image">Add
                                                    Image</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="navs-top-tags" role="tabpanel">
                                        <h6 class="mb-3 text-primary">Product Tags</h6>
                                        <div id="tags-list">
                                            <div class="tag-template mb-4">
                                                <div class="card border shadow-sm">
                                                    <div class="card-body">
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <label class="form-label">Tag</label>
                                                                <select class="form-select" name="tag_id[]">
                                                                    <option value="">Select Tag</option>
                                                                    <option value="tag_one">Tag One</option>
                                                                    <option value="tag_two">Tag Two</option>
                                                                    <option value="tag_three">Tag Three</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label class="form-label">Added At</label>
                                                                <input type="text" class="form-control"
                                                                    name="added_at[]" placeholder="Auto" readonly>
                                                            </div>
                                                            <div class="col-md-3 d-flex align-items-end">
                                                                <button type="button"
                                                                    class="btn btn-outline-danger remove-tag">Remove</button>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="product_tag_id[]">
                                                        <input type="hidden" name="product_id[]">
                                                        <input type="hidden" name="added_by[]">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-12 text-end">
                                                <button type="button" class="btn btn-primary add-tag">Add Tag</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="navs-top-treatments" role="tabpanel">
                                        <h6 class="mb-3 text-primary">Product Treatments</h6>
                                        <div id="treatments-list">
                                            <div class="treatment-template mb-4">
                                                <div class="card border shadow-sm">
                                                    <div class="card-body">
                                                        <div class="row mb-3">
                                                            <div class="col-md-3">
                                                                <label class="form-label">Treatment Type</label>
                                                                <input type="text" class="form-control"
                                                                    name="treatment_type[]" placeholder="e.g. Heat, Dye">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label class="form-label">Treatment Method</label>
                                                                <input type="text" class="form-control"
                                                                    name="treatment_method[]"
                                                                    placeholder="e.g. Furnace, Chemical">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <label class="form-label">Intensity</label>
                                                                <input type="text" class="form-control"
                                                                    name="intensity[]" placeholder="e.g. High, Low">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <label class="form-label">Disclosure Required</label>
                                                                <select class="form-select" name="disclosure_required[]">
                                                                    <option value="1">Yes</option>
                                                                    <option value="0">No</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-9">
                                                                <label class="form-label">Notes</label>
                                                                <textarea class="form-control" name="product_treatments_notes[]" rows="2" placeholder="Additional notes"></textarea>
                                                            </div>
                                                            <div class="col-md-3 d-flex align-items-end">
                                                                <button type="button"
                                                                    class="btn btn-outline-danger remove-treatment">Remove</button>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="treatment_id[]">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-12 text-end">
                                                <button type="button" class="btn btn-primary add-treatment">Add
                                                    Treatment</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="navs-top-hallmarks" role="tabpanel">
                                        <h6 class="mb-3 text-primary">Product Hallmarks</h6>
                                        <div id="hallmarks-list">
                                            <div class="hallmark-template mb-4">
                                                <div class="card border shadow-sm">
                                                    <div class="card-body">
                                                        <div class="row mb-3">
                                                            <div class="col-md-3">
                                                                <label class="form-label">Hallmark Type</label>
                                                                <select class="form-select" name="hallmark_type[]">
                                                                    <option value="">Select Type</option>
                                                                    <option value="purity">Purity</option>
                                                                    <option value="maker">Maker</option>
                                                                    <option value="country">Country</option>
                                                                    <option value="assay">Assay</option>
                                                                    <option value="date">Date</option>
                                                                    <option value="other">Other</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label class="form-label">Hallmark Text</label>
                                                                <input type="text" class="form-control"
                                                                    name="hallmark_text[]" placeholder="Text">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label class="form-label">Hallmark Location</label>
                                                                <input type="text" class="form-control"
                                                                    name="hallmark_location[]" placeholder="Location">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label class="form-label">Image</label>
                                                                <input type="file" class="form-control"
                                                                    name="hallmark_image[]" accept="image/*">
                                                            </div>

                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-9">
                                                                <label class="form-label">Notes</label>
                                                                <textarea class="form-control" name="product_hallmarks_notes[]" rows="2" placeholder="Notes"></textarea>
                                                            </div>
                                                            <div class="col-md-3 d-flex align-items-end">
                                                                <button type="button"
                                                                    class="btn btn-outline-danger remove-hallmark">Remove</button>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="hallmark_id[]">
                                                        <input type="hidden" name="product_id[]">
                                                        <input type="hidden" name="created_at[]">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-12 text-end">
                                                <button type="button" class="btn btn-primary add-hallmark">Add
                                                    Hallmark</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade {{ $activeTab === 'components' ? 'show active' : '' }}"
                                        id="navs-top-components" role="tabpanel">
                                        <h6 class="mb-3 text-primary">Product Components</h6>
                                        <div id="components-list">
                                            @php
                                                $componentRows = [];
                                                $oldComponentNames = old('component_name', []);
                                            @endphp
                                            @if (count($oldComponentNames))
                                                @for ($i = 0; $i < count($oldComponentNames); $i++)
                                                    @php
                                                        $componentRows[] = [
                                                            'component_name' => old('component_name.' . $i),
                                                            'component_type_id' => old('component_type_id.' . $i),
                                                            'component_material_id' => old('component_material_id.' . $i),
                                                            'material_weight' => old('material_weight.' . $i),
                                                            'material_purity' => old('material_purity.' . $i),
                                                            'component_gemstone_id' => old('component_gemstone_id.' . $i),
                                                            'gemstone_quantity' => old('gemstone_quantity.' . $i, 1),
                                                            'gemstone_weight' => old('gemstone_weight.' . $i),
                                                            'gemstone_carat_weight' => old('gemstone_carat_weight.' . $i),
                                                            'gemstone_shape' => old('gemstone_shape.' . $i),
                                                            'gemstone_color' => old('gemstone_color.' . $i),
                                                            'gemstone_clarity' => old('gemstone_clarity.' . $i),
                                                            'gemstone_cut_grade' => old('gemstone_cut_grade.' . $i),
                                                            'gemstone_certificate' => old('gemstone_certificate.' . $i),
                                                            'dimension_length' => old('dimension_length.' . $i),
                                                            'dimension_width' => old('dimension_width.' . $i),
                                                            'dimension_height' => old('dimension_height.' . $i),
                                                            'diameter' => old('diameter.' . $i),
                                                            'component_cost' => old('component_cost.' . $i),
                                                            'labor_cost' => old('labor_cost.' . $i),
                                                            'setting_cost' => old('setting_cost.' . $i),
                                                            'position_order' => old('position_order.' . $i, 0),
                                                            'position_description' => old('position_description.' . $i),
                                                            'is_main_component' => old('is_main_component.' . $i, 0),
                                                            'product_notes' => old('product_notes.' . $i),
                                                        ];
                                                    @endphp
                                                @endfor
                                            @elseif (!empty($productComponents) && count($productComponents))
                                                @foreach ($productComponents as $component)
                                                    @php
                                                        $componentRows[] = [
                                                            'component_name' => $component->component_name,
                                                            'component_type_id' => $component->component_type_id,
                                                            'component_material_id' => $component->material_id,
                                                            'material_weight' => $component->material_weight,
                                                            'material_purity' => $component->material_purity,
                                                            'component_gemstone_id' => $component->gemstone_id,
                                                            'gemstone_quantity' => $component->gemstone_quantity ?? 1,
                                                            'gemstone_weight' => $component->gemstone_weight,
                                                            'gemstone_carat_weight' => $component->gemstone_carat_weight,
                                                            'gemstone_shape' => $component->gemstone_shape,
                                                            'gemstone_color' => $component->gemstone_color,
                                                            'gemstone_clarity' => $component->gemstone_clarity,
                                                            'gemstone_cut_grade' => $component->gemstone_cut_grade,
                                                            'gemstone_certificate' => $component->gemstone_certificate,
                                                            'dimension_length' => $component->dimension_length,
                                                            'dimension_width' => $component->dimension_width,
                                                            'dimension_height' => $component->dimension_height,
                                                            'diameter' => $component->diameter,
                                                            'component_cost' => $component->component_cost,
                                                            'labor_cost' => $component->labor_cost,
                                                            'setting_cost' => $component->setting_cost,
                                                            'position_order' => $component->position_order ?? 0,
                                                            'position_description' => $component->position_description,
                                                            'is_main_component' => $component->is_main_component ? 1 : 0,
                                                            'product_notes' => $component->notes,
                                                        ];
                                                    @endphp
                                                @endforeach
                                            @else
                                                @php
                                                    $componentRows[] = [];
                                                @endphp
                                            @endif

                                            @foreach ($componentRows as $row)
                                                @include('product._component_row', [
                                                    'row' => $row,
                                                    'rowIndex' => $loop->index,
                                                ])
                                            @endforeach
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-12 text-end">
                                                <button type="button" class="btn btn-primary" id="add-component-btn">+
                                                    Add Component</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade {{ $activeTab === 'measurements' ? 'show active' : '' }}"
                                        id="navs-top-measurements" role="tabpanel">
                                        <h6 class="mb-3 text-primary">Product Measurements</h6>
                                        @php
                                            $measurementRows = [];
                                            if (old('measurement_id')) {
                                                $measurementFieldKeys = [
                                                    'measurement_id',
                                                    'unit',
                                                    'value_decimal',
                                                    'value_string',
                                                    'position',
                                                    'measurement_notes',
                                                ];

                                                $measurementRowCount =
                                                    collect($measurementFieldKeys)
                                                        ->map(function ($key) {
                                                            return count((array) old($key, []));
                                                        })
                                                        ->max() ?? 0;

                                                for ($i = 0; $i < $measurementRowCount; $i++) {
                                                    $measurementRows[] = [
                                                        'measurement_id' => old('measurement_id.' . $i),
                                                        'unit' => old('unit.' . $i, 'mm'),
                                                        'value_decimal' => old('value_decimal.' . $i),
                                                        'value_string' => old('value_string.' . $i),
                                                        'position' => old('position.' . $i),
                                                        'measurement_notes' => old('measurement_notes.' . $i),
                                                    ];
                                                }
                                            } elseif (isset($productMeasurements) && count($productMeasurements)) {
                                                foreach ($productMeasurements as $measurement) {
                                                    $measurementRows[] = [
                                                        'measurement_id' => $measurement->measurement_id,
                                                        'unit' => $measurement->unit ?? 'mm',
                                                        'value_decimal' => $measurement->value_decimal,
                                                        'value_string' => $measurement->value_string,
                                                        'position' => $measurement->position,
                                                        'measurement_notes' => $measurement->notes,
                                                    ];
                                                }
                                            } else {
                                                $measurementRows[] = [];
                                            }
                                        @endphp
                                        <div id="measurements-list">
                                            @foreach ($measurementRows as $row)
                                                @include('product._measurement_row', [
                                                    'row' => $row,
                                                    'rowIndex' => $loop->index,
                                                ])
                                            @endforeach
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-12 text-end">
                                                <button type="button" class="btn btn-primary add-measurement">Add
                                                    Measurement</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade {{ $activeTab === 'labor' ? 'show active' : '' }}"
                                        id="navs-top-labor" role="tabpanel">
                                        <h6 class="mb-3 text-primary">Product Labor</h6>
                                        @php
                                            $laborRows = [];
                                            if (old('labor_type_id')) {
                                                $laborFieldKeys = [
                                                    'labor_type_id',
                                                    'labor_quantity',
                                                    'labor_actual_hours',
                                                    'labor_cost_amount',
                                                    'labor_notes',
                                                ];

                                                $laborRowCount =
                                                    collect($laborFieldKeys)
                                                        ->map(function ($key) {
                                                            return count((array) old($key, []));
                                                        })
                                                        ->max() ?? 0;

                                                for ($i = 0; $i < $laborRowCount; $i++) {
                                                    $laborRows[] = [
                                                        'labor_type_id' => old('labor_type_id.' . $i),
                                                        'labor_quantity' => old('labor_quantity.' . $i),
                                                        'labor_actual_hours' => old('labor_actual_hours.' . $i),
                                                        'labor_cost_amount' => old('labor_cost_amount.' . $i),
                                                        'labor_notes' => old('labor_notes.' . $i),
                                                    ];
                                                }
                                            } elseif (isset($productLabors) && count($productLabors)) {
                                                foreach ($productLabors as $labor) {
                                                    $laborRows[] = [
                                                        'labor_type_id' => $labor->labor_id,
                                                        'labor_quantity' => $labor->quantity ?? 1,
                                                        'labor_actual_hours' => $labor->actual_hours,
                                                        'labor_cost_amount' => $labor->labor_cost,
                                                        'labor_notes' => $labor->notes,
                                                    ];
                                                }
                                            } else {
                                                $laborRows[] = [];
                                            }
                                        @endphp
                                        <div id="labor-list" class="labor-list">
                                            @foreach ($laborRows as $row)
                                                @include('product._labor_row', [
                                                    'row' => $row,
                                                    'rowIndex' => $loop->index,
                                                ])
                                            @endforeach
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-12 text-end">
                                                <button type="button" class="btn btn-primary add-labor">Add
                                                    Labor</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </form>
    @endsection

    @push('scripts')
        <script>
            $(document).ready(function() {
                function resetFields($root) {
                    $root.find('.is-invalid').removeClass('is-invalid');
                    $root.find('.invalid-feedback').remove();
                    $root.find('[aria-invalid="true"]').removeAttr('aria-invalid');
                    $root.find('input, select, textarea').each(function() {
                        var $el = $(this);
                        if ($el.is(':checkbox') || $el.is(':radio')) {
                            $el.prop('checked', false);
                            return;
                        }
                        if ($el.is('select')) {
                            $el.prop('selectedIndex', 0);
                            return;
                        }
                        $el.val('');
                    });
                }

                function syncRemoveState($list, removeSelector, templateSelector) {
                    var $items = $list.find(templateSelector);
                    $items.find(removeSelector).prop('disabled', false);
                    $items.first().find(removeSelector).prop('disabled', true);
                }

                function setupRepeater(options) {
                    var $list = $(options.list);
                    var templateSelector = options.template;
                    var removeSelector = options.removeBtn;

                    $(options.addBtn).on('click', function() {
                        var $template = $list.find(templateSelector).first();
                        if ($template.length === 0) {
                            return;
                        }
                        var $clone = $template.clone();
                        resetFields($clone);
                        $list.append($clone);
                        syncRemoveState($list, removeSelector, templateSelector);
                    });

                    $list.on('click', removeSelector, function() {
                        if ($(this).prop('disabled')) {
                            return;
                        }
                        $(this).closest(templateSelector).remove();
                        syncRemoveState($list, removeSelector, templateSelector);
                    });

                    syncRemoveState($list, removeSelector, templateSelector);
                }

                setupRepeater({
                    list: '#components-list',
                    template: '.component-template',
                    addBtn: '#add-component-btn',
                    removeBtn: '.remove-component-btn'
                });

                setupRepeater({
                    list: '#measurements-list',
                    template: '.measurement-template',
                    addBtn: '.add-measurement',
                    removeBtn: '.remove-measurement'
                });

                setupRepeater({
                    list: '#labor-list',
                    template: '.labor-template',
                    addBtn: '.add-labor',
                    removeBtn: '.remove-labor'
                });

                setupRepeater({
                    list: '#cost-breakdown-list',
                    template: '.cost-breakdown-template',
                    addBtn: '.add-cost-breakdown',
                    removeBtn: '.remove-cost-breakdown'
                });

                setupRepeater({
                    list: '#treatments-list',
                    template: '.treatment-template',
                    addBtn: '.add-treatment',
                    removeBtn: '.remove-treatment'
                });

                setupRepeater({
                    list: '#image-list',
                    template: '.image-template',
                    addBtn: '.add-image',
                    removeBtn: '.remove-image'
                });

                setupRepeater({
                    list: '#tags-list',
                    template: '.tag-template',
                    addBtn: '.add-tag',
                    removeBtn: '.remove-tag'
                });

                setupRepeater({
                    list: '#hallmarks-list',
                    template: '.hallmark-template',
                    addBtn: '.add-hallmark',
                    removeBtn: '.remove-hallmark'
                });
            });
        </script>
    @endpush
