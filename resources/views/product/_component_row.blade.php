@php
    $rowIndex = $rowIndex ?? 0;
@endphp
<div class="component-template mb-4">
    <div class="card border shadow-sm">
        <div class="card-body">
            <div class="component-form-row row mb-3">
                <div class="col-md-4">
                    <label class="form-label" for="component_name[]">Component
                        Name </label>
                    <input type="text"
                        class="form-control @error('component_name.' . $rowIndex) is-invalid @enderror"
                        name="component_name[]"
                        placeholder="Enter component name"
                        value="{{ $row['component_name'] ?? '' }}">
                    @error('component_name.' . $rowIndex)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label"
                        for="component_type_id[]">Component
                        Type</label>
                    <select class="form-select @error('component_type_id.' . $rowIndex) is-invalid @enderror"
                        name="component_type_id[]">
                        <option value="">Select Type</option>
                        @foreach ($componentTypes ?? [] as $type)
                            <option value="{{ $type->type_id }}"
                                {{ ($row['component_type_id'] ?? '') == $type->type_id ? 'selected' : '' }}>
                                {{ $type->type_name }}</option>
                        @endforeach
                    </select>
                    @error('component_type_id.' . $rowIndex)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label"
                        for="component_material_id[]">Material</label>
                    <select class="form-select @error('component_material_id.' . $rowIndex) is-invalid @enderror"
                        name="component_material_id[]">
                        <option value="">Select Material</option>
                        @foreach ($materials ?? [] as $material)
                            <option value="{{ $material->material_id }}"
                                {{ ($row['component_material_id'] ?? '') == $material->material_id ? 'selected' : '' }}>
                                {{ $material->material_name }}</option>
                        @endforeach
                    </select>
                    @error('component_material_id.' . $rowIndex)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="component-form-row row mb-3">
                <div class="col-md-3">
                    <label class="form-label" for="material_weight[]">Material
                        Weight</label>
                    <input type="number" step="0.001"
                        class="form-control @error('material_weight.' . $rowIndex) is-invalid @enderror"
                        name="material_weight[]"
                        placeholder="e.g. 2.500"
                        value="{{ $row['material_weight'] ?? '' }}">
                    @error('material_weight.' . $rowIndex)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="material_purity[]">Material
                        Purity</label>
                    <input type="text"
                        class="form-control @error('material_purity.' . $rowIndex) is-invalid @enderror"
                        name="material_purity[]"
                        placeholder="e.g. 14K"
                        value="{{ $row['material_purity'] ?? '' }}">
                    @error('material_purity.' . $rowIndex)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label"
                        for="component_gemstone_id[]">Gemstone</label>
                    <select class="form-select @error('component_gemstone_id.' . $rowIndex) is-invalid @enderror"
                        name="component_gemstone_id[]">
                        <option value="">Select Gemstone</option>
                        @foreach ($gemstones ?? [] as $gemstone)
                            <option value="{{ $gemstone->gemstone_id }}"
                                {{ ($row['component_gemstone_id'] ?? '') == $gemstone->gemstone_id ? 'selected' : '' }}>
                                {{ $gemstone->gemstone_name }}</option>
                        @endforeach
                    </select>
                    @error('component_gemstone_id.' . $rowIndex)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label"
                        for="gemstone_quantity[]">Gemstone
                        Quantity</label>
                    <input type="number"
                        class="form-control @error('gemstone_quantity.' . $rowIndex) is-invalid @enderror"
                        name="gemstone_quantity[]" placeholder="e.g. 1"
                        value="{{ $row['gemstone_quantity'] ?? '' }}">
                    @error('gemstone_quantity.' . $rowIndex)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="component-form-row row mb-3">
                <div class="col-md-3">
                    <label class="form-label" for="gemstone_weight[]">Gemstone
                        Weight</label>
                    <input type="number" step="0.001"
                        class="form-control @error('gemstone_weight.' . $rowIndex) is-invalid @enderror"
                        name="gemstone_weight[]"
                        placeholder="e.g. 0.500"
                        value="{{ $row['gemstone_weight'] ?? '' }}">
                    @error('gemstone_weight.' . $rowIndex)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label"
                        for="gemstone_carat_weight[]">Gemstone Carat
                        Weight</label>
                    <input type="number" step="0.001"
                        class="form-control @error('gemstone_carat_weight.' . $rowIndex) is-invalid @enderror"
                        name="gemstone_carat_weight[]"
                        placeholder="e.g. 1.25"
                        value="{{ $row['gemstone_carat_weight'] ?? '' }}">
                    @error('gemstone_carat_weight.' . $rowIndex)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="gemstone_shape[]">Gemstone
                        Shape</label>
                    <select class="form-select @error('gemstone_shape.' . $rowIndex) is-invalid @enderror"
                        name="gemstone_shape[]">
                        <option value="">Select Shape</option>
                        <option value="Round" {{ ($row['gemstone_shape'] ?? '') == 'Round' ? 'selected' : '' }}>Round</option>
                        <option value="Oval" {{ ($row['gemstone_shape'] ?? '') == 'Oval' ? 'selected' : '' }}>Oval</option>
                        <option value="Princess" {{ ($row['gemstone_shape'] ?? '') == 'Princess' ? 'selected' : '' }}>Princess</option>
                        <option value="Emerald" {{ ($row['gemstone_shape'] ?? '') == 'Emerald' ? 'selected' : '' }}>Emerald</option>
                        <option value="Pear" {{ ($row['gemstone_shape'] ?? '') == 'Pear' ? 'selected' : '' }}>Pear</option>
                        <option value="Marquise" {{ ($row['gemstone_shape'] ?? '') == 'Marquise' ? 'selected' : '' }}>Marquise</option>
                        <option value="Cushion" {{ ($row['gemstone_shape'] ?? '') == 'Cushion' ? 'selected' : '' }}>Cushion</option>
                        <option value="Asscher" {{ ($row['gemstone_shape'] ?? '') == 'Asscher' ? 'selected' : '' }}>Asscher</option>
                        <option value="Radiant" {{ ($row['gemstone_shape'] ?? '') == 'Radiant' ? 'selected' : '' }}>Radiant</option>
                        <option value="Heart" {{ ($row['gemstone_shape'] ?? '') == 'Heart' ? 'selected' : '' }}>Heart</option>
                        <option value="Other" {{ ($row['gemstone_shape'] ?? '') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('gemstone_shape.' . $rowIndex)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="gemstone_color[]">Gemstone
                        Color</label>
                    <select class="form-select @error('gemstone_color.' . $rowIndex) is-invalid @enderror"
                        name="gemstone_color[]">
                        <option value="">Select Color</option>
                        <option value="Red" {{ ($row['gemstone_color'] ?? '') == 'Red' ? 'selected' : '' }}>Red</option>
                        <option value="Blue" {{ ($row['gemstone_color'] ?? '') == 'Blue' ? 'selected' : '' }}>Blue</option>
                        <option value="Green" {{ ($row['gemstone_color'] ?? '') == 'Green' ? 'selected' : '' }}>Green</option>
                        <option value="Yellow" {{ ($row['gemstone_color'] ?? '') == 'Yellow' ? 'selected' : '' }}>Yellow</option>
                        <option value="Pink" {{ ($row['gemstone_color'] ?? '') == 'Pink' ? 'selected' : '' }}>Pink</option>
                        <option value="White" {{ ($row['gemstone_color'] ?? '') == 'White' ? 'selected' : '' }}>White</option>
                        <option value="Black" {{ ($row['gemstone_color'] ?? '') == 'Black' ? 'selected' : '' }}>Black</option>
                        <option value="Brown" {{ ($row['gemstone_color'] ?? '') == 'Brown' ? 'selected' : '' }}>Brown</option>
                        <option value="Orange" {{ ($row['gemstone_color'] ?? '') == 'Orange' ? 'selected' : '' }}>Orange</option>
                        <option value="Purple" {{ ($row['gemstone_color'] ?? '') == 'Purple' ? 'selected' : '' }}>Purple</option>
                        <option value="Other" {{ ($row['gemstone_color'] ?? '') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('gemstone_color.' . $rowIndex)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="component-form-row row mb-3">
                <div class="col-md-3">
                    <label class="form-label"
                        for="gemstone_clarity[]">Gemstone
                        Clarity</label>
                    <select class="form-select @error('gemstone_clarity.' . $rowIndex) is-invalid @enderror"
                        name="gemstone_clarity[]">
                        <option value="">Select Clarity</option>
                        <option value="IF" {{ ($row['gemstone_clarity'] ?? '') == 'IF' ? 'selected' : '' }}>IF</option>
                        <option value="VVS1" {{ ($row['gemstone_clarity'] ?? '') == 'VVS1' ? 'selected' : '' }}>VVS1</option>
                        <option value="VVS2" {{ ($row['gemstone_clarity'] ?? '') == 'VVS2' ? 'selected' : '' }}>VVS2</option>
                        <option value="VS1" {{ ($row['gemstone_clarity'] ?? '') == 'VS1' ? 'selected' : '' }}>VS1</option>
                        <option value="VS2" {{ ($row['gemstone_clarity'] ?? '') == 'VS2' ? 'selected' : '' }}>VS2</option>
                        <option value="SI1" {{ ($row['gemstone_clarity'] ?? '') == 'SI1' ? 'selected' : '' }}>SI1</option>
                        <option value="SI2" {{ ($row['gemstone_clarity'] ?? '') == 'SI2' ? 'selected' : '' }}>SI2</option>
                        <option value="I1" {{ ($row['gemstone_clarity'] ?? '') == 'I1' ? 'selected' : '' }}>I1</option>
                        <option value="I2" {{ ($row['gemstone_clarity'] ?? '') == 'I2' ? 'selected' : '' }}>I2</option>
                        <option value="I3" {{ ($row['gemstone_clarity'] ?? '') == 'I3' ? 'selected' : '' }}>I3</option>
                        <option value="Other" {{ ($row['gemstone_clarity'] ?? '') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('gemstone_clarity.' . $rowIndex)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label"
                        for="gemstone_cut_grade[]">Gemstone
                        Cut Grade</label>
                    <select class="form-select @error('gemstone_cut_grade.' . $rowIndex) is-invalid @enderror"
                        name="gemstone_cut_grade[]">
                        <option value="">Select Cut</option>
                        <option value="Brilliant" {{ ($row['gemstone_cut_grade'] ?? '') == 'Brilliant' ? 'selected' : '' }}>Brilliant</option>
                        <option value="Step" {{ ($row['gemstone_cut_grade'] ?? '') == 'Step' ? 'selected' : '' }}>Step</option>
                        <option value="Mixed" {{ ($row['gemstone_cut_grade'] ?? '') == 'Mixed' ? 'selected' : '' }}>Mixed</option>
                        <option value="Rose" {{ ($row['gemstone_cut_grade'] ?? '') == 'Rose' ? 'selected' : '' }}>Rose</option>
                        <option value="Cabochon" {{ ($row['gemstone_cut_grade'] ?? '') == 'Cabochon' ? 'selected' : '' }}>Cabochon</option>
                        <option value="Other" {{ ($row['gemstone_cut_grade'] ?? '') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('gemstone_cut_grade.' . $rowIndex)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label"
                        for="gemstone_certificate[]">Gemstone
                        Certificate</label>
                    <input type="text"
                        class="form-control @error('gemstone_certificate.' . $rowIndex) is-invalid @enderror"
                        name="gemstone_certificate[]"
                        placeholder="e.g. GIA 123456"
                        value="{{ $row['gemstone_certificate'] ?? '' }}">
                    @error('gemstone_certificate.' . $rowIndex)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label"
                        for="dimension_length[]">Length</label>
                    <input type="number" step="0.01"
                        class="form-control @error('dimension_length.' . $rowIndex) is-invalid @enderror"
                        name="dimension_length[]"
                        placeholder="e.g. 10.00"
                        value="{{ $row['dimension_length'] ?? '' }}">
                    @error('dimension_length.' . $rowIndex)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="component-form-row row mb-3">
                <div class="col-md-3">
                    <label class="form-label"
                        for="dimension_width[]">Width</label>
                    <input type="number" step="0.01"
                        class="form-control @error('dimension_width.' . $rowIndex) is-invalid @enderror"
                        name="dimension_width[]"
                        placeholder="e.g. 5.00"
                        value="{{ $row['dimension_width'] ?? '' }}">
                    @error('dimension_width.' . $rowIndex)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label"
                        for="dimension_height[]">Height</label>
                    <input type="number" step="0.01"
                        class="form-control @error('dimension_height.' . $rowIndex) is-invalid @enderror"
                        name="dimension_height[]"
                        placeholder="e.g. 2.50"
                        value="{{ $row['dimension_height'] ?? '' }}">
                    @error('dimension_height.' . $rowIndex)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label"
                        for="diameter[]">Diameter</label>
                    <input type="number" step="0.01"
                        class="form-control @error('diameter.' . $rowIndex) is-invalid @enderror"
                        name="diameter[]"
                        placeholder="e.g. 3.00"
                        value="{{ $row['diameter'] ?? '' }}">
                    @error('diameter.' . $rowIndex)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="component_cost[]">Component
                        Cost</label>
                    <input type="number" step="0.01"
                        class="form-control @error('component_cost.' . $rowIndex) is-invalid @enderror"
                        name="component_cost[]"
                        placeholder="e.g. 120.00"
                        value="{{ $row['component_cost'] ?? '' }}">
                    @error('component_cost.' . $rowIndex)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="component-form-row row mb-3">
                <div class="col-md-3">
                    <label class="form-label" for="labor_cost[]">Labor
                        Cost</label>
                    <input type="number" step="0.01"
                        class="form-control @error('labor_cost.' . $rowIndex) is-invalid @enderror"
                        name="labor_cost[]"
                        placeholder="e.g. 45.00"
                        value="{{ $row['labor_cost'] ?? '' }}">
                    @error('labor_cost.' . $rowIndex)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="setting_cost[]">Setting
                        Cost</label>
                    <input type="number" step="0.01"
                        class="form-control @error('setting_cost.' . $rowIndex) is-invalid @enderror"
                        name="setting_cost[]"
                        placeholder="e.g. 30.00"
                        value="{{ $row['setting_cost'] ?? '' }}">
                    @error('setting_cost.' . $rowIndex)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="position_order[]">Position
                        Order</label>
                    <input type="number"
                        class="form-control @error('position_order.' . $rowIndex) is-invalid @enderror"
                        name="position_order[]" placeholder="e.g. 1"
                        value="{{ $row['position_order'] ?? 0 }}">
                    @error('position_order.' . $rowIndex)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label"
                        for="position_description[]">Position
                        Description</label>
                    <input type="text"
                        class="form-control @error('position_description.' . $rowIndex) is-invalid @enderror"
                        name="position_description[]"
                        placeholder="e.g. Center"
                        value="{{ $row['position_description'] ?? '' }}">
                    @error('position_description.' . $rowIndex)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="component-form-row row mb-3">
                <div class="col-md-3">
                    <label class="form-label" for="is_main_component[]">Is
                        Main
                        Component</label>
                    <select class="form-select @error('is_main_component.' . $rowIndex) is-invalid @enderror"
                        name="is_main_component[]">
                        <option value="0" {{ ($row['is_main_component'] ?? 0) ? '' : 'selected' }}>No</option>
                        <option value="1" {{ ($row['is_main_component'] ?? 0) ? 'selected' : '' }}>Yes</option>
                    </select>
                    @error('is_main_component.' . $rowIndex)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-9">
                    <label class="form-label"
                        for="product_notes[]">Notes</label>
                    <textarea class="form-control @error('product_notes.' . $rowIndex) is-invalid @enderror"
                        name="product_notes[]" rows="2"
                        placeholder="Notes (optional)">{{ $row['product_notes'] ?? '' }}</textarea>
                    @error('product_notes.' . $rowIndex)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-12 text-end">
                    <button type="button"
                        class="btn btn-outline-danger remove-component-btn">Remove</button>
                </div>
            </div>
        </div>
    </div>
</div>
