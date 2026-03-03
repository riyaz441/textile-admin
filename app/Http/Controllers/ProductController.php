<?php

namespace App\Http\Controllers;

use App\Models\CompanyMaster;
use App\Models\ComponentTypeMaster;
use App\Models\LaborMaster;
use App\Models\Measurement;
use App\Models\Product;
use App\Models\ProductComponent;
use App\Models\ProductLabor;
use App\Models\ProductCategoryMaster;
use App\Models\Material;
use App\Models\GemstoneMaster;
use App\Models\SupplierMaster;
use App\Models\ProductMeasurement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index()
    {
        $data['products'] = Product::with('category', 'material', 'gemstone', 'supplier')
            ->orderBy('product_id', 'DESC')->get();
        return view('product/index', $data);
    }

    /**
     * Show the form for creating or editing a product.
     */
    public function form($id = null)
    {
        $data = [];
        if ($id) {
            $data['product'] = Product::findOrFail($id);
            $data['productComponents'] = ProductComponent::where('product_id', $id)->get();
            $data['productLabors'] = ProductLabor::where('product_id', $id)->get();
            $data['productMeasurements'] = ProductMeasurement::where('product_id', $id)->get();
        }
        // Load related data for dropdowns
        $data['categories'] = ProductCategoryMaster::where('status', 'Active')->get();
        $data['materials'] = Material::get();
        $data['gemstones'] = GemstoneMaster::get();
        $data['suppliers'] = SupplierMaster::where('status', 'Active')->get();
        $data['componentTypes'] = ComponentTypeMaster::where('status', 'Active')->get();
        $data['laborTypes'] = LaborMaster::where('status', 'Active')->get();
        $data['measurementTypes'] = Measurement::where('status', 'Active')->get();
        $data['companies'] = CompanyMaster::where('status', 'Active')->get();

        return view('product/form', $data);
    }

    /**
     * Store or update product
     */
    public function save(Request $request, $id = null)
    {
        $product = $id
            ? Product::findOrFail($id)
            : new Product();

        $scalarFields = [
            'company_id',
            'sku',
            'barcode',
            'product_name',
            'description',
            'category_id',
            'material_id',
            'gemstone_id',
            'supplier_id',
            'collection',
            'designer',
            'country_of_origin',
            'weight_grams',
            'metal_weight',
            'gemstone_weight',
            'gemstone_count',
            'total_metal_weight',
            'total_gemstone_weight',
            'carat_purity',
            'size',
            'color',
            'style',
            'gender',
            'cost_price',
            'markup_percentage',
            'selling_price',
            'wholesale_price',
            'discount_price',
            'quantity_in_stock',
            'minimum_stock_level',
            'reorder_quantity',
            'set_count',
            'serial_number_format',
            'serialized_count',
            'last_serial_number',
            'certificate_number',
            'certificate_issuer',
            'certificate_date',
            'status',
        ];

        foreach ($scalarFields as $field) {
            $value = $request->input($field);
            if (is_array($value)) {
                $request->merge([$field => $value[0] ?? null]);
            }
        }

        $request->validate(
            [
                'company_id' => 'required|exists:companies,company_id',
                'sku' => [
                    'required',
                    'min:2',
                    'max:50',
                    'unique:products,sku,' . ($id ?? 'NULL') . ',product_id',
                ],
                'product_name' => [
                    'required',
                    'min:3',
                    'max:200',
                    'regex:/^(?=.*[a-zA-Z])(?!.*<script>)[a-zA-Z0-9\s!@#$%^&*()_+{}\[\]:;\"\'<>,.?\/\\\\|-]+$/i',
                ],
                'description' => 'nullable|string|max:1000',
                'barcode' => 'nullable|string|max:100',
                'category_id' => 'nullable|exists:categories,category_id',
                'material_id' => 'nullable|exists:materials,material_id',
                'gemstone_id' => 'nullable|exists:gemstones,gemstone_id',
                'supplier_id' => 'nullable|exists:suppliers,supplier_id',
                'collection' => 'nullable|string|max:100',
                'designer' => 'nullable|string|max:100',
                'country_of_origin' => 'nullable|string|max:50',
                'weight_grams' => 'nullable|numeric|min:0',
                'metal_weight' => 'nullable|numeric|min:0',
                'gemstone_weight' => 'nullable|numeric|min:0',
                'gemstone_count' => 'nullable|integer|min:0',
                'total_metal_weight' => 'nullable|numeric|min:0',
                'total_gemstone_weight' => 'nullable|numeric|min:0',
                'carat_purity' => 'nullable|string|max:20',
                'size' => 'nullable|string|max:20',
                'color' => 'nullable|string|max:30',
                'style' => 'nullable|string|max:50',
                'gender' => 'nullable|in:male,female,unisex',
                'cost_price' => 'required|numeric|min:0.01',
                'markup_percentage' => 'nullable|numeric|min:0|max:100',
                'selling_price' => 'required|numeric|min:0.01',
                'wholesale_price' => 'nullable|numeric|min:0',
                'discount_price' => 'nullable|numeric|min:0',
                'quantity_in_stock' => 'required|integer|min:0',
                'minimum_stock_level' => 'required|integer|min:0',
                'reorder_quantity' => 'nullable|integer|min:0',
                'component_based' => 'nullable|boolean',
                'is_set' => 'nullable|boolean',
                'set_count' => 'nullable|integer|min:1',
                'is_serialized' => 'nullable|boolean',
                'track_individual_items' => 'nullable|boolean',
                'serial_number_format' => 'nullable|string|max:100',
                'serialized_count' => 'nullable|integer|min:0',
                'last_serial_number' => 'nullable|integer|min:0',
                'is_lot_based' => 'nullable|boolean',
                'requires_certificate' => 'nullable|boolean',
                'certificate_number' => 'nullable|string|max:100',
                'certificate_issuer' => 'nullable|string|max:100',
                'certificate_date' => 'nullable|date',
                'hallmark' => 'nullable|string|max:100',
                'status' => 'required|in:Active,Inactive',
                'is_featured' => 'nullable|boolean'
            ],
            [
                'sku.required' => 'SKU is required',
                'sku.unique' => 'This SKU already exists',
                'product_name.required' => 'Product name is required',
                'product_name.min' => 'Product name must be at least 3 characters',
                'cost_price.required' => 'Cost price is required',
                'selling_price.required' => 'Selling price is required',
                'quantity_in_stock.required' => 'Quantity in stock is required',
            ]
        );

        $componentFieldKeys = [
            'component_name',
            'component_type_id',
            'component_material_id',
            'material_weight',
            'material_purity',
            'component_gemstone_id',
            'gemstone_quantity',
            'gemstone_weight',
            'gemstone_carat_weight',
            'gemstone_shape',
            'gemstone_color',
            'gemstone_clarity',
            'gemstone_cut_grade',
            'gemstone_certificate',
            'dimension_length',
            'dimension_width',
            'dimension_height',
            'diameter',
            'component_cost',
            'labor_cost',
            'setting_cost',
            'position_description',
            'product_notes',
        ];

        $hasComponents = collect($componentFieldKeys)
            ->flatMap(function ($key) use ($request) {
                return (array) $request->input($key, []);
            })
            ->filter(function ($value) {
                return trim((string) $value) !== '';
            })
            ->isNotEmpty();

        if ($hasComponents) {
            $componentRules = [
                'component_name.*' => 'nullable|string|max:100',
                'component_type_id.*' => 'nullable',
                'component_material_id.*' => 'nullable',
                'material_weight.*' => 'nullable|numeric|min:0',
                'material_purity.*' => 'nullable|string|max:20',
                'component_gemstone_id.*' => 'nullable|exists:gemstones,gemstone_id',
                'gemstone_quantity.*' => 'nullable|integer|min:0',
                'gemstone_weight.*' => 'nullable|numeric|min:0',
                'gemstone_carat_weight.*' => 'nullable|numeric|min:0',
                'gemstone_shape.*' => 'nullable|in:Round,Oval,Princess,Emerald,Pear,Marquise,Cushion,Asscher,Radiant,Heart,Other',
                'gemstone_color.*' => 'nullable|in:Red,Blue,Green,Yellow,Pink,White,Black,Brown,Orange,Purple,Other',
                'gemstone_clarity.*' => 'nullable|in:IF,VVS1,VVS2,VS1,VS2,SI1,SI2,I1,I2,I3,Other',
                'gemstone_cut_grade.*' => 'nullable|in:Brilliant,Step,Mixed,Rose,Cabochon,Other',
                'gemstone_certificate.*' => 'nullable|string|max:100',
                'dimension_length.*' => 'nullable|numeric|min:0',
                'dimension_width.*' => 'nullable|numeric|min:0',
                'dimension_height.*' => 'nullable|numeric|min:0',
                'diameter.*' => 'nullable|numeric|min:0',
                'component_cost.*' => 'nullable|numeric|min:0',
                'labor_cost.*' => 'nullable|numeric|min:0',
                'setting_cost.*' => 'nullable|numeric|min:0',
                'position_order.*' => 'nullable|integer|min:0',
                'position_description.*' => 'nullable|string|max:200',
                'is_main_component.*' => 'nullable|boolean',
                'product_notes.*' => 'nullable|string',
            ];

            $componentMessages = [
                'component_name.*.string' => ':attribute must be a valid text.',
                'component_name.*.max' => ':attribute must not be greater than :max characters.',
                'component_type_id.*.exists' => ':attribute selection is invalid.',
                'component_material_id.*.exists' => ':attribute selection is invalid.',
                'material_weight.*.numeric' => ':attribute must be a number.',
                'material_weight.*.min' => ':attribute must be at least :min.',
                'material_purity.*.string' => ':attribute must be a valid text.',
                'material_purity.*.max' => ':attribute must not be greater than :max characters.',
                'component_gemstone_id.*.exists' => ':attribute selection is invalid.',
                'gemstone_quantity.*.integer' => ':attribute must be a whole number.',
                'gemstone_quantity.*.min' => ':attribute must be at least :min.',
                'gemstone_weight.*.numeric' => ':attribute must be a number.',
                'gemstone_weight.*.min' => ':attribute must be at least :min.',
                'gemstone_carat_weight.*.numeric' => ':attribute must be a number.',
                'gemstone_carat_weight.*.min' => ':attribute must be at least :min.',
                'gemstone_shape.*.string' => ':attribute must be a valid text.',
                'gemstone_shape.*.max' => ':attribute must not be greater than :max characters.',
                'gemstone_color.*.string' => ':attribute must be a valid text.',
                'gemstone_color.*.max' => ':attribute must not be greater than :max characters.',
                'gemstone_clarity.*.string' => ':attribute must be a valid text.',
                'gemstone_clarity.*.max' => ':attribute must not be greater than :max characters.',
                'gemstone_cut_grade.*.string' => ':attribute must be a valid text.',
                'gemstone_cut_grade.*.max' => ':attribute must not be greater than :max characters.',
                'gemstone_certificate.*.string' => ':attribute must be a valid text.',
                'gemstone_certificate.*.max' => ':attribute must not be greater than :max characters.',
                'dimension_length.*.numeric' => ':attribute must be a number.',
                'dimension_length.*.min' => ':attribute must be at least :min.',
                'dimension_width.*.numeric' => ':attribute must be a number.',
                'dimension_width.*.min' => ':attribute must be at least :min.',
                'dimension_height.*.numeric' => ':attribute must be a number.',
                'dimension_height.*.min' => ':attribute must be at least :min.',
                'diameter.*.numeric' => ':attribute must be a number.',
                'diameter.*.min' => ':attribute must be at least :min.',
                'component_cost.*.numeric' => ':attribute must be a number.',
                'component_cost.*.min' => ':attribute must be at least :min.',
                'labor_cost.*.numeric' => ':attribute must be a number.',
                'labor_cost.*.min' => ':attribute must be at least :min.',
                'setting_cost.*.numeric' => ':attribute must be a number.',
                'setting_cost.*.min' => ':attribute must be at least :min.',
                'position_order.*.integer' => ':attribute must be a whole number.',
                'position_order.*.min' => ':attribute must be at least :min.',
                'position_description.*.string' => ':attribute must be a valid text.',
                'position_description.*.max' => ':attribute must not be greater than :max characters.',
                'is_main_component.*.boolean' => ':attribute value is invalid.',
                'product_notes.*.string' => ':attribute must be a valid text.',
            ];

            $componentLabels = [
                'component_name' => 'Component Name',
                'component_type_id' => 'Component Type',
                'component_material_id' => 'Material',
                'material_weight' => 'Material Weight',
                'material_purity' => 'Material Purity',
                'component_gemstone_id' => 'Gemstone',
                'gemstone_quantity' => 'Gemstone Quantity',
                'gemstone_weight' => 'Gemstone Weight',
                'gemstone_carat_weight' => 'Gemstone Carat Weight',
                'gemstone_shape' => 'Gemstone Shape',
                'gemstone_color' => 'Gemstone Color',
                'gemstone_clarity' => 'Gemstone Clarity',
                'gemstone_cut_grade' => 'Gemstone Cut Grade',
                'gemstone_certificate' => 'Gemstone Certificate',
                'dimension_length' => 'Length',
                'dimension_width' => 'Width',
                'dimension_height' => 'Height',
                'diameter' => 'Diameter',
                'component_cost' => 'Component Cost',
                'labor_cost' => 'Labor Cost',
                'setting_cost' => 'Setting Cost',
                'position_order' => 'Position Order',
                'position_description' => 'Position Description',
                'is_main_component' => 'Is Main Component',
                'product_notes' => 'Notes',
            ];

            $rowCount = collect($componentFieldKeys)
                ->map(function ($key) use ($request) {
                    return count((array) $request->input($key, []));
                })
                ->max() ?? 0;

            $componentAttributes = [];
            for ($i = 0; $i < $rowCount; $i++) {
                $rowNumber = $i + 1;
                foreach ($componentLabels as $field => $label) {
                    $componentAttributes[$field . '.' . $i] = $label . ' (Row ' . $rowNumber . ')';
                }
            }

            $request->validate($componentRules, $componentMessages, $componentAttributes);
        }

        $laborFieldKeys = [
            'labor_type_id',
            'labor_quantity',
            'labor_actual_hours',
            'labor_cost_amount',
            'labor_notes',
        ];

        $hasLabors = collect($laborFieldKeys)
            ->flatMap(function ($key) use ($request) {
                return (array) $request->input($key, []);
            })
            ->filter(function ($value) {
                return trim((string) $value) !== '';
            })
            ->isNotEmpty();

        if ($hasLabors) {
            $laborRules = [
                'labor_type_id.*' => 'nullable|exists:labors,labor_id',
                'labor_quantity.*' => 'nullable|integer|min:1',
                'labor_actual_hours.*' => 'nullable|numeric|min:0',
                'labor_cost_amount.*' => 'nullable|numeric|min:0',
                'labor_notes.*' => 'nullable|string',
            ];

            $laborMessages = [
                'labor_type_id.*.exists' => ':attribute selection is invalid.',
                'labor_quantity.*.integer' => ':attribute must be a whole number.',
                'labor_quantity.*.min' => ':attribute must be at least :min.',
                'labor_actual_hours.*.numeric' => ':attribute must be a number.',
                'labor_actual_hours.*.min' => ':attribute must be at least :min.',
                'labor_cost_amount.*.numeric' => ':attribute must be a number.',
                'labor_cost_amount.*.min' => ':attribute must be at least :min.',
                'labor_notes.*.string' => ':attribute must be a valid text.',
            ];

            $laborLabels = [
                'labor_type_id' => 'Labor Type',
                'labor_quantity' => 'Quantity',
                'labor_actual_hours' => 'Actual Hours',
                'labor_cost_amount' => 'Labor Cost',
                'labor_notes' => 'Notes',
            ];

            $laborRowCount = collect($laborFieldKeys)
                ->map(function ($key) use ($request) {
                    return count((array) $request->input($key, []));
                })
                ->max() ?? 0;

            $laborAttributes = [];
            for ($i = 0; $i < $laborRowCount; $i++) {
                $rowNumber = $i + 1;
                foreach ($laborLabels as $field => $label) {
                    $laborAttributes[$field . '.' . $i] = $label . ' (Row ' . $rowNumber . ')';
                }
            }

            $request->validate($laborRules, $laborMessages, $laborAttributes);
        }

        $measurementFieldKeys = [
            'measurement_id',
            'unit',
            'value_decimal',
            'value_string',
            'position',
            'measurement_notes',
        ];

        $hasMeasurements = collect($measurementFieldKeys)
            ->flatMap(function ($key) use ($request) {
                return (array) $request->input($key, []);
            })
            ->filter(function ($value) {
                return trim((string) $value) !== '';
            })
            ->isNotEmpty();

        if ($hasMeasurements) {
            $measurementRules = [
                'measurement_id.*' => 'nullable',
                'unit.*' => 'nullable|string|max:20',
                'value_decimal.*' => 'nullable|numeric|min:0',
                'value_string.*' => 'nullable|string|max:100',
                'position.*' => 'nullable|string|max:100',
                'measurement_notes.*' => 'nullable|string',
            ];

            $measurementMessages = [
                'unit.*.string' => ':attribute must be a valid text.',
                'unit.*.max' => ':attribute must not be greater than :max characters.',
                'value_decimal.*.numeric' => ':attribute must be a number.',
                'value_decimal.*.min' => ':attribute must be at least :min.',
                'value_string.*.string' => ':attribute must be a valid text.',
                'value_string.*.max' => ':attribute must not be greater than :max characters.',
                'position.*.string' => ':attribute must be a valid text.',
                'position.*.max' => ':attribute must not be greater than :max characters.',
                'measurement_notes.*.string' => ':attribute must be a valid text.',
            ];

            $measurementLabels = [
                'measurement_id' => 'Measurement Type',
                'unit' => 'Unit',
                'value_decimal' => 'Value (Decimal)',
                'value_string' => 'Value (String)',
                'position' => 'Position',
                'measurement_notes' => 'Notes',
            ];

            $measurementRowCount = collect($measurementFieldKeys)
                ->map(function ($key) use ($request) {
                    return count((array) $request->input($key, []));
                })
                ->max() ?? 0;

            $measurementAttributes = [];
            for ($i = 0; $i < $measurementRowCount; $i++) {
                $rowNumber = $i + 1;
                foreach ($measurementLabels as $field => $label) {
                    $measurementAttributes[$field . '.' . $i] = $label . ' (Row ' . $rowNumber . ')';
                }
            }

            $request->validate($measurementRules, $measurementMessages, $measurementAttributes);
        }

        DB::transaction(function () use ($request, $product, $id, $hasComponents, $hasLabors, $hasMeasurements) {
            $product->fill($request->only([
                'company_id',
                'sku',
                'barcode',
                'product_name',
                'description',
                'category_id',
                'material_id',
                'gemstone_id',
                'supplier_id',
                'collection',
                'designer',
                'country_of_origin',
                'weight_grams',
                'metal_weight',
                'gemstone_weight',
                'gemstone_count',
                'total_metal_weight',
                'total_gemstone_weight',
                'carat_purity',
                'size',
                'color',
                'style',
                'gender',
                'cost_price',
                'markup_percentage',
                'selling_price',
                'wholesale_price',
                'discount_price',
                'quantity_in_stock',
                'minimum_stock_level',
                'reorder_quantity',
                'set_count',
                'serial_number_format',
                'serialized_count',
                'last_serial_number',
                'certificate_number',
                'certificate_issuer',
                'certificate_date',
                'status',
            ]));

            // Convert boolean values
            $product->component_based = $request->has('component_based');
            $product->is_set = $request->has('is_set');
            $product->is_serialized = $request->has('is_serialized');
            $product->track_individual_items = $request->has('track_individual_items');
            $product->is_lot_based = $request->has('is_lot_based');
            $product->requires_certificate = $request->has('requires_certificate');
            $product->is_featured = $request->has('is_featured');

            $product->save();

            if ($hasComponents) {
                if ($id) {
                    ProductComponent::where('product_id', $product->product_id)->delete();
                }

                $componentNames = $request->input('component_name', []);
                $componentTypeIds = $request->input('component_type_id', []);
                $componentMaterialIds = $request->input('component_material_id', []);
                $componentGemstoneIds = $request->input('component_gemstone_id', []);
                $materialWeights = $request->input('material_weight', []);
                $materialPurities = $request->input('material_purity', []);
                $gemstoneQuantities = $request->input('gemstone_quantity', []);
                $gemstoneWeights = $request->input('gemstone_weight', []);
                $gemstoneCaratWeights = $request->input('gemstone_carat_weight', []);
                $gemstoneShapes = $request->input('gemstone_shape', []);
                $gemstoneColors = $request->input('gemstone_color', []);
                $gemstoneClarities = $request->input('gemstone_clarity', []);
                $gemstoneCutGrades = $request->input('gemstone_cut_grade', []);
                $gemstoneCertificates = $request->input('gemstone_certificate', []);
                $dimensionLengths = $request->input('dimension_length', []);
                $dimensionWidths = $request->input('dimension_width', []);
                $dimensionHeights = $request->input('dimension_height', []);
                $diameters = $request->input('diameter', []);
                $componentCosts = $request->input('component_cost', []);
                $laborCosts = $request->input('labor_cost_amount', []);
                $settingCosts = $request->input('setting_cost', []);
                $positionOrders = $request->input('position_order', []);
                $positionDescriptions = $request->input('position_description', []);
                $isMainComponents = $request->input('is_main_component', []);
                $notes = $request->input('product_notes', []);

                $components = [];
                foreach ($componentNames as $index => $name) {
                    $name = trim((string) ($name ?? ''));
                    if ($name === '') {
                        continue;
                    }

                    $components[] = [
                        'product_id' => $product->product_id,
                        'component_type_id' => $componentTypeIds[$index] ?? null,
                        'component_name' => $name,
                        'material_id' => $componentMaterialIds[$index] ?? null,
                        'material_weight' => $materialWeights[$index] ?? null,
                        'material_purity' => $materialPurities[$index] ?? null,
                        'gemstone_id' => $componentGemstoneIds[$index] ?? null,
                        'gemstone_quantity' => $gemstoneQuantities[$index] ?? null,
                        'gemstone_weight' => $gemstoneWeights[$index] ?? null,
                        'gemstone_carat_weight' => $gemstoneCaratWeights[$index] ?? null,
                        'gemstone_shape' => $gemstoneShapes[$index] ?? null,
                        'gemstone_color' => $gemstoneColors[$index] ?? null,
                        'gemstone_clarity' => $gemstoneClarities[$index] ?? null,
                        'gemstone_cut_grade' => $gemstoneCutGrades[$index] ?? null,
                        'gemstone_certificate' => $gemstoneCertificates[$index] ?? null,
                        'dimension_length' => $dimensionLengths[$index] ?? null,
                        'dimension_width' => $dimensionWidths[$index] ?? null,
                        'dimension_height' => $dimensionHeights[$index] ?? null,
                        'diameter' => $diameters[$index] ?? null,
                        'component_cost' => $componentCosts[$index] ?? null,
                        'labor_cost' => $laborCosts[$index] ?? null,
                        'setting_cost' => $settingCosts[$index] ?? null,
                        'position_order' => $positionOrders[$index] ?? 0,
                        'position_description' => $positionDescriptions[$index] ?? null,
                        'is_main_component' => ($isMainComponents[$index] ?? 0) ? 1 : 0,
                        'notes' => $notes[$index] ?? null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                if (!empty($components)) {
                    ProductComponent::insert($components);
                }
            }

            if ($hasLabors) {
                if ($id) {
                    ProductLabor::where('product_id', $product->product_id)->delete();
                }

                $laborTypeIds = $request->input('labor_type_id', []);
                $laborQuantities = $request->input('labor_quantity', []);
                $laborActualHours = $request->input('labor_actual_hours', []);
                $laborCosts = $request->input('labor_cost_amount', []);
                $laborNotes = $request->input('labor_notes', []);

                $labors = [];
                foreach ($laborTypeIds as $index => $laborTypeId) {
                    $laborTypeId = trim((string) ($laborTypeId ?? ''));
                    if ($laborTypeId === '') {
                        continue;
                    }

                    $labors[] = [
                        'product_id' => $product->product_id,
                        'labor_id' => $laborTypeId,
                        'quantity' => $laborQuantities[$index] ?? 1,
                        'actual_hours' => $laborActualHours[$index] ?? null,
                        'labor_cost' => $laborCosts[$index] ?? null,
                        'notes' => $laborNotes[$index] ?? null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                if (!empty($labors)) {
                    ProductLabor::insert($labors);
                }
            }

            if ($hasMeasurements) {
                if ($id) {
                    ProductMeasurement::where('product_id', $product->product_id)->delete();
                }

                $measurementIds = $request->input('measurement_id', []);
                $units = $request->input('unit', []);
                $valueDecimals = $request->input('value_decimal', []);
                $valueStrings = $request->input('value_string', []);
                $positions = $request->input('position', []);
                $measurementNotes = $request->input('measurement_notes', []);

                $measurementNameMap = Measurement::whereIn('measurement_id', array_filter($measurementIds))
                    ->pluck('name', 'measurement_id')
                    ->toArray();

                $measurements = [];
                foreach ($measurementIds as $index => $measurementId) {
                    $measurementId = trim((string) ($measurementId ?? ''));
                    if ($measurementId === '') {
                        continue;
                    }
                    $unitValue = trim((string) ($units[$index] ?? ''));
                    if ($unitValue === '') {
                        $unitValue = 'mm';
                    }

                    $measurements[] = [
                        'measurement_id' => $measurementId,
                        'product_id' => $product->product_id,
                        'measurement_type' => $measurementNameMap[$measurementId] ?? null,
                        'unit' => $unitValue,
                        'value_decimal' => $valueDecimals[$index] ?? null,
                        'value_string' => $valueStrings[$index] ?? null,
                        'position' => $positions[$index] ?? null,
                        'notes' => $measurementNotes[$index] ?? null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                if (!empty($measurements)) {
                    ProductMeasurement::insert($measurements);
                }
            }
        });

        return redirect('products')->with(
            'success',
            $id ? 'Product updated successfully!' : 'Product created successfully!'
        );
    }

    /**
     * Display the specified product.
     */
    public function show($id)
    {
        $data['product'] = Product::with('category', 'material', 'gemstone', 'supplier')->findOrFail($id);
        $data['productComponents'] = ProductComponent::where('product_id', $id)
            ->orderBy('position_order')
            ->get();
        $data['productLabors'] = ProductLabor::where('product_id', $id)->get();
        $data['productMeasurements'] = ProductMeasurement::where('product_id', $id)->get();
        $data['componentTypes'] = ComponentTypeMaster::get()->keyBy('type_id');
        $data['materials'] = Material::get()->keyBy('material_id');
        $data['gemstones'] = GemstoneMaster::get()->keyBy('gemstone_id');
        $data['laborTypes'] = LaborMaster::get()->keyBy('labor_id');
        $data['measurementTypes'] = Measurement::get()->keyBy('measurement_id');
        return view('product/show', $data);
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $product = Product::findOrFail($id);
            $product->delete();
            ProductComponent::where('product_id', $id)->delete();
            ProductLabor::where('product_id', $id)->delete();
            ProductMeasurement::where('product_id', $id)->delete();
        });

        return redirect('products')->with('danger', 'Product deleted successfully!');
    }

    /**
     * Change the status of a product.
     */
    public function changeStatus(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->status = $request->status;
        $product->save();

        return response()->json(['success' => true, 'message' => 'Status updated successfully!', 'status' => $product->status]);
    }
}
